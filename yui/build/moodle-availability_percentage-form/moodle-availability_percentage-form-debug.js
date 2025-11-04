YUI.add('moodle-availability_percentage-form', function (Y, NAME) {

/**
 * JavaScript for form editing percentage completion conditions.
 *
 * @module moodle-availability_percentage-form
 */
M.availability_percentage = M.availability_percentage || {};

/**
 * @class M.availability_percentage.form
 * @extends M.core_availability.plugin
 */
M.availability_percentage.form = Y.Object(M.core_availability.plugin);

/**
 * Initialises this plugin.
 *
 * @method initInner
 * @param {Array} cms Array of objects containing cmid => name
 */
M.availability_percentage.form.initInner = function(cms) {
    this.cms = cms;
};

/**
 * Creates the form node for this plugin.
 *
 * @method getNode
 * @param {object} json Saved condition data
 * @return {Node} HTML node for form
 */
M.availability_percentage.form.getNode = function(json) {
    // Create HTML structure.
    var html = '<span class="col-form-label p-r-1"> ' + M.util.get_string('title', 'availability_percentage') + '</span>' +
               ' <span class="availability-group form-group"><label>' +
            '<span class="accesshide">' + M.util.get_string('label_cm', 'availability_percentage') + ' </span>' +
            '<select class="custom-select" name="cm" title="' + M.util.get_string('label_cm', 'availability_percentage') + '">' +
            '<option value="0">' + M.util.get_string('choosedots', 'moodle') + '</option>';
    
    for (var i = 0; i < this.cms.length; i++) {
        var cm = this.cms[i];
        // String has already been escaped using format_string.
        Y.log('Adding option for cm: ' + cm.id + ' - ' + cm.name, 'debug', 'moodle-availability_percentage-form');
        html += '<option value="' + cm.id + '">' + cm.name + '</option>';
    }
    
    html += '</select></label> <label><span class="accesshide">' +
                M.util.get_string('label_percentage', 'availability_percentage') +
            ' </span><input type="number" class="form-control" ' +
                'name="p" min="0" max="100" step="1" ' +
                'style="width: 80px; display: inline-block;" ' +
                'title="' + M.util.get_string('label_percentage', 'availability_percentage') + '" ' +
                'placeholder="50" value="50"> <span class="p-l-1">%</span>' +
            '</label></span>';
    
    var node = Y.Node.create('<span class="form-inline">' + html + '</span>');

    // Set initial values.
    if (json.cm !== undefined &&
            node.one('select[name=cm] > option[value=' + json.cm + ']')) {
        Y.log('Setting initial cm value: ' + json.cm, 'debug', 'moodle-availability_percentage-form');
        node.one('select[name=cm]').set('value', '' + json.cm);
    }
    if (json.p !== undefined) {
        Y.log('Setting initial percentage value: ' + json.p, 'debug', 'moodle-availability_percentage-form');
        node.one('input[name=p]').set('value', '' + json.p);
    }

    // Add event handlers (first time only).
    if (!M.availability_percentage.form.addedEvents) {
        M.availability_percentage.form.addedEvents = true;
        var root = Y.one('.availability-field');
        root.delegate('change', function() {
            Y.log('Form changed, updating availability', 'debug', 'moodle-availability_percentage-form');
            // Whichever input changed, just update the form.
            M.core_availability.form.update();
        }, '.availability_percentage select, .availability_percentage input');
        root.delegate('input', function() {
            Y.log('Input changed, updating availability', 'debug', 'moodle-availability_percentage-form');
            // For number input, update on input as well.
            M.core_availability.form.update();
        }, '.availability_percentage input[type=number]');
    }

    return node;
};

/**
 * Fills value into the JSON data from the form.
 *
 * @method fillValue
 * @param {object} value JSON object to be filled in
 * @param {Node} node HTML node for form
 */
M.availability_percentage.form.fillValue = function(value, node) {
    value.cm = parseInt(node.one('select[name=cm]').get('value'), 10);
    value.p = parseInt(node.one('input[name=p]').get('value'), 10);
    Y.log('Filled values - cm: ' + value.cm + ', percentage: ' + value.p, 'debug', 'moodle-availability_percentage-form');
};

/**
 * Checks if the form contains errors.
 *
 * @method fillErrors
 * @param {Array} errors Array of error strings
 * @param {Node} node HTML node for form
 */
M.availability_percentage.form.fillErrors = function(errors, node) {
    var cmid = parseInt(node.one('select[name=cm]').get('value'), 10);
    if (cmid === 0) {
        Y.log('Error: No activity selected', 'warn', 'moodle-availability_percentage-form');
        errors.push('availability_percentage:error_selectcmid');
    }
    
    var percentage = parseInt(node.one('input[name=p]').get('value'), 10);
    if (isNaN(percentage) || percentage < 0 || percentage > 100) {
        Y.log('Error: Invalid percentage value: ' + percentage, 'warn', 'moodle-availability_percentage-form');
        errors.push('availability_percentage:error_percentage');
    }
};


}, '@VERSION@', {"requires": ["base", "node", "event", "moodle-core_availability-form"]});
