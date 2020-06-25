<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p>Email received?</p></h2>

<form action='welcome' method='post'>
	<p>
		A new email was sent to you.<br><br>
		~<br><br>
		Please, use the link to finish your account creation !<br><br>
		~<br><br>
		See you soon ! <?= '<3'; ?><br><br>
	</p>
	<p>
	<input type='submit' name='whatever' value='Go back to the Welcome page'/><br/>

<?php

