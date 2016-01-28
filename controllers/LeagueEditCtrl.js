/**
 * Controller for editing a league.
 *
 * @controller LeagueEditCtrl
 */
app.controller('LeagueEditCtrl', function ($scope, $location, $routeParams, CallModel)
{
	/* 
	 * Checks to see if logged in.
	 * If not, redirects to login page.
	 */
	CallModel.ifLoggedIn(function () {}, function () {
		$location.path('/login');
	});


	/**
	 * Method for getting league data from @class TournamentGet.
	 *
	 * @method getLeague
	 */
	function getLeague() {
		CallModel.fetch('TournamentGet', {
			id: $routeParams.leagueId
		},
		{
			success: function (response) {
				$scope.data = response;
			},
			fail: function (response) {
				alert(response.error_msg);

				$location.path('/');
			}
		});
	}


	/**
	 * Function that is called when the update button is pressed.
	 *
	 * @method eventUpdate
	 */
	function eventUpdate() {
		CallModel.fetch('TournamentUpdate', {
			id: $routeParams.leagueId
		},
		{
			success: function (response) {
				$location.path('/league/' + $routeParams.leagueId);
			},
			fail: function (response) {
				alert(response.error_msg);
			}
		}
	}


	getLeague();
});