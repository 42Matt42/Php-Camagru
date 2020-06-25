<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p> Settings </p></h2>
	<p>
	<p class="has-text-primary"> Current information</p>
	<p class="is-italic">Email: <?= htmlspecialchars($_SESSION['email'])?><br>
	Username: <?= htmlspecialchars($_SESSION['username'])?></p>
	<p>Notifications:
		<?php if($notif == 1)
			echo '[on]';
		else if ($notif == 2)
			echo '[off]';?>
	</p>
	</p><br>

	<?php if (htmlspecialchars($_SESSION['checkin']) == "logged")
	{
		if ($notif == 1)
		{?>
			<form action='notification' method='post'>
				<p class="has-text-weight-semibold">Notifications: </p>
				<i>I don't want to receive an email when someone comment one of my picture: </i>
				<input type='submit' class="button is-danger is-outlined" name='notification' value='Desactivate'/><br>
			</form>
			<br><?php
		}
		if ($notif == 2)
		{?>
			<form action='notification' method='post'>
				<p class="has-text-weight-semibold">Notifications: </p>
				<i>I want to receive an email when someone comment one of my picture: </i>
				<input type='submit' class="button is-success" name='notification' value='Activate'/><br>
			</form>
			<br><?php
		}?>

		<form action='account' method='post'>
		<p>
			Security question - please, type your <b>current password</b> again:
			<input type='password' name='password_bis' placeholder='Retype your password' /><br><br>
		</p>
		<p>
			<p class="is-italic">You may choose a new username:</p>
			<p class="has-text-weight-semibold">New username: </p><input type='text' name='username_new' placeholder=<?= htmlspecialchars($_SESSION['username']) ?> /><br/>
			<br>
			<p class="is-italic">You may choose a new email:</p>
			<p class="has-text-weight-semibold">New email: </p><input type='email' name='email_new' placeholder=<?= htmlspecialchars($_SESSION['email']) ?> /><br/>
			<br>
			<p class="is-italic">You may choose a new password:</p>
			<p class="has-text-weight-semibold">New password: </p><input type='password' name='password_new' placeholder='********' /><br><br>
		</p>
		<p>
			<input type='submit' class="button is-primary" name='logger_account' value='Apply'/><br/>
		</p>
		</form>
		<?php
	}

