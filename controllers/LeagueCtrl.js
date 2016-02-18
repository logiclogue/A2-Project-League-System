/**
 * League page controller.
 *
 * @controller LeagueCtrl
 */
app.controller('LeagueCtrl', function ($scope, $http, $location, $routeParams, CallModel)
{
	/**
	 * String that determines which sub page the user is on.
	 *
	 * @val $scope.subPage
	 * type String
	 */
	$scope.subPage = 'table';
	/**
	 * Object that contains the table data.
	 *
	 * @val $scope.table
	 * type Object
	 */
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