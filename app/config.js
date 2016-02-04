/****************************************
 * Angular config.                      *
 * Mainly used to configure the routes. *
 ****************************************/
app.config(['$routeProvider', function ($routeProvider)
{
	$routeProvider
	.when('/', {
		templateUrl: 'views/home.html',
		controller: 'HomeCtrl'
	})
	.when('/user', {
		templateUrl: 'views/user-search-page.html',
		controller: 'UserSearchCtrl'
	})
	.when('/profile', {
		templateUrl: 'views/profile.html',
		controller: 'ProfileCtrl'
	})
	.when('/profile/:userId', {
		templateUrl: 'views/profile.html',
		controller: 'ProfileCtrl'
	})
	.when('/league', {
		templateUrl: 'views/league-search-page.html',
		controller: 'LeagueSearchCtrl'
	})
	.when('/league/create', {
		templateUrl: 'views/league-edit.html',
		controller: 'LeagueCreateCtrl'
	})
	.when('/league/:leagueId', {
		templateUrl: 'views/league.html',
		controller: 'LeagueCtrl'
	})
	.when('/league/:leagueId/edit', {
		templateUrl: 'views/league-edit.html',
		controller: 'LeagueEditCtrl'
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