<div class="page-wrapper">

            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Edit Patient</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                    <form action="<?= base_url() ?>Patient/edit_dishesh" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
									<div class="form-group">
										<label>Select Resaturant</label>
										<select class="form-control select" name="restaurant_id">
										    <option value ="">Please select Restaurant</option>
										    <?php foreach($Restaurant as $res){?>
										    
											<option value =<?php echo $res->id;?> <?php if($res->id == $Patient_data->restaurant_id): ?> selected="selected"<?php endif; ?>><?php echo $res->name;?></option>
											<?php } ?>
										</select>
									</div>
								</div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Dishes Name</label>
                                        <input class="form-control" name="name" type="text" value="<?= empty($Patient_data->name)?'':$Patient_data->name ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Price <span class="text-danger">*</span></label>
                                        <input class="form-control" name="price" type="text" value="<?= empty($Patient_data->price)?'':$Patient_data->price ?>">
                                    </div>
                                </div>

                                
                                <div class="col-sm-6">
									<div class="form-group">
										<label>Image</label>
										<div class="profile-upload">
											<div class="upload-img">
												<img alt="" src="assets/img/user.jpg">
											</div>
											<div class="upload-input">
												<input type="file" id="patient_image" name="patient_image" class="form-control">
                                                <p id="file_error" style="display:none;">File Type is not allowed</p>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                            
                            <div class="m-t-20 text-center">
                                <input type="hidden" id="id" name="id" value="<?php echo $Patient_data->id;?>">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
			
        </div>
        <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
     <script>
     $(document).ready(function(){
        $("#email").blur(function(){
        var email = $(this).val();
        $.post("<?= base_url() ?>Patient/CheckEmail", {email: email}, function(result){
         if(result == 1){
         $('#email_error').css({"display":"block","color":"red"});
         $('.submit-btn').prop('disabled', true);
         }
         else {
             
            $('#email_error').css({"display":"none"});
            $('.submit-btn').prop('disabled', false);
         }
  });
  });



                $('#datepicker').datetimepicker({
                    format: 'DD-MM-YYYY'
                });


                 $('#patient_image').change(function(){
                var ext = $('#patient_image').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                  //alert('invalid extension!');
                  
                  $('#file_error').css({"display":"block","color":"red"});
                  //$('#file_error').val('not allowed');
                  $('.submit-btn').prop('disabled', true);
                 }
                 else {
                     $('#file_error').css({"display":"none"});
                    $('.submit-btn').prop('disabled', false);
                 }
                 })
          
     })
     </script>