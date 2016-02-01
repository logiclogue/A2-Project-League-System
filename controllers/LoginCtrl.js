/**
 * Controller for managing user login.
 * Also manages user registering.
 *
 * @controller LoginCtrl
 */
app.controller('LoginCtrl', function ($scope, $window, $http, $location, CallModel)
{
	$scope.response = {
		success: true
	};

	/*
	 * If user is logged in, redirects to home page.
	 */
	 CallModel.ifLoggedIn(function () {
	 	$location.path('/');
	 },
	 function () {});


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
		}, {
			success: function (response) {
				getUserData();

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
		CallModel.fetch('Register', {
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