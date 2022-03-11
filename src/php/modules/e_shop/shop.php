<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php");

$shop = new Shop($database, $functions);

$perPage = 6;
$showPaging = $functions->getPaging("product", $perPage);

?>

<!-- section1 -->
<div class="styleShop">
	<div class="content">

		<!-- header -->
		<?php foreach($shop->getShopHeader() as $output){?>
			<header>
				<div class="col-full">
					<div class="wrap-col">
						<h2><?php echo $output["name"]; ?></h2>
						
						<h4><?php echo $output["content"]; ?></h4>
					</div>
				</div>
			</header>
		<?php } ?>
		
		<div class="col-full">
			<div class="wrap-col">
				
			<div class="col-3-12 col-4-12m categoryMenu">
				<div class="wrap-col">
					<div class="showShoping">
						<p class="totalProducts">0</p>
						<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/resources/images/svg/shoping_bag.svg" title="" alt="">
						<p class="totalProductsPrice"><?php echo $shop->productOrder(); ?> kr</p>
					</div>
					<h3>Produkter</h3>
					<ul>
						<a href="/modules/e_shop/shop.php" title="Visa alla produkter">
							<li>
								<p>Visa alla produkter</p>
							</li>
						</a>
						<?php foreach ($shop->productCategory() as $output){ ?>
						<a href="<?php echo $output["link"].$output["id"]; ?>" title="<?php echo $output["title"]; ?>">
							<li>
								<p><?php echo $output["title"]; ?></p>
							</li>
						</a>
						<?php } ?>
					</ul>
				</div>
			</div>

				<div class="col-9-12 col-8-12m flex-container">

					<?php foreach($shop->getProduct(null, $perPage) as $output){ ?>
						
						<!-- information -->
						<div class="col-4-12 col-6-12m">
							<div class="wrap-col productBorder">

								<!-- picture -->				
								<div class="col-full">
									<div class="wrap-col">

										<div class="product">
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/resources/uploads/shop/<?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="<?php echo $output["title"]; ?>">

											<div class="priceTag">
												<div class="priceTagText">
													<?php echo $output["price"]; ?>:-
												</div>
											</div>
											
										</div>

									</div>
								</div>

								<!-- text -->
								<div class="col-full">
									<div class="wrap-col">

										<div class="tit"><?php echo $output["title"]; ?></div>

										<div class="sub">
											<?php echo $functions->ellipsis($output["content"]); ?>
										</div>

										<!-- Section - link -->
										<div class="productLSBtn">
											<a href="#">-</a>
										</div>

										<div class="showProduct productBtn">0 st</div>

										<div class="productRSBtn productLSBtnActive">
											<div  id="<?php echo $output["id"]; ?>" class="addProduct">+</div>
										</div>
		
									</div>
								</div>

							</div>
						</div>

					<?php } ?>

					<!-- paging -->
					<div class="col-full">
						<div class="wrap-col pagingBox"> 
							<?php foreach($showPaging as $output){
								echo $output["backBtn"];
								
								foreach($output["statusBtn"] as $statusBtn){
									echo $statusBtn;
								};

								echo $output["forwardBtn"];
							}; ?>
						</div>
					</div>
					<!-- paging end -->

				</div>

			</div>
		</div>

	</div>
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/footer.php"); ?>