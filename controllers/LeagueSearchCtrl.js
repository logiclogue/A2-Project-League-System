/**
 * Controller used to search for a leauge.
 *
 * @class UserSearchCtrl
 */
app.controller('LeagueSearchCtrl', function ($scope, $location)
{
	/**
	 * Method that is called when a league is clicked.
	 * Clicked from @directive cpLeagueSearch.
	 *
	 * @method $scope.eventClickLeague
	 * @param leagueId {Integer} Id of the league.
	 */
	$scope.eventClickLeague = function (leagueId) {
		$location.path('/league/' + leagueId);
	}
});