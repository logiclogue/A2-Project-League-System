/**
 * Profile page controller.
 *
 * @method ProfileCtrl
 */
app.controller('ProfileCtrl', function ($scope, $http, $location, callModel)
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

	/*
	 * Method that gets user data from UserGet model.
	 *
	 * @method getUser
	 */
	function getUser() {
		callModel.fetch('Status', {}, {
			success: function (response) {
				callModel.fetch('UserGet', {
					id: response.user.id
				},
				{
					success: function (response) {
						console.log(response);
						$scope.data = response;

						$scope.data.full_name = response.first_name + ' ' + response.last_name;
					},
					fail: function (response) {
						alert(response.error_msg);

						$location.path('/');
					}
				});
			}
		});
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
	getUser();
});