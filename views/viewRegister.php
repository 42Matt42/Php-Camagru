<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p> Registration </p></h2>

<?php

	// if (isset($errorMsg) && $errorMsg != '')
	// {
	// 	echo $errorMsg . '<br>';
	// 	$errorMsg = '';
	// }

	if (htmlspecialchars($_SESSION['checkin']) != "logged")
	{
		?>
		<form action='adduser' method='post'>
		<p>
			Choose a username:<br> <input type='text' name='username_add' placeholder='username' required/><br/>
			[between 4 and 24 alphanumeric characters]<br>
			<br>
			Choose an email:<br> <input type='email' name='email_add' placeholder='email' required/><br/>
			<br>
			Choose a password:<br>
			<input type='password' name='password_add' placeholder='password' required/><br/>
			[at least 1 lowercase (abc...) and 1 uppercase (ABC...) alphabetical characters,<br>
			1 number (123...) and a length between 8 and 24 characters]<br>
			<br>
		</p>
			Are you sure all your information is correct?<br>
			<br>
			<input type="checkbox" name="checkbox" value="Yes">  Yes!<br>
		<p>
			<input type='submit' name='adduser' value='Confirm'/><br/>
		</p>
		</form>
		<?php
	}
