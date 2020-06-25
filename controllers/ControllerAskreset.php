<?php
session_start();
require_once('views/View.php');

class ControllerAskreset
{
	private $_view;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CAskreset');
		else
			$this->ft_askreset();
	}

	private function ft_askreset()
	{
		if (htmlspecialchars($_SESSION['checkin']) != 'logged' && htmlspecialchars($_POST['logger_reset']) == 'Reset Password')
		{
			$this->_view = new View('Askreset');
			$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username'])));
		}
		else
		{
			header('Location: /Camagru/welcome');
		}
	}
}
