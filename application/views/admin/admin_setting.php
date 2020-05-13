<div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form action="<?= base_url() ?>AdminDashboard/changePassword" method="post" >
                            <h3 class="page-title">Company Settings</h3>
                            <?php  if(!empty($this->session->flashdata('error'))){ ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                            <?php } ?>

                            <?php  if(!empty($this->session->flashdata('success'))){ ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                            <?php } ?>
                            <div class="row">
                             
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Enter Old Password <span class="text-danger">*</span></label>
                                        <input class="form-control" name="old_password" type="password" value="">
                                        <?= form_error('old_password') ?>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Enter New Password</label>
                                        <input class="form-control" name="new_password"  type="password">
                                        <?= form_error('new_password') ?>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input class="form-control" name="confirm_password"  type="password">
                                        <?= form_error('confirm_password') ?>
                                    </div>
                                </div>
                            </div>
                          
                           
                            <div class="row">
                                <div class="col-sm-12 text-center m-t-20">
                                    <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
           
        </div>