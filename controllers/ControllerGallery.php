<?php
require_once('views/View.php');

class ControllerGallery
{
	private $_pictureManager;
	private $_commentManager;
	private $_loveManager;
	private $_view;
	private $_email;
	private $_iduser;
	private $_id_picture;
	private $_limit;
	private $_offset;
	private $_authorPicture;
	private $_deletedPicturePath;

	public function __construct($url)
	{
		if(isset($url) && count($url) == 1)
			header('Location: /Camagru/gallery/1');
		if(isset($url) && count($url) != 2)
			throw new Exception('Page introuvable_CG');
		else
			$this->ft_gallery($url[1]);
	}

	private function ft_gallery($url)
	{
		if (!($url > 0 && $url < 999999))
			header('Location: /Camagru/gallery/1');

		$this->_pictureManager = new PictureManager;
		$this->_commentManager = new CommentManager;
		$this->_loveManager = new LoveManager;

		if (isset($_SESSION['email']))
			$_email = htmlspecialchars($_SESSION['email']);

		if ($_email != '')
		{
			$_iduser = $this->_loveManager->getIduser($_email);
			$_id_picture = htmlspecialchars($_POST['id_picture']);
			if (isset($_POST['DeletePic']) && (htmlspecialchars($_POST['DeletePic']) == 'Delete my picture'))
			{

				$_deletedPicturePath = $this->_pictureManager->getPicPath($_iduser, $_id_picture);
				$this->_pictureManager->deletePic($_iduser, $_id_picture);
				if ($_deletedPicturePath) {
					unlink($_deletedPicturePath);
				}
			}
			if (isset($_POST['Love']) && (htmlspecialchars($_POST['Love']) == 'I Like it !'))
			{
				if ($this->_loveManager->isLoved($_iduser, $_id_picture) == 0)
					$this->_loveManager->addLove($_iduser, $_id_picture);
			}
			if (isset($_POST['Dislove']) && (htmlspecialchars($_POST['Dislove']) == 'Dislike'))
			{
				$this->_loveManager->destroyLove($_iduser, $_id_picture);
			}
			if (isset($_POST['AddComment']) && (htmlspecialchars($_POST['AddComment']) == 'Add my comment !') && isset($_POST['commentary']) && htmlspecialchars($_POST['commentary']) != '' && isset($_POST['id_author']) && htmlspecialchars($_POST['id_author']) != '')
			{
				$this->_commentManager->addCom($_iduser, $_id_picture, htmlspecialchars($_POST['commentary']));
				$_authorPicture = $this->_commentManager->authorPic(htmlspecialchars($_POST['id_author']));
				if ($this->_loveManager->getNotificationStatus($_authorPicture) == 1)
					$this->_commentManager->authorMail($_authorPicture, htmlspecialchars($_POST['commentary']));
			}
		}
		$_offset = ($url - 1) * 5;
		$pictures = $this->_pictureManager->getPictureGallery(5, $_offset);
		$this->_view = new View('Gallery');
		$this->_view->generate(array('pictures' => $pictures, 'page' => $url, 'prev' => ($url - 1), 'next' => ($url + 1), 'iduser' => $_iduser,'username' => htmlspecialchars($_SESSION['username'])));
	}
}
