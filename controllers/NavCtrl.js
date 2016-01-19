/**
 * Controller for managing the navbar.
 *
 * @controller NavCtrl
 */
app.controller('NavCtrl', function ($scope, callModel)
{
	/**
	 * Changes nav button 'Login' depending whether logged in or not
	 *
	 *
	 */
	callModel.ifLoggedIn(function () {
		$scope.aLoginLogout = 'Logout';
	},
	function () {
		$scope.aLoginLogout = 'Login/Register';
	});
});