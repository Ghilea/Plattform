<?php 
/***************************/
/* include				   */
/***************************/
$inc = [
    "/res/header.php", 
    "/res/class/classMyPage.php",
    "/res/class/classMyValidation.php"
];

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
$classArray = array("myPage", "myCheck");

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
$myPage->setInformation("myProduct");
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
    "[><]product_model" => ["product.product_model_id" => "id"],
    "[><]product_capacity" => ["product.product_capacity_id" => "id"],
    "[><]product_region" => ["product.product_region_id" => "id"],
    "[><]product_region_city" => ["product.product_region_city_id" => "id"],
    "[><]product_region_district" => ["product.product_region_district_id" => "id"],
    "[><]color" => ["forum.color_id" => "id"],
],[
    "forum_topic.id",
    "forum_topic.image",
    "forum_topic.forum_id",
    "forum_topic.forum_topic_id",
    "forum_thread.title",
    "forum_thread.added",
    "forum_thread.description",
    "color",
    "product_category.title(categoryTitle)",
    "product_gear.title(gearTitle)",
    "product_brand.title(brandTitle)",
    "product_region_city.title(regionCityTitle)",
    "product_region_district.title(regionDistrictTitle)",
    "product.showProduct",
    "forum_thread_setup.created"
],[
    "AND" =>["forum_topic.forum_id" => "6", "forum_topic.account_id" => $_SESSION["id"]
    ], 
    "ORDER" => ["forum_thread_setup.created" => "DESC", "added" => "ASC"]]);

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

                <a href="/pages/forum/addTopic.php?id=6">Lägg till cykel</a>

				<?php foreach($query as $output){
					
                    if ($output["showProduct"] == 1){
                        $showData = "Göm";
                        $showImageData = "/res/images/symbol/invisible.png";
                    }else{
                        $showData = "Visa";
                        $showImageData = "/res/images/symbol/visible.png";
                    } ?>
					
                    <!-- section setup -->
                    <div class="col-full">
				        <div class="wrap-col boxForum borderWhiteLeft">
                            <p class="floatLeft">
                                <a href="/pages/forum/editPost.php?id=<?php echo $output["id"]; ?>">
                                    <img class="imageEdit" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/symbol/plus.png"> Ändra
                                </a>
                            </p>
                                
                            <p class="floatLeft">
                                <a href="/pages/forum/deleteTopic.php?id=<?php echo $output["id"]; ?>">
                                    <img class="imageDelete" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/symbol/remove.png"> Ta bort
                                </a>
                            </p>
                            
                            <p class="floatLeft">
                                <span id="<?php echo $output["id"]; ?>" class="mousePointer show" title="<?php echo $output["showProduct"]; ?>">
                                    <img class="imageChange" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $showImageData; ?>"><?php echo $showData; ?>    
                                </span>                                                   
                            </p>
                            
                       </div>
                    </div>

                    <!-- bicycle -->
				    <div class="col-full">
					    <div class="wrap-col boxForum borderWhiteLeft">
							
                            <a href="/pages/product/productView.php?id=<?php echo $output["id"]; ?>">	
                                <!-- Section 1 -->
                                <div class="col-2-12 col-4-12m">
                                    <div class="wrap-col">
                                        <figure class="image">
                                            <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $myImage->thumbnail($myCheck->safe($output["image"]), "../uploads/topic/"); ?>" title="<?php echo $myCheck->safe($output["title"]); ?>" alt="<?php echo $myCheck->safe($output["title"]); ?>">
                                        </figure>
                                    </div>
                                </div>
                                    
                                <!-- Section 2 -->
                                <div class="col-10-12 col-8-12m">
                                    <div class="wrap-col txtLeft forum">

                                        <h2 class="overflowText">
                                            <?php echo $myCheck->safe($output["title"]); ?>
                                        </h2>

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
				            </a>
                            
						</div>
					</div>

				<?php } ?>
				
			</div>
		</div>

	</div>
</div>

<?php require_once(absPath("2"). "/res/footer.php"); ?>

<script defer src="/res/js/showProduct.js"></script>