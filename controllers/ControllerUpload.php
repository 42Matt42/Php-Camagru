<?php
session_start();
require_once('views/View.php');

class ControllerUpload
{
	private $_view;
	private $_pictureManager;

	public function __construct($url)
	{
		if(isset($url) && count($url) > 1)
			throw new Exception('Page introuvable_CCamera');
		else
			$this->ft_upload();
	}

	private function ft_upload()
	{
		if ((htmlspecialchars($_SESSION['checkin']) == 'logged') && (isset($_POST['alpha'])) && (($_FILES['upfile']['size'] != 0) || (htmlentities($_POST['camera--check']) == 'picture_on_the_way')))
		{
			$this->_pictureManager = new PictureManager;
			$filter = htmlentities($_POST['alpha']);
			$shift_x = 220;
			$shift_y = 110;
			if ($filter == "background_2")
			{
				$shift_x = 0;
				$shift_y = 0;
			}
			// Case 1/2: UPLOAD with a customed picture (without using the camera)
			if (isset($_FILES['upfile']) && $_FILES['upfile']['size'] != 0)
			{
				if (!isset($_FILES['upfile']['error']) || is_array($_FILES['upfile']['error']))
				{
					$_SESSION['msg'] = "An error occured with your uploaded file, please try again";
					header('Location: /Camagru/welcome');
				}
				if ($_FILES["upfile"]["size"] > 99000000)
				{
					$_SESSION['msg'] = "Your file is too large, try  a smaller one";
					header('Location: /Camagru/welcome');
				}
				if ($_FILES["upfile"]["tmp_name"] == 0)
				{
					$_SESSION['msg'] = "Name your file before to upload it";
					header('Location: /Camagru/welcome');
				}
				$extension = strtolower(pathinfo($_FILES['upfile']['name'], PATHINFO_EXTENSION));
				if (in_array($extension, array('png'))){
					$image_name = uniqid() . '.' . $extension;
					$image_path = 'uploads/' . $image_name;
					if (file_exists($image_path))
					{
						$image_name = uniqid() . $image_name;
						$image_path = 'uploads/' . $image_name;
					}
					move_uploaded_file($_FILES['upfile']['tmp_name'], 'uploads/'. $image_name);
					if (!($pic = imagecreatefrompng($image_path)))
					{
						$_SESSION['msg'] = "Your uploaded picture is too small, pick a bigger background";
						header('Location: /Camagru/welcome');
					}
					$alpha = imagecreatefrompng('uploads/' . $filter . '.png');
					$this->_pictureManager->merge_pic_background($pic, $alpha, $shift_x, $shift_y, 0, 0, imagesx($alpha), imagesy($alpha), 100);
					imagepng($pic,  'uploads/'. $image_name);
					imagedestroy($pic);
				}
				else
				{
					$_SESSION['msg'] = "Choose a valid file with a PNG format and try again.";
					header('Location: /Camagru/welcome');
				}
			}
			// Case 2/2: UPLOAD with a live camera picture
			else if (isset($_POST['camera--final']) && (htmlentities($_POST['camera--check']) == "picture_on_the_way"))
			{
				$image_base64 = explode(";base64,", htmlentities($_POST['camera--final']));
				$image_decoded = base64_decode($image_base64[1]);
				file_put_contents('uploads/tmp.png', $image_decoded);
				$pic = imagecreatefrompng('uploads/tmp.png');
				$alpha = imagecreatefrompng('uploads/'.$filter.'.png');
				$this->_pictureManager->merge_pic_background($pic, $alpha, $shift_x, $shift_y, 0, 0, imagesx($alpha), imagesy($alpha), 100);
				$image_name = uniqid() . '.png';
				$image_path = 'uploads/' . $image_name;
				if (file_exists($image_path))
				{
					$image_name = uniqid() . $image_name;
					$image_path = 'uploads/' . $image_name;
				}
				imagepng($pic, $image_path);
				imagedestroy($pic);
			}
			$id_user = $this->_pictureManager->getId_user(htmlspecialchars($_SESSION['username']));
			$this->_pictureManager->addPic($id_user, '../' . $image_path, $image_path);
			$this->_view = new View('Upload');
			$this->_view->generate(array('username' => htmlspecialchars($_SESSION['username'])));
		}
		else
		{
			$_SESSION['msg'] = "Take a picture first or upload a valid file as a background, please try again";
			header('Location: /Camagru/welcome');
		}
	}
}
