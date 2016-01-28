/**
 * Controller for managing the navbar.
 *
 * @controller NavCtrl
 */
app.controller('NavCtrl', function ($scope, $location, CallModel)
{
	/**
	 * Changes login boolean depending whether logged in or not.
	 *
	 * @method loginButtonText
	 */
	function loginButtonCheck() {
		CallModel.ifLoggedIn(function () {
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
		CallModel.fetch('Logout', {}, {
			success: function () {
				$location.path('/login');
			}
		});
	};


	$scope.$on('$routeChangeSuccess', loginButtonCheck);
});