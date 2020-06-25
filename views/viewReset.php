<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p> Password change activated ! </p></h2>

<form action='welcome' method='post'>
	<p>
		You can now login with your new password on the Welcome page !<br><br>
		~<br><br>
		Enjoy ! <?= '<3'; ?><br><br>
	</p>
	<p>
	<input type='submit' name='whatever' value='Go back to the Welcome page'/><br/>

<?php

