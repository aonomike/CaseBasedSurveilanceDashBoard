/*   
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 1.7.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v1.7/admin/
*/

var blue		= '#348fe2',
    blueLight	= '#5da5e8',
    blueDark	= '#1993E4',
    aqua		= '#49b6d6',
    aquaLight	= '#6dc5de',
    aquaDark	= '#3a92ab',
    green		= '#00acac',
    greenLight	= '#33bdbd',
    greenDark	= '#008a8a',
    orange		= '#f59c1a',
    orangeLight	= '#f7b048',
    orangeDark	= '#c47d15',
    dark		= '#2d353c',
    grey		= '#b6c2c9',
    purple		= '#727cb6',
    purpleLight	= '#8e96c5',
    purpleDark	= '#5b6392',
    red         = '#ff5b57',
    pink        = '#D108A3';

var handleVectorMap = function() {
	"use strict";
	if ($('#world-map').length !== 0) {
		$('#world-map').vectorMap({
		map: 'world_mill_en',
		scaleColors: ['#e74c3c', '#0071a4'],
		normalizeFunction: 'polynomial',
		hoverOpacity: 0.5,
		hoverColor: false,
		markerStyle: {
			initial: {
				fill: '#4cabc7',
				stroke: 'transparent',
				r: 3
			}
		},
		regionStyle: {
			initial: {
				fill: 'rgb(97,109,125)',
                "fill-opacity": 1,
                stroke: 'none',
                "stroke-width": 0.4,
                "stroke-opacity": 1
			},
			hover: {
				"fill-opacity": 0.8
			},
			selected: {
				fill: 'yellow'
			},
			selectedHover: {
			}
		},
		focusOn: {
            x: 0.5,
            y: 0.5,
            scale: 0
        },
		backgroundColor: '#2d353c',
		markers: [
			{latLng: [41.90, 12.45], name: 'Vatican City'},
			{latLng: [43.73, 7.41], name: 'Monaco'},
			{latLng: [-0.52, 166.93], name: 'Nauru'},
			{latLng: [-8.51, 179.21], name: 'Tuvalu'},
			{latLng: [43.93, 12.46], name: 'San Marino'},
			{latLng: [47.14, 9.52], name: 'Liechtenstein'},
			{latLng: [7.11, 171.06], name: 'Marshall Islands'},
			{latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
			{latLng: [3.2, 73.22], name: 'Maldives'},
			{latLng: [35.88, 14.5], name: 'Malta'},
			{latLng: [12.05, -61.75], name: 'Grenada'},
			{latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
			{latLng: [13.16, -59.55], name: 'Barbados'},
			{latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
			{latLng: [-4.61, 55.45], name: 'Seychelles'},
			{latLng: [7.35, 134.46], name: 'Palau'},
			{latLng: [42.5, 1.51], name: 'Andorra'},
			{latLng: [14.01, -60.98], name: 'Saint Lucia'},
			{latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
			{latLng: [1.3, 103.8], name: 'Singapore'},
			{latLng: [1.46, 173.03], name: 'Kiribati'},
			{latLng: [-21.13, -175.2], name: 'Tonga'},
			{latLng: [15.3, -61.38], name: 'Dominica'},
			{latLng: [-20.2, 57.5], name: 'Mauritius'},
			{latLng: [26.02, 50.55], name: 'Bahrain'},
			{latLng: [0.33, 6.73], name: 'São Tomé and Príncipe'}
		]
		});
	}
};
var handleBarChart = function (data, target) {
    "use strict";
    if ($(target).length !== 0) { 
        $.plot(target, [ {data: data, color: purple} ], {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.4,
                    align: 'center',
                    fill: true,
                    fillColor: purple,
                    zero: true
                }
            },
            xaxis: {
                mode: "categories",
                tickColor: '#ddd',
                tickLength: 0
            },
            grid: {
                borderWidth: 0
            }
        });
    }
};

var handleInteractiveChart = function (facility, startDate, endDate,county, eventId) {
	"use strict";

    var url = '/CaseBased/Dashboard/get_gender_based_yearly_event_distribution';
    
	if ($('#interactive-chart').length !== 0) {	        
       
        getPlotData(facility, startDate, endDate, county, eventId, url);

       // bindInteractiveChart();
    }
};

var getPlotData = function(facility, startDate, endDate, county, eventId, url) {
    var maxYaxis = 0;
    var maleData = [];
    var femaleData = [];
    var xLabels = [];
    var maleYears = [];
    var femaleYears = [];
    var plottingData = [];
    

    var startYear = 0 ;
    var endYear = 0;
    $.post(url, {'facility':facility,'start_date':startDate, 'end_date':endDate, 'county':county, 'event_id':eventId}, function(returnedData){
           
            var maleArray = [];
            var femaleArray = [];
            startYear = parseInt(returnedData[0].YEAR);

            endYear = parseInt(returnedData[returnedData.length-1].YEAR);
            $.each(returnedData, function(){ 
                if (this.EVENT_COUNT> maxYaxis) {
                    maxYaxis = parseInt(this.EVENT_COUNT) + 200 ;
                }
                if(this.Sex=="MALE" || this.Sex == "Male") {
                   var maleDataArray  = new Array();
                    maleYears.push(this.YEAR);
                    maleDataArray.push(this.YEAR);
                    maleDataArray.push(this.EVENT_COUNT);

                    maleData.push(maleDataArray);                    
                } else if (this.Sex == "FEMALE" || this.Sex == "Female") {
                    var femaleDataArray = new Array();
                    femaleYears.push(this.YEAR);
                    femaleDataArray.push(this.YEAR); 
                    femaleDataArray.push(this.EVENT_COUNT);
                    femaleData.push(femaleDataArray);
                };
                                                 
            });
           
            while (endYear>=startYear) { 
                var xLabel = [];
                xLabel.push(startYear);
                xLabel.push(startYear);
                xLabels.push(xLabel);

                if(maleYears.indexOf(startYear.toString()) == -1) {
                    var maleDataArray = [];
                    maleDataArray.push(startYear);
                    maleDataArray.push(0);
                    maleData.push(maleDataArray);
                }  
                if(femaleYears.indexOf(startYear.toString()) == -1) {
                    var femaleDataArray = [];
                    femaleDataArray.push(startYear);
                    femaleDataArray.push(0);
                    femaleData.push(femaleDataArray);
                } 

                maleData = maleData.sort(function(a, b){
                    return a[0]-b[0];

                }) ;

                femaleData = femaleData.sort(function(a, b){
                    return a[0]-b[0];

                }) ;
                startYear++;
            }


            plottingData = [
                                {
                                    data: maleData, 
                                    label: "Males", 
                                    color: blue,
                                    lines: { show: true, fill:false, lineWidth: 2 },
                                    points: { show: true, radius: 3, fillColor: '#fff' },
                                    shadowSize: 0
                                }, {
                                    data: femaleData,
                                    label: 'Females',
                                    color: red,
                                    lines: { show: true, fill:false, lineWidth: 2 },
                                    points: { show: true, radius: 3, fillColor: '#fff' },
                                    shadowSize: 0
                                }
             
                            ]
            plotInteractiveChart(plottingData, xLabels, maxYaxis);         

    },'json');

    return plottingData;
}

//assigns labels to the lines of linegraph
var bindInteractiveChart = function() {
    var showTooltip = function (x, y, contents) {
                                        $('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css( {
                                            top: y - 45,
                                            left: x - 55
                                        }).appendTo("body").fadeIn(200);
                                    }
     var previousPoint = null;
        $("#interactive-chart").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint !== item.dataIndex) {
                    previousPoint = item.dataIndex;
                    $("#tooltip").remove();
                    var y = item.datapoint[1].toFixed(2);
                    
                    var content = item.series.label + " " + y;
                    showTooltip(item.pageX, item.pageY, content);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
            event.preventDefault();
        });
}
//function to show tooltip
var showTooltip = function (x, y, contents) {
                                        $('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css( {
                                            top: y - 45,
                                            left: x - 55
                                        }).appendTo("body").fadeIn(200);
                                    }

//function to plot event trend line graph  
var plotInteractiveChart = function(plottingData, xLabels, maxYaxis) {

                                var showTooltip = function (x, y, contents) {
                                        $('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css( {
                                            top: y - 45,
                                            left: x - 55
                                        }).appendTo("body").fadeIn(200);
                                    }
                                 
                                var plot =  $.plot($("#interactive-chart"), plottingData , 
                                                    {
                                                        xaxis: {  ticks:xLabels, tickDecimals: 0, tickColor: '#ddd' },
                                                        yaxis: {  ticks: 10, tickColor: '#ddd', min: 0, max: maxYaxis},
                                                        grid: { 
                                                            hoverable: true, 
                                                            clickable: true,
                                                            tickColor: "#ddd",
                                                            borderWidth: 1,
                                                            backgroundColor: '#fff',
                                                            borderColor: '#ddd'
                                                        },
                                                        legend: {
                                                            labelBoxBorderColor: '#ddd',
                                                            margin: 10,
                                                            noColumns: 1,
                                                            show: true
                                                        }
                                                    }
                                                );
                                 var previousPoint = null;

                                $("#interactive-chart").bind("plothover", function (event, pos, item) {
                                    $("#x").text(pos.x.toFixed(2));
                                    $("#y").text(pos.y.toFixed(2));
                                    if (item) {
                                        if (previousPoint !== item.dataIndex) {
                                            previousPoint = item.dataIndex;
                                            $("#tooltip").remove();
                                            var y = item.datapoint[1].toFixed(2);
                                            
                                            var content = item.series.label + " " + y;
                                            showTooltip(item.pageX, item.pageY, content);
                                        }
                                    } else {
                                        $("#tooltip").remove();
                                        previousPoint = null;            
                                    }
                                    event.preventDefault();
                                });
                            }

//function that listens to change event on event select item 
var eventChange = function() {
    $("#existing-events").change(function(){
        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var county = $("#county").val();
        var facility = $("#facility").val();
        var eventId = $("#existing-events").val(); 
        handleInteractiveChart(facility, startDate, endDate, county, eventId);
    });
}

//function that listens to change event on facility dropdown
var facilityChange = function(){  
    $("#facility").change(function(){
        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var county = $("#county").val();
        var facility = $("#facility").val();
        var eventId = $("#existing-events").val();
        getCountyByFacilityCode(facility);
        getPopulationSeekingCareByAge(facility, startDate, endDate,county);
        getTotalNumberOfPatientsWithEvents(facility, startDate, endDate,county);
        getReportBasedOnVariousIndicators(facility, startDate, endDate,county);
        getEventSummaryStatistics(facility, startDate, endDate,county);
        handleInteractiveChart(facility, startDate, endDate,county, eventId);
        get_90_90_90(facility, startDate, endDate,county);
        getGenderBasedEventDistribution(facility, startDate, endDate,county);        
    });
}

//function that listens to change event on county select element
var countyChange = function(){  
    $("#county").change(function(){
        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var county = $("#county").val();
        var facility = $("#facility").val();
        var eventId = $("#existing-events").val();
        getPopulationSeekingCareByAge(facility, startDate, endDate,county);
        getFacilityByCounty(county);
        getTotalNumberOfPatientsWithEvents(facility, startDate, endDate,county);
        getReportBasedOnVariousIndicators(facility, startDate, endDate,county);
        getEventSummaryStatistics(facility, startDate, endDate,county);
        handleInteractiveChart(facility, startDate, endDate,county, eventId);
        get_90_90_90(facility, startDate, endDate,county);
        getGenderBasedEventDistribution(facility, startDate, endDate,county);
    });
}

//function that listens to change event on start-date input box
var startDateChange = function() {
    $("#start-date").change(function(){

        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var county = $("#county").val();
        var facility = $("#facility").val();

        getPopulationSeekingCareByAge(facility, startDate, endDate,county);
        getTotalNumberOfPatientsWithEvents(facility, startDate, endDate,county);
        getReportBasedOnVariousIndicators(facility, startDate, endDate,county);
        getEventSummaryStatistics(facility, startDate, endDate,county);
        handleInteractiveChart(facility, startDate, endDate,county);

    });
}

//function that listens to change event on end-date input box
var endDateChange = function() {
    $("#start-date").change(function(){
        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var county = $("#county").val();
        var facility = $("#facility").val();
        getPopulationSeekingCareByAge(facility, startDate, endDate,county);
        getTotalNumberOfPatientsWithEvents(facility, startDate, endDate,county);
        getReportBasedOnVariousIndicators(facility, startDate, endDate,county);
        getEventSummaryStatistics(facility, startDate, endDate,county);
    });
}


var handleInteractivePieChart = function (dataSet, colorArray, labels) {
    "use strict";
    if ($('#interactive-pie-chart').length !== 0) {
        var graphData = [];
        var series = 2;
       for( var i = 0; i<series; i++)
        {
            graphData[i] = { label: labels[i], data: dataSet[i], color: colorArray[i]};
        }

        $.plot($("#interactive-pie-chart"), graphData,
        {
            series: {
                pie: { 
                    show: true
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            legend: {
                labelBoxBorderColor: '#ddd',
                backgroundColor: 'none'
            }
        });
    }
};

var handleDonutChart = function (dataArray) {
    "use strict";
    if ($('#donut-chart').length !== 0) {
        var data = [];
        var series = 2;
        var colorArray = [blue, purpleDark];
       
        var nameArray = ['Males Positive', 'Females Positive'];
        for( var i = 0; i<series; i++)
        {
            data[i] = { label: nameArray[i], data: dataArray[i], color: colorArray[i] };
        }
        $.plot($("#donut-chart"), data, 
        {
            series: {
                pie: { 
                    innerRadius: 0.5,
                    show: true,
                    combine: {
                        color: '#999',
                        threshold: 0.1
                    }
                }
            },
            grid:{borderWidth:0, hoverable: true, clickable: true},
            legend: {
                show: false
            }
        });
    }
};

var handleStackedChart = function (data) {
    "use strict";
    var d1 = [];    
    var d2 = [];
    var ticksLabel = [];
    var count = 0; 
    for (var i = 0; i < data.length; i++) {
        if(data[i].gender === "MALE" || data[i].gender === "Male") {
            d1.push([count, data[i].event_count]);
            ticksLabel.push([count, data[i].verbose_name]); 
            count ++;
        } else if(data[i].gender === "Female" || data[i].gender === "FEMALE"){
            d2.push([count, data[i].event_count]);
        }
              

    }
    
    var options = { 
        xaxis: {  tickColor: 'transparent',  ticks: ticksLabel},
        yaxis: {  tickColor: '#ddd', ticksLength: 10},
        grid: { 
            hoverable: true, 
            tickColor: "#ccc",
            borderWidth: 0,
            borderColor: 'rgba(0,0,0,0.2)'
        },
        series: {
            stack: true,
            lines: { show: false, fill: false, steps: false },
            bars: { show: true, barWidth: 0.5, align: 'center', fillColor: null },
            highlightColor: 'rgba(0,0,0,0.8)'
        },
        legend: {
            show: true,
            labelBoxBorderColor: '#ccc',
            position: 'ne',
            noColumns: 1
        }
    };
    var xData = [
        {
            data:d1,
            color: blue,
            label: 'Male',
            bars: {
                fillColor: blue
            }
        },
        {
            data:d2,
            color: red,
            label: 'Female',
            bars: {
                fillColor: red
            }
        }      
    ];
    $.plot("#stacked-chart", xData, options);
    
    function showTooltip2(x, y, contents) {
        $('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css( {
            top: y,
            left: x + 35
        }).appendTo("body").fadeIn(200);
    }
    var previousXValue = null;
    var previousYValue = null;
    $("#stacked-chart").bind("plothover", function (event, pos, item) {
        if (item) {
            var y = item.datapoint[1] - item.datapoint[2];
            
            if (previousXValue != item.series.label || y != previousYValue) {
                previousXValue = item.series.label;
                previousYValue = y;
                $("#tooltip").remove();
    
                showTooltip2(item.pageX, item.pageY, y + " " + item.series.label);
            }
        }
        else {
            $("#tooltip").remove();
            previousXValue = null;
            previousYValue = null;       
        }
    });
};

var handleDashboardSparkline = function() {
	"use strict";
    var options = {
        height: '50px',
        width: '100%',
        fillColor: 'transparent',
        lineWidth: 2,
        spotRadius: '4',
        highlightLineColor: blue,
        highlightSpotColor: blue,
        spotColor: false,
        minSpotColor: false,
        maxSpotColor: false
    };

    function renderDashboardSparkline() {
        var value = [50,30,45,40,50,20,35,40,50,70,90,40];
        options.type = 'line';
        options.height = '23px';
        options.lineColor = red;
        options.highlightLineColor = red;
        options.highlightSpotColor = red;
        
        var countWidth = $('#sparkline-unique-visitor').width();
        if (countWidth >= 200) {
            options.width = '200px';
        } else {
            options.width = '100%';
        }
        
        $('#sparkline-unique-visitor').sparkline(value, options);
        options.lineColor = orange;
        options.highlightLineColor = orange;
        options.highlightSpotColor = orange;
        $('#sparkline-bounce-rate').sparkline(value, options);
        options.lineColor = green;
        options.highlightLineColor = green;
        options.highlightSpotColor = green;
        $('#sparkline-total-page-views').sparkline(value, options);
        options.lineColor = blue;
        options.highlightLineColor = blue;
        options.highlightSpotColor = blue;
        $('#sparkline-avg-time-on-site').sparkline(value, options);
        options.lineColor = grey;
        options.highlightLineColor = grey;
        options.highlightSpotColor = grey;
        $('#sparkline-new-visits').sparkline(value, options);
        options.lineColor = dark;
        options.highlightLineColor = dark;
        options.highlightSpotColor = grey;
        $('#sparkline-return-visitors').sparkline(value, options);
    }
    
    renderDashboardSparkline();
    
    $(window).on('resize', function() {
        $('#sparkline-unique-visitor').empty();
        $('#sparkline-bounce-rate').empty();
        $('#sparkline-total-page-views').empty();
        $('#sparkline-avg-time-on-site').empty();
        $('#sparkline-new-visits').empty();
        $('#sparkline-return-visitors').empty();
        renderDashboardSparkline();
    });
};

var handleDashboardDatepicker = function() {
	"use strict";
    $('#datepicker-inline').datepicker({
        todayHighlight: true
    });
};

var handleDashboardTodolist = function() {
	"use strict";
    $('[data-click=todolist]').click(function() {
        var targetList = $(this).closest('li');
        if ($(targetList).hasClass('active')) {
            $(targetList).removeClass('active');
        } else {
            $(targetList).addClass('active');
        }
    });
};

var handleDashboardGritterNotification = function() {
    $(window).load(function() {
        setTimeout(function() {
            $.gritter.add({
                title: 'Welcome back, Admin!',
                text: 'Thank You for Visiting Us',
                //image: '/CaseBased/assets/assets/img/user-2.jpg',
                sticky: true,
                time: '',
                class_name: 'my-sticky-class'
            });
        }, 10);
    });
};

var getGenderBasedYearlyEventDistribution = function() {
    var facility = ''; //$("#facility").val();
    var start_date = '';//$("#start-date").val();
    var end_date = ''; //$("#end-date").val();
    var county = ''; //$("#county").val();
    var url = '/CaseBased/Dashboard/get_population_infected_and_seeking_care_summary';
    $.post(url,{'facility':facility,'start_date':start_date, 'end_date':end_date, 'county':county},function(returned_data){
    },'json');
};

//function to get the total number of patients with events
var getTotalNumberOfPatientsWithEvents = function(facility, startDate, endDate,county) {
   
    var url = '/CaseBased/Dashboard/get_total_person_counts_with_events';
    $.post(url,{'facility':facility,'start_date':startDate, 'end_date':endDate, 'county':county}, function(returned_data){
        $("#patient-count").html(returned_data.total_person_count);
    },'json');
}

var getEventSummaryStatistics = function(facility, startDate, endDate,county) {
        var url = '/CaseBased/Dashboard/get_event_counts_per_event';
        $.post(url,{'facility':facility,'start_date':startDate, 'end_date':endDate, 'county':county},function(returnedData){
            var total = 0 ;
            var html = '';
                                        
                if (returnedData)
                {
                    $.each(returnedData, function(){
                        total += parseInt(this.event_count);
                    });
                    $.each(returnedData, function(){
                        var percentage =(parseInt(this.event_count)/total)*100;
                        percentage =Math.round(percentage*10)/10;
                        html+='<tr class="gradeA"><td>'+this.verbose_name+'</td><td>'+this.event_count+'</td><td>'+percentage+'</td></tr>';
                    });
                    $("#summary-detail").html(html);
                    $("#number-of-events").html(total);
                }
                else {
                    $("#summary-detail").html("");                    
                }
                                        
        },'json');
    }

// function to get patients based on various indicators
var getReportBasedOnVariousIndicators = function(facility, startDate, endDate,county) {    
    var url = '/CaseBased/Dashboard/get_report_based_on_various_indicators';
    $.post(url,{'facility':facility,'start_date':startDate, 'end_date':endDate, 'county':county},function(returnedData){
        var html = '';
        var malesPositive = returnedData.MALES_EVER_POSITIVE;
        var femalesPositive = returnedData.FEMALES_EVER_POSITIVE;
        var unknownGenderPositive = returnedData.GENDER_UNKNOWN_EVER_POSITIVE;
        var totalPositive = returnedData.TOTAL_EVER_POSITIVE;
        var malesOnArv = returnedData.MALES_EVER_ON_ARV;
        var femalesOnArv = returnedData.FEMALES_EVER_ON_ARV;
        var unknownGenderOnArv = returnedData.GENDER_UNKNOWN_EVER_ON_ARV;
        var totalOnArv = returnedData.TOTAL_NUMBER_EVER_ON_ARV;
        var cd4Over500 = returnedData.NUMBER_WITH_CD4_COUNT_OVER_500;
        var cd4Below500 = returnedData.NUMBER_WITH_CD4_COUNT_BELOW_500;
        var cd4Total = returnedData.NUMBER_WITH_CD4_COUNT;
        var viralLoadOver1000 = returnedData.NUMBER_WITH_VIRAL_LOAD_OVER_1000;
        var viralLoadBelow1000 = returnedData.NUMBER_WITH_VIRAL_LOAD_BELOW_1000;
        var numberWithViralLoad = returnedData.NUMBER_WITH_VIRAL_LOAD;
        var numberDead= returnedData.NUMBER_DEAD;
        var percentageMalesPositive = 0;
        var percentageFemalesPositive = 0;
        var percentageUnknownGenderPositive = 0;
        var percentageMalesOnArv = 0;
        var percentageFemalesOnArv = 0;
        var percentageUnknownGenderOnArv = 0;
        var percentageCd4Over500 = 0;
        var percentageCd4Below500 = 0;
        var percentageViralLoadOver1000 = 0;
        var percentageViralLoadBelow1000 = 0 ;

        var donutData = [malesPositive, femalesPositive];
        handleDonutChart(donutData);

        var dataSet = [cd4Below500, cd4Over500];
        var colorArray = [green, grey];
        var labels = [cd4Below500+" cd4 counts below 500", cd4Over500+" cd4 counts Over 500"];
        handleInteractivePieChart(dataSet, colorArray, labels)

            //get percentage of positive males
            if(totalPositive>0) {
                if (malesPositive) {
                    percentageMalesPositive = (malesPositive*100)/totalPositive;
                    percentageMalesPositive = (Math.round(percentageMalesPositive*10)/10);
                }
                
                //get percentage of positive females
                if(femalesPositive) {
                    percentageFemalesPositive = (femalesPositive*100)/totalPositive;
                    percentageFemalesPositive = (Math.round(percentageFemalesPositive*10)/10); 
                }
                
                //get percentage of unknown gender positive

                if(unknownGenderPositive) {
                    percentageUnknownGenderPositive = (unknownGenderPositive*100)/totalPositive;
                    percentageUnknownGenderPositive = (Math.round(percentageUnknownGenderPositive*10)/10);
                }
            }
            //get percentage of males on arvs
            if(totalOnArv>0) {
                if(malesOnArv) {
                    percentageMalesOnArv = calculatePercentage(malesOnArv, totalOnArv);
                }
                //get percentage of positive females
                if(femalesOnArv) {
                    percentageFemalesOnArv = calculatePercentage(femalesOnArv, totalOnArv);
                }
                //get percentage of unknown gender positive
                if(unknownGenderOnArv) {
                    percentageUnknownGenderOnArv = calculatePercentage(unknownGenderOnArv, totalOnArv);
                }
            }

            if(cd4Total> 0) {
                //get percentage with cd4 count over 500
                if(cd4Over500) {
                    percentageCd4Over500 = calculatePercentage(cd4Over500,cd4Total);
                }
                //get percentage with cd4 count below 500
                if(cd4Below500) {
                    percentageCd4Below500 = calculatePercentage(cd4Below500,cd4Total);
                }
            }

            if(numberWithViralLoad>0) {
                //get percentage with viral load count below 1000
                if(viralLoadOver1000) {
                    percentageViralLoadOver1000 = calculatePercentage(viralLoadOver1000,numberWithViralLoad);
                }                

                //get percentage with viral load count below 1000
                if(viralLoadBelow1000) {
                    percentageViralLoadBelow1000 = calculatePercentage(viralLoadBelow1000,numberWithViralLoad);
                  }
            }
         $("#male-count").html(malesPositive);
         $("#female-count").html(femalesPositive);
        
        var percentageDeath = calculatePercentage(numberDead, totalPositive);            
        var html = '<tr><td> HIV POSITIVE </td><td>Males</td><td><p>'+malesPositive+'</p></td>';
            html +='<td>'+percentageMalesPositive+'</td></tr><tr><td></td><td>Females</td><td ><p >'+femalesPositive+'</p></td>';
            html += '<td id="percentage-female-positive"> <p>'+percentageFemalesPositive+'</p></td></tr>';                                    
            html +='<tr><td></td><td>Unknown Gender</td><td><p>'+unknownGenderPositive+'</p></td></tr>';
            html +='<tr><td> </td> <td>Totals</td><td><p>'+totalPositive+'</p></td><td>100 </td>';
            html +='</tr><tr><td> NUMBER ON ARVS </td><td>Males</td><td><p>'+ malesOnArv+'</p></td>';
            html +='<td><p>'+percentageMalesOnArv+'</p></td></tr><tr><td></td><td>Females</td>';
            html +='<td><p >'+femalesOnArv+'</p></td><td> <p>'+percentageFemalesOnArv+'</p></td>';
            html +='</tr><tr><td></td><td>Unknown Gender</td><td><p>'+unknownGenderOnArv+'</p></td>';
            html += '<td><p>'+percentageUnknownGenderOnArv+'</p></td></tr><tr><td></td><td>Totals</td><td><p>'+totalOnArv+'</p></td>';
            html +='<td>100</td></tr><tr><td> POPULATION WITH CD4 COUNT </td><td> <=500 cell/mm3</td><td><p>'+cd4Below500+'</p></td>';
            html +='<td><p>'+percentageCd4Below500+'</p></td></tr><tr><td></td><td> >500 cell/mm3 </td>';
            html +='<td><p>'+cd4Over500+'</p></td><td><p>'+percentageCd4Over500+'</p></td></tr><tr>';
            html +='<td></td><td>Totals</td><td><p>'+cd4Total+'</p></td><td> 100 </td></tr>';
            html +='<tr><td> POPULATION WITH HIGH VIRAL LOAD </td><td><=1000cp/ml</td><td><p>'+viralLoadBelow1000+'</p></td>';
            html +='<td><p>'+percentageViralLoadBelow1000 +'</p></td><tr><td></td><td> >1000cp/ml</td>';
            html +='<td><p>'+viralLoadOver1000+'</p></td><td><p>'+percentageViralLoadOver1000+'</p></td>';
            html +='</tr><tr><td></td><td>Total </td><td><p>'+numberWithViralLoad+'</p></td><td> 100</td>';
            html +='</tr><tr><td> POPULATION CONFIRMED DEAD </td><td>Number Dead </td><td><p>'+numberDead+'</p></td>';
            html +='<td>'+percentageDeath+'</td></tr>';
            $('#indicators').html(html);
        },'json');
}

var getPopulationSeekingCareByAge = function(facility, startDate, endDate,county) {
    var url = '/CaseBased/Dashboard/get_population_infected_and_seeking_care_summary';
     var resultArray = [];
    $.post(url,{'facility':facility,'start_date':startDate, 'end_date':endDate, 'county':county}, function(returnedData) {
        var html = '';
        var total = 0 ;
       
        if(returnedData) {           
            $.each(returnedData, function() {
                total += parseInt(this.number_seeking_care);
            });
            $.each(returnedData, function() {
                var percentage = calculatePercentage(this.number_seeking_care,total);
                var result = [];
                result.push(this.age_range);
                result.push(percentage);
                resultArray.push(result);
                handleBarChart(resultArray, "#bar-chart") 
                html += '<tr class="gradeA"><td>'+this.age_range+'</td><td>'+this.number_seeking_care+'</td><td>'+percentage+' </td></tr> ';
            }); 
                $("#population").html(html);           
        } 
        
    },'json');
}


var getGenderBasedEventDistribution = function(facility, startDate, endDate,county) {
    var url = '/CaseBased/Dashboard/get_gender_based_event_distribution';
    $.post(url,{'facility':facility,'start_date':startDate, 'end_date':endDate, 'county':county}, function(returnedData) { 
       handleStackedChart(returnedData);
    },'json');
}


var calculatePercentage = function(score, total) {
    var percentage = (parseInt(score)*100)/parseInt(total);
    percentage = (Math.round(percentage*10)/10); 
    return percentage;
}
var  getFacilityByCounty= function(county) {
    var url = "/CaseBased/Dashboard/get_facilities_by_county";

    $.post(url,{"county":county},function(returned_data){
        var html="<option></option>";       
        $.each(returned_data,function(){            
            html+="<option value='"+this.mflcode+"'>"+this.facilityname+" -"+this.mflcode+"</option>";      
        });

        $("#facility").html(html);
    }, "json"); 
}

var getCountyByFacilityCode = function(facility_code) {
    var url = "/CaseBased/Dashboard/get_county_by_facility_code";

    $.post(url,{"facility_code":facility_code},function(returned_data){
        $("#county").val(returned_data.county);
    }, "json"); 
}

//draw the 90 90 90 donut chart
var get_90_90_90 = function(facility, startDate, endDate, county) {
    var url = "/CaseBased/Dashboard/get_diagnosis_vs_initiation_vs_vl_suppression";
    var data = [];
    $.post(url,{'facility':facility,'start_date':startDate, 'end_date':endDate, 'county':county},function(returnedData){
        data.push(["Total Number", returnedData.total_count], ["Initiated To ART",returnedData.number_initiated_to_care],["Viral Load < 1000", returnedData.vl_below_1000]);
        handleBarChart(data,"#bar");
      //  handleInteractivePieChart(returnedData);
    },"json");
}


// function to refresh the page every 30 seconds
var refreshEventPage = function() {    
    setInterval(function(){ 
        
        county = $("#county").val();
        startDate= $("#start-date").val();
        endDate= $("#end-date").val();
        facility= $("#facility").val();
         eventId= $("#existing-events").val();
        getPopulationSeekingCareByAge(facility, startDate, endDate,county);
        getEventSummaryStatistics(facility, startDate, endDate,county);
        getTotalNumberOfPatientsWithEvents(facility, startDate, endDate,county);
        getReportBasedOnVariousIndicators(facility, startDate, endDate,county);
        get_90_90_90(facility, startDate, endDate,county);
        getGenderBasedEventDistribution(facility, startDate, endDate,county);        
       // handleInteractiveChart(facility, startDate, endDate,county, eventId);
    }, 30000);
};

var activeLink = function() {
                $("#sidebar").find("a").click(function() {
                    $(this).css("background-color", "#00acac")
                });
}
var Dashboard = function () {
	"use strict";
    return {
        //main function
        init: function () {
            var facility = "";
            var startDate = '';
            var endDate = '';
            var county = "";
            var eventId = 12;
            refreshEventPage();
            facilityChange();
            countyChange();
            eventChange();
           // handleDashboardGritterNotification();
            getReportBasedOnVariousIndicators(facility, startDate, endDate,county);
            handleInteractiveChart(facility, startDate, endDate,county, eventId);
            getPopulationSeekingCareByAge (facility, startDate, endDate,county);
            get_90_90_90(facility, startDate, endDate,county);
            getGenderBasedEventDistribution(facility, startDate, endDate,county);
            $("#existing-events").val(12);
            activeLink();
            handleDashboardSparkline();
            handleDashboardTodolist();
            handleVectorMap();
            handleDashboardDatepicker();
            handleBarChart();
            
        }
    };
}();