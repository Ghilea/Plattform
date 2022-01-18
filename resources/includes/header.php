<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$config = new Config($database);
$functions = new Functions($database);
$login = new Login($database, $functions);

$company = $config->GetConfig("company")[0];
?>

<!DOCTYPE html>
<html lang="sv">

<head>
	<!-- TITLE -->
	<title><?php echo  $config->GetConfig("pageTitle")[0]["name"]; ?></title>

	<!-- META -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<?php foreach ($config->GetConfig("meta") as $output) {  ?>
		<meta name="<?php echo $output["name"]; ?>" content="<?php echo $output["content"]; ?>">
	<?php } ?>

	
	<!-- ICON -->
	<link rel="shortcut icon" href="<?php echo $config->GetConfig("icon")[0]["image"]; ?>">

	<!-- CSS -->
	<link href="<?php echo $config->GetConfig("font")[0]["link"]; ?>" rel="stylesheet">

	<link href="<?php echo $config->GetConfig("css")[0]["link"]; ?>" rel="stylesheet" type='text/css'>

</head>

<body>
	<!-- Header -->
	<header id="header">
		<a class="logo" href="/index.php" title="<?php echo $company["name"]; ?>">
		
			
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $config->GetConfig("logo")[0]["image"]; ?>" alt="">
				
				<p>
					<?php echo $company["name"]; ?>
					<span><?php echo $company["content"]; ?></span>
				</p>
	
		</a>
		<div class="menu">
			<input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open"/>
			<label class="menu-open-button" for="menu-open">
				<span class="hamburger hamburger-1"></span>
				<span class="hamburger hamburger-2"></span>
				<span class="hamburger hamburger-3"></span>
			</label>
					
			<?php foreach ($config->GetMenu() as $output) {  ?>
							
			<a <?php if(isset($output["id"])){ echo "id='".$output["id"]."' "; } ?> class="menu-item" href="<?php echo $output["link"]; ?>" title="<?php echo $output["name"]; ?>">
				<img class="hamburger-image" src="<?php echo $output["image"]; ?>">
			</a>
			
			<?php }?>
		</div>
				
		<nav>
			<ul>
				<?php foreach ($config->GetMenu() as $output) { ?>
				<li>
					<a 
						<?php if(isset($output["id"])){ ?> 
							id="<?php echo $output["id"]; ?>"
						<?php } ?>

						<?php if(isset($output["class"])){ 
							?> class="<?php echo $output["class"]; ?>"
						<?php } ?> 

						href="<?php echo $output["link"]; ?>" 
						title="<?php echo $output["name"]; ?>">
						
						<?php echo $output["name"]; ?>
					</a>			
				</li>
				<?php } ?>

			</ul>
		</nav>

	</header>