/**
 * League page controller.
 *
 * @controller LeagueCtrl
 */
app.controller('LeagueCtrl', function ($scope, $http, $location, $routeParams, CallModel)
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

				console.log($scope.data);
			},
			fail: function (response) {
				alert(response.error_msg);

				$location.path('/');
			}
		});
	}


	getLeague();
});