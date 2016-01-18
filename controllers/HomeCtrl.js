/**
 * Home controller.
 *
 * @method HomeCtrl
 */
app.controller('HomeCtrl', function ($scope, $http, $location, callModel)
{
	callModel.ifLoggedIn(function () { // If logged in.
		console.log("Logged in");
	},
	function () { // If not logged in, redirects to login page.
		$location.path('/login');
	});
});