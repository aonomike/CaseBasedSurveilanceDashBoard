<hr />
                   

                   
            </div>

        </div>
        <!--END PAGE CONTENT -->

         <!-- RIGHT STRIP  SECTION -->
        <div id="right">
            <div class="well well-small">
                <ul class="list-unstyled">
                   <!--  <li>Total Events &nbsp; : <span id="total-events"><?php //echo $totals->total_event_count ?></span></li> -->
                    <li>Total Patients &nbsp; : <span id="total-persons"><?php echo $person_count->total_person_count ?></span></li>
                </ul>
            </div>
           
        </div>
        <div class="well well-small" id="graphical">
                
                 <?php
                                if(is_array($event_counts ))
                                {
                                foreach ($event_counts as $count) {
                                    $event_count = $count->event_count;
                                    $total_events=$totals->total_event_count;
                                    $percentage=(($event_count*100)/$total_events);
                                    $percent=round($percentage*10)/10;
                            ?>
                                <span><?php  echo $count->event_name ; ?></span><span class="pull-right"><small><?php if(isset($percent)) echo ($percent).'%'; ?></small></span>
                                <div class="progress mini">
                                    <div class="progress-bar progress-bar-info" style="width: <?php if(isset($percent)) echo($percent) ?>%"></div>
                                </div>

                            <?php
                            }}
                            ?>
            </div>
          
            
         

        </div>
         <!-- END RIGHT STRIP  SECTION -->
    </div>

    <!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <div id="footer">
        <p>&copy;  Case Based Surveilance Dash Board &nbsp; &nbsp;</p>
    </div>
    <!--END FOOTER -->


    <!-- GLOBAL SCRIPTS -->

    <script src="<?php echo base_url()?>assets/plugins/jquery-2.0.3.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/myjquery.js"></script>
    <script src="<?php echo base_url()?>assets/js/page-level-scripts/view_dashboard.js"></script>

    <!-- END GLOBAL SCRIPTS -->

    <!-- PAGE LEVEL SCRIPTS -->
    <script src="<?php echo base_url(); ?>assets/Chart.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/flot/jquery.flot.time.js"></script>
    <script  src="<?php echo base_url()?>assets/plugins/flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url()?>assets/js/for_index.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

</body>

    <!-- END BODY -->
</html>
