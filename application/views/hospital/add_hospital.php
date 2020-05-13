<div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Hospitals</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form action="<?= base_url() ?>Hospital/add_hospital" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label>Hospital Name</label>
								<input class="form-control" name="hospital_name" type="text">
                                <?= form_error('hospital_name') ?>
							</div>

                            <div class="form-group">
                                <label>Hospital address</label>
                                <input class="form-control" name="hospital_address" id="searchTextField" type="text" autocomplete="false">
                                <?= form_error('hospital_address') ?>
                            </div>

                            <div class="form-group">
                                <label>Hospital Service</label>
                                <input class="form-control" name="hospital_service" type="text">
                                <?= form_error('hospital_service') ?>
                            </div>

                            <div class="form-group">
                                <label>Hospital Image</label>
                                <div class="profile-upload">
                                    <div class="upload-img">
                                        <img alt=""  id="d" src="<?= base_url() ?>assets/img/user.jpg">
                                    </div>
                                    <div class="upload-input">
                                        <input type="file" id="hospital_image" class="form-control" name="hospital_image">
                                        <p id="file_error" style="display:none;">File Type is not allowed</p>
                                    </div>
                                </div>
                            </div>
                               
                            
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Create Department</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
			
        </div>

        <script>
            document.getElementById("hospital_image").onchange = function () {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        // get loaded data and render thumbnail.
                        document.getElementById("d").src = e.target.result;
                    };

                    // read the image file as a data URL.
                    reader.readAsDataURL(this.files[0]);
                };

            </script>


