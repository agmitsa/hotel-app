<?php
ini_set("display_errors", 0);
require __DIR__.'/../boot/boot.php';

use Hotel\User;

//Check for existed logged in user
if (!empty(User::getCurrentUserId())) {
	header('Location: /public/index.php');die;
}
?>
<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="noindex,nofollow">	
		<title>Hotels-Log in to your Account</title>
		<link href="assets/css/entry.css" type="text/css" rel="stylesheet" />	
	</head>
	<body>
        <header>
            <div class="container">
				<p class="logo">Hotels</p>
                <div class="primary-menu text-right">
                    <ul>
						<li class='home'><a href="index.php"><i class='fas fa-home'></i>Home</a></li>	
						<li class="profile"><a href="profile-page.php"><i class='fas fa-user'></i>Profile</a></li>

                    </ul>
                </div>
				<div class="clear"></div>
            </div>
        </header>
		<main>
			<div class='login-form'>
				<div class='login-logo'>
					<h1>Hotels</h1>
					<h2>Find the Perfect Hotel</h2>		
				</div>
				<form action='actions/login.php' method='POST'>	
					<?php if(!empty($_GET['error'])) {?> 
					<div class='alert'>Login Error</div>
					<?php } ?>				
                    <div class="form-group email">
                        <label for="email"><span style="color: red;">*</span>E-mail:</label>
                        <input id="email" name='email' value="" placeholder="ex. example@example.com" type="input">
                    </div>
                    <div class="form-group password">
                        <label for="password"><span style="color: red;">*</span>Password:</label>
                        <input name="password" id="password" value="" type="password">

                    </div>
                    <div class="form-group">
                        <label for="rememberMe">Remember me</label>
                        <input id="rememberMe" name="rememberMe" type="checkbox">											
                    </div>
                    <div class="action">
                        <input name="btn-submit" id="submitButton" type="submit" value="Log in">
                    </div>					
				</form>
				<div class='forgot-psw'>
					<a href='#'>Forgot your password?</a>
				</div>
				<div class='register'>
					 <span>Or else: <a href="register.php">Register</a></span>
				</div>
			</div>
		</main>
		<footer>
			<p>©collegelink 2020</p>		
		</footer>
		<link href="assets/css/fontawesome.min.css" rel="stylesheet" />				
		<link href="assets/css/wda-style.css" type="text/css" rel="stylesheet" />	
	</body>
</html>