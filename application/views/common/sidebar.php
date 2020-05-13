<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                    <?php $url = $this->uri->segment(1); ?>
                        <li class="menu-title">Main</li>
                        <li class="<?= ($url =='AdminDashboard')?'active':'' ?>" >
                            <a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
						<li class="<?= ($url =='Doctor')?'active':'' ?>">
                            <a href="<?= base_url() ?>Doctor"><i class="fa fa-cutlery"></i> <span>Restaurant</span></a>
                        </li >
                        <li class="<?= ($url =='Patient')?'active':'' ?>" >
                            <a href="<?= base_url() ?>Patient"><i class="fa fa-cutlery"></i> <span>Dish</span></a>
                        </li>
                        <!--<li class="<?= ($url =='Appointment')?'active':'' ?>">-->
                        <!--    <a href="<?= base_url() ?>Appointment"><i class="fa fa-calendar"></i> <span>Booking</span></a>-->
                        <!--</li>-->
                        <!-- <li class="<?= ($url =='Schedule')?'active':'' ?>">
                            <a href="<?= base_url() ?>Schedule"><i class="fa fa-calendar-check-o"></i> <span>Doctor Schedule</span></a>
                        </li>
                        <li class="<?= ($url =='department')?'active':'' ?>">
                            <a href="<?= base_url() ?>department"><i class="fa fa-hospital-o"></i> <span>Departments</span></a>
                        </li>

                        <li class="<?= ($url =='Loan')?'active':'' ?>">
                            <a href="<?= base_url() ?>Loan"><i class="fa fa-money"></i> <span>Loan</span></a>
                        </li>

                        <li class="<?= ($url =='Hospital')?'active':'' ?>">
                            <a href="<?= base_url() ?>Hospital"><i class="fa fa-money"></i> <span>Hospital/Institute</span></a>
                        </li> -->
						<!-- <li class="submenu">
							<a href="#"><i class="fa fa-user"></i> <span> Employees </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="employees.html">Employees List</a></li>
								<li><a href="leaves.html">Leaves</a></li>
								<li><a href="holidays.html">Holidays</a></li>
								<li><a href="attendance.html">Attendance</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><i class="fa fa-money"></i> <span> Accounts </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="invoices.html">Invoices</a></li>
								<li><a href="payments.html">Payments</a></li>
								<li><a href="expenses.html">Expenses</a></li>
								<li><a href="taxes.html">Taxes</a></li>
								<li><a href="provident-fund.html">Provident Fund</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><i class="fa fa-book"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="salary.html"> Employee Salary </a></li>
								<li><a href="salary-view.html"> Payslip </a></li>
							</ul>
						</li>
                        <li>
                            <a href="chat.html"><i class="fa fa-comments"></i> <span>Chat</span> <span class="badge badge-pill bg-primary float-right">5</span></a>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-video-camera camera"></i> <span> Calls</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="voice-call.html">Voice Call</a></li>
                                <li><a href="video-call.html">Video Call</a></li>
                                <li><a href="incoming-call.html">Incoming Call</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-envelope"></i> <span> Email</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="compose.html">Compose Mail</a></li>
                                <li><a href="inbox.html">Inbox</a></li>
                                <li><a href="mail-view.html">Mail View</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="submenu">
                            <a href="#"><i class="fa fa-commenting-o"></i> <span> Blog</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog-details.html">Blog View</a></li>
                                <li><a href="add-blog.html">Add Blog</a></li>
                                <li><a href="edit-blog.html">Edit Blog</a></li>
                            </ul>
                        </li> -->
						
                    </ul>
                </div>
            </div>
        </div>

<!-- 
        <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
        <script>
        $(document).ready(function(){
      $('ul li a').click(function(){
       
      $('ul li ').removeClass("active");
      $(this).addClass("active");
});
});
        </script> -->