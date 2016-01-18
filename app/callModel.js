/**
 * Factory for calling the PHP models.
 *
 * @factory callModel
 */
app.factory('callModel', function ($http, $location)
{
	return {
		/**
		 * Method for fetching a result from a model.
		 * Sends data to the model.
		 *
		 * @method fetch
		 * @param modelName {String} Name of the model to call.
		 * @param data {Object} Data to pass to the model.
		 * @param callback {Function} Function that gets called when receives response from model.
		 */
		fetch: function (modelName, data, callback) {
			$http({
				url: 'models/' + modelName + '.php',
				method: 'POST',
				data: 'JSON=' + encodeURIComponent(JSON.stringify(data)),
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			})
			.then(callback);
		},
		/**
		 * Method that accepts two functions.
		 * One is executed if the user is logged in.
		 * The other is called if the user is not logged in.
		 *
		 * @method ifLoggedIn
		 * @param callbackTrue {Function} Called if logged in.
		 * @param callbackFalse {Function} Called if not logged in.
		 */
		ifLoggedIn: function (callbackTrue, callbackFalse) {
			this.fetch('Status', {}, function (response) {
				console.log(response.data);
				if (response.data.logged_in) {
					callbackTrue();
				}
				else {
					callbackFalse();
				}
			});
		}
	};
});