<div class="page-wrapper">
    
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Edit Hospitals</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form action="<?= base_url() ?>Hospital/edit_hospital" method="post" enctype="multipart/form-data">
                          
                          <div class="form-group">
                            <label>Hospital Name</label>
                            <input class="form-control" name="hospital_name" type="text" value="<?= empty($hospital->hospital_name)?'':$hospital->hospital_name ?>" id="hospital_name">

                            <p class="alert alert-danger" id="hospital_name_error" style="display:none;">Hospital Name is required</p>
                          </div>
                            
                            <div>
                                <input type="hidden"  name="id" value="<?= empty($hospital->id)?'':$hospital->id ?>">
                            </div>

                            <div class="form-group">
                                <label>Hospital address</label>
                                <input class="form-control" name="hospital_address" type="text" value="<?= empty($hospital->hospital_address)?'':$hospital->hospital_address ?>" id="searchTextField">
                                 <p class="alert alert-danger" id="searchTextField_error" style="display:none;">Hospital Address is required</p>
                            </div>

                            <div class="form-group">
                                <label>Hospital Service</label>
                                <input class="form-control" name="hospital_service" type="text " value="<?= empty($hospital->hospital_service)?'':$hospital->hospital_service ?>" id="hospital_service">
                                <p class="alert alert-danger" id="hospital_service_error" style="display:none;">Hospital Address is required</p>
                               
                            </div>
                            
                            <div class="form-group">
                                <label>Hospital Image</label>
                                <div class="profile-upload">
                                    <div class="upload-img">
                                      
                                        <img alt=""  id="d" src="<?= base_url() ?>uploads/hospital_images/<?= empty($hospital->hospital_image)?'user.jpg':$hospital->hospital_image?>">
                                    </div>
                                    <div class="upload-input">
                                        <input type="file" id="hospital_image" class="form-control" name="hospital_image">
                                        <p id="file_error" style="display:none;">File Type is not allowed</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" id="save">Update Hospital</button>
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
          var hospital_address = $("#searchTextField").val();
          var hospital_name = $("#hospital_name").val();
          var hospital_service = $("#hospital_service").val();

          var count =0;

          if(hospital_address.length <= 0){
           $('#searchTextField_error').css('display','block');
           count++;

          }
          if(hospital_name.length <= 0){
             $('#hospital_name_error').css('display','block');    
             count++;
          }
          if(hospital_service.length <= 0){
             $('#hospital_service_error').css('display','block');    
             count++;
          }

          if(count <= 0){
            
          }
          else {
          event.preventDefault();
          }
      });
    });


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