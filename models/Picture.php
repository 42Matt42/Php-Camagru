<?php
class Picture
{
	private $_id_picture;
	private $_id_user;
	private $_picture;
	private $_picture_date;
	private $_picture_cam;
	private $_loves;
	private $_comments;
	private $_users;

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
	public function setId_picture($id_picture)
	{
		$id_picture = (int) $id_picture;
		if($id_picture > 0)
			$this->_id_picture = $id_picture;
	}
	public function setId_user($id_user)
	{
		$id_user = (int)$id_user;

		if($id_user > 0)
			$this->_id_user = $id_user;
	}
	public function setPicture($picture)
	{
		$this->_picture = $picture;
	}
	public function setPicture_date($picture_date)
	{
		$this->_picture_date = $picture_date;
	}
	public function setPicture_cam($picture_cam)
	{
		$this->_picture_cam = $picture_cam;
	}
	public function setLoves($loves)
	{
		$this->_loves = $loves;
	}
	public function setComments($comments)
	{
		$this->_comments = $comments;
	}
	public function setUsers($users)
	{
		$this->_users = $users;
	}

	// Getters:
	public function id_picture()
	{
		return $this->_id_picture;
	}
	public function id_user()
	{
		return $this->_id_user;
	}
	public function picture()
	{
		return $this->_picture;
	}
	public function picture_date()
	{
		return $this->_picture_date;
	}
	public function picture_cam()
	{
		return $this->_picture_cam;
	}
	public function loves()
	{
		return $this->_loves;
	}
	public function comments()
	{
		return $this->_comments;
	}
	public function users()
	{
		return $this->_users;
	}
}
