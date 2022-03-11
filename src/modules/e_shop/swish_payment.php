<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php");

$myBBCode = new BBCode();
//$myPaging = new Paging();
$shop = new Shop($database, $functions);
$swish = new SwishPayment($database, $functions);

$createPayment = $swish->createPaymentRequest();
//$getPayment = $swish->getPaymentRequest($createPayment);

?>

<!-- section1 -->
<div class="styleShop">
	<div class="content">

		

	</div>
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/footer.php"); ?>