/**
 * Directive used to search for a user.
 *
 * @directive cpUserSearch
 */
app.directive('cpUserSearch', function (CallModel)
{
	return {
		templateUrl: 'views/user-search.html',
		scope: {
			eventClickName: '=',
			theName: '@'
		},
		link: function (scope, element, attrs) {
			/**
			 * Method that is called when text in input field is changed.
			 * Updates search for user when input is changed.
			 *
			 * @method scope.eventInputChange
			 */
			scope.eventInputChange = function () {
				CallModel.fetch('UserSearch', {
					name: scope.inputName
				},
				{
					success: function (response) {
						scope.users = response.users;
					}
				});
			};
		}
	}
});