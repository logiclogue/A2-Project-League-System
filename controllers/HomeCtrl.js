/**
 * Home controller.
 *
 * @method HomeCtrl
 */
app.controller('HomeCtrl', function ($scope, $http, $location, callModel)
{
	/**
	 * Checks to see if logged in.
	 * If not, redirects to login page.
	 *
	 * 
	 */
	callModel.ifLoggedIn(function () { // If logged in.
		console.log("Logged in");
	},
	function () { // If not logged in, redirects to login page.
		$location.path('/login');
	});
});