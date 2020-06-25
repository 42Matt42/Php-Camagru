<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p>Notification</p></h2>

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
	</p><br><?php
	if ($_SESSION['checkin'] == "logged")
	{
		?>
		<form action='welcome' method='post'>
		<p>
		<input class="button is-primary is-rounded" type='submit' name='whatever' value='Welcome page'/><br/>
		</p>
		</form>
		<?php
	}
