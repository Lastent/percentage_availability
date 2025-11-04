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
 * Language strings.
 *
 * @package availability_percentage
 * @copyright 2025 Your Name
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Restriction by percentage completion';
$string['title'] = 'Percentage completion';
$string['description'] = 'Require that a percentage of students complete another activity.';

$string['label_cm'] = 'Activity or resource';
$string['label_percentage'] = 'Required percentage';

$string['error_selectcmid'] = 'You must select an activity for the percentage completion condition.';
$string['error_percentage'] = 'You must enter a valid percentage between 0 and 100.';

$string['missing'] = '(Missing activity)';

$string['requires_complete'] = 'At least <strong>{$a->percentage}%</strong> of students must complete the activity <strong>{$a->name}</strong>';
$string['requires_notcomplete'] = 'Less than <strong>{$a->percentage}%</strong> of students must have completed the activity <strong>{$a->name}</strong>';

$string['privacy:metadata'] = 'The Restriction by percentage completion plugin does not store any personal data.';
