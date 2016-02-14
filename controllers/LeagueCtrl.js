/**
 * League page controller.
 *
 * @controller LeagueCtrl
 */
app.controller('LeagueCtrl', function ($scope, $http, $location, $routeParams, CallModel)
{
	$scope.subPage = 'table';
	$scope.table;


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

		CallModel.fetch('TournamentLeagueTable', {
			id: $routeParams.leagueId
		},
		{
			success: function (response) {
				$scope.table = response.table;
			}
		});
	}


	(function () {
		CallModel.redirectIfNotLoggedIn();
		getLeague();
	}());
});