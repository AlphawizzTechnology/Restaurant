<div class="page-wrapper">

            <div class="content">
                <div class="row">
                    <div class="col-sm-5 col-5">
                        <h4 class="page-title">Departments</h4>
                       
                    </div>
                    <div class="col-sm-7 col-7 text-right m-b-30">
                        <a href="<?= base_url() ?>department/add_department" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Add Department</a>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Department Name</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($departments)){ 
                                     foreach($departments as $d):
                                    ?>
                                    <tr>
                                        <td><?= empty($d->id)?'':$d->id ?></td>
                                        <td><?= empty($d->department_name)?'':$d->department_name ?></td>
                                        
										<td><span class="custom-badge <?= ($d->status == 1)?'status-green':'status-red' ?>"><?= ($d->status == 1)?'active':'inactive' ?></span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?= base_url() ?>Department/edit_department/<?= empty($d->id)?'':$d->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="<?= base_url() ?>Department/delete_department/<?= empty($d->id)?'':$d->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    
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