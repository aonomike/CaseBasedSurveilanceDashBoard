
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="report_div" align="center">
                           
                           <?php
                           		if(is_array($event_counts))
                           		{
                           		foreach ($event_counts as $count) {
                           			$event_count = $count->event_count;
                           			$total_events=$totals->total_event_count;
                           			$percentage=(($event_count*100)/$total_events);
                           			$percent=round($percentage*10)/10;
                            ?>
	                            <div class="col-lg-3" style="border:1px solid #5BC0DE; border-radius:7%; margin:3px; text-align: center; font-family: Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif; background-color:#f5f5f5" title="<?php echo $count->description?>">
		                            <a class="btn chart-link" href="<?php echo base_url()?>Dashboard/load_bar_chart/<?php echo $count->event_id?>" >
		                                <i class=""></i>
		                                <span>  <h5><?php  echo $count->verbose_name ;    ?></h5></span><br/>
		                                <span class="btn btn-info"><?php echo $count->event_count; ?></span> <br/>
		                                <span class=""><?php echo ($percent).'%'; ?></span>
                                        <input type="hidden" class="event-ids" value="<?php echo $count->event_id?>" />;
		                            </a>
	                            </div>
                            <?php
                        	}}
                            ?>
                        
                        </div>

                    </div>

                </div>                
                 
                  <!--END BLOCK SECTION -->
