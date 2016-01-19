/**
 * Controller for managing the navbar.
 *
 * @controller NavCtrl
 */
app.controller('NavCtrl', function ($scope, $location, callModel)
{
	/**
	 * Changes login boolean depending whether logged in or not.
	 *
	 * @method loginButtonText
	 */
	function loginButtonCheck() {
		callModel.ifLoggedIn(function () {
			$scope.loggedIn = true;
		},
		function () {
			$scope.loggedIn = false;
		});
	}


	/**
	 * Event when logout button is clicked.
	 * Calls model 'Logout' then redirects to login page.
	 *
	 * @method $scope.btnLogout
	 */
	$scope.btnLogout = function () {
		callModel.fetch('Logout', {}, function () {});
		$location.path('/login');
	};


	$scope.$on('$routeChangeSuccess', loginButtonCheck);
});