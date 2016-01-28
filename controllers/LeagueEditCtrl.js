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



	function redirect(response) {
		alert(response.error_msg);

		$location.path('/');
	}


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
				// Fill fields with current league info.
				$scope.name = response.name;
				$scope.description = response.description;

				// Check to see if user isn't a league manager, and then redirect
				if (!response.is_league_manager) {
					response.error_msg = "You must be a league manager to edit the league";

					redirect(response);
				}
			},
			fail: redirect
		});
	}


	/**
	 * Function that is called when the update button is pressed.
	 *
	 * @method eventUpdate
	 */
	$scope.eventUpdate = function () {
		// Calls @class TournamentUpdate with info from name and description fields.
		CallModel.fetch('TournamentUpdate', {
			id: $routeParams.leagueId,
			name: $scope.name,
			description: $scope.description
		},
		{
			success: function (response) {
				$location.path('/league/' + $routeParams.leagueId);
			},
			fail: function (response) {
				alert(response.error_msg);
			}
		});
	}


	getLeague();
});