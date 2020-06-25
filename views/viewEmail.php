<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p> Check your mailbox </p></h2>

<?php

if ($_SESSION['checkin'] != "logged")
{
	?>
	<form action='welcome' method='post'>
	<p>
		A new email was sent to you.
		~
		Please, use the link to check it !
		~
		<?= '<3'; ?>
	</p>
	<p>
	<input type='submit' name='whatever' value='Go back to the Welcome page'/><br/>
	</p>
	</form>
	<?php
}
