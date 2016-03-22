/**
 * Directive for displaying fixtures.
 *
 * @class cpFixtures
 */
app.directive('cpFixtures', function ($window, CallModel)
{
	/**
	 * Variable for storing scope.
	 *
	 * @property self
	 * @type Object
	 */
	var self;


	/**
	 * Method that gets data about fixtures from @class FixturesGet.
	 *
	 * @method getFixtures
	 */
	function getFixtures() {
		CallModel.fetch('FixturesGet', {
			player_id: self.playerId,
			tournament_id: self.tournamentId
		},
		{
			success: function (response) {
				self.fixtures = response.fixtures;
			}
		});
	}


	return {
		templateUrl: 'views/fixtures.html',
		scope: {
			playerId: '=',
			tournamentId: '=',
			isReady: '='
		},
		link: function ($scope) {
			self = $scope;

			$scope.yourId = $window.sessionStorage.yourId;

			// When loaded call @method getFixtures
			var waiting = $scope.$watch('isReady', function (success) {
				if (success === true) {
					waiting();
					getFixtures();
				}
			});
		}
	}
});