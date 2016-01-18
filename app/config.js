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
		templateUrl: 'views/login.html',
		controller: 'LoginCtrl'
	})
	.when('/register', {
		templateUrl: 'views/login.html',
		controller: 'LoginCtrl'
	})
	.otherwise({
		redirectTo: '/'
	});
}]);