<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p>Reset your password</p></h2>

<?php
	echo $errorMsg . '<br>' . '<br>';
	$errorMsg = '';

	if ($_SESSION['checkin'] != "logged")
	{
		?>
		<form action='email' method='post'>
		<p>
			Type your email:<br>
			Email: <input type='email' name='email' placeholder='email' required/><br/>
			<br>
			Choose a new password:<br>
			New password: <input type='password' name='password2' placeholder='********' required/><br/>
		</p>
		<p>
			<input type='submit' name='logger_askreset' value='Confirm'/><br/>
		</p>
		</form>
		<?php
	}
