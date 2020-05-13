<div class="page-wrapper">
<?php

$array = json_decode($Schedule->available);
?>
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Edit Schedule</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form action="<?= base_url() ?>Schedule/edit_schedule" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
										<label>Doctor Name</label>
										<select class="select">
											<option>Select</option>
											<?php foreach($doctors as $d): ?>
                                            <option value="<?= empty($d->id)?'':$d->id  ?>" <?= ($Schedule->doctor_id == $d->id)?'selected':'' ?> name="doctor_id"><?= empty($d->doctor_name)?'':$d->doctor_name ?></option>
                                            <?php endforeach ?>
										</select>
									</div>
                                </div>

                                <div>
                                <input type="hidden" name="id" value='<?= $Schedule->id ?>'>
                                </div>
                                <div class="col-md-6">
									<div class="form-group">
										<label>Available Days</label>
										<select class="select" multiple name="available[]" id="available_days">
											<option>Select Days</option>
											<option <?= (empty($array))?'':in_array("Sunday", $array)?'selected':'' ?>  value="Sunday" >Sunday</option>
											<option <?= (empty($array))?'':in_array("Monday", $array)?'selected':'' ?> value="Monday">Monday</option>
											<option <?= (empty($array))?'':in_array("Tuesday", $array)?'selected':'' ?> value="Tuesday">Tuesday</option>
											<option <?= (empty($array))?'':in_array("Wednesday", $array)?'selected':'' ?> value="Wednesday">Wednesday</option>
											<option <?= (empty($array))?'':in_array("Thursday", $array)?'selected':'' ?> value="Thursday">Thursday</option>
											<option <?= (empty($array))?'':in_array("Friday", $array)?'selected':'' ?> value="Friday">Friday</option>
											<option <?= (empty($array))?'':in_array("Saturday", $array)?'selected':'' ?> value="Saturday">Saturday</option>
										</select>
                                         <p class="alert alert-danger" id="available_days_error" style="display:none;">Days are required</p>
									</div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Time</label>
                                        <div class="time-icon">
                                            <input type="text" value="<?= empty($Schedule->start_time)?'':$Schedule->start_time ?>" name="start_time" class="form-control" id="datetimepicker3">
                                        </div>
                                         <p class="alert alert-danger" id="datetimepicker3_error" style="display:none;">Start Time is required</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Time</label>
                                        <div class="time-icon">
                                            <input type="text" value="<?= empty($Schedule->end_time)?'':$Schedule->end_time ?>" name="end_time" class="form-control" id="datetimepicker4">
                                        </div>
                                         <p class="alert alert-danger" id="datetimepicker4_error" style="display:none;">End Time is required</p>
                                    </div>
                                </div>

                                <div class="col-md-12">
									<div class="form-group">
										<label>Department</label>
										<select class="select" name="department_id" >
											<?php foreach($department as $d): ?>
                                            <option value="<?= empty($d->id)?'':$d->id ?>" <?= ($d->id == $Schedule->id)?'checked':'' ?>><?= empty($d->department_name)?'':$d->department_name ?></option>
                                            <?php endforeach ?>
										</select>

									</div>
                                </div>

                            </div>
                           
                            <div class="form-group">
                                <label class="display-block">Schedule Status</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="status" id="product_active" value="1" <?= empty($Schedule->status)?'':($Schedule->status==1)?'checked':'' ?>>
									<label class="form-check-label" for="product_active">
									Active
									</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="status" id="product_inactive" value="0" <?= ($Schedule->status==0)?'checked':'' ?>>
									<label class="form-check-label" for="product_inactive">
									Inactive
									</label>
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
          var days = $("#available_days").val();
          var st = $("#datetimepicker3").val();
          var et = $("#datetimepicker4").val();
         
           var count =0;

         if(days.length <= 0){
           $('#available_days_error').css('display','block');
           count++;
          }
          if(days.length > 0){
           $('#available_days_error').css('display','none');
           count--;
          }
          if(st.length <= 0){
             $('#datetimepicker3_error').css('display','block');    
             count++;
          }
           if(st.length > 0){
             $('#datetimepicker3_error').css('display','none');    
             count--;
          }
          if(et.length <= 0){
             $('#datetimepicker4_error').css('display','block');    
             count++;
          }
          if(et.length > 0){
             $('#datetimepicker4_error').css('display','none');    
             count--;
          }

          if(count <= 0){
            
          }
          else {
       event.preventDefault();
          }
     });

         $('input[type="text"').keyup(function(event) {
             alert('hii');
         });

     });
 </script>