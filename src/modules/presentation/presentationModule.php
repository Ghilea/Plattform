<?php $presentation = new Presentation($database, $functions); ?>

<!-- about me -->
<div id="about" class="styleSimple">

	<!-- header -->
	<header>
		<div class="col-full">
			<div class="wrap-col">
				<h2>Personlig presentation</h2>
			</div>
		</div>
	</header>

	<div class="col-full">
		<div class="wrap-col">

			<div class="flex-container">

				<!--section -->
				<div class="col-6-12 col-6-12m">
					<div class="wrap-col">

						<!-- Section -->
						<div class="col-full flex-item">
							<div class="wrap-col">
								<div class="circleImg">
									<img src="https://i.imgur.com/lFkZJ3K.jpg" title="Dennis Karlsson" alt="Dennis Karlsson">
								</div>
							</div>
						</div>

						<!-- Section -->
						<div class="col-full">
							<div class="wrap-col">
								<h3>Egenskaper</h3>

								<p class=presentationList>Konstnärlig, <span>plikttrogen</span>, svag för god mat, god kock, <span>tålamod</span>, envis och praktisk.</p>

								<h3>Mina bästa sidor</h3>

								<p class=presentationList>Arbetssam, <span>ärlig</span>, pålitlig, och med ett enormt <span>tålamod</span>.</p>
							</div>
						</div>

					</div>
				</div>
				<!-- end section -->
				<!-- section -->
				<div class="col-6-12 col-6-12m">
					<div class="wrap-col">
	
						<!-- Section - title and text -->
						<div class="col-full">
							<div class="wrap-col">
								<h3>Om mig och min framtid hos Partykungen</h3>
						
								<p class="justify">Jag har i tidig ålder varit intresserad av teknik. Men det var först under en datorkurs som anordnades på kvällstid i
								högstadiet som jag lärde mig om vilka delar som finns i en dator. Vi fick testa att plocka isär och sätta ihop de
								datorer som fanns på skolan. Vid den tiden började jag och några klasskompisar att lära oss programmera i Gamemaker. För
								att motivera oss själva anordnade vi små tävlingar varje månad på vem som kunde skapa det bästa spelet.</p>

								<p class="justify">Mitt intresse för programmering fortsatte att växa och jag började få upp ögonen för att skapa hemsidor. Därför sökte
								jag till ett IT-gymnasium med inriktning webbdesign och databashantering. Men det fanns också ett starkt intresse för
								att hjälpa människor, och efter gymnasiet sökte jag mig därför till läraryrket för att få försöka in både mitt
								IT-intresse och att hjälpa och undervisa andra människor.</p>

								<p class="justify">På fritiden blir det mycket programmering, men även andra kreativa element som att skissa porträtt, baka eller att spela
								piano. Men jag upplever att programmeringen på fritiden står för en alldeles för liten del av mitt liv, även om jag
								försöker hålla mig uppdaterad inom de tekniska ämnena och fortsätter lära mig på egen hand nya språk och frameworks.</p>

								<p class="justify">Jag är nu föräldraledig, men innan dess har jag under åren som varit försökt byta inriktning och hitta något jag
								verkligen vill hålla på med (programmering). Jag har arbetat som lärare i några år nu och har haft ansvar för klasser i
								både Gävle kommun och Älvkarleby kommun. Läraryrket är präglad av kontinuerliga utmaningar som kräver konflikthantering,
								problemlösning, stresstålighet och prioriteringsförmågor.</p>

								<p class="justify">Som systemutvecklare hos Partykungen skulle jag vara den som inte tvekar att hjälpa andra, tar till mig nya saker och
								anpassar mig där det behövs. Med en lugn personlighet speglar jag vidare mitt lugn till andra kollegor, såväl som
								kunder. Även vid stressande situationer försöker jag alltid att tänka positivt som även det kan spegla sig vidare till
								de jag har kontakt med. Det är viktigt för mig att hjälpa till där det behövs på ett pedagogiskt vis, men jag tar även
								ansvar för att fullborda mina egna arbetsuppgifter och därför drar jag mig inte undan utmaningar.</p>
							</div>
						</div>

					</div>
				</div>
				<!-- end section -->
				<!-- section -->
				<div class="content">
					<div class="col-full">
						<div class="wrap-col">

							<h2>titel</h2>

							<?php foreach($presentation->getMyHobby() as $output) { ?>
							
								<!-- Section game -->
								<div class="col-2-12 col-4-12m col-6-12sm flex-item">
									<div class="wrap-col">
										<div class="<?php echo $output["class"]; ?>">
											<img src="<?php echo $output["link"]; ?>" title="<?php echo $output["name"]; ?>" alt="<?php echo $output["name"]; ?>">
										</div>

										<h4><?php echo $output["name"]; ?></h4>
									</div>
								</div>

							<?php } ?>

						</div>
					</div>
				</div>
				<!-- end section -->
			</div>
			<!-- end flex section -->
		</div>
	</div>
	<!-- end section wrap-->
</div>