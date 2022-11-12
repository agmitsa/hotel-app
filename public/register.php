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
		<title>Hotels-Register</title>
		<link href="assets/css/entry.css" type="text/css" rel="stylesheet" />	
	</head>
	<body>
        <header>
            <div class="container">
				<p class="logo">Hotels</p>
                <div class="primary-menu text-right">
                    <ul>
						<li class='home'><a href="index.php"><i class='fas fa-home'></i>Home</a></li>	
						<li class="profile"><a href="profile.php"><i class='fas fa-user'></i>Profile</a></li>

                    </ul>
                </div>
				<div class="clear"></div>
            </div>
        </header>
		<main>
			<div class='register-form'>
				<div class='register-logo'>
					<h1>Hotels</h1>
					<h2>Find the Perfect Hotel</h2>		
				</div>
				<form method='POST' action='actions/register.php'>				
					<div class="form-group">
						<label for="name"><span style="color: red;">*</span>Name:</label>
						<input id="name" value="" name='name' placeholder="ex. John Doe" type="text">
						<div class='text-danger name-error'>You must fill in this field.</div>												
					</div>
                    <div class="form-group email">
                        <label for="email"><span style="color: red;">*</span>E-mail:</label>
                        <input id="email" value="" name='email' placeholder="ex. example@example.com" type="input">
						<div class='text-danger email-error'>Must be a valid e-mail address!</div>						
                    </div>
                    <div class="form-group password">
                        <label for="password"><span style="color: red;">*</span>Password:</label>
                        <input name="password" id="password" value="" type="password">
						<div class='text-danger password-error'>Password must contain at least eight characters, one letter, one number and one special character!</div>											
                    </div>
                    <div class="form-group password">
                        <label for="confirm-password"><span style="color: red;">*</span>Confirm Password:</label>
                        <input name="confirm-password" id="confirm-password" value="" type="password">
						<div class='text-danger confirm-error'>Passwords do not match!</div>											
                    </div>
                    <div class="form-group">
                        <label for="agreeTerms">I have understood and agree with the <a href='#'>Terms of Service</a>:</label>
                        <input id="agreeTerms" name="agreeTerms" type="checkbox">						
                  </div>
                    <div class="action">
                        <input name="btn-submit" id="submitButton" type="submit" value="Register" disabled>
                    </div>					
				</form>
				<div class='login'>
					 <span>Already have an account? <a href="login.php">Log in</a>.</span>
				</div>
			</div>
		</main>
		<footer>
			<p>©collegelink 2020</p>		
		</footer>
		<link href="assets/css/fontawesome.min.css" rel="stylesheet" />				
		<link href="assets/css/wda-style.css" type="text/css" rel="stylesheet" />	
		<script src='./register.js'></script>		
	</body>
</html>