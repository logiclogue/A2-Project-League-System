/**
 * Controller used to search for a user.
 *
 * @class UserSearchCtrl
 */
app.controller('UserSearchCtrl', function ($scope, $location)
{
	/**
	 * Method that is called when a user is clicked.
	 * Clicked from @directive cpUserSearch.
	 *
	 * @method $scope.eventClickUser
	 * @param userId {Integer} Id of the user.
	 */
	$scope.eventClickUser = function (userId) {
		$location.path('/profile/' + userId);
	}
});