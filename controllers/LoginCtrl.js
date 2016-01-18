/**
 * Controller for managing user login.
 * Also manages user registering.
 *
 * @controller LoginCtrl
 */
app.controller('LoginCtrl', function ($scope, $http, $location, callModel)
{
	/**
	 * Method that logs the user in.
	 *
	 * @method btnLoginClick
	 */
	$scope.btnLoginClick = function () {
		callModel.fetch('Login', {
			email: $scope.inputEmailLogin,
			password: $scope.inputPasswordLogin
		},
		function (response) {
			console.log(response.data);
		});
	};

	/**
	 * Method that registers the user.
	 *
	 * @method btnRegisterClick
	 */
	$scope.btnRegisterClick = function () {
		callModel.fetch('Register', {
			first_name: $scope.inputFirstName,
			last_name: $scope.inputLastName,
			email: $scope.inputEmailRegister,
			password: $scope.inputPasswordRegister
		},
		function (response) {
			console.log(response.data);
		});
	};
});