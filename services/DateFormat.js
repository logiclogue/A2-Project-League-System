/**
 * Factory that returns the site's format of date.
 *
 * @factory DateFormat
 */
app.factory('DateFormat', function ()
{
	/**
	 * Days of the week for date format.
	 *
	 * @var days
	 */
	var days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
	/**
	 * Months of the year for date format.
	 *
	 * @var months
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