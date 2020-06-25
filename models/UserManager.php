<?php
session_start();
class UserManager extends Model
{
	public function getUsers()
	{
		return $this->getAll('user', 'User');
	}

	// GET

	//  Get Password based on email
	public function getPass($email)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT password FROM user WHERE email = ?');
			$req->execute(array($email));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($output['password']);
		$req->closeCursor();
	}

	//  Get username based on email
	public function getPseudo($email)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT username FROM user WHERE email = ?');
			$req->execute(array($email));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($output['username']);
		$req->closeCursor();
	}

	//  Get mail_new_account based on email (to valid a new account creation)
	public function getValidaccount($email)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT mail_new_account FROM user WHERE email = ?');
			$req->execute(array($email));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($output['mail_new_account']);
		$req->closeCursor();
	}

	//  Check if the given key_reset exists (>= 1) or not (0)
	public function getKey_new_account($key_new_account)
	{
		$req = $this->getBdd()->prepare('SELECT COUNT(key_new_account) FROM user WHERE key_new_account = ?');
		$req->execute(array($key_new_account));
		$output = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return ($output["COUNT(key_new_account)"]);
	}

	//  Check if the given key_reset exists (>= 1) or not (0)
	public function getKey_reset($key_reset)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT COUNT(key_reset) FROM user WHERE key_reset = ?');
			$req->execute(array($key_reset));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($output["COUNT(key_reset)"]);
		$req->closeCursor();
	}

	//  Check if the given email already exists (>= 1) or not (0)
	public function existingEmail($email)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT COUNT(email) FROM user WHERE email = ?');
			$req->execute(array($email));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
		return ($output["COUNT(email)"]);
	}

	//  Check if the given username already exists (>= 1) or not (0)
	public function existingPseudo($username)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT COUNT(username) FROM user WHERE username = ?');
			$req->execute(array($username));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
		return ($output["COUNT(username)"]);
	}

	// Check if input are correct during account creation or data changes
	public static function checkEmail($email)
    {
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
			return (1);
		else
			return (0);
    }
    public static function checkPseudo($username)
    {
        if (strlen($username) > '3' && strlen($username) < '25' && preg_match("#^[a-zA-Z0-9]*$#", $username))
			return (1);
		else
			return (0);
    }
    public static function checkPassword($password)
    {
		if (strlen($password) > '7' && strlen($password) < '25' && preg_match("#[0-9]+#", $password) && preg_match("#[A-Z]+#", $password) && preg_match("#[a-z]+#", $password) && preg_match("#^[a-zA-Z0-9]*$#", $password))
			return (1);
		else
			return (0);
    }

	// UPDATE

	//  Update password based on email
	public function updatePass($new, $email)
	{
		try
		{
			$req = $this->getBdd()->prepare('UPDATE user SET password = :new WHERE email = :email');
			$req->execute(array('email' => $email, 'new' => $new));
		}
		catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
		$req->closeCursor();
	}

	//  Update username based on email
	public function updatePseudo($new, $email)
	{
		try
		{
			$req = $this->getBdd()->prepare('UPDATE user SET username = :new WHERE email = :email');
			$req->execute(array('email' => $email, 'new' => $new));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	//  Update email based on email
	public function updateEmail($new, $email)
	{
		try
		{
			$req = $this->getBdd()->prepare('UPDATE user SET email = :new WHERE email = :email');
			$req->execute(array('email' => $email, 'new' => $new));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	//  b) Update mail_new_account based on the key
	public function confirmValidaccount($key_new_account)
	{
		try
		{
			$req = $this->getBdd()->prepare('UPDATE user SET key_new_account = NULL, mail_new_account = 1 WHERE key_new_account = :key_new_account');
			$req->execute(array('key_new_account' => $key_new_account));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	//  Update mail_new_account to desactivate notifications
	public function desactivateNotification($email)
	{
		try
		{
			$req = $this->getBdd()->prepare('UPDATE user SET mail_new_account = 2 WHERE email = :email');
			$req->execute(array('email' => $email));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error des');
		}
		$req->closeCursor();
	}

	//  Update mail_new_account to activate notifications
	public function activateNotification($email)
	{
		try
		{
			$req = $this->getBdd()->prepare('UPDATE user SET mail_new_account = 1 WHERE email = ?');
			$req->execute(array($email));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error act');
		}
		$req->closeCursor();
	}

	// VALID PASSWORD RESET

	//  A) Update key_reset and password2 based on the email
	public function keyReset($key_reset, $password2, $email)
	{
		try
		{
			$req = $this->getBdd()->prepare('UPDATE user SET password2 = :password2, key_reset = :key_reset WHERE email = :email');
			$req->execute(array('password2' => password_hash($password2, PASSWORD_DEFAULT), 'key_reset' => $key_reset, 'email' => $email));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	// B) Replace password by password2
	public function confirmReset($key_reset, $password2)
	{
		try
		{
			$req = $this->getBdd()->prepare('UPDATE user SET password = :password2, key_reset = NULL WHERE key_reset = :key_reset');
			$req->execute(array('key_reset' => $key_reset, 'password2' => $password2));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor(); // Termine le traitement de la requête
	}

	//  Get Password2 based on key_reset
	public function getPass2($key_reset)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT password2, key_reset FROM user WHERE key_reset = ?');
			$req->execute(array($key_reset));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
		return ($output['password2']);
	}

	// ADD

	// Add new user in the DB
	public function addUser($username, $password, $email, $key_new_account)
	{
		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO user(username, password, email, key_new_account) VALUES(:pseudo, :password, :email, :key_new_account)');
			$req->execute(array(
  	 		'pseudo' => $username,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'email' => $email,
			'key_new_account' => $key_new_account));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	// EMAIL

	// Confirm your new account creation by activating the email
	public function mailValidaccount($email, $key_new_account)
	{
		$email = str_replace(array("\n","\r",PHP_EOL),'',$email);
		$subject = 'Welcome to Camagru !';
		$from = 'matt.saubin@gmail.com';

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Create email headers
		$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();

		// Compose a simple HTML email message
		$link = "http://localhost:8081/Camagru/validaccount/" . $key_new_account;
		$custom = "Open the link to valid your account creation: <a href=\"$link\">Click the link !</a>";
		$message = '<html><body>';
		$message .= '<h1 style="color:#006600;">';
		$message .= 'Welcome to Camagru !';
		$message .= '</h1>';
		$message .= '<p style="color:#009900;font-size:16px;">';
		$message .= $custom;
		$message .= '</p><p style="color:#006600;font-size:16px;"> Have a nice day ! <br><br> Team Camagru</p>';
		$message .= '</body></html>';

		mail($email, $subject, $message, $headers);
	}

	// Reset your password by activating the email
	public function mailReset($email, $key_reset)
	{
		$email = str_replace(array("\n","\r",PHP_EOL),'',$email);
		$subject = 'Camagru - Reset your password';
		$from = 'matt.saubin@gmail.com';

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Create email headers
		$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();

		// Compose a simple HTML email message
		$link = "http://localhost:8081/Camagru/reset/" . $key_reset;
		$custom = "Open the link to reset your password: <a href=\"$link\">Click the link!</a>";
		$message = '<html><body>';
		$message .= '<h1 style="color:#006600;">';
		$message .= 'Reset your password';
		$message .= '</h1>';
		$message .= '<p style="color:#009900;font-size:16px;">';
		$message .= $custom;
		$message .= '</p><p style="color:#006600;font-size:16px;"> Have a nice day ! <br><br> Team Camagru</p>';
		$message .= '</body></html>';

		mail($email, $subject, $message, $headers);
	}
}
