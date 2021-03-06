/**
 * Controller for managing user login.
 * Also manages user registering.
 *
 * @class LoginCtrl
 */
app.controller('LoginCtrl', function ($scope, $window, $http, $location, $route, CallModel)
{
	/**
	 * States the success of response.
	 *
	 * @property $scope.response
	 * @type Object
	 */
	$scope.response = {
		success: true
	};

	/**
	 * States the success of the response from registering.
	 *
	 * @property $scope.responseRegister
	 * @type Object
	 */
	$scope.responseRegister = {
		success: true
	};

	/*
	 * If user is logged in, redirects to home page.
	 */
	 CallModel.ifLoggedIn(function () {
	 	$location.path('/');
	 },
	 function () {});


	 /**
	  * Method for getting user data and storing it in a session.
	  *
	  * @method getUserData
	  */
	 function getUserData() {
	 	CallModel.fetch('Status', {},
	 	{
	 		success: function (response) {
	 			$window.sessionStorage.yourId = response.user.id;
	 		}
	 	});
	 }


	/**
	 * Method that logs the user in.
	 *
	 * @method eventLogin
	 */
	$scope.eventLogin = function () {
		CallModel.fetch('Login', {
			email: $scope.inputEmailLogin,
			password: $scope.inputPasswordLogin
		},
		{
			success: function (response) {
				getUserData();

				alert('You have successfully logged in');
				
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
	 * @method eventRegister
	 */
	$scope.eventRegister = function () {
		if ($scope.inputPasswordRegister === $scope.inputPasswordRepeatRegister) {
			CallModel.fetch('Register', {
				first_name: $scope.inputFirstName,
				last_name: $scope.inputLastName,
				email: $scope.inputEmailRegister,
				password: $scope.inputPasswordRegister
			},
			{
				success: function (response) {
					alert('You have successfully registered. You must now login.');
					
					$route.reload();
				},
				fail: function (response) {
					$scope.responseRegister = response;
				}
			});
		}
		else {
			$scope.responseRegister = {
				success: false,
				error_msg: 'Passwords do not match'
			}
		}
	};
});