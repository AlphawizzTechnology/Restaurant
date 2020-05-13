<div class="page-wrapper">
 
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Booking</h4>
                    </div>
                    <!-- <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="<?= base_url() ?>Appointment/add_appointment" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Appointment</a>
                    </div> -->
                </div>
                
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped custom-table mb-0 datatable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Driver Name</th>
										<th>Age</th>
										<th>Passenger Name</th>
										
										<th>Booking Date</th>
										<th>/booking Time</th>
										<th>Status</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>

                                <?php if(!empty($Appointments)){
                                     foreach($Appointments as $a):

                                    ?>
									<tr>
										<td><?= empty($a->appointment_id)?'':$a->appointment_id ?></td>
										<td><img width="28" height="28" src="<?= base_url() ?>uploads/patients_profiles/<?= empty($a->Patient_image)?'user.png':$a->Patient_image ?>" class="rounded-circle m-r-5" alt=""> <?= empty($a->full_name)?'':$a->full_name ?></td>
										<td><?= empty($a->age)?'0':$a->age ?></td>
										<td><?= empty($a->Docter_name)?'':$a->Docter_name ?></td>
										
										<td><?= empty($a->appointment_date)?'':$a->appointment_date ?></td>
										<td><?= empty($a->appointment_time)?'':$a->appointment_time ?></td>
										<!-- <td><span class="custom-badge <?= ($a->status == 0)?'status-purple':(($a->status == 1)?'status-green':'status-red') ?>"><?= ($a->status == 0)?'Pending':(($a->status == 1)?'Done':'Cancelled') ?></span></td> -->
                                         
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                            <?php 
                                               if($a->status == 0) { ?>
                                                    <a class="custom-badge status-blue dropdown-toggle"  data-toggle="dropdown" aria-expanded="false">
                                                    Pending
                                                </a>
                                                <?php } else if($a->status == 1){ ?>
                                                    <a class="custom-badge status-green dropdown-toggle"  data-toggle="dropdown" aria-expanded="false">
                                                    Done
                                                </a>
                                               <?php  } else  { ?>
                                                <a class="custom-badge status-red dropdown-toggle"  data-toggle="dropdown" aria-expanded="false">
                                                    Cancelled
                                                </a>
                                               <?php } ?>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                   
                                                    <a class="dropdown-item" href="<?= base_url() ?>Appointment/Status/<?=  $a->appointment_id?>/0">Pending</a>
                                                    <a class="dropdown-item" href="<?= base_url() ?>Appointment/Status/<?=  $a->appointment_id?>/1">Done</a>
                                                    <a class="dropdown-item" href="<?= base_url() ?>Appointment/Status/<?=  $a->appointment_id?>/2">Cancelled</a>
                                                </div>
                                            </div>
                                        </td>




										<td class="text-right">
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="<?= base_url() ?>Appointment/edit_appointment/<?= $a->appointment_id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="<?= base_url() ?>Appointment/delete_appointment/<?= $a->appointment_id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
													<!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_appointment"><i class="fa fa-trash-o m-r-5"></i> Delete</a> -->
												</div>
											</div>
										</td>
									</tr>
                                     <?php endforeach; } ?>
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
          

			<div id="delete_appointment" class="modal fade delete-modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body text-center">
							<img src="assets/img/sent.png" alt="" width="50" height="46">
							<h3>Are you sure want to delete this Appointment?</h3>
							<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-danger">Delete</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>