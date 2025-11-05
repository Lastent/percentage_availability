# Availability Condition: Percentage Completion (percentage)

A Moodle availability condition plugin that restricts access to activities based on the percentage of students who have completed another activity.

## Description

This plugin allows teachers to create access restrictions that check if at least a certain percentage of enrolled students in a course have completed a specific activity. This is useful for collaborative learning scenarios where access to new content should only be granted when a sufficient portion of the class has completed prerequisite work.

## Features

- Set a percentage threshold (0-100%) for activity completion
- Select any activity with completion tracking enabled
- Works with Moodle's standard activity completion system
- Compatible with "NOT" conditions for inverse logic
- GDPR compliant (stores no personal data)

## Requirements

- Moodle 4.5 or later
- Activity completion must be enabled at the site and course level
- At least one activity with completion tracking in the course

## Installation

1. Copy the `percen` folder to `/path/to/moodle/availability/condition/`
2. Log in to Moodle as an administrator
3. Navigate to Site Administration → Notifications
4. Follow the on-screen instructions to complete the installation

## Usage

1. **Enable Completion Tracking:**
   - Ensure completion tracking is enabled in your course settings
   - Configure completion criteria for the activity you want to track

2. **Add Restriction:**
   - Edit any activity or section
   - Go to "Restrict access" section
   - Click "Add restriction"
   - Select "Percentage completion"
   - Choose the activity to monitor
   - Set the required percentage (0-100)
   - Save the settings

3. **Example Scenarios:**
   - **Peer Learning:** Unlock a discussion forum when 80% of students complete a quiz
   - **Progressive Content:** Release advanced materials when 75% complete the basics
   - **Group Pacing:** Ensure the majority of the class progresses together

## How It Works

The plugin:
1. Counts all enrolled students with the capability to submit assignments (or similar student role)
2. Checks how many of those students have completed the specified activity
3. Calculates the percentage of completion
4. Grants access if the percentage meets or exceeds the threshold

**Note:** The check is performed when a user attempts to access the restricted content. The percentage is calculated dynamically based on current enrollment and completion data.

## Examples

### Example 1: Unlock Quiz 2 when 70% complete Quiz 1
```
Activity: Quiz 2
Restriction: Percentage completion
  - Activity: Quiz 1
  - Percentage: 70
```

### Example 2: Hide content until less than 50% are done (using NOT)
```
Activity: Advanced Module
Restriction: NOT Percentage completion
  - Activity: Basic Module
  - Percentage: 50
```

## File Structure

```
percen/
├── classes/
│   ├── condition.php          # Main condition logic
│   ├── frontend.php            # JavaScript initialization
│   └── privacy/
│       └── provider.php        # GDPR compliance
├── lang/
│   └── en/
│       └── availability_percentage.php  # Language strings
├── yui/
│   ├── src/
│   │   └── form/
│   │       ├── js/
│   │       │   └── form.js     # JavaScript form logic
│   │       ├── build.json      # YUI build config
│   │       └── meta/
│   │           └── form.json   # YUI metadata
│   └── build/
│       └── moodle-availability_percentage-form/
│           ├── moodle-availability_percentage-form.js
│           ├── moodle-availability_percentage-form-min.js
│           └── moodle-availability_percentage-form-debug.js
├── version.php                 # Plugin metadata
└── README.md                   # This file
```

## Technical Details

### Database
This plugin does not create any database tables. It relies on Moodle's core completion tracking system.

### Performance
- Uses Moodle's built-in completion API
- Calculates percentages on-demand (no caching currently implemented)
- For large courses, consider the performance impact of checking all enrolled users

### Privacy
This plugin does not store any personal data and implements the `null_provider` privacy interface.

## Future Enhancements

Potential improvements:
- Caching of percentage calculations for better performance
- Option to exclude certain user groups from the calculation
- Different completion states (e.g., pass/fail grades)
- Time-based conditions (percentage within a date range)

## Troubleshooting

**Plugin doesn't appear in restriction list:**
- Verify completion is enabled at site and course level
- Ensure at least one activity has completion tracking enabled

**Restriction not working:**
- Check that the referenced activity still exists
- Verify students are properly enrolled in the course
- Confirm the activity has completion criteria configured

**Performance issues:**
- In very large courses, the calculation may be slow
- Consider using caching or reducing the frequency of checks

## Support

For bug reports and feature requests, please contact the plugin maintainer or use the Moodle forums.

## License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

## Credits

Created for Moodle availability condition system.
Based on the completion condition plugin structure.

## Changelog

### Version 1.0 (2025-11-01)
- Initial release
- Basic percentage-based completion checking
- Support for all completion states
- YUI-based form interface
