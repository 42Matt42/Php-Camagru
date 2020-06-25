<?php
session_start();
require_once('views/View.php');

class ControllerEmail
{
	private $_view;
	private $_email;
	private $_key_reset;
	private $_control;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CEmail');
		else
			$this->ft_email();
	}

	private function ft_email()
	{
		$this->_userManager = new UserManager;

		if (isset($_POST['email']) && isset($_POST['password2']) && isset($_POST['logger_askreset']) && (htmlspecialchars($_POST['logger_askreset']) == 'Confirm'))
		{
			$_email = htmlspecialchars($_POST['email']);
			$_control = $this->_userManager->existingEmail($_email);
			$_pass2 = filter_var(filter_var(htmlspecialchars($_POST['password2']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			try
			{
				if (!$this->_userManager->checkPassword(htmlspecialchars($_pass2)))
				{
					throw new Exception('Your password lenght must be between 8 and 24 and contains a lowercase, an uppercase and a number character, please try again');
				}
				if ($_control == 1)
				{
					//  A) Update key_reset and password2 based on the email
					$_key_reset = htmlspecialchars(substr(md5(mt_rand()),0,15));
					$this->_userManager->keyReset($_key_reset, htmlspecialchars($_pass2), $_email);
					$this->_userManager->mailReset($_email, $_key_reset);
				}
				else
					throw new Exception('This email is not registered on our website.');
			}
			catch (Exception $e)
			{
				$errorMsg = $e->getMessage();
				$this->_view = new View('Askreset');
				$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username']), 'errorMsg' => $errorMsg));
				die();
			}
			$this->_view = new View('Email');
			$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username']), '_test' => $_control));
		}
		else
		{
			$_SESSION['msg'] = "Error";
			header('Location: /Camagru/askreset');
		}
	}
}
