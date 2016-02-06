/**
 * Directive for displaying fixtures.
 *
 * @directive cpFixtures
 */
app.directive('cpFixtures', function (CallModel)
{
	/**
	 * Varaibe for storing scope.
	 *
	 * @var self
	 */
	var self;


	function getFixtures() {
		CallModel.fetch('FixturesGet', {
			player_id: self.playerId,
			tournament_id: self.tournamentId
		},
		{
			success: function (response) {
				console.log(response);
			}
		})
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