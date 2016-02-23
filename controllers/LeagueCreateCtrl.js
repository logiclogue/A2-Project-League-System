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
	 * @var $scope.editOrCreate
	 * @type String
	 */
	$scope.editOrCreate = 'Create';
	/**
	 * Object where error message is and tells whether there is an error message.
	 *
	 * @property $scope.response
	 * @type Object
	 */
	$scope.response = {
		success: true
	}
	
	
	/**
	 * Event that is called when 'Create' button is clicked.
	 * Creating the league.
	 *
	 * @method $scope.eventUpdate
	 */
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
				$scope.response = response;
			}
		});
	};


	(function () {
		CallModel.redirectIfNotLoggedIn();
	}());
});