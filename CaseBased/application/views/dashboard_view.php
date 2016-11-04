			<!-- begin row -->
			<div class="row">
				<!-- begin col-8 -->
				<div class="col-md-8">
					<div class="panel panel-inverse" data-sortable-id="index-1">
						<div class="panel-heading row">
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
							<h4 class="panel-title col-md-4">Event Trends Over Time</h4>	
							<!-- begin row -->
							<div class="row">
								<label class="control-label col-lg-2  col-md-2" for="existing-events">Filter Events</label>  
								<div class="col-lg-4 col-md-4">
	                                <select id="existing-events" name="existing-events" class="form-control">
	                                    <option ></option>
	                                    <?php foreach ($existing_events as $event):  ?>  
	                                        <option value="<?php echo $event->event_id ?>"><?php echo $event->verbose_name ?></option> 
	                                    <?php endforeach; ?> 
	                                </select>
	                            </div>
	                         </div>
	                         <!-- end row -->
						</div>

                         <div class="row">
							<div class="panel-body">
								<div id="interactive-chart" class="height-sm"></div>
							</div>
						</div>

					</div>
				</div>
				<!-- end col-8 -->

				<!-- begin col-4 -->
		        <div class="col-md-4">
                    <div class="panel panel-inverse" data-sortable-id="flot-chart-3">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">The UNAIDS 90-90-90 target variables</h4>
                        </div>
                        <div class="panel-body">
                            <div id="bar" class="height-sm"></div>
                        </div>
                    </div>
		        </div>
		        <!-- end col-4 -->
				
			</div>
			<!-- end row -->
			 <!-- begin row -->
			<div class="row">
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-3">
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
				<div class="col-md-3 col-sm-3">
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
				<div class="col-md-3 col-sm-3">
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
				<div class="col-md-3 col-sm-3">
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
			<!-- begin row -->
			<div class="row">
				
				<!-- begin col-4 -->
		        <div class="col-md-4">
                    <div class="panel panel-inverse" data-sortable-id="flot-chart-3">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Prevelence in Males vs Females</h4>
                        </div>
                        <div class="panel-body">
                            <div id="donut-chart" class="height-sm"></div>
                        </div>
                    </div>
		        </div>
		        <!-- end col-4 -->
		        <!-- begin col-4 -->
		        <div class="col-md-8">
                    <div class="panel panel-inverse" data-sortable-id="flot-chart-3">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Percentage Population Seeking Care By Age</h4>
                        </div>
                        <div class="panel-body">
                            <div id="bar-chart" class="height-sm"></div>
                        </div>
                    </div>
		        </div>
		        <!-- end col-4 -->
		        
			</div>
			<!-- end row -->
			       
			<!-- begin row-->
			<div class="row">
				 
				<!-- begin col-8 -->
		        <div class="col-md-8">
                    <div class="panel panel-inverse" data-sortable-id="flot-chart-3">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title"> Distribution of major hiv sentinel events</h4>
                        </div>
                        <div class="panel-body">
                            <div id="stacked-chart" class="height-sm"></div>
                        </div>
                    </div>
		        </div>
		        <!-- end col-8 -->
		        <!-- begin col-4 -->
		        <div class="col-md-4">
                    <div class="panel panel-inverse" data-sortable-id="flot-chart-3">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">CD4 Count <500 vs >500 </h4>
                        </div>
                        <div class="panel-body">
                            <div id="interactive-pie-chart" class="height-sm"></div>
                        </div>
                    </div>
		        </div>
		        <!-- end col-4 -->
			</div>
			<!-- end row-->
		</div>
		<!-- end #content -->
		
     	
		