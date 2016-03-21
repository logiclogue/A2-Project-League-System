/**
 * Factory for handling the rating graph.
 *
 * @module RatingChart
 */
app.factory('RatingChart', function ()
{
	/**
	 * @property ctx
	 * @type Object
	 */
	var ctx;
	/**
	 * Chart object for talking to Chart.JS library.
	 *
	 * @property chart
	 * @type Object
	 */
	var chart;
	/**
	 * List of dates corresponding to a rating.
	 *
	 * @property dates
	 * @type Array
	 */
	var dates = [];
	/**
	 * List of ratings for the graph.
	 *
	 * @property averageRating
	 * @type Array
	 */
	var averageRating = [];
	/**
	 * Data object for drawing the chart.
	 *
	 * @property data
	 * @type Object
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
	 * @property options
	 * @type Object
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
			// Sort rating in reverse order.
			ratings.sort(function (a, b) {
				return a.date > b.date;
			});

			// Calculate average rating.
			ratings.forEach(function (rating) {
				averageRating.push(parseInt(rating.rating));
				dates.push(rating.date);
			});
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

			dates.push('');
			averageRating.push(1300);
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