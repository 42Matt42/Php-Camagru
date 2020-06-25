<?php
session_start();
require_once('views/View.php');

class ControllerReset
{
	private $_userManager;
	private $_view;
	private $_key_reset;

	public function __construct($url)
	{
		if(isset($url) && count($url) != 2)
			throw new Exception('Page introuvable_CReset');
		else
			$this->ft_reset($url[1]);
	}

	private function ft_reset($url)
	{
		$this->_userManager = new UserManager;

		if (isset($url) && ($this->_userManager->getKey_reset(htmlspecialchars($url)) > 0))
		{
			// B) Replace password by password2
			$this->_userManager->confirmReset($url, $this->_userManager->getPass2($url));

			$this->_view = new View('Reset');
			$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username'])));
		}
		else
		{
			$_SESSION['msg'] = "New password already activated or invalid link";
			header('Location: /Camagru/welcome');
		}
	}
}
