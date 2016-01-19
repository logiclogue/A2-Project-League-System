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
		templateUrl: 'views/home.html',
		controller: 'HomeCtrl'
	})
	/*.when('/tournaments', {
		templateUrl: 'views/tournament-list.html',
		controller: 'TournamentListCtrl'
	})*/
	.when('/profile', {
		templateUrl: 'views/profile.html',
		controller: 'ProfileCtrl'
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