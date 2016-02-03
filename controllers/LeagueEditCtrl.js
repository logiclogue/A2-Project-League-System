/**
 * Controller for editing a league.
 *
 * @controller LeagueEditCtrl
 */
app.controller('LeagueEditCtrl', function ($scope, $window, $location, $routeParams, CallModel)
{
	/**
	 * The text that goes in the edit page.
	 *
	 * @var $scope.editOrCreate
	 * @type String
	 */
	$scope.editOrCreate = 'Edit';
	/**
	 * Id of the user.
	 * Used to prevent the user from removing themselves as a league manager.
	 *
	 * @var $scope.yourId
	 * @type Integer
	 */
	$scope.yourId = $window.sessionStorage.yourId;
	$scope.addingManager = false;
	$scope.addingPlayer = false;

	/**
	 * Method that redirects to home page and prints error message.
	 *
	 * @method redirect
	 */
	function redirect(response) {
		alert(response.error_msg);

		$location.path('/');
	}

	/**
	 * Method for getting league data from @class TournamentGet.
	 *
	 * @method getLeague
	 */
	function getLeague() {
		CallModel.fetch('TournamentGet', {
			id: $routeParams.leagueId
		},
		{
			success: function (response) {
				$scope.data = response;
				// Fill fields with current league info.
				$scope.name = response.name;
				$scope.description = response.description;

				// Check to see if user isn't a league manager, and then redirect
				if (!response.is_league_manager) {
					response.error_msg = "You must be a league manager to edit the league";

					redirect(response);
				}
			},
			fail: redirect
		});
	}


	/**
	 * Function that is called when the update button is pressed.
	 *
	 * @method $scope.eventUpdate
	 */
	$scope.eventUpdate = function () {
		// Calls @class TournamentUpdate with info from name and description fields.
		CallModel.fetch('TournamentUpdate', {
			id: $routeParams.leagueId,
			name: $scope.name,
			description: $scope.description
		},
		{
			success: function (response) {
				$location.path('/league/' + $routeParams.leagueId);
			},
			fail: function (response) {
				alert(response.error_msg);
			}
		});
	}

	/**
	 * Function that is called when a player is removed from the league.
	 *
	 * @method $scope.eventRemoveUser
	 * @param userId {Integer} Id of the player to remove.
	 */
	$scope.eventRemovePlayer = function (userId) {
		CallModel.fetch('TournamentPlayerRemove', {
			user_id: userId,
			tournament_id: $routeParams.leagueId
		},
		{
			success: function (response) {
				getLeague();
			},
			fail: function (response) {
				alert(response.error_msg);
			}
		});
	};

	/**
	 * Function that is called when a league manager is removed.
	 *
	 * @method $scope.eventRemoveManager
	 * @param userId {Integer} Id of the league manager to remove.
	 */
	$scope.eventRemoveManager = function (userId) {
		CallModel.fetch('TournamentManagerRemove', {
			user_id: userId,
			tournament_id: $routeParams.leagueId
		},
		{
			success: function (response) {
				getLeague();
			}
		});
	};

	$scope.eventAddManager = function () {
		$scope.addingManager = true;
		$scope.addingPlayer = false;
	};

	$scope.eventAddPlayer = function () {
		$scope.addingManager = false;
		$scope.addingPlayer = true;
	};

	$scope.eventCancelAdding = function () {
		$scope.addingManager = false;
		$scope.addingPlayer = false;
	};


	(function () {
		/* 
		 * Checks to see if logged in.
		 * If not, redirects to login page.
		 */
		CallModel.redirectIfNotLoggedIn();

		getLeague();
	}());
});