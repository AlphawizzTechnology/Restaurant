<div class="page-wrapper">
  <div class="content">
      <div class="row">
          <div class="col-lg-8 offset-lg-2">
              <h4 class="page-title">Edit Profile</h4>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-8 offset-lg-2">
            <form action="<?= base_url() ?>AdminDashboard/EditProfile" method="post" enctype="multipart/form-data">
              <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                          <label>First Name <span class="text-danger">*</span></label>
                          <input class="form-control" name="first_name" type="text" value="<?= empty($Admin_data->first_name)?'':$Admin_data->first_name ?>" id="fn" >
                          <p class="alert alert-danger" id="fne" style="display:none;">First Name is reqiured</p>
                      </div>
                  </div>

                  <div class="col-sm-6">
                      <div class="form-group">
                          <label>Last Name  <span class="text-danger">*</span></label>
                          <input class="form-control" name="last_name" type="text" value="<?= empty($Admin_data->last_name)?'':$Admin_data->last_name ?>" id="ln">
                           <p class="alert alert-danger" id="lne" style="display:none;">Last Name is required</p>
                      </div>
                  </div>

                  <div class="col-sm-6">
                      <div class="form-group">
                          <label>Username <span class="text-danger">*</span></label>
                          <input class="form-control" name="Username" type="text" value="<?= empty($Admin_data->Username)?'':$Admin_data->Username ?>" id="un">
                           <p class="alert alert-danger" id="une" style="display:none;">Username is required</p>
                      </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input class="form-control" name="Email" type="email" value="<?= empty($Admin_data->Email)?'':$Admin_data->Email ?>" id="email"> 
                    <p class="alert alert-danger" id="email_error" style="display:none;">Email is required</p>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Date of Birth </label>
                      <div class="cal-icon">
                        <input type="text" name="dob" value="<?= empty($Admin_data->dob)?'':$Admin_data->dob ?>" class="form-control datetimepicker">
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group gender-select">
                      <label class="gen-label">Gender:</label>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="radio" name="gender" value="Male" class="form-check-input" <?= empty($Admin_data->gender)?'':empty($Admin_data->gender == 'Male')?'':'checked' ?>>Male
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="radio" name="gender" value="Female" class="form-check-input"
                        <?= empty($Admin_data->gender)?'':empty($Admin_data->gender == 'Female')?'':'checked' ?>>Female
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                            <label>Address</label>
                            <input type="text"  name="address" class="form-control" value="<?= empty($Admin_data->address)?'':$Admin_data->address ?>">
                          </div>
                      </div>
                    </div>
                    <div>
                        <input type="hidden" name="id" value="<?= empty($Admin_data->id)?'':$Admin_data->id ?>">
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Phone Number  <span class="text-danger">*</span></label>
                      <input class="form-control" type="text" value="<?= empty($Admin_data->phone_number)?'':$Admin_data->phone_number ?>" name="phone_number" id="contact">
                      <p class="alert alert-danger" id="contact_error" style="display:none;">Contact is required</p>
                    </div>
                  </div>

                  <div class="col-sm-6">
                      <div class="form-group">
                        <label>Avatar</label>
                        <div class="profile-upload">
                          <div class="upload-img">
                              <img alt="" id="d" src="<?= base_url() ?>uploads/admin_profiles/<?= empty($Admin_data->image)?'':$Admin_data->image ?>">
                          </div>
                          <div class="upload-input">
                              <input type="file" id="admin_image" name="admin_image" class="form-control">
                          </div>
                        </div>
                      </div>
                  </div>

              </div>

              <div class="m-t-20 text-center">
              <button class="btn btn-primary submit-btn" id="save">Save</button>
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
                 $('#save').click(function(event){
          
          var fn = $("#fn").val();
          var ln = $("#ln").val();
          var un = $("#un").val();
          var email = $("#email").val();
          
          var contact = $("#contact").val();
          
          var count =0;

          if(fn.length <= 0){
           $('#fne').css('display','block');
           count++;

          }
          if(ln.length <= 0){
             $('#lne').css('display','block');    
             count++;
          }
          if(un.length <= 0){
             $('#une').css('display','block');    
             count++;
          }
          if(email.length <= 0){
             $('#email_error').css('display','block');    
             count++;
          }
          
          if(contact.length <= 0){
             $('#contact_error').css('display','block');    
             count++;
          }

          if(count <= 0){
            
          }
          else {
       event.preventDefault();
          }

      })


   document.getElementById("admin_image").onchange = function () {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        // get loaded data and render thumbnail.
                        document.getElementById("d").src = e.target.result;
                    };

                    // read the image file as a data URL.
                    reader.readAsDataURL(this.files[0]);
                };

            })
        </script>