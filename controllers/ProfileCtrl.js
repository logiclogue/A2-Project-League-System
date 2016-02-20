/**
 * Profile page controller.
 *
 * @controller ProfileCtrl
 */
app.controller('ProfileCtrl', function ($scope, $http, $location, $routeParams, CallModel, RatingChart)
{
	/**
	 * Id of the user.
	 *
	 * @var userId
	 */
	var userId;

	/**
	 * Variable for storing the name of the current subpage.
	 *
	 * @var $scope.currentSubPage
	 * @type {String}
	 */
	$scope.subPage = 'results';


	/**
	 * Method that gets user data from UserGet model.
	 *
	 * @method getUser
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
	 */
	function getStatus() {
		CallModel.fetch('Status', {}, {
			success: function (response) {
				userId = response.user.id;

				getUser(userId);
			}
		});
	}

	/**
	 * Method that gets the users ratings for the graph.
	 *
	 * @method getRatings
	 */
	function getRatings() {
		RatingChart.init();

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
		
		if ($routeParams.userId === undefined) {
			getStatus();
		}
		else {
			userId = $routeParams.userId;

			getUser(userId);
		}

		getRatings();
	}());
});