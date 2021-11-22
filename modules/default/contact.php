<?php
/***************************/
/* include				   */
/***************************/
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');

/***************************/
/* new class               */
/***************************/
$myCheck = new Check();

?>

<!-- section 1 -->
<div class="styleLight">
	<div class="content">

        <!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">
					<h2>Kontakt</h2>
					<p class="txtCenter">Olika sätt att komma i kontakt med oss</p>
				</div>
			</div>
		</header>
		
        <!-- information -->
		<div class="col-full">
			<div class="wrap-col">

			    <div class="col-3-12">
                    <div class="wrap-col">
                        <h3>Telefon</h3>
                        
                        <h4 class="txtLeft">Privatpersoner</h4>
                        <p class="txtLeft">Måndag-Fredag: 10-14.</p>
                        <p class="txtLeft">0220 - 13 53 22</p>
                        
                        <h4 class="txtLeft">Företag / Förening</h4>
                        <p class="txtLeft">Måndag-Fredag: 8-16.</p>
                        <p class="txtLeft">0220 - 13 53 25</p>
                        
                    </div>
                </div>
                
                <div class="col-5-12">
                    <div class="wrap-col">
                        <h3>E-post</h3>
                        
                        <h4 class="txtLeft">Allmäna frågor</h4>
                        <p class="txtLeft">kontakt@programmeringsskolan.se</p>
                        
                        <h4 class="txtLeft">Tekniska frågor</h4>
                        <p class="txtLeft">support@programmeringsskolan.se</p>
                        
                        <h4 class="txtLeft">Personal</h4>
                        <p class="txtLeft">förnamn.efternamn@programmeringsskolan.se</p>
                        
                    </div>
                </div>
                
                <div class="col-4-12">
                    <div class="wrap-col">
                        <h3>Besök</h3>

                        <h4 class="txtLeft">Öppettider</h4>
                        <p class="txtLeft">Måndag-Fredag: 8-15.</p>
                        <p class="txtLeft">Lördag-Söndag samt helgdagar: 11-15.</p>
                        <p class="txtLeft">Avikande dagar: Stängt</p>
                        
                    </div>
                </div>
			
			</div>
		</div>
	
	</div>
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.php"); ?>