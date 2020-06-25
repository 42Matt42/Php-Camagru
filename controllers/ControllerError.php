<?php
session_start();
require_once('views/View.php');

class ControllerError
{
	private $_view;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CCamera');
		else
			$this->ft_error();
	}

	private function ft_error()
	{
		$this->_view = new View('Error');
		$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username'])));
	}
}
