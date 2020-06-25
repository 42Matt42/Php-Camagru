<?php
session_start();
require_once('views/View.php');

class ControllerLogout
{
	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CLogout');
		else
			$this->ft_auth_off();
	}

	public function ft_auth_off()
	{
		if (isset($_POST['logger_off']) && (htmlspecialchars($_POST['logger_off']) == 'Disconnect'))
		{
			unset ($_SESSION['checkin']);
			unset ($_SESSION['email']);
			unset ($_SESSION['username']);
			$_SESSION['msg'] = "You're now disconnected !";
		}
		header('Location: /Camagru/welcome');
	}
}
