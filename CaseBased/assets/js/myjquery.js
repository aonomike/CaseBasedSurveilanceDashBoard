$(document).ready(function () {
		$(".date-picker").datepicker({
			dateFormat:"yy-mm-dd"
		});			
});

window.onload = function(){
		// var event_id= $("#event-id").val();
		// load_graph_data(event_id);		
		// var ctx = document.getElementById("canvas").getContext("2d");
		// window.myBar = new Chart(ctx).Bar(barChartData, {
		// 	responsive : true
		// });
	}


function load_graph_data(event_id){	
	var post_url='/CaseBased/Dashboard/get_event_count_by_month';
	var start_date = $("#start-date").val();
	var end_date = $("#end-date").val();
	var county = $("#county").val();
	var facility = $("#facility").val();

	$.post(post_url,{"event_id":event_id, "start_date": start_date, "end_date": end_date, "facility":facility, "county":county}, function(returned_data) {	
		var labels = new Array();
		var male_count = new Array();
		var female_count = new Array();
		$.each(returned_data, function(){
				labels.push(this.MONTH_NAME);
				male_count.push(this.MALE_COUNT);
				female_count.push(this.FEMALE_COUNT);
		});

		var barChartData = {
							labels :labels,
							datasets : [
								{
									fillColor : "rgba(220,220,220,0.5)",
									strokeColor : "rgba(220,220,220,0.8)",
									highlightFill: "rgba(220,220,220,0.75)",
									highlightStroke: "rgba(220,220,220,1)",
									data : male_count
								},
								{
									fillColor : "rgba(151,187,205,0.5)",
									strokeColor : "rgba(151,187,205,0.8)",
									highlightFill : "rgba(151,187,205,0.75)",
									highlightStroke : "rgba(151,187,205,1)",
									data : female_count
								}
							]

						}


		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	},'json');
}






	
