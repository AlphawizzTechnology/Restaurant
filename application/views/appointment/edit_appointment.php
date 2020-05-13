<div class="page-wrapper">

                <div class="content">
                
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <h4 class="page-title">Edit Appointment</h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form action="<?= base_url() ?>Appointment/edit_appointment" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Appointment ID</label>
                                            <input class="form-control" type="text" name="appointment_id" value="<?= empty($App->appointment_id)?'':$App->appointment_id ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        
                                            <div class="form-group">
                                            <label>Patient Name</label>
                                            <input class="form-control" type="text" name="full_name" value="<?= empty($App->full_name)?' ':$App->full_name ?>" readonly="">
                                        
                                        </div>
                                    </div>
                                </div>


                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Doctor</label>
                                            <select class="select" name="doctor_id" id="doctor_id">
                                            <?php foreach($doctors as $d): ?>
                                                <option value="<?= empty($d->id)?'':$d->id ?>" ><?= empty($d->doctor_name)?'':$d->doctor_name ?></option>
                                              <?php  endforeach; ?>
                                            </select>
                                            <p class="alert alert-danger" id="doctor_id_error" style="display:none;">Doctor id is required</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Patient Age</label>
                                            <input class="form-control" type="text" name="age" value="<?= empty($App->age)?'0':$App->age ?>" readonly="">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <div class="cal-icon">
                                                <input type="text" id="datepickers" value="<?= empty($App->appointment_date)?'':$App->appointment_date ?>" name="appointment_date" class="form-control datetimepicker">
                                                <p class="alert alert-danger" id="datepickers_error" style="display:none;">date is required</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Time</label>
                                            <div class="time-icon">
                                                <input type="text" name="appointment_time" value="<?= empty($App->appointment_time)?'':$App->appointment_time ?>" class="form-control" id="datetimepicker3">
                                                <p class="alert alert-danger" id="datetimepicker3_error" style="display:none;">Time is required</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Patient Email</label>
                                            <input class="form-control" type="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Patient Phone Number</label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div> -->

                                <!-- <div class="form-group">
                                    <label>Message</label>
                                    <textarea cols="30" rows="4" class="form-control"><?= empty($App->message) ?></textarea>
                                </div> -->
                                <div class="form-group">
                                    <label class="display-block">Appointment Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="product_active" value="0" <?= ($App->status == 0)?'checked':'' ?>>
                                        <label class="form-check-label" for="product_active">
                                        Pending
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="product_inactive" <?= empty($App->status)?'':($App->status == 1)?'checked':'' ?> value="1" >
                                        <label class="form-check-label" for="product_inactive">
                                        Done
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="product_inactive" <?= empty($App->status)?'':($App->status == 2)?'checked':'' ?> value="2" >
                                        <label class="form-check-label" for="product_inactive">
                                        Cancel
                                        </label>
                                    </div>
                                    <p class="alert alert-danger" id="gender_error" style="display:none;">Gender is required</p>
                                    
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
             $('#datepickers').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
            });



      $('#save').click(function(event){
          
          var doctor_id = $("#doctor_id").val();
          var date = $("#datepickers").val();
          var time = $("#datetimepicker3").val();
          
          
          var option=document.getElementsByName('status');

            
          
          var count =0;

          if(doctor_id.length <= 0){
           $('#doctor_id_error').css('display','block');
           count++;

          }
          if(date.length <= 0){
             $('#datepickers_error').css('display','block');    
             count++;
          }
          if(time.length <= 0){
             $('#datetimepicker3_error').css('display','block');    
             count++;
          }
          if (!(option[0].checked || option[1].checked || option[2].checked)) {
                
                $('#gender_error').css('display','block');
                
                
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


</script>