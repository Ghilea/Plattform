<?php 
/***************************/
/* include				   */
/***************************/
$inc = array("/res/header.php", "/res/class/classMyPage.php", "/res/class/classMyValidation.php", "/res/class/classMyDate.php");

foreach ($inc as $value) {
    require_once(absPath("2"). $value);
}

/***************************/
/* control absolute path   */
/***************************/
function absPath($value){
    return realpath(dirname(__dir__, $value));
}

/***************************/
/* new class               */
/***************************/
$classArray = array("myPage", "myDate", "myCheck");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* check			       */
/***************************/
$myCheck->setOnline(true);

/***************************/
/* information 			   */
/***************************/
$myPage->setInformation("myReservation");
$pageTitle = $myPage->getTitle();
$pageDescription = $myPage->getDescription();

/***************************/
/* databas query           */
/***************************/
$query = $database->select("forum_topic",[
"[><]forum" => ["forum_topic.forum_id" => "id"],
"[><]forum_thread" => ["forum_thread_id" => "id"],
"[><]forum_thread_setup" => ["forum_thread.forum_thread_setup_id" => "id"],
"[><]product" => ["forum_topic.id" => "forum_topic_id"],
"[><]product_category" => ["product.product_category_id" => "id"],
"[><]product_brand" => ["product.product_brand_id" => "id"],
"[><]product_gear" => ["product.product_gear_id" => "id"],
"[><]product_reservation" => ["product.forum_topic_id" => "product_id"],
"[><]product_region" => ["product.product_region_id" => "id"],
"[><]product_region_city" => ["product.product_region_city_id" => "id"],
"[><]product_region_district" => ["product.product_region_district_id" => "id"]
],[
"forum_topic.id",
"forum_topic.image",
"product_reservation.id(reservationID)",
"forum_topic.forum_id",
"forum_thread.title",
"product_category.title(categoryTitle)",
"product_gear.title(gearTitle)",
"product_brand.title(brandTitle)",
"product_region_city.title(regionCityTitle)",
"product_region_district.title(regionDistrictTitle)",
"product_reservation.added"
],[
"AND" =>
[
"forum_topic.forum_id" => "6", 
"product_reservation.added[>=]" => date("Y-m-d"), 
"product_reservation.account_id" => $_SESSION["id"]
], 
"ORDER" => ["product_reservation.added" => "ASC"]]);

//var_dump($database->error()); ?>

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
		
		<!-- information -->
		<div class="col-full">
			<div class="wrap-col">
				
				<?php foreach($query as $output){ ?>
						
                    <!-- section setup -->
                    <div class="col-full">
				        <div class="wrap-col boxForum borderWhiteLeft">
                            <p class="floatLeft">
                                <a href="/pages/account/editMyReservation.php?id=<?php echo $output["reservationID"]?>&amp;product_id=<?php echo $output["id"]?>">
                                    <img src="/res/images/symbol/plus.png"> Ändra
                                </a>
                            </p>
                                
                            <p class="floatLeft">
                                <a href="/pages/account/deleteMyReservation.php?id=<?php echo $output["reservationID"]; ?>">
                                    <img src="/res/images/symbol/plus.png"> Ta bort
                                </a>
                            </p>

                        </div>
                    </div>	
                        
                    <!-- bicycle -->
				    <div class="col-full">
						<div class="wrap-col boxForum borderWhiteLeft">
								
							<!-- Section 1 -->
							<div class="col-2-12 col-4-12m">
								<div class="wrap-col">

									<figure class="image">
                                        <a href="/pages/product/productView.php?id=<?php echo $output["id"]; ?>">
                                            <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $myCheck->safe($output["title"]); ?>" alt="<?php echo $myCheck->safe($output["title"]); ?>">
                                        </a>
                                   </figure>

							    </div>
							</div>
								
							<!-- Section 2 -->
							<div class="col-10-12 col-8-12m">
								<div class="wrap-col txtLeft forum">

									<h2>
										<a href="/pages/product/productView.php?id=<?php echo $output["id"]; ?>"><?php echo $myCheck->safe($output["title"]); ?></a>
									</h2>
       
									<p>
                                        Bokad: 
                                        <?php $myDate->setReDate('%A %d %B %Y', $output["added"]); ?>
                                        <?php echo $myDate->getReDate(); ?>
                                    </p>
								    
                                    <p>
                                        Plats: <?php echo $myCheck->safe($output["regionCityTitle"]); ?> kommun vid området <?php echo $myCheck->safe($output["regionDistrictTitle"]); ?>
                                    </p>
                                    
								    <p>
								        <?php echo $output["categoryTitle"]; ?>
										<span>&middot;</span> <?php echo $myCheck->safe($output["gearTitle"]); ?>
										<span>&middot;</span> <?php echo $myCheck->safe($output["brandTitle"]); ?>
									</p>
			
								</div>
							</div>
				
						</div>
					</div>
				
				<?php } ?>
  
			</div>
		</div>

	</div>
</div>

<?php require_once(absPath("2"). "/res/footer.php"); ?>