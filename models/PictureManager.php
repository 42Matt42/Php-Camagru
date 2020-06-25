<?php
class PictureManager extends Model
{
	public function getPictures()
	{
		return $this->getAll('picture', 'Picture');
	}

	// GET

	//	Get pictures by DESC order
	public function getPictureLimit($limit, $offset)
	{
		$var = [];

		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM picture ORDER BY picture_date DESC LIMIT ? OFFSET ? ');
			// $req->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
			$req->bindParam(1, $limit,PDO::PARAM_INT);
			$req->bindParam(2, $offset,PDO::PARAM_INT);
			$req->execute();
			while ($data = $req->fetch(PDO::FETCH_ASSOC))
				{
				array_push($var, new Picture($data));
			}
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($var);
		$req->closeCursor();
	}

	public function getLoveGallery($id_picture)
	{
		$loves = array();
		$var = array('id_picture' => $id_picture);
		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM love WHERE id_picture = :id_picture');
			$req->execute($var);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		while ($data = $req->fetch(PDO::FETCH_ASSOC))
			$loves[] = new Love($data);
		foreach ($loves as $love)
			{
				$var = array('id_user' => $love->id_user());
				try
				{
					$req = $this->getBdd()->prepare('SELECT email FROM user WHERE id_user = :id_user');
					$req->execute($var);
				}
				catch (PDOException $e)
				{
					throw new Exception('Query error');
				}
				$data = $req->fetch(PDO::FETCH_ASSOC);
				$love->setEmail($data['email']);
				$req->closeCursor();
			}
		return $loves;
		$req->closeCursor();
	}

	public function getCommentGallery($id_picture)
	{
		$comments = array();
		$var = array('id_picture' => $id_picture);
		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM comment WHERE id_picture = :id_picture ORDER BY comment_date ASC');
			$req->execute($var);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		while ($data = $req->fetch(PDO::FETCH_ASSOC))
			$comments[] = new Comment($data);
		foreach ($comments as $comment)
		{
			$var = array('id_user' => $comment->id_user());
			try
			{
				$req = $this->getBdd()->prepare('SELECT username FROM user WHERE id_user = :id_user');
				$req->execute($var);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$comment->setUsername($data['username']);
			$req->closeCursor();
		}
		return $comments;
		$req->closeCursor();
	}

	public function getPictureGallery($limit, $offset)
	{
		$pictures = $this->getPictureLimit($limit, $offset);
		foreach ($pictures as $picture)
		{
			$values = array('id_user' => $picture->id_user());
			try
			{
				$req = $this->getBdd()->prepare('SELECT id_user, username, email FROM user WHERE (id_user = :id_user)');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$user = new User($data);
			$picture->setUsers($user);
			$picture->setLoves($this->getLoveGallery($picture->id_picture()));
			$picture->setComments($this->getCommentGallery($picture->id_picture()));
		}
		return $pictures;
		$req->closeCursor();
	}

	public function merge_pic_background($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
		$cut = imagecreatetruecolor($src_w, $src_h);
		imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
		imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
		imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
	}

	// Get the id_user based on the username
	public function getId_user($username)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT id_user FROM user WHERE username = ?');
			$req->execute(array($username));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($output['id_user']);
		$req->closeCursor();
	}

	// Add a new picture in the DB
	public function addPic($id_user, $picture, $picture_cam)
	{
		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO picture(id_user, picture, picture_cam) VALUES(:id_user, :picture, :picture_cam)');
			$req->execute(array(
			'id_user' => $id_user,
			'picture' => $picture,
			'picture_cam' => $picture_cam));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	// Delete a picture from the DB
	public function deletePic($id_user, $id_picture)
	{
		try
		{
			$req = $this->getBdd()->prepare('DELETE FROM picture WHERE id_user = :id_user AND id_picture = :id_picture');
			$req->execute(array(
			'id_user' => $id_user,
			'id_picture' => $id_picture));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	// Get the picture path based on id__picture (in order to delete it in php)
	public function getPicPath($id_user, $id_picture)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT picture_cam FROM picture WHERE id_user = :id_user AND id_picture = :id_picture');
			$req->execute(array(
				'id_user' => $id_user,
				'id_picture' => $id_picture));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($output['picture_cam']);
		$req->closeCursor();
	}
}
