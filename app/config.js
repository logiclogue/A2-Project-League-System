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
	.when('/profile/edit', {
		templateUrl: 'views/profile-edit.html',
		controller: 'ProfileEditCtrl'
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
	.when('/league/:leagueId/edit', {
		templateUrl: 'views/league-edit.html',
		controller: 'LeagueEditCtrl'
	})
	.when('/league/:leagueId', {
		templateUrl: 'views/league.html',
		controller: 'LeagueCtrl'
	})
	.when('/result/enter/:tournamentId/:player1Id/:player2Id', {
		templateUrl: 'views/result-enter.html',
		controller: 'ResultEnterCtrl'
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