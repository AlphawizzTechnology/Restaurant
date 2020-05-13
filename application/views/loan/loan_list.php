<div class="page-wrapper">

            <div class="content">
                <div class="row">
                    <div class="col-sm-8 col-6">
                        <h4 class="page-title">Loan Request</h4>
                    </div>
                    <div class="col-sm-4 col-6 text-right m-b-30">
                        <a href="<?= base_url() ?>Loan/setLoanAmount" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Loan Amount</a>
                    </div>
                </div>
                <!-- <div class="row filter-row">
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <div class="form-group form-focus">
                            <label class="focus-label">Employee Name</label>
                            <input type="text" class="form-control floating">
                        </div>
                    </div>
                   
                    
                    

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12 ">
                        <a href="#" class="btn btn-success btn-block"> Search </a>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Loan Amount</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>No of Days</th>
                                        
                                        <th class="text-center">Status</th>
                                        <!-- <th class="text-right">Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <?php  foreach($loan as $l): 
                                     $a = explode(' ',$l->patient_name);

                                    ?>
                                    <tr>
                                        <td>
                                            <a class="avatar">
                                            
                                            <img src="<?= base_url() ?>uploads/patients_profiles/<?= empty($l->image)?'user.png':$l->image ?>"></a>
                                            <h2><?= empty($l->patient_name)?'': $l->patient_name?></h2>
                                        </td>
                                        
                                        <td><?= empty($l->loan_amount)?'00.00':$l->loan_amount ?></td>
                                        <td><?= empty($l->from)?'00-00-00':$l->from ?></td>
                                        
                                        <td><?= empty($l->to)?'00-00-00':$l->to ?></td>
                                        <?php  $diff = strtotime($l->from) - strtotime($l->to); 
                                            $diff = abs(round($diff / 86400));

                                            $years = ($diff / 365) ;
                                            $years = floor($years); 
                                            $month = ($diff % 365) / 30.5; 
                                            $month = floor($month); 
                                            $days = ($diff % 365) % 30.5; // the rest of days
                                            // Echo all information set
                                            


                                              ?>
                                        <td><?= empty($years)?'':$years.' years '?><?=empty($month)?'': $month.' month '?> <?= empty($days)?'':$days.' days' ?></td>
                                       
                                        <td class="text-center">
                                            <div class="dropdown action-label">
                                            <?php  if($l->status == 0) { ?>
                                                    <a class="custom-badge status-blue dropdown-toggle"  data-toggle="dropdown" aria-expanded="false">
                                                    Pending
                                                </a>
                                                <?php } else if($l->status == 1){ ?>
                                                    <a class="custom-badge status-green dropdown-toggle"  data-toggle="dropdown" aria-expanded="false">
                                                    approved
                                                </a>
                                               <?php  } else  { ?>
                                                <a class="custom-badge status-red dropdown-toggle"  data-toggle="dropdown" aria-expanded="false">
                                                    Declined
                                                </a>
                                               <?php } ?>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    
                                                    <a class="dropdown-item" href="<?= base_url() ?>Loan/Status/<?=  $l->id?>/0">Pending</a>
                                                    <a class="dropdown-item" href="<?= base_url() ?>Loan/Status/<?=  $l->id?>/1">Approved</a>
                                                    <a class="dropdown-item" href="<?= base_url() ?>Loan/Status/<?=  $l->id?>/2">Declined</a>
                                                </div>
                                            </div>
                                        </td>
                                       
                                    </tr>
                                    <?php endforeach ?>
                                     <!-- <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-leave.html"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" title="Decline" data-toggle="modal" data-target="#delete_approve"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td> -->
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>