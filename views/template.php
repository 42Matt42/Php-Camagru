<!DOCTYPE html>
<html lang=”en”>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php if (preg_match("#/Camagru/gallery/#", $_SERVER['REQUEST_URI']))
        {?>
            <link rel="stylesheet" type="text/css" href="../views/bulma.css"><?php
        }
        else
        {?>
            <link rel="stylesheet" type="text/css" href="views/bulma.css"><?php
        }?>
		<title><?= $t ?></title>
	</head>
	<body>
	<section class="section">
		<div class="container">
		<header>
		<p class="has-text-grey"><?php
		date_default_timezone_set('Europe/Paris');
		echo (date("H:i:s - d/m/Y",time())) . '<br>' ?></p>

		<p>
		<p class="has-text-link">
		<?php if (isset($pseudo) && $pseudo != '')
		{
			echo 'Connected : ' . $pseudo . '<br></br>';
		}?>
		</p>
		<?php
		if ($_SESSION['checkin'] == "logged")
		{
			if (preg_match("#/Camagru/gallery/#", $_SERVER['REQUEST_URI']))
				echo '<form action="../logout" method="post">';
			else
				echo '<form action="logout" method="post">';?>
			<p>
				<input class="button is-rounded" type="submit" name="logger_off" value="Disconnect"/><br/>
			</p>
			</form><?php
		} ?>
		</p>
		<?php if ($_SERVER['REQUEST_URI'] != "/Camagru/welcome")
		{
			if (preg_match("#/Camagru/gallery/#", $_SERVER['REQUEST_URI']))
				echo '<form action="../welcome" method="post">';
			else
				echo '<form action="welcome" method="post">';?>
			<p>
				<input class="button is-primary is-rounded" type="submit" name="welcome" value="Welcome Page"/><br/>
			</p>
			</form><?php
		}?>
		</p>
		<?php if (!preg_match("#/Camagru/gallery/#", $_SERVER['REQUEST_URI']))
		{?>
			<form action="gallery/1" method="post">
			<p>
				<input class="button is-link is-rounded" type="submit" name="gallery" value="~ Gallery ~"/><br/>
			</p>
			</form><?php
		}?>
		</p>
		<p class="has-background-warning";><?php
		if (isset($_SESSION['msg']) && $_SESSION['msg'] != '')
		{
			echo $_SESSION['msg'] . '<br>';
			$_SESSION['msg'] = '';
			unset($_SESSION['msg']);
		}?>
		</p>
		<p class="has-background-warning";><?php
		if (isset($errorMsg))
		{
			echo 'ERROR: ' . $errorMsg . '<br>';
			$errorMsg = '';
			unset($errorMsg);
		}
		?></p>
		<br>
		<h1 class="title"><a href="<?= URL ?>">Camagru</a></h1>
		</header>
		<br>
			<?= $content ?>
			<br>
		</div>
  	</section>
	<footer class="footer">
  	<div class="content has-text-centered">
    <p>
      <strong>Camagru</strong> made with love ♥️ by msaubin
	</p>
	</div>
	</footer>
	</body>
</html>
