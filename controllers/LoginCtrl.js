/**
 * Controller for managing user login.
 * Also manages user registering.
 *
 * @controller LoginCtrl
 */
app.controller('LoginCtrl', function ($scope, $http, $location, callModel, callStatus)
{
	$scope.response = {
		success: true
	};

	/*
	 * If user is logged in, redirects to home page.
	 */
	 callModel.ifLoggedIn(function () {
	 	$location.path('/');
	 },
	 function () {});


	/**
	 * Method that logs the user in.
	 *
	 * @method btnLoginClick
	 */
	$scope.btnLoginClick = function () {
		callModel.fetch('Login', {
			email: $scope.inputEmailLogin,
			password: $scope.inputPasswordLogin
		}, {
			success: function (response) {
				callStatus.update();
				$location.path('/');
			},
			fail: function (response) {
				$scope.response = response;
			}
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