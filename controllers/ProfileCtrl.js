/**
 * Profile page controller.
 *
 * @controller ProfileCtrl
 */
app.controller('ProfileCtrl', function ($scope, $http, $location, $routeParams, callModel)
{
	/**
	 * Variable for storing the name of the current subpage.
	 *
	 * @var currentSubPage
	 * @type {String}
	 */
	var currentSubPage = 'results';


	/*
	 * Checks to see if logged in.
	 * If not, redirects to login page.
	 */
	callModel.ifLoggedIn(function () {}, function () {
		$location.path('/login');
	});

	/**
	 * Method that gets user data from UserGet model.
	 *
	 * @method getUser
	 */
	function getUser(user_id) {
		callModel.fetch('UserGet', {
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
	 *
	 * @method getStatus
	 */
	function getStatus() {
		callModel.fetch('Status', {}, {
			success: function (response) {
				getUser(response.user.id);
			}
		})
	}


	/**
	 * Method for view checking whether it can show a particular subpage.
	 *
	 * @method $scope.isSubPage
	 * @param pageName {String} Name of the page to query.
	 * @return {Boolean} Whether that page is visible.
	 */
	$scope.isSubPage = function (pageName) {
		return currentSubPage === pageName;
	};

	/**
	 * Method for returning the class for an active subpage button.
	 *
	 * @method subPageClass
	 */
	$scope.subPageClass = function (pageName) {
		if (currentSubPage === pageName) {
			return 'active';
		}
		else {
			return '';
		}
	}

	/**
 	 * Method for changing the current subs page.
 	 *
 	 * @method btnChangeSubPage
 	 * @param pageName {String} Name of page to switch to.
 	 */
	$scope.btnChangeSubPage = function (pageName) {
		currentSubPage = pageName;
	};


	/*
	 * Standard controller calls.
	 */
	if ($routeParams.userId === undefined) {
		getStatus();
	}
	else {
		getUser($routeParams.userId);
	}
});