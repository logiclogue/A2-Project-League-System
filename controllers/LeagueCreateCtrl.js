/**
 * Controller for creating a league.
 *
 * @controller LeagueCreateCtrl
 */
app.controller('LeagueCreateCtrl', function ($scope, $location, CallModel)
{
	/**
	 * The text that goes in the edit page.
	 *
	 * @val $scope.editOrCreate
	 * @type String
	 */
	$scope.editOrCreate = 'Create';


	CallModel.redirectIfNotLoggedIn();
	
	
	$scope.eventUpdate = function () {
		CallModel.fetch('TournamentCreate', {
			name: $scope.name,
			description: $scope.description
		},
		{
			success: function (response) {
				$location.path('/league/' + response.id);
			},
			fail: function (response) {
				alert(response.error_msg);
			}
		});
	};
});