<?php 
/** * Login
 * Tar imot et brukernavn og passord fra brukeren og kjører
 * dette gjennom SHA512 kryptering for å så sende et kall til
 * database serveren for å sjekke om dette er gyldig, hvis dataene
 * stemmer så før man lov til å logge inn på siden. * * PHP version 5 * * LICENSE: This source file is subject to version 3.01 of the PHP license * that is available through the world-wide-web at the following URI: * http://www.php.net/license/3_01.txt.  If you did not receive a copy of * the PHP License and are unable to obtain it through the web, please * send a note to license@php.net so we can mail you a copy immediately. * * @author		Original Author <andersborglarsen@gmail.com> * @author		Original Author <haavard@ringshaug.net> * @author		Original Author <oyvind.gautestad@gmail.com> * @author		Original Author <linda.fermann@gmail.com> * @copyright 	2013-2018 * @license		http://www.php.net/license/3_01.txt * @link		http://student.hive.no/web10007/1 * */


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