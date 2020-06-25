<?php
session_start();
require_once('views/View.php');

class ControllerSettings
{
	private $_view;
	private $_notif;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CSettings');
		else
			$this->ft_settings();
	}

	public function ft_settings()
	{
		$this->_userManager = new UserManager;

		if (isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_POST['logger_settings']) && (htmlspecialchars($_POST['logger_settings']) == 'Settings'))
		{
			$_notif = $this->_userManager->getValidaccount(htmlspecialchars($_SESSION['email']));
			$this->_view = new View('Settings');
			$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username']), 'notif' => $_notif));
		}
		else
		{
			header('Location: /Camagru/welcome');
		}
	}
}
