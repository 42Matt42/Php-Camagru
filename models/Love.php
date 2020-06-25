<?php
class Love
{
	private $_id_love;
	private $_id_user;
	private $_id_picture;
	private $_status;
	private $_email;

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
	public function setId_love($id_love)
	{
		$id_love = (int) $id_love;
		if($id_love > 0)
			$this->_id_love = $id_love;
	}
	public function setId_user($id_user)
	{
		$id_user = (int)$id_user;

		if($id_user > 0)
			$this->_id_user = $id_user;
	}
	public function setId_picture($id_picture)
	{
		$id_picture = (int) $id_picture;
		if($id_picture > 0)
			$this->_id_picture = $id_picture;
	}
	public function setStatus($status)
	{
		$this->_status = $status;
	}
	public function setEmail($email)
	{
		$this->_email = $email;
	}


	// Getters:
	public function id_love()
	{
		return $this->_id_love;
	}
	public function id_user()
	{
		return $this->_id_user;
	}
	public function id_picture()
	{
		return $this->_id_picture;
	}
	public function status()
	{
		return $this->_status;
	}
	public function email()
	{
		return $this->_email;
	}
}
