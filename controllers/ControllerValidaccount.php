<?php
session_start();
require_once('views/View.php');

class ControllerValidaccount
{
	private $_userManager;
	private $_view;
	private $_key_new_account;

	public function __construct($url)
	{
		if(isset($url) && count($url) != 2)
			throw new Exception('Page introuvable_CValidaccount');
		else
			$this->ft_validaccount($url[1]);
	}

	private function ft_validaccount($url)
	{
		$this->_userManager = new UserManager;

		if (isset($url) && ($this->_userManager->getKey_new_account(htmlspecialchars($url)) > 0))
		{
			//  Update mail_new_account based on the key
			$this->_userManager->confirmValidaccount($url);

			$this->_view = new View('Validaccount');
			$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username'])));
		}
		else
		{
			$_SESSION['msg'] = "Account already activated or invalid link";
			header('Location: /Camagru/welcome');
		}
	}
}
