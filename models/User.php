<?php
class User
{
	private $_id_user;
	private $_username;
	private $_password;
	private $_email;
	private $_register_date;
	private $_user_group;

	public function __construct(array $data)
	{
		$this->hydrate($data);
	}

	public function hydrate(array $data)
	{
		foreach($data as $key => $value)
		{
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method))
				$this->$method($value);
		}
	}

	// Setters:
	public function setId_user($id_user)
	{
		$id_user = (int)$id_user;

		if($id_user > 0)
			$this->_id_user = $id_user;
	}
	public function setUsername($username)
	{
		if(is_string($username))
			$this->_username = $username;
	}
	public function setPassword($password)
	{
		if(is_string($password))
			$this->_password = $password;
	}
	public function setEmail($email)
	{
		if(is_string($email))
			$this->_email = $email;
	}
	public function setRegister_date($register_date)
	{
		$this->_register_date = $register_date;
	}
	public function setUser_group($user_group)
	{
		if(is_string($user_group))
			$this->_user_group = $user_group;
	}

	// Getters:
	public function id_user()
	{
		return $this->_id_user;
	}
	public function username()
	{
		return $this->_username;
	}
	public function password()
	{
		return $this->_password;
	}
	public function email()
	{
		return $this->_email;
	}
	public function register_date()
	{
		return $this->_register_date;
	}
	public function user_group()
	{
		return $this->_user_group;
	}
}
