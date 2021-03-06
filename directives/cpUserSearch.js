/**
 * Directive used to search for a user.
 *
 * @class cpUserSearch
 */
app.directive('cpUserSearch', function (CallModel)
{
	return {
		templateUrl: 'views/search.html',
		scope: {
			eventClickName: '=',
			theName: '@'
		},
		link: function (scope, element, attrs) {
			/**
			 * Search name
			 *
			 * @property scope.inputName
			 * @type String
			 */
			scope.inputName = '';

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
						scope.results = response.users;
					}
				});
			};
		}
	}
});