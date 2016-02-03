/**
 * Controller used to search for a user.
 *
 * @controller UserSearchCtrl
 */
app.controller('UserSearchCtrl', function ($scope, $location)
{
	/**
	 * Method that is called when a user is clicked.
	 * Clicked from @directive cpUserSearch.
	 *
	 * @method $scope.goToUserPage
	 * @param userId
	 */
	$scope.goToUserPage = function (userId) {
		$location.path('/profile/' + userId);
	}
});