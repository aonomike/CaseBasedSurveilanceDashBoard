$(document).ready( function() {
	// body...
	//glodal variable
	var counter = $("#counter").val();
	//refresh the event counts after every three seconds
	refresh_event_page();	
	
	//County change event
	$("#county").change(function(){
		
		 var county = $("#county").val();
		 get_facility_by_county(county);		 
		 var county = $("#county").val();
		
		 var start_date = $("#start-date").val();
		 var end_date = $("#end-date").val();
		 var event_id = $("#selected-event").val();
		 var facility = 	$("#facility").val();	
		 var event_selected = $("#selected-event").val();

		 counter =  $("#counter").val();
		 
		 if(event_id=="")
		 {
		 	event_id=-1;
		 }
		 
		 if(counter==1)
		 {
		 	filter_events_by_facility_and_county_and_start_date_and_end_date(facility, county,start_date, end_date);		 	
		}		
		 else if(counter==2)
		 {
		 	event_id = $("#selected-event").val();
		 	get_event_count_by_month(event_id, facility, county, start_date, end_date);
		 }	
		 else if(counter==3) {
		 	//function to display the events in a tabular report
		 	console.log("counter"+counter);
		 	display_events_in_table_form(event_selected, facility, county, start_date, end_date);
		 }	
		 else if(counter==4) {
    		get_infected_population_seeking_care();
    	}

    	else if(counter==5) {
    		get_summary_statistics();
		}	

	});

	$("body").on("change","#facility", function(){
		var facility_code = $("#facility").val();
		get_county_by_facility_code(facility_code);
		var county = $("#county").val();
		var start_date = $("#start-date").val();
		var end_date = $("#end-date").val();
		counter =  $("#counter").val();
		if(counter==1) {
			
			filter_events_by_facility_and_county_and_start_date_and_end_date(facility_code, county,start_date, end_date) ;
		}
		else if(counter==2) {
			get_event_count_by_month(event_id, facility, county, start_date, end_date);
		}
		else if(counter==3) {			
			//function to display the events in a tabular report
			display_events_in_table_form(event_selected, facility, county, start_date, end_date);
		}
		else if(counter==4) {
    		get_infected_population_seeking_care();
    	}

    	else if(counter==5) {
    		get_summary_statistics();
		}	
		
	});

	$("#start-date").change(function() {
		county = $("#county").val();
		start_date= $("#start-date").val();
		end_date= $("#end-date").val();
		facility= $("#facility").val();
		var start = new Date(start_date);
		var end = new Date(end_date);
		counter =  $("#counter").val();
		var event_id = $("#event-id").val();		
	
		if (event_id=="")
		{
			event_id=-1;
		}
		if(counter==1) 
		{
			filter_events_by_facility_and_county_and_start_date_and_end_date(facility, county,start_date, end_date);
		}
		else if(counter==2) {
			event_id = $("#selected-event").val()
			get_event_count_by_month(event_id, facility, county, start_date, end_date);
		}
		else if(counter==3) {
			//function to display the events in a tabular report
			display_events_in_table_form(event_selected, facility, county, start_date, end_date);
		}
		else if(counter==4) {
    		get_infected_population_seeking_care();
    	}

    	else if(counter==5) {
    		get_summary_statistics();
		}	
	});

	$("#end-date").change(function() {
		county = $("#county").val();
		start_date= $("#start-date").val();
		end_date= $("#end-date").val();
		facility= $("#facility").val();
		var start = new Date(start_date);
		var end = new Date(end_date);	
		counter =  $("#counter").val();

		if(counter==1)
		{
			filter_events_by_facility_and_county_and_start_date_and_end_date(facility, county,start_date, end_date);			
		}
		else if(counter==2)
		{
			event_id = -1;
			get_event_count_by_month(event_id, facility, county, start_date, end_date);
		}
		else if(counter==3) {
			//function to display the events in a tabular report
			display_events_in_table_form(event_selected, facility, county, start_date, end_date);
		}
		else if(counter==4) {
    		get_infected_population_seeking_care();
    	}

    	else if(counter==5) {
    		get_summary_statistics();
		}	
		
	});

	$("body").on("click",".chart-link", function(event){
		event.preventDefault();
		var county = $("#county").val();
		var facility = $("#facility").val();
		var start_date = $("#start-date").val();
		var end_date = $("#end-date").val();
		var event_id = $(this).find("input",".event-ids").val();
		get_event_count_by_month(event_id, facility, county, start_date, end_date);
	});

	$(".change-view").click(function() {
		var view = $(this).find("input").val();
		$("#change").html(view);
		if(view == "Tile View") {
			$("#counter").val(1);
			var event_selected = $("#selected-event").val();
			var event_selected = $("#selected-event").val();
			var facility = $("#facility").val();
			var start_date = $("#start-date").val();
			var end_date = $("#end-date").val();
			var county = $("#county").val();
		}
		else if(view=="Graph View") {
			$("#counter").val(2);
			var event_selected = $("#selected-event").val();
			var facility = $("#facility").val();
			var start_date = $("#start-date").val();
			var end_date = $("#end-date").val();
			var county = $("#county").val();
			get_event_count_by_month(event_selected, facility, county, start_date, end_date);
		}
		else if(view=="Tabular View") {
			$("#counter").val(3);
			var event_selected = $("#selected-event").val();
			var facility = $("#facility").val();
			var start_date = $("#start-date").val();
			var end_date = $("#end-date").val();
			var county = $("#county").val();
			display_events_in_table_form(event_selected, facility, county, start_date, end_date);
		}
	});

});

//display infected population seeking care summary
$("#get-infected-population-summary").click(function(){
	$("#counter").val(4);
	get_infected_population_seeking_care();
});

// get summary statitics
$("#summary-statistics").click(function(){
	 $("#counter").val(5);	 	
	 get_summary_statistics();	 
});

//get monthly event distribution
function get_event_count_by_month(event_id, facility, county, start_date, end_date) {
	//set event id to -1 if the event id is nothing
	if(event_id=="")
	{
		event_id=-1;
	}	
	
	var post_url='/CaseBased/Dashboard/load_bar_chart_using_jpost';
	$("#selected-event").val(event_id);
	$(".report_div").html("");

	$.post(post_url,{"event_id":event_id, "start_date": start_date, "end_date": end_date, "facility":facility, "county":county}, function(returned_data) {
		var labels = new Array();
		var male_count = new Array();
		var female_count = new Array();
		$.each(returned_data, function(){
				$("#event-name").html();
				$("#event-name").html(this.verbose_name);
				labels.push(this.MONTH_NAME+' '+this.YEAR);
				male_count.push(this.MALE_COUNT);
				female_count.push(this.FEMALE_COUNT);
		});

		var html = '<div id="content"><div ><canvas id="canvas" ></canvas></div>';
		$(".report_div").html(html);
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
		 $("#counter").val(2);
	},'json');
}

function display_events_in_table_form(event_selected, facility, county, start_date, end_date)
{
	var url = "/CaseBased/Dashboard/filter_events_by_facility_and_county_and_start_date_and_end_date";
	$.post(url,{"facility":facility, "county":county, "start_date":start_date, "end_date":end_date},function(returned_data){
		var html="";
		var html_string ="";
		html += '<div class="row"><div class="col-lg-12"><div class="panel panel-default"><div class="panel-heading">SENTINEL EVENT SUMMARIES </div>';
	    html += '<div class="panel-body"><div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="dataTables-example">';
	    html += '<thead><tr><th>Event Name</th><th>Total Number</th><th>Percentage</th> </tr></thead>';
	    html += '<tfoot><tr><th>Event Name</th><th>Total Number</th><th>Percentage</th></tr></tfoot><tbody>';
		
		var total = 0;

		$.each(returned_data,function(){
			total += parseInt(this.event_count);
		});

		$.each(returned_data,function(){
			
			var event_count = (this.event_count);
			var percentage = (event_count/total)*100;
			var percent =(Math.round(percentage*10)/10);
			
		    html += '<tr class="gradeA"><td>'+this.verbose_name+'</td><td>'+event_count+'</td><td>'+percent+' %</td></tr>';
			html_string +=' <span>'+this.verbose_name+'</span><span class="pull-right"><small>'+percent+'%</small></span>';
			html_string +='<div class="progress mini">';
			html_string +='<div class="progress-bar progress-bar-info" style="width: '+percent +'%"></div></div>';
		
		});
		 html += '</tbody></table></div></div></div></div></div>';
		$('.report_div').html('');
		$('.report_div').html(html);
		$('#graphical').html('');
		$('#graphical').html(html_string);
		
	},'json');
}

//filter events
function filter_events(facility, county, start_date, end_date)
{	
	var url = "/CaseBased/Dashboard/filter_events";
	$.post(url,{"facility":facility, "county":county, "start_date":start_date, "end_date":end_date},function(returned_data){
		var html="";
		var html_string ="";
		$.each(returned_data,function(){
			var event_count = (this.event_count);
			var total_event_count = this.total_event_count;
			var percentage = (event_count/total_event_count)*100;
			var percent =(Math.round(percentage*10)/10);
			html+='<div class="col-lg-3" style="border:1px solid #5BC0DE; border-radius:7%; margin:3px; text-align: center; font-family: Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif; background-color:#f5f5f5" title="'+this.description+'">';
			html+='<a class="btn chart-link" href="Dashboard/load_bar_chart/'+this.event_id+'" > <i class=""></i>';
			html+='<span>  <h5>'+this.verbose_name+'</h5></span><br/>';
			html+='<span class="btn btn-info">'+this.event_count+'</span> <br/>';
			html+='<span class="">'+percent+'%'+'</span>';
			html+='<input type="hidden" class="event-ids" value="'+this.event_id+'" />';
			html+=' </a></div>';
			html_string+=' <span>'+this.verbose_name+'</span><span class="pull-right"><small>'+percent+'%</small></span>';
			html_string+='<div class="progress mini">';
			html_string+='<div class="progress-bar progress-bar-info" style="width: '+percent+'%"></div></div>';
		
		});

		$('.report_div').html('');
		$('.report_div').html(html);
		$('#graphical').html('');
		$('#graphical').html(html_string);
		
	},'json');

	
	get_total_number_of_events(facility, county, start_date, end_date);

	get_total_patient_count(facility, county, start_date, end_date);

	 
}

function filter_events_by_facility_and_county_and_start_date_and_end_date(facility, county,start_date, end_date) {
	var url = "/CaseBased/Dashboard/filter_events_by_facility_and_county_and_start_date_and_end_date";
	$.post(url,{"facility":facility, "county":county, "start_date":start_date, "end_date":end_date},function(returned_data){
		var html="";
		var html_string ="";
		
		if(returned_data==false) {
			var alert_string = '<div class="alert alert-info">  <strong>Sorry, No data was found!</strong> There currently does not exist event data with the specified filter.</div>';
			$('#report_div').html(alert_string);
			$('.report_div').html('');
			$('.report_div').html(alert_string);
		}
		else {
				var total = 0 ;
				$.each(returned_data,function(){
					total += parseInt(this.event_count);
					console.log(this.event_count);
					console.log(total);
				});
				$.each(returned_data,function(){
				var event_count = (this.event_count);
				var percentage = (event_count/total)*100;
				var percent =(Math.round(percentage*10)/10);
				html+='<div class="col-lg-3" style="border:1px solid #5BC0DE; border-radius:7%; margin:3px; text-align: center; font-family: Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif; background-color:#f5f5f5" title="'+this.description+'">';
				html+='<a class="btn chart-link" href="Dashboard/load_bar_chart/'+this.event_id+'" > <i class=""></i>';
				html+='<span>  <h5>'+this.verbose_name+'</h5></span><br/>';
				html+='<span class="btn btn-info">'+this.event_count+'</span> <br/>';
				html+='<span class="">'+percent+'%'+'</span>';
				html+='<input type="hidden" class="event-ids" value="'+this.event_id+'" />';
				html+=' </a></div>';
				html_string+=' <span>'+this.verbose_name+'</span><span class="pull-right"><small>'+percent+'%</small></span>';
				html_string+='<div class="progress mini">';
				html_string+='<div class="progress-bar progress-bar-info" style="width: '+percent+'%"></div></div>';
			
			});
			$('.report_div').html('');
			$('.report_div').html(html);
			$('#graphical').html('');
			$('#graphical').html(html_string);
		}
		

		
		
	},'json');

	
	get_total_number_of_events(facility, county, start_date, end_date);

	get_total_patient_count(facility, county, start_date, end_date);
}

//fuction to count the total number of events reported by facilities
function get_total_number_of_events(facility, county, start_date, end_date) {
	var post_url='/CaseBased/Dashboard/get_total_number_of_events';
	$.post(post_url,{"facility":facility,"county":county, "start_date":start_date, "end_date":end_date},function(returned_data){		
		var	total_event_count=returned_data.total_event_count;
		$('#total-events').html(total_event_count);
	},'json');
}

//function to count the total number of patients in facilities
function get_total_patient_count(facility, county, start_date, end_date) {
	var person_url='/CaseBased/Dashboard/get_total_patient_count';

	 $.post(person_url,{"facility":facility, "county":county, "start_date":start_date, "end_date":end_date },function(returned_data){
	 	var	total_person_count=returned_data.total_person_count;
	 	$('#total-persons').html(total_person_count);
		
	 },'json');
}



function compare_start_date_and_end_date(start_date, end_date) {
	if(start_date > end_date)
				{
					$("#start-date").css("border-color","red");
					$("#end-date").css("border-color","red");
					$("#start-end-error").html("end date cannot be smaller than start date");
					$("#start-end-error").css("color","red");
					$(".report_div").html("");
				}
				else
				{
					$("#start-end-error").html("");
					$("#start-date").css("border-color","green");
					$("#end-date").css("border-color","green");					
				}
}

function get_facility_by_county(county)
{
	var url = "/CaseBased/Dashboard/get_facilities_by_county";

	$.post(url,{"county":county},function(returned_data){
		//console.log(returned_data);
		var html="<option></option>";		
		$.each(returned_data,function(){			
			html+="<option value='"+this.mflcode+"'>"+this.facilityname+" -"+this.mflcode+"</option>";		
		});

		$("#facility").html(html);
	}, "json");	
}

function get_county_by_facility_code(facility_code) {
	var url = "/CaseBased/Dashboard/get_county_by_facility_code";

	$.post(url,{"facility_code":facility_code},function(returned_data){
		$("#county").val(returned_data.county);
	}, "json");	
}

function get_county_by_facility(facility_code) {
	var url = "/CaseBased/Dashboard/get_county_by_facility_code";
	var county="";
	$.post(url,{"facility_code":facility_code},function(returned_data){
		county+=returned_data.county;

	}, "json");	
}

//get all events without filter
function get_new_events() {
	var url = '/CaseBased/Dashboard/refresh_events';
	$.post(url,{},function(returned_data){
		//console.log(returned_data);
		var html='';
		var html_string ='';
		$.each(returned_data,function(){
			var event_count = (this.event_count);
			var total_event_count = this.total_event_count;
			var percentage = (event_count/total_event_count)*100;
			var percent =(Math.round(percentage*10)/10);
			html+='<div class="col-lg-3" style="border:1px solid #5BC0DE; border-radius:7%; margin:3px; text-align: center; font-family: Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif; background-color:#f5f5f5" title="'+this.description+'">';
			html+='<a class="btn chart-link" href="Dashboard/load_bar_chart/'+this.event_id+'" > <i class=""></i>';
			html+='<span>  <h5>'+this.verbose_name+'</h5></span><br/>';
			html+='<span class="btn btn-info">'+this.event_count+'</span> <br/>';
			html+='<span class="">'+percent+'%'+'</span>';
			html+='<input type="hidden" class="event-ids" value="'+this.event_id+'" />';
			html+=' </a></div>';

			html_string+=' <span>'+this.verbose_name+'</span><span class="pull-right"><small>'+percent+'%</small></span>';
			html_string+='<div class="progress mini">';
			html_string+='<div class="progress-bar progress-bar-info" style="width: '+percent+'%"></div></div>';
		
		});

		$('.report_div').html('');
		$('.report_div').html(html);
		$('#graphical').html('');
		$('#graphical').html(html_string);
		
	},'json');

	var post_url='/CaseBased/Dashboard/get_total_event_counts';
	$.post(post_url,{},function(returned_data){
		var	total_event_count=returned_data.total_event_count;
		$('#total-events').html(total_event_count);
		
	},'json');

	var person_url='/CaseBased/Dashboard/get_total_person_counts';
	$.post(person_url,{},function(returned_data){
		var	total_person_count=returned_data.total_person_count;
		$('#total-persons').html(total_person_count);
		
	},'json');
}

//infected population seeking care summary
function get_infected_population_seeking_care() {
	var facility = $("#facility").val();
	var start_date = $("#start-date").val();
	var end_date = $("#end-date").val();
	var county = $("#county").val();
	var url = '/CaseBased/Dashboard/get_population_infected_and_seeking_care_summary';
	$.post(url,{'facility':facility,'start_date':start_date, 'end_date':end_date, 'county':county},function(returned_data){
		if(returned_data==false) {
			var alert_string = '<div class="alert alert-info">  <strong>Sorry, No data was found!</strong> There currently does not exist event data with the specified filter.</div>';
			$('#report_div').html(alert_string);
			$('.report_div').html('');
			$('.report_div').html(alert_string);
		}
		else 
		{
			var html='';
			var html_string ='';
			var total = 0;
			html += '<div class="row"><div class="col-lg-12"><div class="panel panel-default"><div class="panel-heading">INFECTED POPULATION SEEKING CARE SUMMARY </div>';
		    html += '<div class="panel-body"><div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		    html += '<thead><tr><th>Age Group</th><th>Number Seeking Care</th> <th>Percetage</th></tr></thead>';
		   // html += '<tfoot><tr><th>Age Group</th><th>Number Seeking Care</th></tr></tfoot><tbody>';
			
			$.each(returned_data,function(){	
				total += parseInt(this.number_seeking_care);					
			});

			$.each(returned_data,function(){	




				var percentage =(parseInt(this.number_seeking_care)/total)*100

				var percent = (Math.round(percentage*10)/10);			
			    html += '<tr class="gradeA"><td>'+this.age_range+'</td><td> '+this.number_seeking_care+'</td><td> '+ percent +' %</td></tr>';
						
			});
			 html += '<tr class="gradeA"><td><b>Total</b></td><td> '+total+' </td></tr></tbody></table></div></div></div></div></div>';
			$('.report_div').html('');
			$('.report_div').html(html);		
		}		
	},'json');
}

function get_summary_statistics() {
	var facility = $("#facility").val();
	var start_date = $("#start-date").val();
	var end_date = $("#end-date").val();
	var county = $("#county").val();
	var url = '/CaseBased/Dashboard/get_report_based_on_various_indicators';
	$.post(url,{'facility':facility,'start_date':start_date, 'end_date':end_date, 'county':county},function(returned_data){
		
		if(returned_data==false) {
			var alert_string = '<div class="alert alert-info">  <strong>Sorry, No data was found!</strong> There currently does not exist event data with the specified filter.</div>';
			$('#report_div').html(alert_string);
			$('.report_div').html('');
			$('.report_div').html(alert_string);
		}
		else 
		{
			var males_positive = returned_data.MALES_EVER_POSITIVE;
			var females_positive = returned_data.FEMALES_EVER_POSITIVE;
			var unknown_gender_positive = returned_data.GENDER_UNKNOWN_EVER_POSITIVE;
			var total_positive = returned_data.TOTAL_EVER_POSITIVE;
			var males_on_arv = returned_data.MALES_EVER_ON_ARV;
			var females_on_arv = returned_data.FEMALES_EVER_ON_ARV;
			var unknown_gender_on_arv = returned_data.GENDER_UNKNOWN_EVER_ON_ARV;
			var total_on_arv = returned_data.TOTAL_NUMBER_EVER_ON_ARV;
			var cd4_over_500 = returned_data.NUMBER_WITH_CD4_COUNT_OVER_500;
			var cd4_below_500 = returned_data.NUMBER_WITH_CD4_COUNT_BELOW_500;
			var cd4_total = returned_data.NUMBER_WITH_CD4_COUNT;
			var viral_load_over_1000 = returned_data.NUMBER_WITH_VIRAL_LOAD_OVER_1000;
			var viral_load_below_1000 = returned_data.NUMBER_WITH_VIRAL_LOAD_BELOW_1000;
			var number_with_viral_load= returned_data.NUMBER_WITH_VIRAL_LOAD;
			var number_dead= returned_data.NUMBER_DEAD;
			var percentage_males_positive = 0;
			var percentage_females_positive = 0;
			var percentage_unknown_gender_positive = 0;
			var percentage_males_on_arv = 0;
			var percentage_females_on_arv = 0;
			var percentage_unknown_gender_on_arv = 0;
			var percentage_cd4_over_500 = 0;
			var percentage_cd4_below_500 = 0;
			var percentage_viral_load_over_1000 = 0;
			var percentage_viral_load_below_1000 = 0 ;

			//get percentage of positive males
			if(total_positive>0)
			{
				if (males_positive)
				{
					percentage_males_positive = (males_positive*100)/total_positive;
					percentage_males_positive = (Math.round(percentage_males_positive*10)/10);
				}
				
				//get percentage of positive females
				if(females_positive) 
				{
					percentage_females_positive = (females_positive*100)/total_positive;
					percentage_females_positive = (Math.round(percentage_females_positive*10)/10);	
				}
				
				//get percentage of unknown gender positive

				if(unknown_gender_positive)
				{
					percentage_unknown_gender_positive = (unknown_gender_positive*100)/total_positive;
					percentage_unknown_gender_positive = (Math.round(percentage_unknown_gender_positive*10)/10);
				}
			}
			//get percentage of males on arvs
			if(total_on_arv>0)
			{
				if(males_on_arv)
				{
					percentage_males_on_arv = (males_on_arv*100)/total_on_arv;
					percentage_males_on_arv = (Math.round(percentage_males_on_arv*10)/10);
				}
				//get percentage of positive females
				if(females_on_arv)
				{
					percentage_females_on_arv = (females_on_arv*100)/total_on_arv;
					percentage_females_on_arv = (Math.round(percentage_females_on_arv*10)/10);
				}
				//get percentage of unknown gender positive
				if(unknown_gender_on_arv)
				{
					percentage_unknown_gender_on_arv = (unknown_gender_on_arv*100)/total_on_arv;
					percentage_unknown_gender_on_arv = (Math.round(percentage_unknown_gender_on_arv*10)/10);
				}
			}

			if(cd4_total> 0)
			{
				//get percentage with cd4 count over 500
				if(cd4_over_500)
				{
					percentage_cd4_over_500 = (cd4_over_500*100)/cd4_total;
					percentage_cd4_over_500 = (Math.round(percentage_cd4_over_500*10)/10);
				}
				//get percentage with cd4 count below 500
				if(cd4_below_500)
				{
					percentage_cd4_below_500 = (cd4_below_500*100)/cd4_total;
					percentage_cd4_below_500 = (Math.round(percentage_cd4_below_500*10)/10);
				}
			}

			if(number_with_viral_load>0)
			{
				//get percentage with viral load count below 1000
				if(viral_load_over_1000) 
				{
					percentage_viral_load_over_1000 = (viral_load_over_1000*100)/number_with_viral_load;
					percentage_viral_load_over_1000 = (Math.round(percentage_viral_load_over_1000*10)/10);	
				}
				

				//get percentage with viral load count below 1000
				if(viral_load_below_1000)
				{
					percentage_viral_load_below_1000 = (viral_load_below_1000*100)/number_with_viral_load;
					percentage_viral_load_below_1000 = (Math.round(percentage_viral_load_below_1000*10)/10);
				}
			}
			
			var html = '<div class="row"><div class="col-lg-12"><div class="panel panel-default"><div class="panel-heading">SUMMARIES BASED ON VARIOUS EVENTS </div>';
		   	html += '<div class="panel-body"><div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		    html += '<thead><tr><th> INDICATORS </th><th>VARIABLE</th> <th>NUMBER</th><th> PERCENTAGE </th></tr></thead>';
		    html += '<tbody><tr><td> HIV POSITIVE </td><td>MALES</td> <td>'+males_positive+'</td><td> '+percentage_males_positive+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>FEMALES</td> <td>'+females_positive+'</td><td> '+percentage_females_positive+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>UNKNOWN GENDER</td> <td>'+unknown_gender_positive+'</td><td> '+percentage_unknown_gender_positive+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>TOTAL POSITIVE</td> <td>'+total_positive+'</td><td>  </td></tr>';
		    html += '<tr><td> NUMBER ON ARVS </td><td>MALES</td> <td>'+males_on_arv+'</td><td> '+percentage_males_on_arv+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>FEMALES</td> <td>'+females_on_arv+'</td><td> '+percentage_females_on_arv+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>UNKNOWN GENDER</td> <td>'+unknown_gender_on_arv+'</td><td> '+percentage_unknown_gender_on_arv+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>TOTAL ON ARVS</td> <td>'+total_on_arv+'</td><td> </td></tr>';
		   	html += '<tr><td> POPULATION WITH CD4 COUNT </td><td> <=500 cell/mm3</td> <td>'+cd4_below_500+'</td><td> '+percentage_cd4_below_500+'% </td></tr>';
		    html +=  '<tr><td>  </td><td> >500 cell/mm3 </td> <td>'+cd4_over_500+'</td><td> '+percentage_cd4_over_500+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>TOTALS</td> <td>'+cd4_total+'</td><td> 100% </td></tr>';
		    html += '<tr><td> POPULATION WITH HIGH VIRAL LOAD </td><td><=1000cp/ml</td> <td>'+viral_load_below_1000+'</td><td> '+percentage_viral_load_below_1000+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>>1000cp/ml</td> <td>'+viral_load_over_1000+'</td><td> '+percentage_viral_load_over_1000+'% </td></tr>';
		    html +=  '<tr><td>  </td><td>TOTAL </td> <td>'+number_with_viral_load+'</td><td> 100% </td></tr>';
		    html +=  '<tr><td> POPULATION CONFIRMED DEAD </td><td>NUMBER DEAD  </td> <td>'+number_dead+'</td><td></td></tr>';
		    
		    html += '</tbody>';	
		    html += '</table>';		

		    $('.report_div').html('');
			$('.report_div').html(html);
		}	

	 },'json');
}

//refresh page every 30 seconds
function refresh_event_page() {    
    setInterval(function(){ 
    	county = $("#county").val();
		start_date= $("#start-date").val();
		end_date= $("#end-date").val();
		facility= $("#facility").val();
		var counter =  $("#counter").val();
    	
    	if(counter==1)
    	{
    		var county = $("#county").val();
			var facility = $("#facility").val();
			var start_date = $("#start-date").val();
			var end_date = $("#end-date").val();
			var event_id = $("#selected-event").val();
    		filter_events_by_facility_and_county_and_start_date_and_end_date(facility, county,start_date, end_date); 
    	}
    	else if(counter==2) {

    		var county = $("#county").val();
			var facility = $("#facility").val();
			var start_date = $("#start-date").val();
			var end_date = $("#end-date").val();
			var event_id = $("#selected-event").val();
			get_event_count_by_month(event_id, facility, county, start_date, end_date);
    	}
    	else if(counter==3) {
    		var county = $("#county").val();
			var facility = $("#facility").val();
			var start_date = $("#start-date").val();
			var end_date = $("#end-date").val();
			var event_id = $("#selected-event").val();
			get_tabular_event_presentation(event_id, facility, county, start_date, end_date);
    	}
    	else if(counter==4) {
    		var county = $("#county").val();
			var facility = $("#facility").val();
			var start_date = $("#start-date").val();
			var end_date = $("#end-date").val();
			var event_id = $("#selected-event").val();
			get_infected_population_seeking_care();
		}
		else if(counter==5) {
    		var county = $("#county").val();
			var facility = $("#facility").val();
			var start_date = $("#start-date").val();
			var end_date = $("#end-date").val();
			var event_id = $("#selected-event").val();
			get_summary_statistics();
		}
		

    }, 30000);
}
