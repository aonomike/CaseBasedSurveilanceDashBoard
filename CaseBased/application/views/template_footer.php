<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	<!-- Begin Footer -->
	<footer class="footer navbar-fixed-bottom" >
      <div class="container">
        <p>Developed By KEMRI/CGHR HISS Programme</p>
      </div>
    </footer>
	<!-- End Footer -->
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url(); ?>assets/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="assets/crossbrowserjs/html5shiv.js"></script>
		<script src="assets/crossbrowserjs/respond.min.js"></script>
		<script src="assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url(); ?>assets/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	<!-- ================== include chart JS ================== -->
	<script src="<?php echo base_url(); ?>assets/assets/plugins/chart-js/chart.js"></script>
	<!-- ================== end include chart JS ================== -->
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo base_url(); ?>assets/assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/flot/jquery.flot.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/flot/jquery.flot.time.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/flot/jquery.flot.resize.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/sparkline/jquery.sparkline.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/flot/jquery.flot.stack.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/flot/jquery.flot.crosshair.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/flot/jquery.flot.categories.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/js/chart-flot.demo.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/js/apps.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/js/apps.min.js"></script>
<!--	<script src="<?php echo base_url(); ?>assets/assets/js/chart-js.demo.js"></script> -->

	<script src="<?php echo base_url(); ?>assets/assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<!--<script src="<?php echo base_url(); ?>assets/assets/js/dashboard.min.js"></script>-->
	<script src="<?php echo base_url(); ?>assets/assets/js/dashboard.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/js/apps.min.js"></script>
	<!-- ================== MANAGE DATA TABLES ================== -->
	<script src="<?php echo base_url(); ?>assets/assets/plugins/DataTables/js/jquery.dataTables.js"></script>
	<!--<script src="<?php echo base_url(); ?>assets/assets/js/table-manage-default.demo.min.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/assets/js/table-manage-default.demo.js"></script>
	<script src="<?php echo base_url(); ?>assets/assets/js/apps.min.js"></script>
	<!-- ================== END MANAGE DATA TABLES ================== -->

	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
			TableManageDefault.init();			
			//ChartJs.init();
		});
	</script>
</body>
</html>