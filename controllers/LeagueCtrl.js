/**
 * League page controller.
 *
 * @controller LeagueCtrl
 */
app.controller('LeagueCtrl', function ($scope, $http, $location, $routeParams, CallModel)
{
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
	 * Method that redirects if not a subpage.
	 *
	 * @method checkSubPage
	 */
	function checkSubPage() {
		switch ($routeParams.subPage) {
			case 'fixtures':
			case 'results':
			case 'table':
				break;
			default:
				$location.path('/league/' + $routeParams.leagueId);
		}
	}


	(function () {
		CallModel.redirectIfNotLoggedIn();
		getLeague();
		checkSubPage();
	}());
});