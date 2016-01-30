/**
 * Directive for handling results.
 *
 * @directive cpResult
 */
app.directive('cpResult', function (CallModel)
{
	var self,
		days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
		months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];


	function getDateString(dateString) {
		var date = new Date(dateString);

		return days[date.getDay()] + ' ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
	}

	function sortResults() {
		self.results.forEach(function (result) {
			if (result.score1 > result.score2) {
				result.winOrLoss = 'win';
			}
			else {
				result.winOrLoss = 'loss';
			}

			result.date = getDateString(result.date);
		});
	}

	function getResults() {
		CallModel.fetch('ResultGet', {},
		{
			success: function (response) {
				self.results = response.results;

				sortResults();
			}
		});
	}


	return {
		templateUrl: 'views/results.html',
		link: function (scope) {
			self = scope;

			getResults();
		}
	}
});