/**
 * Controller that allows a user to input a result.
 *
 * @module ResultEnterCtrl
 */
app.controller('ResultEnterCtrl', function ($scope, $routeParams, $location, CallModel, DateFormat)
{
	/**
	 * The id of the tournament as defined by the route parametre.
	 *
	 * @property $scope.tournamentId
	 * @type Integer
	 */
	$scope.tournamentId = $routeParams.tournamentId;
	/**
	 * Name of the tournament.
	 *
	 * @property $scope.tournamentName
	 * @type String
	 */
	$scope.tournamentName;
	/**
	 * Player 1 data object.
	 *
	 * @property $scope.player1
	 * @type Integer
	 */
	$scope.player1 = {};
	/**
	 * Player 2 data object.
	 *
	 * @property $scope.player2
	 * @type Integer
	 */
	$scope.player2 = {};
	/**
	 * The date that the result will be entered.
	 *
	 * @property $scope.date
	 * @type String
	 */
	$scope.date = DateFormat.getString(Date.now());
	/**
	 * Error message, if there is one.
	 *
	 * @property $scope.errorMsg
	 * @type String
	 */
	$scope.errorMsg = '';


	/**
	 * Method that is called when submit button is pressed.
	 * Enters a result.
	 *
	 * @method $scope.eventSubmitResult
	 */
	$scope.eventSubmitResult = function () {
		CallModel.fetch('ResultEnter', {
			tournament_id: $routeParams.tournamentId,
			player1_id: $routeParams.player1Id,
			player2_id: $routeParams.player2Id,
			player1_score: $scope.player1.score,
			player2_score: $scope.player2.score
		},
		{
			success: function (response) {
				alert('Successfully entered result');

				$location.path('/league/' + $routeParams.tournamentId);
			},
			fail: function (response) {
				$scope.errorMsg = response.error_msg;
			}
		})
	};


	/**
	 * Method for getting information about the tournament.
	 *
	 * @method getTournamentData
	 */
	function getTournamentData() {
		CallModel.fetch('TournamentGet', {
			id: $routeParams.tournamentId
		},
		{
			success: function (response) {
				$scope.tournamentName = response.name;
			}
		});
	}

	/**
	 * Method that gets the player data.
	 *
	 * @method getPlayerData
	 */
	function getPlayerData() {
		CallModel.fetch('UserGet', {
			id: $routeParams.player1Id
		},
		{
			success: function (response) {
				$scope.player1.fullName = response.first_name + ' ' + response.last_name;
				$scope.player1.id = response.id;
			}
		});

		CallModel.fetch('UserGet', {
			id: $routeParams.player2Id
		},
		{
			success: function (response) {
				$scope.player2.fullName = response.first_name + ' ' + response.last_name;
				$scope.player2.id = response.id;
			}
		})
	}


	/*
	 * Redirects if not logged in.
	 * Gets data about tournament and user.
	 */
	(function () {
		CallModel.redirectIfNotLoggedIn();
		getTournamentData();
		getPlayerData();
	}());
});