/**
 * Controller for editing a user.
 *
 * @class ProfileEditCtrl
 */
app.controller('ProfileEditCtrl', function ($scope, $window, $location, CallModel)
{
	/**
	 * The user id.
	 *
	 * @property $scope.yourId
	 * @type Integer
	 */
	$scope.yourId = $window.sessionStorage.yourId;
	/**
	 * Error message to be displayed if there is an error.
	 *
	 * @property $scope.errorMsg
	 * @type String
	 */
	$scope.errorMsg;


	/**
	 * Method that is called when submit button is pressed.
	 *
	 * @method $scope.eventSubmit
	 */
	$scope.eventSubmit = function () {
		CallModel.fetch('UserUpdate', {
			first_name: $scope.first_name,
			last_name: $scope.last_name,
			home_phone: $scope.home_phone,
			mobile_phone: $scope.mobile_phone
		},
		{
			success: function (response) {
				alert("Successfully updated your profile");

				$location.path('/profile');
			},
			fail: function (response) {
				$scope.errorMsg = response.error_msg;
			}
		})
	};


	/**
	 * Method the gets the data of the user.
	 *
	 * @method getUserData
	 */
	function getUserData() {
		CallModel.fetch('UserGet', {
			id: $scope.yourId
		},
		{
			success: function (response) {
				$scope.first_name = response.first_name;
				$scope.last_name = response.last_name;
			},
			fail: function (response) {
				alert(response.error_msg);

				$location.path('/profile');
			}
		});
	}


	/*
	 * Redirects if not logged in.
	 * Then gets the user data to fill in the fields.
	 */
	 (function () {
	 	CallModel.redirectIfNotLoggedIn();
	 	getUserData();
	 }());
});