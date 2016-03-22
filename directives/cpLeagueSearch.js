/**
 * Directive used to search for a tournament.
 *
 * @class cpLeagueSearch
 */
app.directive('cpLeagueSearch', function (CallModel)
{
	return {
		templateUrl: 'views/search.html',
		scope: {
			eventClickName: '=',
			theName: '@'
		},
		link: function (scope) {
			/**
			 * Must be empty string for search results box to fully hide
			 *
			 * @property scope.inputName
			 * @type String
			 */
			scope.inputName = '';
			

			/**
			 * Method that is called when text in input field is changed.
			 * Updates search for tournament when input is changed.
			 *
			 * @method scope.eventInputChange
			 */
			scope.eventInputChange = function () {
				CallModel.fetch('TournamentSearch', {
					name: scope.inputName
				},
				{
					success: function (response) {
						scope.results = response.tournaments;
					}
				});
			};
		}
	}
});