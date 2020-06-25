<?php
session_start();
require_once('views/View.php');

class ControllerNotification
{
	private $_userManager;
	private $_view;
	private $_email;
	private $_notif;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CAccount');
		else
			$this->ft_notification();
	}

	public function ft_notification()
	{
		$this->_userManager = new UserManager;

		if (isset($_SESSION['email']) && isset($_POST['notification']) && (htmlspecialchars($_POST['notification']) == ('Desactivate' || 'Activate')))
		{
			$_email = htmlspecialchars($_SESSION['email']);

			if (htmlspecialchars($_POST['notification']) == 'Desactivate')
				$this->_userManager->desactivateNotification($_email);
			if (htmlspecialchars($_POST['notification']) == 'Activate')
				$this->_userManager->activateNotification($_email);
			$_notif = $this->_userManager->getValidaccount($_email);
			$this->_view = new View('Notification');
			$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username']), 'notif' => $_notif));
		}
		else
		{
			header('Location: /Camagru/welcome');
		}
	}
}
