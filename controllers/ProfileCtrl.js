/**
 * Profile page controller.
 *
 * @class ProfileCtrl
 */
app.controller('ProfileCtrl', function ($scope, $http, $location, $routeParams, $window, CallModel, RatingChart)
{
	/**
	 * Id of the user.
	 *
	 * @property userId
	 * @type Integer
	 */
	var userId;

	/**
	 * Variable for storing the name of the current subpage.
	 *
	 * @property $scope.currentSubPage
	 * @type String
	 */
	$scope.subPage = 'results';
	/**
	 * Is user.
	 *
	 * @property $scope.isUser
	 * @type Boolean
	 */
	 $scope.isUser = false;


	/**
	 * Method that gets user data from UserGet model.
	 *
	 * @method getUser
	 * @param user_id {Integer} Id of user to get.
	 */
	function getUser(user_id) {
		CallModel.fetch('UserGet', {
			id: user_id
		},
		{
			success: function (response) {
				$scope.data = response;
				$scope.data.full_name = response.first_name + ' ' + response.last_name;
			},
			fail: function (response) {
				alert(response.error_msg);

				$location.path('/');
			}
		});
	}

	/**
	 * Method the gets the id of the current user.
	 * Then calls @method getUser with id of current user.
	 *
	 * @method getStatus
	 * @param callback {Function} Executes after response from server.
	 */
	function getStatus(callback) {
		CallModel.fetch('Status', {}, {
			success: function (response) {
				userId = response.user.id;

				getUser(userId);
				callback();
			}
		});
	}

	/**
	 * Method that gets the users ratings for the graph.
	 *
	 * @method getRatings
	 */
	function getRatings() {
		CallModel.fetch('UserRatings', {
			user_id: userId
		}, {
			success: function (response) {
				RatingChart.inputRatings(response.ratings);
				RatingChart.draw();
			}
		});
	}


	/*
	 * Redirects if not logged in.
	 * Checks whether url user id is set.
	 * If not, calls @method getStatus.
	 * Else, calls @method getUser with id of user.
	 */
	(function () {
		CallModel.redirectIfNotLoggedIn();

		RatingChart.init();
		
		if ($routeParams.userId === undefined) {
			$scope.isUser = true;

			getStatus(function () {
				getRatings();
			});
		}
		else {
			userId = $routeParams.userId;
			$scope.isUser = $window.sessionStorage.yourId === userId;

			getUser(userId);
			getRatings();
		}
	}());
});