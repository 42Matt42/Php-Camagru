<?php
session_start();
require_once('views/View.php');

class ControllerCamera
{
	private $_view;
	private $_pictureManager;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CCamera');
		else
			$this->ft_camera();
	}

	private function ft_camera()
	{
		$this->_pictureManager = new PictureManager;
		if (htmlspecialchars($_SESSION['checkin']) == 'logged')
		{
			$pictures = $this->_pictureManager->getPictureGallery(3, 0);
			$this->_view = new View('Camera');
			$this->_view->generate(array('pictures' => $pictures, 'username' => htmlspecialchars($_SESSION['username'])));
		}
		else
		{
			header('Location: /Camagru/welcome');
		}
	}
}
