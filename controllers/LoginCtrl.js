/**
 * Controller for managing user login.
 * Also manages user registering.
 *
 * @controller LoginCtrl
 */
app.controller('LoginCtrl', function ($scope, $http, $location)
{
	/**
	 * Method that logs the user in.
	 *
	 * @method btnLoginClick
	 */
	$scope.btnLoginClick = function () {
		console.log("Logging in!");
	};

	/**
	 * Method that registers the user.
	 *
	 * @method btnRegisterClick
	 */
	$scope.btnRegisterClick = function () {
		console.log("Registering!");
	};
});