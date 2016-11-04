<!-- begin row -->
<div class="row">
	<!-- begin col-12 -->
	<div class="col-md-12">
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
								<th> Patient Name</th>
								<th>Date Of Birth</th> 
								<th>Facility Name</th>
								<th>County</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="person">
						<?php
								if (is_array($patients))
								{
                           			foreach ($patients as $p) {
						?>
									<tr class="gradeA">
										<td><a href="#"><?php echo $p->first_name.' '. $p->middle_name.' '. $p->last_name ?></a></td>
										<td> <?php echo $p->birthdate ?></td>
										<td> <?php echo $p->facilityname.'-'.$p->mflcode ?> </td>
										<td> <?php echo $p->county ?> </td>
										<td>
											<div class="input-group-btn">
			                                    <ul class="dropdown-menu pull-right">
			                                        <li><a href="#">Browse Events</a></li>
			                                        <li><a href="#">View Details</a></li>
			                                    </ul>
			                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
			                                        <span class="caret"></span>
			                                    </button>
			                                    <button type="button" class="btn btn-success">Action</button>
			                                </div>
										</td>
									</tr> 
	                           	
	                           	<?php }	}			                           			

	                       ?>    		
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- end col-12 -->
</div>
<!-- end row -->