<?php

abstract class Model
{
	private static $_bdd;

	private static function setBdd()
	{
		try
		{
			self::$_bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'qwerty');
			self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query connexion error');
		}
	}

	// Get the database connexion
	protected function getBdd()
	{
		if(self::$_bdd == null)
			self::setBdd();
		return self::$_bdd;
	}

	protected function getAll($table, $obj)
	{
		$var = [];

		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM '. $table);
			$req->execute();
			while ($data = $req->fetch(PDO::FETCH_ASSOC))
				array_push($var, new $obj($data));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return $var;
		$req->closeCursor();
    }
}
