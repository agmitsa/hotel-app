document.addEventListener("DOMContentLoaded", () => {
	const $name = document.querySelector('#name');
	const $email = document.querySelector("#email");
	const $password = document.querySelector("#password");
	const $confirmPassword = document.querySelector('#confirm-password');  
	const $submit = document.querySelector("#submitButton");
	
	const $nameError = document.querySelector('.name-error');
	const $emailError = document.querySelector(".email-error");
	const $passwordError = document.querySelector(".password-error");
	const $confirmError = document.querySelector('.confirm-error'); 
	
	let nameIsValid = false;
	let emailIsValid = false;
	let passwordIsValid = false;
	let confirmIsValid = false;
	
	//Check if name field is empty in order to be valid
	const getNameValidation = (name) => {
		if (name == '') {
			nameIsValid = false;
			
		} else {
			nameIsValid = true;
		}
	}
	
	const getEmailValidation = (email) => {
	if (
	  email !== "" &&
	  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)
	) {
	  emailIsValid = true;
	} else {
	  emailIsValid = false;
	}
	};
	
	//Check if password field is empty or it contains at least eight characters, one letter, one number and one special character
	const getpasswordValidation = (password) => {
	if (password !== "" && /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(password)) {
	  passwordIsValid = true;
	} else {
	  passwordIsValid = false;
	}
	};
	//Check for the confirm password field
	const getConfirmValidation = (confirm) => {
		if (passwordIsValid && confirm === $password.value){
			confirmIsValid = true;
		} else {
			confirmIsValid = false;
		}		
	}
	//Disable/enable sign in button depending on inputs
	const checkSigninBtn = () => {
		if (emailIsValid && passwordIsValid && confirmIsValid && nameIsValid) {
		  $submit.disabled = false;
		} else {
		  $submit.disabled = true;
		}
	};

//Event Listeners	
	$name.addEventListener('input', (e) => {
		getNameValidation(e.target.value)
		if (!nameIsValid) {
			$nameError.style = '';
		} else {
			$nameError.style.display = 'none';			
		}
		checkSigninBtn();		
	});

	$email.addEventListener("input", (e) => {
		getEmailValidation(e.target.value);

		if (!emailIsValid) {
			$emailError.style = '';
		} else {
			$emailError.style.display = 'none';
		}

		checkSigninBtn();
	});

	$password.addEventListener("input", (e) => {
	getpasswordValidation(e.target.value);
		if (!passwordIsValid) {
			$passwordError.style='';
		} else {
			$passwordError.style.display = 'none';
		}

		checkSigninBtn();
	});

	$confirmPassword.addEventListener('input', (e) => {
		getConfirmValidation(e.target.value);
		if (!confirmIsValid){
			$confirmError.style = '';
		} else {
			$confirmError.style.display = 'none';

		}		
		checkSigninBtn();

	});

	$nameError.style.display = 'none';
	$emailError.style.display = 'none';
	$passwordError.style.display = 'none';
	$confirmError.style.display = 'none';
	
});
