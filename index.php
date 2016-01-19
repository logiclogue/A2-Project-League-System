<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Computing Project</title>
	<meta name="author" content="Jordan Lord">

	
	<script src="lib/angular.min.js"></script>
	<script src="lib/angular-route.min.js"></script>

	<script src="app/app.js"></script>
	<script src="app/config.js"></script>
	<script src="app/callModel.js"></script>
	<script src="controllers/LoginCtrl.js"></script>
	<script src="controllers/HomeCtrl.js"></script>
	<script src="controllers/NavCtrl.js"></script>


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
				<li><a href="" ng-show="loggedIn" ng-click="btnLogout()">Logout</a></li>
				<li><a href="#/login" ng-hide="loggedIn">Login/Register</a></li>
				<li><a href="#/" ng-show="loggedIn">Profile</a></li>
				<li><a href="#/" ng-show="loggedIn">Tournaments</a></li>
				<li><a href="#/" ng-show="loggedIn">Home</a></li>
			</ul>
		</div>
	</div>

	<!-- Main area for page -->
	<div ng-view></div>

</body>
</html>