/**
 * Factory for handling the rating graph.
 *
 * @factory RatingChart
 */
app.factory('RatingChart', function ()
{
	var canvas = document.getElementById('canvas-rating-chart');
	var ctx = canvas.getContext('2d');
	var chart = new Chart(ctx);
	var dates = [];
	var averageRating = [];
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
				var average = 0;
				var count = 1;

				return function (rating) {
					average = average + ((rating.rating - average) / count);
					average = Math.round(average);

					count += 1;

					rating.average_rating = average;
					averageRating.push(average);
					dates.push(rating.date);
				};
			}());
		},
		draw: function () {
			chart.Line(data, options);
		}
	}
});