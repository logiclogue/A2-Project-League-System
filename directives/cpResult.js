/**
 * Directive for handling results.
 *
 * @directive cpResult
 */
app.directive('cpResult', function (CallModel)
{
	/**
	 * Variable for storing scope.
	 *
	 * @var self
	 */
	var self;
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


	/**
	 * Function that returns formated output date from input date.
	 *
	 * @method getDateString
	 * @param dateString {String} Input date string.
	 * @return {String} Output formated date string.
	 */
	function getDateString(dateString) {
		var date = new Date(dateString);

		return days[date.getDay()] + ' ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
	}

	/**
	 * Function that sets CSS class for colouring result.
	 * Also calls @method getDateString for each result.
	 *
	 * @method sortResults
	 */
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

	/**
	 * Function that gets the results data from @class ResultGet.
	 *
	 * @method getResults
	 */
	function getResults() {
		CallModel.fetch('ResultGet', {
			result_id: self.resultId,
			tournament_id: self.tournamentId,
			player1_id: self.playerOneId,
			player2_id: self.playerTwoId
		},
		{
			success: function (response) {
				self.results = response.results;

				sortResults();
			}
		});
	}


	return {
		templateUrl: 'views/results.html',
		scope: {
			resultId: '=',
			tournamentId: '=',
			playerOneId: '=',
			playerTwoId: '=',
			isReady: '='
		},
		link: function ($scope) {
			self = $scope;

			// When loaded call @method getResults.
			var waiting = $scope.$watch('isReady', function (success) {
				if (success === true) {
					waiting();
					getResults();
				}
			});
		}
	}
});