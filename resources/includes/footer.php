<footer>
<div class="footer">
<div class="container-fluid row">
	<?php if ($config->getFooter() == true) { ?>

		

		<?php foreach ($config->getFooter() as $output) { ?>
			
			<div class="col-lg-3 col-md-12 col-sm-12">
				<h2><?php echo $output["name"] ?></h2>

				<ul>
					<?php foreach ($output["sub"] as $outputSub) { ?>

						<li><a href="<?php echo $outputSub["link"]; ?>"><?php echo $outputSub["name"]; ?></a></li>

					<?php } ?>
					</ul>
			</div>
		<?php } ?>

	
	<?php } else { ?>
		<h2 id="contact">Kontakt</h2>

		<div id="footerContactForm">
			<form action="mailto:tougent@gmail.com" method=”POST” enctype=”text/plain”>
				<input type="text" name="contactName" placeholder="Namn*" pattern="[a-ÖA-Ö]+" required>
				<input type="email" name="contactEmail" placeholder="E-post*" required>
				<input type="text" name="contactSubject" placeholder="Ämne">
				<textarea name="contactMessage" placeholder="Meddelande*" required></textarea>
				<button>Skicka</button>
			</form>
		</div>

	<?php } ?>

	</div>

</div>

<div class="sFooter">
	<div class="container row">

		<div class="socialMedia">
			<?php foreach ($config->GetSocialMedia() as $output) { ?>
				<a href="<?php echo $output["link"]; ?>"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $output["name"]; ?>" alt="<?php echo $output["name"]; ?>"></a>
			<?php } ?>
		</div>

		<div class="copyright">
			<p><?php echo $config->GetConfig("copyright")[0]["content"]; ?></p>
		</div>

	</div>
</div>
</footer>

<?php foreach ($config->GetSettingsBtn() as $outputSetting) {
if($outputSetting["target_id"] === 'settingsBtn'){?>
	<input type="checkbox" id="<?php echo $outputSetting["target_id"]; ?>">

	<label <?php if(isset($outputSetting["class"])){ ?> class="<?php echo $outputSetting["class"]; ?>"<?php } ?> for="<?php echo $outputSetting["target_id"]; ?>"></label>

<?php } } ?>

<!-- overlayMenu -->
<div class="bodyOverlay"></div>

<!-- sidemenu -->
<div id="sideNav" class="sideNav"></div>


<div id="overlayMenu" class="overlayBox">
	<?php foreach ($config->ActivateModule("settings") as $output) { 	
		require_once($_SERVER['DOCUMENT_ROOT'].$output["link"]);
	} ?>
</div>

<!-- show video embed -->
<div class="overlay-video">
	<div class="videoWrapperExt">
		<div class="videoWrapper">
			<iframe id="player" src="" allowfullscreen></iframe>
		</div>
	</div>
</div>

<?php foreach ($config->GetConfig("script") as $output) {
	if (is_null($output["name"]) || $output["name"] == $functions->getLinkName()) { ?>
		<script defer <?php echo $output["content"]; ?> src="<?php echo $output["link"]; ?>"></script>
<?php } } ?>
</body>

</html>