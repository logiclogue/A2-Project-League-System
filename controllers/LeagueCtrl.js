/**
 * League page controller.
 *
 * @controller LeagueCtrl
 */
app.controller('LeagueCtrl', function ($scope, $http, $location, callModel) {
	/* 
	 * Checks to see if logged in.
	 * If not, redirects to login page.
	 */
	callModel.ifLoggedIn(function () {}, function () {
		$location.path('/login');
	});


	/**
	 * Method for getting league data from @class TournamentGet.
	 *
	 * @method getLeague
	 */
	function getLeague() {
		callModel.fetch('TournamentGet', {
			id: 1
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


	getLeague();
});