<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$classArray = array("myPage", "myCheck");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* check data		       */
/***************************/
$myCheck->setOnline(true);
$myCheck->setAccess("4", true);

/***************************/
/* information 			   */
/***************************/
$myPage->setInformation("memberRegister"); 
$pageTitle = $myPage->getTitle();
$pageDescription = $myPage->getDescription();

/***************************/
/* array                   */
/***************************/
$data = array("Födelseår", "Namn", "E-post", "Betalning"); ?>

<!-- section 1 -->
<div class="styleLight noBottomPadding">
	<div class="content">

		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">
					<h2><?php echo $pageTitle[0]; ?></h2>
					<p class="max"><?php echo $pageDescription[0]; ?></p>
				</div>
			</div>
		</header>
        
	</div>
</div>

<!-- section 3 -->
<div class="styleLight">
	<div class="content">
		 
		<!-- search -->
		<div class="col-full">
			<div class="wrap-col boxForum borderWhiteLeft">
				<input id="search" type="search" placeholder="sök här"  name="search"/>
			</div>
		</div>
		
		<!-- information -->
		<div class="col-full txtCenter">
			<div class="wrap-col">
                
                <?php foreach ($data as $output){ ?>
                 
                    <div class="col-3-12 col-3-12m removeSM">
                        <div class="wrap-col">
                            <h4 class="overflowText"><?php echo $output; ?></h4>
                        </div>
                    </div>
                
                <?php } ?>

			</div>
		</div>

		<!-- ajax data -->
		<div id="results"></div>

	</div>
</div>
	
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>

<script defer src="/res/js/memberRegister.js"></script>
