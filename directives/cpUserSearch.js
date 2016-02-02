/**
 * Directive used to search for a user.
 *
 * @directive cpUserSearch
 */
app.directive('cpUserSearch', function (CallModel)
{
	/**
	 * Variable that is used used for scope.
	 * Available to the view.
	 *
	 * @var $scope
	 */
	var $scope;


	/**
	 * Method that gets user info on the text in input field.
	 *
	 * @method getUsers
	 */
	function getUsers() {
		CallModel.fetch('UserSearch', {
			name: $scope.inputName
		},
		{
			success: function (response) {
				$scope.users = response.users;
			}
		});
	}

	/**
	 * Method that binds @var $scope.eventInputChange to @method getUsers.
	 *
	 * @method mainssss
	 */
	function main() {
		$scope.eventInputChange = getUsers;
	}


	return {
		templateUrl: 'views/user-search.html',
		scope: {
			isReady: '='
		},
		link: function (scope) {
			$scope = scope;

			// When loaded call @method main.
			var waiting = scope.$watch('isReady', function (success) {
				if (success === true) {
					waiting();
					main();
				}
			});
		}
	}
});