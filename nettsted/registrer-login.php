<?php 
/**
 * Tar imot et brukernavn og passord fra brukeren og kjører
 * dette gjennom SHA512 kryptering for å så sende et kall til
 * database serveren for å sjekke om dette er gyldig, hvis dataene
 * stemmer så før man lov til å logge inn på siden.


include("../includes/headerNettsted.php");  // INKLUDERER HEADER TIL NETTSTED
?>

<!--div class="leftContent clearfloat"-->
	<?php
	include("../includes/login.php"); 		// INKLUDERER LOGIN SCRIPT
	?>
<!--/div-->
<!-- <div class="rightContent"> -->
	<?php 
	include("../includes/registrer.php"); 	// INKLUDERER REGISRER SKJEMAET
	?>
<!--  </div>-->

	


<?php 
// if($_SESSION['loggedIn'] == true) {			// SJEKKER OM EN BRUKER ER LOGGET INN
	include("../includes/footerNettsted.php");	// INKLUDERER FOOTER
// } else { 
?>
	</div> <!--end content-->
	</div> <!--end container--> 
</body>
</html>
<?php // }?>