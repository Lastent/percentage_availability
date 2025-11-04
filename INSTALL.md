# Quick Installation Guide

## Installation Steps

1. **Install the plugin:**
   - The plugin is already in the correct location: `availability/condition/percen`
   - Log in to your Moodle site as an administrator
   - Navigate to: **Site administration → Notifications**
   - Click "Upgrade Moodle database now" button
   - The plugin will be detected and installed

2. **Enable completion tracking (if not already enabled):**
   - Go to: **Site administration → Advanced features**
   - Enable "Completion tracking"
   - Save changes

3. **Configure your course:**
   - Edit your course settings
   - Under "Completion tracking", select "Yes"
   - Save changes

4. **Set up an activity with completion:**
   - Edit any activity (e.g., a quiz, assignment, etc.)
   - Under "Activity completion", configure completion criteria
   - Save the activity

5. **Use the restriction:**
   - Edit another activity or section
   - Under "Restrict access", click "Add restriction..."
   - Select "Percentage completion"
   - Choose the activity to monitor
   - Set the percentage threshold (0-100)
   - Save changes

## Next Steps

After installation, you can test the plugin by:

1. Creating a simple assignment with completion tracking
2. Creating a second activity restricted by percentage completion
3. Having students complete the first assignment
4. Checking that the second activity becomes available when the threshold is met

## Verification

To verify the plugin is installed correctly:

1. Go to: **Site administration → Plugins → Availability restrictions → Manage restrictions**
2. You should see "Percentage completion" in the list
3. Make sure it's enabled (eye icon should be open)

## Troubleshooting

**Plugin doesn't show up in notifications:**
- Make sure you're logged in as an administrator
- Try: **Site administration → Notifications** (force check)
- Clear Moodle caches: **Site administration → Development → Purge all caches**

**Can't see the restriction option:**
- Verify completion is enabled (site and course level)
- Ensure at least one activity has completion tracking
- Check that the plugin is enabled in the restrictions manager

**Restriction not working as expected:**
- Check that students are enrolled in the course
- Verify the referenced activity has completion criteria set
- Test with a small percentage first (e.g., 10%) to ensure it works

## Advanced Configuration

Currently, the plugin works out-of-the-box with no additional configuration needed. All settings are configured per-restriction when you add it to an activity or section.

## Permissions

This plugin uses standard Moodle permissions. Teachers with the capability to manage activity restrictions can use this plugin. No special permissions are required.
