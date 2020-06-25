<?php
session_start();
require_once('views/View.php');

class ControllerAuth
{
	private $_userManager;
	private $_view;
	private $_email;
	private $_username;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CAuth');
		else
			$this->ft_auth();
	}

	public function ft_auth()
	{
		$this->_userManager = new UserManager;

		if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['logger']) && (htmlspecialchars($_POST['logger'] == 'OK')))
		{
			$_email = htmlspecialchars($_POST['email']);

			if (password_verify(htmlspecialchars($_POST['password']), $this->_userManager->getPass($_email)))
			{
				if ($this->_userManager->getValidaccount($_email) == (1 || 2))
				{
					$_SESSION['email'] = $_email;
					$_username = $this->_userManager->getPseudo($_email);
					$_SESSION['username'] = $_username;
					$_SESSION['checkin'] = "logged";
				}
				else
				{
					$_SESSION['checkin'] = "fail";
					$_SESSION['msg'] = "Check your email to activate your account !";
				}
			}
			else
			{
				$_SESSION['checkin'] = "fail";
				$_SESSION['msg'] = "Wrong Email or Password, please try again";
			}
		}
		else
		{
			$_SESSION['checkin'] = "fail";
			$_SESSION['msg'] = "Fullfill the fields Email + Password then press OK";
		}
		header('Location: /Camagru/welcome');
	}
}
