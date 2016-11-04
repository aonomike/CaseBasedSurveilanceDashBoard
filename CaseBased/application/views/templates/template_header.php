<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Case Based Surveillance | Dashboard</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/css/animate.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/css/style.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->

	<!-- ================== SETUP FAVICON ================== -->
	<link rel="icon" href="<?php echo base_url();?>assets/assets/img/favicon.ico" type="image/x-icon">
	<!-- ================== END FAVICON ================== -->

	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?php echo base_url(); ?>assets/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url(); ?>assets/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="<?php echo base_url(); ?>Dashboard/index" class="navbar-brand"><span class="navbar-logo"></span> CBS Dashboard</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					<li>
						<form class="navbar-form full-width">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter keyword" />
								<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
							</div>
						</form>
					</li>
					
					<li class="dropdown navbar-user">
						<!--<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<img src="assets/img/user-13.jpg" alt="" /> 
							<span class="hidden-xs">Adam Schwartz</span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="javascript:;">Edit Profile</a></li>
							<li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>
							<li><a href="javascript:;">Calendar</a></li>
							<li><a href="javascript:;">Setting</a></li>
							<li class="divider"></li>
							<li><a href="javascript:;">Log Out</a></li>
						</ul>
						-->
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<!--<li class="nav-profile">
						<div class="image">
							<a href="javascript:;"><img src="assets/img/user-13.jpg" alt="" /></a>
						</div>
						<div class="info">
							Sean Ngu
							<small>Front end developer</small>
						</div>
					</li>
					-->
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="nav-header">Navigation</li>
					<li class="has-sub active">
						<a href="javascript:;">
						    <b class="caret pull-right"></b>
						    <i class="fa fa-laptop"></i>
						    <span>Dashboard</span>
					    </a>
						<ul class="sub-menu">
						    <li class="active" style="color:white"><a href="<?php echo base_url(); ?>Patient/get_patients">Patients</a></li> 
						</ul>
					</li>
					<!-- <li class="has-sub">
						<a href="javascript:;">
							<span class="badge pull-right"></span>
							<i class="fa fa-filter"></i> 
							<span>Set Filter </span>
						</a>
						<ul class="sub-menu">
						    <li>Start Date<br/><input type="date" name = "start-date" id ="start-date" class="date"></li>
						    <li>End Date<br/><input type="date" name = "end-date" id ="end-date" class="date"></li>
						    <li>County<br/>
						    	<div >
	                                <select id="county" name="county" class="form-control">
	                                    <option ></option>
	                                    <?php //foreach ($counties as $county):  ?>  
	                                        <option value="<?php //echo $county->county ?>" >
	                                                        <?php // echo $county->county; ?>                                                 
	                                        </option> 
	                                    <?php// endforeach; ?> 
	                                </select> 
	                            </div>
						    </li>
						    <li>Facility<br/>
						    	<div>
	                                <select id="facility" name="facility" class="form-control">
	                                    <option ></option>
	                                    <?php //foreach ($facilities as $facility):  ?>  
	                                        <option value="<?php// echo $facility->mflcode ?>"><?php// echo $facility->facilityname." ".$facility->mflcode ?></option> 
	                                    <?php //endforeach; ?> 
	                                </select>
	                            </div>
						    </li>
						    <li>Event<br/><input type="text" name = "event" id ="event" class="auto-complete"></li>
						
						</ul>
					</li> -->
					<!--<li class="has-sub">
						
					
				 -->
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
			       
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<!-- <ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li class="active">Dashboard</li>
			</ol> -->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Dashboard <small>Case Based Surveillance Dashboard...</small></h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">

                <form id="filter_form">
                    <div id="filter" class="row">                       
                        <div class="form-group">
                            <!-- <label class="control-label col-lg-1  col-md-1" for="start-date">Start Date</label>
                             <div class="col-lg-2 col-md-2">
                                <input  type="hidden" name="start-date" id="start-date" class=""  value="<?php echo set_value('end-date'); ?>" />
                            </div>-->
                            <!-- <label class="control-label col-lg-1  col-md-1" for="end-date" >End Date</label>
                             <div class="col-lg-2 col-md-2">
                                <input  type="hidden" name="end-date" id="end-date" class="date-picker"  value="<?php echo set_value('end-date'); ?>" />                            
                                 <label id="start-end-error"></label>
                            </div>-->
                            <label class="control-label col-lg-2 col-md-2" for="county"> County</label>
                            <div class="col-lg-4 col-md-4">
                                <select id="county" name="county" class="form-control">
                                    <option ></option>
                                    <?php foreach ($counties as $county):  ?>  
                                        <option value="<?php echo $county->county ?>" >
                                                        <?php echo $county->county; ?>                                                 
                                        </option> 
                                    <?php endforeach; ?> 
                                </select> 
                            </div>
                            <label class="control-label col-lg-2  col-md-2" for="staff-id">Facility</label>
                            <div class="col-lg-4 col-md-4">
                                <select id="facility" name="facility" class="form-control">
                                    <option ></option>
                                    <?php foreach ($facilities as $facility):  ?>  
                                        <option value="<?php echo $facility->mflcode ?>"><?php echo $facility->facilityname." ".$facility->mflcode ?></option> 
                                    <?php endforeach; ?> 
                                </select>
                            </div>
                        </div>
                        <div><input type="hidden" id="counter" name="counter" value="1" /></div>
                         <div><input type="hidden" id="selected-event" name="selected-event" value="-1"  /></div>
                    </div> 
                    <hr/>
                </form>
			</div>
			<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-green">
						<div class="stats-icon"><i class="fa fa-desktop"></i></div>
						<div class="stats-info">
							<h4>TOTAL NUMBER OF PATIENTS</h4>
							<p id="patient-count"><?php echo $person_count->total_person_count;  ?></p>	
						</div>
						<div class="stats-link">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-blue">
						<div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
						<div class="stats-info">
							<h4>NUMBER OF MALES</h4>
							<p id="male-count"><?php echo $indicator_data->MALES_EVER_POSITIVE ?></p>	
						</div>
						<div class="stats-link">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-purple">
						<div class="stats-icon"><i class="fa fa-users"></i></div>
						<div class="stats-info">
							<h4>NUMBER OF FEMALES</h4>
							<p id="female-count" ><?php echo $indicator_data->FEMALES_EVER_POSITIVE ?></p>	
						</div>
						<div class="stats-link">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-red">
						<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
						<div class="stats-info">
							<h4>TOTAL NUMBER OF EVENTS</h4>
							<p id="number-of-events"><?php echo( $totals->total_event_count) ?></p>	
						</div>
						<div class="stats-link">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
			</div>
			<!-- end row -->