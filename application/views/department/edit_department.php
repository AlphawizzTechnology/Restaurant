<div class="page-wrapper">
            <div class="content">
                <div class="row">
                
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Edit Department</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form action="<?= base_url() ?>Department/edit_department" method="post">
							<div class="form-group">
								<label>Department Name</label>
								<input class="form-control" name="department_name" type="text" value="<?= empty($department_data->department_name)?'':$department_data->department_name ?>" id="dp_name">
                                  <p class="alert alert-danger" id="dp_name_error" style="display:none;">Department Name is required</p>
							</div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea cols="30" rows="4" class="form-control" name="description" id="des"><?= empty($department_data->description)?'':$department_data->description ?></textarea>
                                <p class="alert alert-danger" id="des_error" style="display:none;">Description is required</p>
                            </div>
                             
                            <div><input type="hidden" name="id" value="<?= empty($department_data->id)?'':$department_data->id  ?>"></div>

                            <div class="form-group">
                                <label class="display-block">Department Status</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="status" id="product_active" value="1" <?= ($department_data->status == 1)?'checked':'' ?>>
									<label class="form-check-label" for="product_active">
									Active
									</label>
                                    <p class="alert alert-danger" id="status_error" style="display:none;">Status is required</p>
								</div>
                                

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="status" id="product_inactive" value="0" <?= ($department_data->status == 0)?'checked':'' ?>>
									<label class="form-check-label" for="product_inactive">
									Inactive
									</label>
								</div>
                            </div>

                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" id="save"> Save Department</button>
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
          
          var department_name = $("#dp_name").val();
          var department_description = $("#des").val();
          
          
          
          var option=document.getElementsByName('status');

            
          
          var count =0;

          if(department_name.length <= 0){
           $('#dp_name_error').css('display','block');
           count++;

          }
          if(department_description.length <= 0){
             $('#des_error').css('display','block');    
             count++;
          }
          
          if (!(option[0].checked || option[1].checked)) {
                
                $('#status_error').css('display','block');
                
                
            }
          
          // if(status.length <= 0){
          //    $('#emaile').css('display','block');    
          //    count++;
          // }
          

          if(count <= 0){
            
          }
          else {
          event.preventDefault();
          }

      })
         });


</script>