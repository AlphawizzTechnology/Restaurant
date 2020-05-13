<div class="page-wrapper">

            <div class="content">
                <div class="row">
                    <div class="col-sm-5 col-5">
                        <h4 class="page-title">Hospitals</h4>
                       
                    </div>
                    <div class="col-sm-7 col-7 text-right m-b-30">
                        <a href="<?= base_url() ?>Hospital/add_hospital" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Add Hospital</a>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hospital Name</th>
                                        <th>Hospital Image</th>
                                        <th>Hospital Address</th>
                                        <th>Hospital Service</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(!empty($hospital)){ 
                                     $count = 0;
                                     foreach($hospital as $d):
                                        $count++;
                                    ?>
                                    <tr>
                                        <td><?= empty($count)?'':$count ?></td>
                                        <td><img width="80px" height="80px" src="<?= base_url() ?>uploads/hospital_images/<?= empty($d->hospital_image)?'hospital1.png': $d->hospital_image ?>"></td>
                                        <td><?= empty($d->hospital_name)?'':$d->hospital_name ?></td>
                                        <td><?= empty($d->hospital_address)?'':$d->hospital_address ?></td>
                                         <td><?= empty($d->hospital_service)?'':$d->hospital_service  ?></td>
										
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?= base_url() ?>Hospital/edit_hospital/<?= empty($d->id)?'':$d->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="<?= base_url() ?>Hospital/delete_hospital/<?= empty($d->id)?'':$d->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php  endforeach ?>
                                <?php  } else { echo 'department not found';} ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>