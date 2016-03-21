/**
 * Factory that returns the site's format of date.
 *
 * @module DateFormat
 */
app.factory('DateFormat', function ()
{
	/**
	 * Days of the week for date format.
	 *
	 * @property days
	 * @type Array
	 */
	var days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
	/**
	 * Months of the year for date format.
	 *
	 * @property months
	 * @type Array
	 */
	var months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];


	return {
		/**
		 * Function that returns formated output date from input date.
		 *
		 * @method getDateString
		 * @param dateString {String} Input date string.
		 * @return {String} Output formated date string.
		 */
		getString: function (dateString) {
			var date = new Date(dateString);

			return days[date.getDay()] + ' ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
		}
	}
});