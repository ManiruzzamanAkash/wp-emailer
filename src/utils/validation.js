/**
 * External dependencies.
 */
import { __ } from '@wordpress/i18n';

/**
 * Validate the settings form data.
 *
 * @param {Object}   input   Key-value pair input.
 * @returns {Object} checker Check validation response.
 */
export function validateSettings({ key, value }) {
    let checker = {
        valid: true,
        message: ""
    };

    switch (key) {
    case "numrows":
        if (value < 1 || value > 5) {
            checker.message = __('Please give valid input for number of rows.', 'wp-emailer');
            checker.valid = false;
        }
        break;

    case "humandate":
        if (parseInt(value) !== 0 && parseInt(value) !== 1) {
            checker.message = __('Please check if human readable date will be displayed or not.', 'wp-emailer');
            checker.valid = false;
        }
        break;

    case "emails":
        if ('' !== value && null !== value) {
            const invalidMatches = value.filter((email) => !validateEmail(email) );

            if (invalidMatches.length) {
                checker.message = __('Please provide valid emails.', 'wp-emailer');
                checker.valid = false;
            }
        }
        break;

    default:
        break;
    }

    return checker;
}

export const validateEmail = (email) => {
    return String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};