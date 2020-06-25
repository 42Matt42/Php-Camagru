<?php
class CommentManager extends Model
{
	public function getComments()
	{
		return $this->getAll('comment', 'Comment');
	}

	// Add comment
	public function addCom($id_user, $id_picture, $comment)
	{
		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO comment(id_user, id_picture, comment) VALUES(:id_user, :id_picture, :comment)');
			$req->execute(array(
			'id_user' => $id_user,
			'id_picture' => $id_picture,
			'comment' => $comment));
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	// Find the author (email) of a picture based on an id_picture
	public function authorPic($id_author)
	{
		try
		{
			$req = $this->getBdd()->prepare('SELECT email FROM user WHERE id_user = :id_author');
			$req->execute(array('id_author' => $id_author));
			$output = $req->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
		return ($output['email']);
	}

	// Send an email to the author of a picture
	public function authorMail($email, $comment)
	{
		$email = str_replace(array("\n","\r",PHP_EOL),'',$email);
		$subject = 'Camagru - New comment on your picture';
		$from = 'matt.saubin@gmail.com';

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Create email headers
		$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();

		// Compose a simple HTML email message
		$link = "http://localhost:8081/Camagru/gallery/1";
		$custom = "gallery: <a href=\"$link\">Click the link!</a>";
		$message = '<html><body>';
		$message .= '<h1 style="color:#006600;">';
		$message .= 'New comment on your picture !';
		$message .= '</h1>';
		$message .= '<p style="color:#009900;font-size:16px;">';
		$message .= 'Someone added a comment on your picture:' . '<br>' . '<br>' . '"' . $comment . '"' . '<br>' . '<br>';
		$message .= 'Go check it out in the ' . $custom;
		$message .= '</p><p style="color:#006600;font-size:16px;"> Have a nice day ! <br><br> Team Camagru</p>';
		$message .= '</body></html>';

		mail($email, $subject, $message, $headers);
	}
}
