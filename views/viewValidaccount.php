<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p> Account creation confirmed ! </p></h2>

<form action='welcome' method='post'>
	<p>
		Thank you !<br><br>
		~<br><br>
		You can now login through the Welcome page !<br><br>
		~<br><br>
		Enjoy ! <?= '<3'; ?><br><br>
	</p>
	<p>
	<input type='submit' name='whatever' value='Go back to the Welcome page'/><br/>

<?php

