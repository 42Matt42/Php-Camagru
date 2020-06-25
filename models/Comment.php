<?php
class Comment
{
	private $_id_comment;
	private $_id_user;
	private $_id_picture;
	private $_comment;
	private $_comment_date;
	private $_username;

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
	public function setId_comment($id_comment)
	{
		$id_comment = (int) $id_comment;
		if($id_comment > 0)
			$this->_id_comment = $id_comment;
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
	public function setComment($comment)
	{
		$this->_comment = $comment;
	}
	public function setComment_date($comment_date)
	{
		$this->_comment_date = $comment_date;
	}
	public function setUsername($username)
	{
		$this->_username = $username;
	}

	// Getters:
	public function id_comment()
	{
		return $this->_id_comment;
	}
	public function id_user()
	{
		return $this->_id_user;
	}
	public function id_picture()
	{
		return $this->_id_picture;
	}
	public function comment()
	{
		return $this->_comment;
	}
	public function comment_date()
	{
		return $this->_comment_date;
	}
	public function username()
	{
		return $this->_username;
	}
}
