<?php
session_start();
require_once('views/View.php');

class ControllerWelcome
{
	private $_view;

	public function __construct($url)
	{
		if ($url == "")
			$this->ft_welcome();
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CWelcome');
		else
			$this->ft_welcome();
	}

	private function ft_welcome()
	{
		$this->_view = new View('Welcome');
		$this->_view->generate(array('pictures' => $pictures, 'username' => htmlspecialchars($_SESSION['username'])));
	}
}
