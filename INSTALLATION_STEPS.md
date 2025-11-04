# Installation Verification Steps

## Step 1: Install the Plugin

The plugin files are in place, but Moodle needs to register it in the database.

**Action Required:**

1. Open your browser and navigate to:
   ```
   http://192.168.1.197:8080/admin/index.php
   ```

2. Log in as an administrator

3. Moodle should automatically detect the new plugin and show a notification like:
   ```
   "New plugins have been detected"
   or
   "Plugins requiring attention"
   ```

4. Click **"Upgrade Moodle database now"** button

5. Wait for the upgrade to complete

6. You should see "availability_percentage" in the list of installed plugins

## Step 2: Verify Installation

After installation, verify the plugin is active:

1. Go to: **Site administration → Plugins → Availability restrictions → Manage restrictions**
2. Look for "Percentage completion" in the list
3. Ensure the "eye" icon is open (plugin is enabled)

## Step 3: Enable Completion (if not already done)

The plugin requires completion tracking to work:

1. **Site-wide:**
   - Go to: **Site administration → Advanced features**
   - Enable "Completion tracking"
   - Save changes

2. **Course-level:**
   - Go to your course settings
   - Under "Completion tracking", select "Yes"
   - Save changes

3. **Activity-level (for at least one activity):**
   - Edit an activity (e.g., a quiz or assignment)
   - Under "Activity completion", set completion criteria
   - Save the activity

## Step 4: Test the Restriction

Once installed and enabled:

1. Edit any activity or section
2. Expand "Restrict access"
3. Click "Add restriction..."
4. You should now see **"Percentage completion"** in the list
5. Select it and configure:
   - Choose an activity with completion tracking
   - Set a percentage (0-100)
6. Save

## Troubleshooting

### Plugin doesn't appear after installation
- Clear all caches: **Site administration → Development → Purge all caches**
- Hard refresh your browser (Ctrl+Shift+R or Cmd+Shift+R)

### "Percentage completion" not in the restriction list
Check:
- Is completion enabled at site level?
- Is completion enabled for this course?
- Is there at least one activity with completion tracking?
- Did you clear the cache after installation?

### Permission issues with the plugin directory
If you see permission errors during installation:
```bash
sudo chown -R www-data:www-data /home/roman/Documents/Projects/DockerContainers/moodle-apache/moodle/availability/condition/percen
```

## Expected Behavior

When working correctly:
- The restriction appears in the "Add restriction..." dialog
- You can select an activity from a dropdown
- You can enter a percentage value (0-100)
- The description shows: "At least X% of students must complete the activity [Activity Name]"

## Files Created

All required files are in place:
- ✓ version.php
- ✓ classes/condition.php
- ✓ classes/frontend.php
- ✓ classes/privacy/provider.php
- ✓ lang/en/availability_percentage.php
- ✓ yui/src/form/js/form.js
- ✓ yui/build/moodle-availability_percentage-form/* (all 3 files)

The plugin is ready - it just needs to be installed through the Moodle admin interface!
