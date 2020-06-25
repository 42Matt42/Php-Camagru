<?php session_start();?>
<?php $this->_t = 'Camagru';?>
<?php $this->_pseudo = $username; ?>
<?php $this->_errorMsg = $errorMsg; ?>

<h2 class="subtitle"><p>GALLERY</p></h2>
<p>Page # <?= $page; ?></p>

<p><?php
		if ($page > 0 && $page < 999999)
		{
			?><p>
				<?php
				if ($page > 1)
				{ ?>
				<form action="<?php echo $prev; ?>" method="post">
					<input class="button is-info is-rounded" type="submit" name="PrevPage" value="Previous Page" />
					<input type="hidden" name="page" value=<?= $page ?> />
				</form>
				<?php }
				if ($page < 999998)
				{ ?>
				<form action="<?php echo $next; ?>"  method="post">
					<input class="button is-info is-rounded" type="submit" name="NextPage" value="Next Page" />
					<input type="hidden" name="page" value=<?= $page ?> /><br/>
				</form>
				<?php } ?>
			</p><?php
		}
?></p>
<br><br>
<?php foreach($pictures as $picture): ?>
	<time><?= $picture->picture_date() ?></time><br>
	By <?= $picture->users()->username() ?>
	<p><a href="<?= $picture->picture() ?>">
	<img style="width: 50vw;height: auto;object-fit: cover;margin:2px;padding: 2px;" src="<?= $picture->picture() ?>" /></p></a>
	<p><?php
	if ((htmlspecialchars($_SESSION['checkin']) == 'logged') && (htmlspecialchars($_SESSION['email']) != ('' || NULL)))
	{
		if (isset($_SESSION['email']) && ($iduser == $picture->id_user()))
		{
			?>
			<form action="<?php echo $page; ?>" method="post">
			<p>
				<input class="button is-small" type="submit" name="DeletePic" value="Delete my picture" />
				<input type="hidden" name="id_picture" value=<?= $picture->id_picture() ?> />
			</form><?php
		}
	}?>
	</p>
	<p><?= count ($picture->loves());?><img class="icon" src="../resources/display_love_icon.png">	like<br></p>
	<p><?php
	if ((htmlspecialchars($_SESSION['checkin']) == "logged") && (htmlspecialchars($_SESSION['email']) != ('' || NULL)))
	{
		$glam = 0;

		foreach($picture->loves() as $love)
		{
			$glam = 0;
			if (isset($_SESSION['email']) && ($love->email() == htmlspecialchars($_SESSION['email'])))
			{
				?>
				<form action="<?php echo $page; ?>" method="post">
				<p>
					<input class="button is-info is-light" type="submit" name="Dislove" value="Dislike" /><br/>
					<input type="hidden" name="id_picture" value=<?= $picture->id_picture() ?> /><br/>
				</p>
				</form>
				<?php $glam += 1;
			}
		}
		if (isset($_SESSION['email']) && $glam < 1)
		{
			?>
				<form action="<?php echo $page; ?>" method="post">
				<p>
					<input class="button is-danger is-light" type="submit" name="Love" value="I Like it !"/><br/>
					<input type="hidden" name="id_picture" value=<?= $picture->id_picture() ?> /><br/>
				</p>
				</form>
			<?php
		}
	}
?></p>
<p><?php foreach($picture->comments() as $comment)
	{?>
		<p style="border: 1px black solid;">
			<time><?= $comment->comment_date() ?></time><br>
			<?= $comment->username()?>:<br><br>
			<?= $comment->comment()?><br>
		</p><?php
	}?>
		<p><?php
			if (isset($_SESSION['email']))
			{
				?>
				<form action="<?php echo $page; ?>" method="post">
				<p>
					<textarea name="commentary" rows="5" cols="40"> </textarea>
					<input class="button is-primary is-light" type="submit" name="AddComment" value="Add my comment !" /><br/>
					<input type="hidden" name="id_picture" value=<?= $picture->id_picture() ?> /><br/>
					<input type="hidden" name="id_author" value=<?= $picture->id_user() ?> /><br/>
				</p>
				</form>
				<?php
			}
		?></p>
</p>

</a>
<p style="border: 1px black outset;"></p>
<?php endforeach; ?>
Page <?= $page ;?>
