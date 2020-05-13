<div class="page-wrapper">
            <div class="content">
            
                <div class="row">
                    <div class="col-sm-7 col-6">
                        <h4 class="page-title">Admin Profile</h4>
                    </div>

                    <div class="col-sm-5 col-6 text-right m-b-30">
                        <a href="<?= base_url() ?>AdminDashboard/EditProfile" class="btn btn-primary btn-rounded"><i class="fa fa-pencil"></i> Edit Profile</a>
                    </div>
                </div>
                <div class="card-box profile-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#"><img class="avatar" src="<?= base_url() ?>uploads/admin_profiles/<?= empty($admin->image)?'':$admin->image ?>" alt=""></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0"><?= empty($admin->first_name)?'':$admin->first_name ?> <?= empty($admin->last_name)?'':$admin->last_name  ?></h3>
                                                <small class="text-muted">Admin</small>
                                                <div class="staff-id">ID : <?= empty($admin->id)?'':$admin->id ?></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <span class="title">Phone:</span>
                                                    <span class="text"><a href="#"><?= empty($admin->phone_number)?'':$admin->phone_number ?></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Email:</span>
                                                    <span class="text"><a href="#"><?= empty($admin->Email)?'':$admin->Email ?></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Birthday:</span>
                                                    <span class="text"><?= empty($admin->dob)?'00-00-00':$admin->dob ?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Address:</span>
                                                    <span class="text"><?= empty($admin->address)?'':$admin->address ?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Gender:</span>
                                                    <span class="text"><?= empty($admin->gender)?'':$admin->gender ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
				

				</div>
            </div>

          
        </div>