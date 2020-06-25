<?php
session_start();
require_once('views/View.php');

class ControllerAdduser
{
	private $_userManager;
	private $_view;
	private $_add_username;
	private $_add_email;
	private $_key_new_account;


	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CAdduser');
		else
			$this->ft_adduser();
	}

	private function ft_adduser()
	{
		$this->_userManager = new UserManager;

		if (htmlspecialchars($_POST['adduser']) == 'Confirm' && htmlspecialchars($_POST['username_add']) && htmlspecialchars($_POST['email_add'])
		&& htmlspecialchars($_POST['password_add']) && htmlspecialchars($_POST['checkbox']) == 'Yes')
		{
			$_add_username = filter_var(filter_var(htmlspecialchars($_POST['username_add']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$_add_email = filter_var(htmlspecialchars($_POST['email_add']), FILTER_SANITIZE_EMAIL);

			try
			{
				if (!$this->_userManager->checkEmail($_add_email))
				{
					throw new Exception('Your email should be in a correct format: email@domain.dot, please try again');
				}
				if ($this->_userManager->existingEmail($_add_email))
				{
					throw new Exception('Email already used');
				}
				if (!$this->_userManager->checkPseudo($_add_username))
				{
					throw new Exception('Your username lenght must be between 4 and 24 and only contain alphanumeric characters (abc_ABC_123...), please try again');
				}
				if ($this->_userManager->existingPseudo($_add_username))
				{
					throw new Exception('Pseudo already exists');
				}
				if (!$this->_userManager->checkPassword(htmlspecialchars($_POST['password_add'])))
				{
					throw new Exception('Your password lenght must be between 8 and 24 and contains a lowercase, an uppercase and a number character, please try again');
				}

				$_key_new_account = htmlspecialchars(substr(md5(mt_rand()),0,15));
				$this->_userManager->addUser($_add_username, filter_var(filter_var(htmlspecialchars($_POST['password_add']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH), $_add_email, $_key_new_account);
				$this->_userManager->mailValidaccount($_add_email, $_key_new_account);
				$this->_view = new View('Adduser');
				$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username'])));
			}
			catch (Exception $e)
			{
				$errorMsg = $e->getMessage();
				$this->_view = new View('Register');
				$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username']), 'errorMsg' => $errorMsg));
				// header('Location: /Camagru/register');
				die();
			}
		}
		else
		{
			$_SESSION['msg'] = "Tick the box \"Yes!\" before to Confirm";
			header('Location: /Camagru/register');
		}
	}
}
