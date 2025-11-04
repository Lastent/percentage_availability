<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Percentage completion condition.
 *
 * @package availability_percentage
 * @copyright 2025 Your Name
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_percentage;

use core_availability\info;
use stdClass;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/completionlib.php');

/**
 * Percentage completion condition.
 *
 * @package availability_percentage
 * @copyright 2025 Your Name
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition extends \core_availability\condition {

    /** @var int ID of module that this depends on */
    protected $cmid;

    /** @var int Required percentage (0-100) */
    protected $percentage;

    /**
     * Constructor.
     *
     * @param stdClass $structure Data structure from JSON decode
     * @throws \coding_exception If invalid data structure.
     */
    public function __construct($structure) {
        // Get cmid.
        if (isset($structure->cm) && is_number($structure->cm)) {
            $this->cmid = (int)$structure->cm;
        } else {
            throw new \coding_exception('Missing or invalid ->cm for percentage completion condition');
        }

        // Get percentage.
        if (isset($structure->p) && is_number($structure->p) && 
            $structure->p >= 0 && $structure->p <= 100) {
            $this->percentage = (int)$structure->p;
        } else {
            throw new \coding_exception('Missing or invalid ->p for percentage completion condition');
        }
    }

    /**
     * Saves tree data back to a structure object.
     *
     * @return stdClass Structure object (ready to be made into JSON format)
     */
    public function save(): stdClass {
        return (object) [
            'type' => 'percen',
            'cm' => $this->cmid,
            'p' => $this->percentage,
        ];
    }

    /**
     * Returns a JSON object which corresponds to a condition of this type.
     *
     * Intended for unit testing, as normally the JSON values are constructed
     * by JavaScript code.
     *
     * @param int $cmid Course-module id of other activity
     * @param int $percentage Required percentage (0-100)
     * @return stdClass Object representing condition
     */
    public static function get_json(int $cmid, int $percentage): stdClass {
        return (object) [
            'type' => 'percen',
            'cm' => (int)$cmid,
            'p' => (int)$percentage,
        ];
    }

    /**
     * Determines whether a particular item is currently available
     * according to this availability condition.
     *
     * @param bool $not Set true if we are inverting the condition
     * @param info $info Item we're checking
     * @param bool $grabthelot Performance hint: if true, caches information
     *   required for all course-modules, to make the front page and similar
     *   pages work more quickly (works only for current user)
     * @param int $userid User ID to check availability for
     * @return bool True if available
     */
    public function is_available($not, info $info, $grabthelot, $userid): bool {
        $course = $info->get_course();
        $modinfo = $info->get_modinfo();
        
        // Check if the referenced module exists.
        if (!array_key_exists($this->cmid, $modinfo->cms) || 
            $modinfo->cms[$this->cmid]->deletioninprogress) {
            return false;
        }

        $allow = $this->check_percentage_completion($course, $this->cmid);

        if ($not) {
            $allow = !$allow;
        }

        return $allow;
    }

    /**
     * Check if the required percentage of students have completed the activity.
     *
     * @param stdClass $course Course object
     * @param int $cmid Course-module ID
     * @return bool True if percentage threshold is met
     */
    protected function check_percentage_completion(stdClass $course, int $cmid): bool {
        global $DB;

        // Get all enrolled students in the course.
        // We use 'moodle/course:isincompletionreports' capability which is typically
        // only assigned to students (not teachers/admins).
        $context = \context_course::instance($course->id);
        $enrolledusers = get_enrolled_users($context, 'moodle/course:isincompletionreports', 0, 'u.id', null, 0, 0, true);
        
        if (empty($enrolledusers)) {
            // No students enrolled, condition cannot be met.
            return false;
        }

        $totalstudents = count($enrolledusers);
        
        // Get completion info.
        $completion = new \completion_info($course);
        
        if (!$completion->is_enabled()) {
            // Completion not enabled.
            return false;
        }

        // Count how many students have completed the activity.
        $completedcount = 0;
        
        foreach ($enrolledusers as $user) {
            $completiondata = $completion->get_data((object)['id' => $cmid], false, $user->id);
            
            // Check if completed (any completion state that is not incomplete).
            if ($completiondata->completionstate == COMPLETION_COMPLETE ||
                $completiondata->completionstate == COMPLETION_COMPLETE_PASS ||
                $completiondata->completionstate == COMPLETION_COMPLETE_FAIL) {
                $completedcount++;
            }
        }

        // Calculate percentage.
        $currentpercentage = ($completedcount / $totalstudents) * 100;

        // Check if threshold is met.
        return $currentpercentage >= $this->percentage;
    }

    /**
     * Obtains a string describing this restriction (whether or not
     * it actually applies).
     *
     * @param bool $full Set true if this is the 'full information' view
     * @param bool $not Set true if we are inverting the condition
     * @param info $info Item we're checking
     * @return string Information string (for admin) about all restrictions on
     *   this item
     */
    public function get_description($full, $not, info $info): string {
        $course = $info->get_course();
        $modinfo = $info->get_modinfo();

        // Get name for module.
        if (!array_key_exists($this->cmid, $modinfo->cms) || 
            $modinfo->cms[$this->cmid]->deletioninprogress) {
            $modname = get_string('missing', 'availability_percentage');
        } else {
            $modname = self::description_cm_name($modinfo->cms[$this->cmid]->id);
        }

        $a = (object)[
            'name' => $modname,
            'percentage' => $this->percentage
        ];

        if ($not) {
            return get_string('requires_notcomplete', 'availability_percentage', $a);
        } else {
            return get_string('requires_complete', 'availability_percentage', $a);
        }
    }

    /**
     * Obtains a representation of the options of this condition as a string,
     * for debugging.
     *
     * @return string Text representation of parameters
     */
    protected function get_debug_string(): string {
        return 'cm' . $this->cmid . ' ' . $this->percentage . '%';
    }

    /**
     * Updates this node after restore, returning true if anything changed.
     *
     * @param string $restoreid Restore ID
     * @param int $courseid ID of target course
     * @param \base_logger $logger Logger for any warnings
     * @param string $name Name of this item (for use in warning messages)
     * @return bool True if there was any change
     */
    public function update_after_restore($restoreid, $courseid, \base_logger $logger, $name): bool {
        global $DB;

        $rec = \restore_dbops::get_backup_ids_record($restoreid, 'course_module', $this->cmid);
        if (!$rec || !$rec->newitemid) {
            // If we are on the same course (e.g. duplicate) then we can just
            // use the existing one.
            if ($DB->record_exists('course_modules',
                    ['id' => $this->cmid, 'course' => $courseid])) {
                return false;
            }
            // Otherwise it's a warning.
            $this->cmid = 0;
            $logger->process('Restored item (' . $name .
                    ') has availability condition on module that was not restored',
                    \backup::LOG_WARNING);
            return true;
        } else {
            $this->cmid = (int)$rec->newitemid;
            return true;
        }
    }

    /**
     * Updates the dependency ID.
     *
     * @param string $table Table name
     * @param int $oldid Old ID
     * @param int $newid New ID
     * @return bool True if updated
     */
    public function update_dependency_id($table, $oldid, $newid) {
        if ($table === 'course_modules' && (int)$this->cmid === (int)$oldid) {
            $this->cmid = $newid;
            return true;
        } else {
            return false;
        }
    }
}
