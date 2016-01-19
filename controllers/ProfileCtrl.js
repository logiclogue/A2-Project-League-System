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
});