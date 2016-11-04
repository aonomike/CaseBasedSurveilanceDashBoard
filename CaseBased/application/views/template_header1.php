<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title>HIV Case Based Surveilace Dashboard | Dashboard </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
     
     <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/js/jquery-ui-1.11.4.custom/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/js/jquery-ui-1.11.4.custom/jquery-ui.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/jquery-ui/jquery-ui.structure.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/js/jquery-ui-1.11.4.custom/jquery-ui.theme.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/Font-Awesome/css/font-awesome.css" />
      <!--END GLOBAL STYLES -->



    <!-- PAGE LEVEL STYLES -->
    <link href="<?php echo base_url(); ?>assets/css/layout2.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/flot/examples/examples.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/timeline/timeline.css" />
    <!-- END PAGE LEVEL  STYLES -->
  
     
</head>

    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<body class="padTop53 " >

    <!-- MAIN WRAPPER -->
    <div id="wrap" >
        

        <!-- HEADER SECTION -->
        <div id="top">

            <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i>
                </a>
                <!-- LOGO SECTION -->
                <header class="navbar-header">

                    <a href="<?php echo base_url(); ?>Dashboard/index" class="navbar-brand">
                    <img src="<?php echo base_url(); ?>assets/img/logo1.jpg" alt="" />
                        
                        </a>
                </header>
                <!-- END LOGO SECTION -->
                <ul class="nav navbar-top-links navbar-right">

                    <!-- MESSAGES SECTION -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="label label-success">2</span>    <i class="icon-envelope-alt"></i>&nbsp; <i class="icon-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a href="#">
                                    <div>
                                       <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Today</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing.
                                        <br />
                                        <span class="label label-primary">Important</span> 

                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>Raphel Jonson</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing.
                                         <br />
                                        <span class="label label-success"> Moderate </span> 
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>Chi Ley Suk</strong>
                                        <span class="pull-right text-muted">
                                            <em>26 Jan 2014</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing.
                                         <br />
                                        <span class="label label-danger"> Low </span> 
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>Read All Messages</strong>
                                    <i class="icon-angle-right"></i>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <!--END MESSAGES SECTION -->

                    <!--TASK SECTION -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="label label-danger">5</span>   <i class="icon-tasks"></i>&nbsp; <i class="icon-chevron-down"></i>
                        </a>

                        

                    </li>
                    <!--END TASK SECTION -->

                    <!--ALERTS SECTION -->
                    <li class="chat-panel dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="label label-info">8</span>   <i class="icon-comments"></i>&nbsp; <i class="icon-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-alerts">

                            <li>
                                <a href="#">
                                    <div>
                                        <i class="icon-comment" ></i> New Comment
                                    <span class="pull-right text-muted small"> 4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="icon-twitter info"></i> 3 New Follower
                                    <span class="pull-right text-muted small"> 9 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="icon-envelope"></i> Message Sent
                                    <span class="pull-right text-muted small" > 20 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="icon-tasks"></i> New Task
                                    <span class="pull-right text-muted small"> 1 Hour ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="icon-upload"></i> Server Rebooted
                                    <span class="pull-right text-muted small"> 2 Hour ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="icon-angle-right"></i>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <!-- END ALERTS SECTION -->

                    <!--ADMIN SETTINGS SECTIONS -->

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-user "></i>&nbsp; <i class="icon-chevron-down "></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="icon-user"></i> User Profile </a>
                            </li>
                            <li><a href="#"><i class="icon-gear"></i> Settings </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="login.html"><i class="icon-signout"></i> Logout </a>
                            </li>
                        </ul>

                    </li>
                    <!--END ADMIN SETTINGS -->
                </ul>

            </nav>

        </div>
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <div id="left" >
            <ul id="menu" class="collapse">
                <li class="panel active">
                    <a href="#" >
                        <i class="icon-table"></i> Dashboard 
                    </a>                   
                </li> 
                <li class="panel active" >
                    <a href="#" id="get-infected-population-summary">
                         <i class="glyphicon glyphicon-stats"> </i> Clients Seeking Care
                    </a>                   
                </li>  
                <li class="panel active" >
                    <a href="#" id="summary-statistics">
                         <i class="glyphicon glyphicon-stats"> </i> Summary Statistics
                    </a>                   
                </li>                
            </ul>
        </div>
        <!--END MENU SECTION -->



        <!--PAGE CONTENT -->
        <div id="content">
             
            <div class="inner" style="min-height: 700px;">
                <div class="row">
                    <div class="col-lg-12">
                        <h2> HIV Case Based Surveilance Live Update Dashboard </h2>
                    </div>
                </div>
                  <hr />
                 <!--BLOCK SECTION -->

                <form id="filter_form">
                    <div id="filter" class="row">                       
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="start-date">Start Date</label>
                            <div class="col-lg-4">
                                <input  type="text" name="start-date" id="start-date" class="date-picker" readonly="readonly" value="<?php echo set_value('end-date'); ?>" />
                            </div>
                            <label class="control-label col-lg-2" for="end-date" >End Date</label>
                            <div class="col-lg-4">
                                <input  type="text" name="end-date" id="end-date" class="date-picker" readonly="readonly" value="<?php echo set_value('end-date'); ?>" />                            
                                <label id="start-end-error"></label>
                            </div>
                        </div>
                     </div>
                    <br/>
                     <hr/>
                    <div id="filter" class="row">                       
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="county">Select County</label>
                            <div class="col-lg-4">
                                <select id="county" name="county" class="form-control">
                                    <option ></option>
                                    <?php foreach ($counties as $county):  ?>  
                                        <option value="<?php echo $county->county ?>" >
                                                        <?php echo $county->county; ?>                                                 
                                        </option> 
                                    <?php endforeach; ?> 
                                </select> 
                            </div>
                            <label class="control-label col-lg-2" for="staff-id">Facility</label>
                            <div class="col-lg-4">
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
                     <div id="filter" class="row">                       
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="county"></label>
                            <div class="col-lg-4">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-default" id="change">Change View</button>
                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" class="change-view">Tiles View<input type="hidden" name="tiles-view" class="view" value="Tile View" /></a></li>
                                    <li><a href="#" class="change-view">Graph View<input type="hidden" name="graph-view" class="view" value="Graph View" /></a></li> 
                                    <li><a href="#" class="change-view">Tabular View<input type="hidden" name="tabular-view" class="view" value="Tabular View" /></a></li>                                    
                                  </ul>
                                </div> 
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="county">Event Name: </label> 
                            <label class="control-label col-lg-4" for="county" id="event-name"> </label>                                                       
                        </div>
                    </div>                   
                <br/>
                <hr/>
                </form>



               