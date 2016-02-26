/**
 * Directive for handling results.
 *
 * @directive cpResult
 */
app.directive('cpResult', function (CallModel, DateFormat)
{
	/**
	 * Variable for storing scope.
	 *
	 * @var self
	 */
	var self;


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

			result.date = DateFormat.getString(result.date);
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