<!-- begin row -->
	 <div class="row"> 
	<!-- begin row -->
	 <div class="row"> 
		<!-- begin col-6 -->
		 <div class="col-md-6">					
			
				<div class="tab-pane fade active in" id="latest-post">
					<div class="height-sm" data-scrollbar="false">
						<div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Event Summary Statistics</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="data-table" class=" data-tables table table-striped table-bordered">
                            <thead>
                            	<tr>
                            		<th>Event Name</th>
                            		<th>n</th>
                            		<th>%</th>
                            	</tr>
                            </thead>
                            <tbody id="summary-detail">
                                
                                
                                
                                <?php
							$total = 0 ;
								
								if (is_array($events))
								{
                        			foreach ($events as $e) 
     	                  			{
                        				$total += (int)$e->event_count;
                        			}
                           			foreach ($events as $e) {
                           			$percentage =((int)$e->event_count/$total)*100;
									$percentage =round($percentage*10)/10;
						?>
									<tr class="gradeA"><td><?php echo $e->verbose_name ?></td><td> <?php echo $e->event_count ?></td><td> <?php echo $percentage ?> %</td></tr> 
	                           	
	                           	<?php }	}			                           			

	                       ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
            <!-- end panel -->
					 </div>
				</div>
			</div>
		<!-- end col-6 -->
		<!-- begin col-6 -->
		 <div class="col-md-6">
			<div class="panel panel-inverse" data-sortable-id="index-6">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
					<h4 class="panel-title">Population Seeking Care By Age</h4>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="data-tables table table-valign-middle m-b-0 table-striped table-bordered dataTable no-footer">
							<thead>
								<tr>
									<th>Age Group</th>
									<th>n</th> 
									<th>%</th>
								</tr>
							</thead>
							<tbody id="population">
							<?php
								$total = 0 ;
									
									if (is_array($population))
									{
                            			foreach ($population as $p) 
         	                  			{
                            				$total += (int)$p->number_seeking_care;
                            			}
	                           			foreach ($population as $p) {
	                           			$percentage =((int)$p->number_seeking_care/$total)*100;
										$percentage =round($percentage*10)/10;
							?>
										<tr class="gradeA"><td><?php echo $p->age_range ?></td><td> <?php echo $p->number_seeking_care ?></td><td> <?php echo $percentage ?> %</td></tr> 
		                           	
		                           	<?php }	}			                           			

		                       ?>    		
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div> 
		<!-- end col-6 -->
	 </div> 
	<!-- end row -->
	<!-- start row -->
	 <div class ="row">
		<div class = "col-md-12">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
					<h4 class="panel-title">Report Based on Various Indicators</h4>
				</div>
				<div class="panel-body p-0">
					<?php 
							$males_positive = $indicator_data->MALES_EVER_POSITIVE;
							$females_positive = $indicator_data->FEMALES_EVER_POSITIVE;
							$unknown_gender_positive = $indicator_data->GENDER_UNKNOWN_EVER_POSITIVE;
							$total_positive = $indicator_data->TOTAL_EVER_POSITIVE;
							$males_on_arv = $indicator_data->MALES_EVER_ON_ARV;
							$females_on_arv = $indicator_data->FEMALES_EVER_ON_ARV;
							$unknown_gender_on_arv = $indicator_data->GENDER_UNKNOWN_EVER_ON_ARV;
							$total_on_arv = $indicator_data->TOTAL_NUMBER_EVER_ON_ARV;
							$cd4_over_500 = $indicator_data->NUMBER_WITH_CD4_COUNT_OVER_500;
							$cd4_below_500 = $indicator_data->NUMBER_WITH_CD4_COUNT_BELOW_500;
							$cd4_total = $indicator_data->NUMBER_WITH_CD4_COUNT;
							$viral_load_over_1000 = $indicator_data->NUMBER_WITH_VIRAL_LOAD_OVER_1000;
							$viral_load_below_1000 = $indicator_data->NUMBER_WITH_VIRAL_LOAD_BELOW_1000;
							$number_with_viral_load = $indicator_data->NUMBER_WITH_VIRAL_LOAD;
							$number_dead= $indicator_data->NUMBER_DEAD;
							$percentage_males_positive = 0;
							$percentage_females_positive = 0;
							$percentage_unknown_gender_positive = 0;
							$percentage_males_on_arv = 0;
							$percentage_females_on_arv = 0;
							$percentage_unknown_gender_on_arv = 0;
							$percentage_cd4_over_500 = 0;
							$percentage_cd4_below_500 = 0;
							$percentage_viral_load_over_1000 = 0;
							$percentage_viral_load_below_1000 = 0 ;
							$percentage_dead = 0;

	//get percentage of positive males
	if($total_positive>0)
	{
		if ($males_positive)
		{
			$percentage_males_positive = ($males_positive*100)/$total_positive;
			$percentage_males_positive = (round($percentage_males_positive*10)/10);
		}
		
		//get percentage of positive females
		if($females_positive) 
		{
			$percentage_females_positive = ($females_positive*100)/$total_positive;
			$percentage_females_positive = (round($percentage_females_positive*10)/10);	
		}
		
		//get percentage of unknown gender positive

		if($unknown_gender_positive)
		{
			$percentage_unknown_gender_positive = ($unknown_gender_positive*100)/$total_positive;
			$percentage_unknown_gender_positive = (round($percentage_unknown_gender_positive*10)/10);
		}
	}
	//get percentage of males on arvs
	if($total_on_arv>0)
	{
		if($males_on_arv)
		{
			$percentage_males_on_arv = ($males_on_arv*100)/$total_on_arv;
			$percentage_males_on_arv = (round($percentage_males_on_arv*10)/10);
		}
		//get percentage of positive females
		if($females_on_arv)
		{
			$percentage_females_on_arv = ($females_on_arv*100)/$total_on_arv;
			$percentage_females_on_arv = (round($percentage_females_on_arv*10)/10);
		}
		//get percentage of unknown gender positive
		if($unknown_gender_on_arv)
		{
			$percentage_unknown_gender_on_arv = ($unknown_gender_on_arv*100)/$total_on_arv;
			$percentage_unknown_gender_on_arv = (round($percentage_unknown_gender_on_arv*10)/10);
		}
	}

	if($cd4_total> 0)
	{
		//get percentage with cd4 count over 500
		if($cd4_over_500)
		{
			$percentage_cd4_over_500 = ($cd4_over_500*100)/$cd4_total;
			$percentage_cd4_over_500 = (round($percentage_cd4_over_500*10)/10);
		}
		//get percentage with cd4 count below 500
		if($cd4_below_500)
		{
			$percentage_cd4_below_500 = ($cd4_below_500*100)/$cd4_total;
			$percentage_cd4_below_500 = (round($percentage_cd4_below_500*10)/10);
		}
	}

	if($number_with_viral_load>0)
	{
		//get percentage with viral load count below 1000
		if($viral_load_over_1000) 
		{
			$percentage_viral_load_over_1000 = ($viral_load_over_1000*100)/$number_with_viral_load;
			$percentage_viral_load_over_1000 = (round($percentage_viral_load_over_1000*10)/10);	
		}
		

		//get percentage with viral load count below 1000
		if($viral_load_below_1000)
		{
			$percentage_viral_load_below_1000 = ($viral_load_below_1000*100)/$number_with_viral_load;
			$percentage_viral_load_below_1000 = (round($percentage_viral_load_below_1000*10)/10);
		}
	}

	if ($number_dead>0)
	{
		$percentage_dead = ($number_dead*100)/$total_positive;
		$percentage_dead = (round($percentage_dead*10)/10);	
	}
	
	?>
			<div class="table-responsive">
		   			<table class="table table-valign-middle m-b-0 table-striped table-bordered dataTable no-footer">
			    		<thead>
			    			<tr>
			    				<th> INDICATORS </th>
			    				<th>VARIABLE</th> 
			    				<th>n</th>
			    				<th> % </th>
			    			</tr>
			    		</thead>
			    		<tbody id="indicators">
			    			<tr>
			    				<td> HIV POSITIVE </td>
			    				<td>Males</td> 
			    				<td><p class="male-positive"> <?php echo $males_positive ?></p></td>
			    				<td> <?php echo $percentage_males_positive?> </td>
			    			</tr>
			    			<tr>
			    				<td>  </td>
			    				<td>Females</td> 
			    				<td ><p class="female-positive"><?php echo $females_positive ?></p></td>
			    				<td id="percentage-female-positive"> <p><?php echo $percentage_females_positive ?></p></td>
			    			</tr>
			    			<tr>
			    				<td>  </td>
			    				<td>Unknown Gender</td> 
			    				<td><p class="unknown-gender-positive"><?php echo $unknown_gender_positive ?></p></td>
			    				<td><p class="percentage-unknown-gender-positive"> <?php echo $percentage_unknown_gender_positive ?> </p></td>
			    			</tr>
			    			<tr>
			    				<td>  </td>
			    				<td>Totals</td>
			    				<td><p class="totals-positive"><?php echo $total_positive ?></p></td>
			    				<td>100  </td>
			    			</tr>
			   				<tr>
			   					<td> NUMBER ON ARVS </td>
			   					<td>Males</td> 
			   					<td><p class="males-on-arv"><?php echo $males_on_arv?></p></td>
			   					<td><p class="percentage-males-on-arv"> <?php echo $percentage_males_on_arv ?> </p> </td>
			   				</tr>
			    			<tr>
			    				<td>  </td>
			    				<td>Females</td>
			    				<td><p class="females-on-arv"><?php echo $females_on_arv ?></p></td>
			    				<td> <p class="percentage-females-on-arv"><?php echo $percentage_females_on_arv ?></p></td>
			    			</tr>
			  				<tr>
			  					<td>  </td>
			  					<td>Unknown Gender</td>
			  					<td><p class="unknown-gender-on-arv"><?php echo $unknown_gender_on_arv ?></p></td>
			  					<td> <p class="percentage-unknown-gender-on-arv"><?php echo $percentage_unknown_gender_on_arv ?> </p> </td></tr>
			     			<tr>
			     				<td>  </td>
			     				<td>Total</td>
			     				<td><p class="total-on-arv"><?php echo $total_on_arv ?></p></td>
			     				<td>100 </td>
			     			</tr>
			   				<tr>
			   					<td> POPULATION WITH CD4 COUNT </td>
			   					<td> <=500 cell/mm3</td> 
			   					<td><p class="cd4-below-500"><?php echo $cd4_below_500 ?></p></td>
			   					<td><p class="percentage-cd4-below-500"> <?php echo $percentage_cd4_below_500 ?></p> </td>
			   				</tr>
			    			<tr>
			    				<td>  </td>
			    				<td> >500 cell/mm3 </td>
			    				<td><p class="cd4-over-500"><?php echo $cd4_over_500 ?></p></td>
			    				<td><p class="percentage-cd4-over-500"><?php echo $percentage_cd4_over_500 ?> </p> </td>
			    			</tr>
			    			<tr>
			    				<td>  </td>
			    				<td>Totals</td> 
			    				<td><p class="cd4-total"><?php echo $cd4_total ?></p></td>
			    				<td> 100 </td>
			    			</tr>
			    			<tr>
			    				<td> POPULATION WITH HIGH VIRAL LOAD </td>
			    				<td><=1000cp/ml</td> 
			    				<td><p class="viral-load-below-1000"><?php echo $viral_load_below_1000 ?></p></td>
			    				<td> <p class="percentage-viral-load-below-1000"> <?php echo $percentage_viral_load_below_1000 ?></p> </td>
			    			</tr>
			   				<tr>
			   					<td>  </td>
			   					<td> >1000cp/ml</td> 
			   					<td><p class="viral-load-over-1000"><?php echo $viral_load_over_1000 ?></p></td>
			   					<td><p class="percentage-viral-load-over-1000"><?php echo $percentage_viral_load_over_1000?> </p></td>
			   				</tr>
			    			<tr>
			    				<td>  </td>
			    				<td>Total </td> 
			    				<td><p class="number-with-viral-load"><?php echo $number_with_viral_load ?></p></td>
			    				<td> 100</td>
			    			</tr>
			    			<tr>
			    				<td> POPULATION CONFIRMED DEAD </td>
			    				<td>Number Dead  </td>
			    				<td><p class="number-dead"><?php echo $number_dead ?></p></td>
			    				<td><?php echo $percentage_dead ?></td>
			    			</tr>
			    		</tbody>	
		   			</table>
					</div>
				</div>
				</div>
		</div>
	</div> 
	<!-- end row -->
</div>
<!-- end #content -->

	
