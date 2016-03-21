/**
 * Factory for calling the PHP models.
 *
 * @module CallModel
 */
app.factory('CallModel', function ($http, $location)
{
	return {
		/**
		 * Method for fetching a result from a model.
		 * Sends data to the model.
		 *
		 * @method fetch
		 * @param modelName {String} Name of the model to call.
		 * @param data {Object} Data to pass to the model.
		 * @param callbacks {Object} Collection of functions that will be called depending on the result.
		 *   @param success {Function} Function that is called on success.
		 *   @param fail {Function} Function that is called on fail.
		 *   @param normal {Function} Function that is called regardless.
		 */
		fetch: function (modelName, data, callbacks) {
			$http({
				url: 'php/API.php',
				method: 'POST',
				data: 'JSON=' + encodeURIComponent(JSON.stringify(data)) + '&model=' + modelName,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			})
			.then(function (response) {
				if (response.data.success && typeof callbacks.success == 'function') {
					callbacks.success(response.data);
				}
				else if (!response.data.success && typeof callbacks.fail == 'function') {
					callbacks.fail(response.data);
				}

				if (typeof callbacks.normal == 'function') {
					callbacks.normal(response.data);
				}
			});
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
			this.fetch('Status', {}, {
				success: function (response) {
					if (response.logged_in) {
						callbackTrue();
					}
					else {
						callbackFalse();
					}
				}
			});
		},
		/**
		 * Method that redirects to login page if not logged in.
		 *
		 * @method redirectIfNotLoggedIn
		 */
		redirectIfNotLoggedIn: function () {
			this.ifLoggedIn(function () {}, function () {
				$location.path('/login');
			});
		}
	};
});