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
	 * Also binds other events.
	 *
	 * @method main
	 */
	function main() {
		$scope.eventInputChange = getUsers;

		$scope.$watch('inputName', function (inputName) {
			console.log(inputName);
		});
	}


	return {
		templateUrl: 'views/user-search.html',
		scope: {},
		link: function (scope, element, attrs) {
			$scope = scope;

			console.log(attrs);

			// When loaded call @method main.
			var waiting = scope.$watch('isReady', function (success) {
				console.log(scope.theName);

				if (success === true) {
					waiting();
					main();
				}
			});
		}
	}
});