/**
 * Home controller.
 *
 * @method HomeCtrl
 */
app.controller('HomeCtrl', function ($scope, $http, $location, callModel)
{
	var currentSubPage = 'results';


	/* 
	 * Checks to see if logged in.
	 * If not, redirects to login page.
	 */
	callModel.ifLoggedIn(function () {}, function () {
		$location.path('/login');
	});


	/**
	 * Method for view checking whether it can show a particular sub page.
	 *
	 * @method $scope.isSubPage
	 * @param pageName {String} Name of the page to query.
	 * @return {Boolean} Whether that page is visible.
	 */
	$scope.isSubPage = function (pageName) {
		return currentSubPage === pageName;
	};

	/**
	 * Method for returning the class for an active sub page button.
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