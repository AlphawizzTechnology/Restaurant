<!DOCTYPE html>
<html lang="en">


<!-- login23:11-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Restaurant</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
			<div class="account-center">
				<div class="account-box">
                    <form action="<?= base_url() ?>AdminLogin/Login" method="post" class="form-signin">
						<div class="account-logo">
                            <a href="index-2.html"><img width="100" height="100" src="assets/img/adminlogonew.png" alt=""></a>
                        </div>
                        <?php if(!empty($this->session->flashdata('admin_login_result'))){  ?>
                             <div class="alert alert-danger"><?= $this->session->flashdata('admin_login_result') ?></div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Username or Email</label>
                            <input type="text" autofocus="" name="Username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="Password" class="form-control">
                        </div>
                        <div class="form-group text-center">
                            <a href="<?= base_url() ?>AdminLogin/ForgetPassword">Forgot your password?</a>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary account-btn">Login</button>
                        </div>
                        <!-- <div class="text-center register-link">
                            Don’t have an account? <a href="register.html">Register Now</a>
                        </div> -->
                    </form>
                </div>
			</div>
        </div>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>


<!-- login23:12-->
</html>