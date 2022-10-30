/**
 * Format a date timestamp to human readable time string.
 *
 * @param {Number} timestamp Timestamp number.
 * @param {Boolean} showHourMinute Is show hour-minute or not.
 *
 * @returns Formatted date string.
 */
export const formatDate = (timestamp, showHourMinute = false) => {
    const dateString = new Date(timestamp).toString(); // eg: Tue Jan 20 1970 12:57:14 GMT+0600

    // We'll break this --> Tue Jan 20 1970 12:57:14
    let date = `${dateString.substring(8, 10)} ${dateString.substring(4, 7)} ${dateString.substring(11, 15)}`; // 20 Jan 1970

    if (showHourMinute) {
        date += ` at ${dateString.substring(16, 21)}`; // at 12:57
    }

    return date;
};
