/**
 * Directive for handling results.
 *
 * @module cpResult
 */
app.directive('cpResult', function ($route, CallModel, DateFormat)
{
	/**
	 * Variable for storing scope.
	 *
	 * @property self
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


			/**
			 * Function that deletes a result when delete button is clicked.
			 *
			 * @method $scope.eventDelete
			 * @param id {Integer} Id of the result to be deleted.
			 */
			$scope.eventDelete = function (id) {
				CallModel.fetch('ResultDelete', {
					id: id
				},
				{
					success: function (response) {
						alert("Successfully deleted the result");

						$route.reload();
					},
					fail: function (response) {
						alert(response.error_msg);
					}
				});
			};


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