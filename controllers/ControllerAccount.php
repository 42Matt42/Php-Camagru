<?php
session_start();
require_once('views/View.php');

class ControllerAccount
{
	private $_userManager;
	private $_view;
	private $_email;
	private $_email_new;
	private $_username_new;
	private $_notif;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CAccount');
		else
			$this->ft_account();
	}

	public function ft_account()
	{
		$this->_userManager = new UserManager;

		if (isset($_SESSION['email']) && isset($_POST['password_bis']) && isset($_POST['logger_account']) && (htmlspecialchars($_POST['logger_account']) == 'Apply'))
		{
			$_email = htmlspecialchars($_SESSION['email']);

			if (password_verify(htmlspecialchars($_POST['password_bis']), $this->_userManager->getPass($_email)))
			{
				try
				{
					// if new password required
					if ((isset ($_POST['password_new'])) && (htmlspecialchars($_POST['password_new']) != ''))
					{
						if (!$this->_userManager->checkPassword(htmlspecialchars($_POST['password_new'])))
						{
							throw new Exception('Your password lenght must be between 8 and 24 and contains a lowercase, an uppercase and a number character, please try again');
						}
						$this->_userManager->updatePass(password_hash(filter_var(filter_var(htmlspecialchars($_POST['password_new']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH), PASSWORD_DEFAULT), $_email);
					}

					// if new username required
					if ((isset ($_POST['username_new'])) && (htmlspecialchars($_POST['username_new']) != ''))
					{
						$_username_new = filter_var(filter_var(htmlspecialchars($_POST['username_new']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

						if (!$this->_userManager->checkPseudo($_username_new))
						{
							throw new Exception('Your username lenght must be between 4 and 24 and only contain alphanumeric characters (abc_ABC_123...), please try again');
						}
						if ($this->_userManager->existingPseudo($_username_new) && ($_username_new != $this->_userManager->getPseudo($_email)))
						{
							throw new Exception('Pseudo already exists');
						}
						$this->_userManager->updatePseudo($_username_new, $_email);
						$_SESSION['username'] = $_username_new;
					}

					// if new email required
					if ((isset ($_POST['email_new'])) && (htmlspecialchars($_POST['email_new']) != ''))
					{
						$_email_new = filter_var(htmlspecialchars($_POST['email_new']), FILTER_SANITIZE_EMAIL);
						if (!$this->_userManager->checkEmail($_email_new))
						{
							throw new Exception('Your email should be in a correct format: email@domain.dot, please try again');
						}
						if (($this->_userManager->existingEmail($_email_new)) && ($_email_new != $_email))
						{
							throw new Exception('Email already used');
						}
						$this->_userManager->updateEmail($_email_new, $_email);
						$_SESSION['email'] = $_email_new;
					}
					$_notif = $this->_userManager->getValidaccount($_email);
					$this->_view = new View('Account');
					$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username']), 'notif' => $_notif));
				}
				catch (Exception $e)
				{
					$errorMsg = $e->getMessage();
					$this->_view = new View('Settings');
					$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username']), 'errorMsg' => $errorMsg));
					die();
				}
			}
			else
			{
				$_SESSION['msg'] = 'Wrong Password, try again !';
				header('Location: /Camagru/settings');
			}
		}
		else
		{
			$_SESSION['msg'] = 'Please, type your current password !';
			header('Location: /Camagru/settings');
		}
	}
}
