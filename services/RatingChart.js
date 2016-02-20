/**
 * Factory for handling the rating graph.
 *
 * @factory RatingChart
 */
app.factory('RatingChart', function ()
{
	/**
	 * Canvas context variable.
	 *
	 * @val ctx
	 * @private
	 */
	var ctx;
	/**
	 * Chart object for talking to Chart.JS library.
	 *
	 * @val chart
	 * @private
	 */
	var chart;
	/**
	 * List of dates corresponding to a rating.
	 *
	 * @val dates
	 * @private
	 */
	var dates = [];
	/**
	 * List of ratings for the graph.
	 *
	 * @val averageRating
	 * @private
	 */
	var averageRating = [];
	/**
	 * Data object for drawing the chart.
	 *
	 * @val data
	 * @private
	 */
	var data = {
		labels: dates,
		datasets: [
			{
				label: "Average rating",
				fillColor: "rgba(220,220,220,0.2)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: averageRating
			}
		]
	};
	/**
	 * Configuration for drawing the chart.
	 *
	 * @val options
	 * @private
	 */
	var options = {
		scaleShowGridLines : true,
		scaleGridLineColor : "rgba(0,0,0,.05)",
		scaleGridLineWidth : 1,
		scaleShowHorizontalLines: true,
		scaleShowVerticalLines: true,
		bezierCurve : true,
		bezierCurveTension : 0.4,
		pointDot : true,
		pointDotRadius : 4,
		pointDotStrokeWidth : 1,
		pointHitDetectionRadius : 20,
		datasetStroke : true,
		datasetStrokeWidth : 2,
		datasetFill : true,
		legendTemplate : ""
	};


	return {
		/**
		 * Method that filters the ratings into different tournaments.
		 *
		 * @method inputRatings
		 * @param ratings {Array} Array of all the ratings over time.
		 */
		inputRatings: function (ratings) {
			// Initialise the tournament array.
			var tournamentRatings = [];

			// Sort into different tournaments.
			ratings.forEach(function (rating) {
				tournamentRatings[rating.tournament_id] = tournamentRatings[rating.tournament_id] || [];
				tournamentRatings[rating.tournament_id].tournament_name = rating.tournament_name;
				tournamentRatings[rating.tournament_id].push(rating);
			});

			// Sort rating in reverse order.
			ratings.sort(function (a, b) {
				return a.date > b.date;
			});

			// Calculate average rating.
			ratings.forEach(function () {
				var average;

				return function (rating) {
					average = average + parseInt(rating.rating_change) || parseInt(rating.rating);

					averageRating.push(average);
					dates.push(rating.date);
				};
			}());
		},
		/**
		 * Call this method when initialising the graph.
		 *
		 * @method init
		 */
		init: function () {
			ctx = document.getElementById('canvas-rating-chart').getContext('2d');
			chart = new Chart(ctx);

			// Reset arrays without deleting reference
			dates.splice(0, dates.length);
			averageRating.splice(0, averageRating.length);
		},
		/**
		 * This method is called when drawing the graph.
		 *
		 * @method draw
		 */
		draw: function () {
			chart.Line(data, options);
		}
	}
});