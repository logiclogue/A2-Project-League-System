/**
 * Angular config.
 * Mainly used to configure the routes.
 *
 *
 */
app.config(['$routeProvider', function ($routeProvider)
{
	$routeProvider
	.when('/', {

	})
	.when('/login', {
		templateUrl: 'views/login.php',
		controller: 'LoginCtrl'
	})
	.otherwise({
		redirectTo: '/'
	});
}]);