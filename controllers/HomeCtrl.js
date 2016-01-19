/**
 * Home controller.
 *
 * @method HomeCtrl
 */
app.controller('HomeCtrl', function ($scope, $http, $location, callModel)
{
	var currentPage = 'results';


	/* 
	 * Checks to see if logged in.
	 * If not, redirects to login page.
	 */
	callModel.ifLoggedIn(function () {}, function () {
		$location.path('/login');
	});


	/**
	 * Method for view checking whether it can show a particular mini page.
	 *
	 * @method $scope.miniPage
	 * @param pageName {String} Name of the page to query.
	 * @return {Boolean} Whether that page is visible.
	 */
	$scope.miniPage = function (pageName) {
		return currentPage === pageName;
	};

	/**
	 *
	 *
	 *
	 */
	$scope.miniPageClass = function (pageName) {
		if (currentPage === pageName) {
			return 'active';
		}
		else {
			return '';
		}
	}

	/**
 	 * Method for changing the current mini page.
 	 *
 	 * @method btnChangeMiniPage
 	 * @param pageName {String} Name of page to switch to.
 	 */
	$scope.btnChangeMiniPage = function (pageName) {
		currentPage = pageName;
	};
});