<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Squash League System</title>
	<meta name="author" content="Jordan Lord">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="build/all.css">

</head>
<body ng-app="computing-project">

	<!-- Navbar -->
	<div id="div-navbar" class="u-full-width" ng-controller="NavCtrl">
		<div class="ten columns offset-by-one">
			<a id="a-title">Squash League System</a>
			<ul>
				<li><a href="#/login" ng-hide="loggedIn">Login/Register</a></li>
				<li><a href="#/" ng-show="loggedIn" ng-click="btnLogout()">Logout</a></li>
				<li><a href="#/profile" ng-show="loggedIn">Profile</a></li>
				<li><a href="#/user" ng-show="loggedIn">User</a></li>
				<li><a href="#/league" ng-show="loggedIn">League</a></li>
				<li><a href="#/">Home</a></li>
			</ul>
		</div>
	</div>

	<!-- Main area for page -->
	<div ng-view></div>


	<script src="build/all.js"></script>
</body>
</html>