<?php
session_start();
require_once('views/View.php');

class ControllerRegister
{
	private $_view;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CRegister');
		else
			$this->ft_register();
	}

	private function ft_register()
	{
		if (htmlspecialchars($_SESSION['checkin']) != 'logged' && htmlspecialchars($_POST['logger_register']) == 'Register')
		{
			$this->_view = new View('Register');
			$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username'])));
		}
		else
		{
			header('Location: /Camagru/welcome');
		}
	}
}
