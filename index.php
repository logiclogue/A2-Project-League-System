<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Computing Project</title>
	<meta name="author" content="Jordan Lord">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="lib/normalize.css">
	<link rel="stylesheet" href="lib/skeleton.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body ng-app="computing-project">

	<!-- Navbar -->
	<div id="div-navbar" class="u-full-width" ng-controller="NavCtrl">
		<div class="ten columns offset-by-one">
			<a id="a-title">Computing Project</a>
			<ul>
				<li><a href="#/login" ng-hide="loggedIn">Login/Register</a></li>
				<li><a href="#/" ng-show="loggedIn" ng-click="btnLogout()">Logout</a></li>
				<li><a href="#/profile" ng-show="loggedIn">Profile</a></li>
				<li><a href="#/league" ng-show="loggedIn">League</a></li>
				<li><a href="#/">Home</a></li>
			</ul>
		</div>
	</div>

	<!-- Main area for page -->
	<div ng-view></div>



	<script src="lib/angular.min.js"></script>
	<script src="lib/angular-route.min.js"></script>


	<script src="app/app.js"></script>
	<script src="app/config.js"></script>

	<script src="services/CallModel.js"></script>

	<script src="directives/cpResult.js"></script>
	<script src="directives/cpFixtures.js"></script>
	<script src="directives/cpUserSearch.js"></script>
	<script src="directives/cpLeagueSearch.js"></script>

	<script src="controllers/LoginCtrl.js"></script>
	<script src="controllers/ProfileCtrl.js"></script>
	<script src="controllers/UserSearchCtrl.js"></script>
	<script src="controllers/NavCtrl.js"></script>
	<script src="controllers/HomeCtrl.js"></script>
	<script src="controllers/LeagueCtrl.js"></script>
	<script src="controllers/LeagueEditCtrl.js"></script>
	<script src="controllers/LeagueCreateCtrl.js"></script>
	<script src="controllers/LeagueSearchCtrl.js"></script>
	<script src="controllers/ResultEnterCtrl.js"></script>
</body>
</html>