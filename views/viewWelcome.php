<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p> Hello Space~Time traveller !</p></h2>

<?= "<p>A new story begins... let's go !</p>"  . "<br>";


	if (htmlspecialchars($_SESSION['checkin']) != "logged")
	{?>
		<form action="auth" method="post">
		<p>
			Email: <input type="email" name="email" placeholder="email" required/><br/>
			Password: <input type="password" name="password" placeholder="password" required/><br/>
			<input class="button is-success is-rounded" type="submit" name="logger" value="OK"/><br/>
		</p>
		</form><?php
	}
	if (htmlspecialchars($_SESSION['checkin']) == "logged")
	{?>
		<form action="camera" method="post">
		<p>
			<input class="button is-danger is-rounded" type="submit" name="logger_camera" value="Take a Picture !"/><br/>
		</p>
		</form><?php
	}
	if (htmlspecialchars($_SESSION['checkin']) == "logged")
	{?>
		<form action="settings" method="post">
		<p>
			<input class="button is-rounded" type="submit" name="logger_settings" value="Settings"/><br/>
		</p>
		</form><?php
	}
	else
	{?>
		<form action="register" method="post">
		<p>
			<input class="button is-info is-rounded" type="submit" name="logger_register" value="Register"/><br/>
		</p>
		</form><?php
	}

	if (htmlspecialchars($_SESSION['checkin']) != "logged")
	{
		?>
		<form action='askreset' method='post'>
		<p>
			<input class="button is-rounded" type='submit' name='logger_reset' value='Reset Password'/><br/>
		</p>
		</form>
		<?php
	}
