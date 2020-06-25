<?php
class LoveManager extends Model
{
	public function getLoves()
	{
		return $this->getAll('love', 'Love');
	}

	// check if the user (by id_user) loves (1) that picture (by id_picture) or not (0)
	public function isLoved($id_user, $id_picture)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT SUM(status) FROM love WHERE id_user = :id_user AND id_picture = :id_picture');
			$req->execute(array(
				'id_user' => $id_user,
				'id_picture' => $id_picture));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($output["SUM(status)"]);
		$req->closeCursor();
	}

	//  Get id_user based on email
	public function getIduser($email)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT id_user FROM user WHERE email = ?');
			$req->execute(array($email));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return ($output['id_user']);
		$req->closeCursor();
	}

	//  Get id_user based on email
	public function getNotificationStatus($email)
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

	// Add love
	public function addLove($id_user, $id_picture)
	{
		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO love(id_user, id_picture, status) VALUES(:id_user, :id_picture, :status)');
			$req->execute(array(
    		'id_user' => $id_user,
			'id_picture' => $id_picture,
			'status' => 1));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	// Delete love entry
	public function destroyLove($id_user, $id_picture)
	{
		try
		{
			$req = $this->getBdd()->prepare('DELETE FROM love WHERE id_user = :id_user AND id_picture = :id_picture');
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
}
