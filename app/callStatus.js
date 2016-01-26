app.factory('callStatus', function (callModel) {
	function update() {
		var self = this;

		callModel.fetch('Status', {}, {
			success: function (response) {
				self.data = response;
				console.log(self);
			}
		});
	}

	return {
		data: (function () {
			return update();
		}()),
		update: function () {
			update();
		}
	}
});