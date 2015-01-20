<?php 
/**
 * Login
 * Tar imot et brukernavn og passord fra brukeren og kjører
 * dette gjennom SHA512 kryptering for å så sende et kall til
 * database serveren for å sjekke om dette er gyldig, hvis dataene
 * stemmer så får man lov til å logge inn på siden.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @author		Original Author <andersborglarsen@gmail.com>
 * @author		Original Author <haavard@ringshaug.net>
 * @author		Original Author <oyvind.gautestad@gmail.com>
 * @author		Original Author <linda.fermann@gmail.com>
 * @copyright 	2013-2018
 * @license		http://www.php.net/license/3_01.txt
 * @link		http://student.hive.no/web10007/1
 *
 */

if($_SESSION['loggedIn'] == false) {	// SJEKKER OM BRUKEREN ER LOGGET INN, HVIS BRUKEREN IKKE ER LOGGET INN SÅ FÅR MAN LOGIN SKJEMA
?>
<div class="leftContent" >
<form method="post" action="" name="loginForm" id="loginForm">
	<!-- fieldset  -->
		<h3> Logg inn</h3><br />
		
		<label for="username" class="clearfloat"> Brukernavn </label> 
		<input type="text" name="username" id="username" autofocus="autofocus" tabindex="1" required /> <br />
		
		<label for="password" class="clearfloat"> Passord </label> 
		<input type="password" name="password" id="password" tabindex="2" required /> <br />
		
		<input type="submit" value="Login" id="loginButton" name="loginButton" tabindex="3"  />
	<!-- /fieldset-->
</form>
</div>
<?php }

/* 
 * Lytter til når login knappen blir trykker og sjekker om brukernavn og passord stemmer
 * overens med databasen, hvis det gjør det så blir man logget inn */
$loginButton = $_POST['loginButton'];												// LAGER EN LOGIN KNAPP
if ($loginButton) {																	// LYTTER ETTER OM LOGIN KNAPPEN BLIR TRYKKET
	connect();																		// KOBLER TIL DATABASEN
	$username=mysql_real_escape_string($_POST['username']);							// FJERNER SPESIALTEGN SÅ MAN IKKE KAN LURE SQL
	$password=mysql_real_escape_string(cryptPassword($_POST['password']));			// FJERNER SPESIALTEGN SÅ MAN IKKE KAN LURE SQL

// 	$sql="CALL login('$username','$password');";
	$sql="SELECT Ref_User,Username,Passord FROM user WHERE Username='$username' AND Passord='$password';"; // SPØR DATABASEN ETTER REF,BRUKERNAVN OG PASSORD FOR EN BRUKER
	$sqlResultat=mysql_query($sql) or die(mysql_error());							// RESULTATET AV SPØRRINGEN LAGRES I EN VARIABEL
	$count=mysql_num_rows($sqlResultat);						// HENTER UT VARIABLENE SOM ET ARRAY
	disconnect();																	// KOBLER FRA DATABASEN

/* 
 * Hvis man finner et treff på en bruker med det brukernavnet og passordet så returneres
 * verdien 1 og kun verdien 1. 
 */
	if($count==1){
		$rad=mysql_fetch_array($sqlResultat);

		$userRef 	= $rad[0];				// HENTER UT USERREF OG LEGGER DEN I EN VARIABEL
		$user		= $rad[1];				// HENTER UT BRUKERNAVN OG LEGGER DEN I EN VARIABEL

		$_SESSION['loggedIn'] = true;		// SETTER BRUKEREN SOM INNLOGGET I SESSION
		$_SESSION['userRef'] = $userRef;	// LEGGER INN BRUKERREF I SESSION
		$_SESSION['username'] = $user;		// LEGGER INN BRUKERNAVN I SESSION

		echo "Du er nå innlogget";			// FORTELLER BRUKEREN AT HAN/HUN ER INNLOGGET

		/* Hvis man er logget inn så sjekker vi om brukeren er en student
		 * eller ansatt på timeedit og gir dem sin respektive index side, enten vedlikehold(admins)
		 * eller nettsted.
		 */
		if($_SESSION['loggedIn'] == true) {
			connect();															// KOBLER TIL DATABASEN			$sqlSetning="SELECT Admin FROM User WHERE Ref_User='$userRef';";	// SJEKKER I DATABASEN OM EN BRUKERREF ER ADMIN ELLER IKKE.			$sqlResultat=mysql_query($sqlSetning) or die(mysql_error());		// RESULTATET AV SPØRRINGEN LAGRES I EN VARIABEL			$rad=mysql_fetch_array($sqlResultat);								// HENTER UT VARIABLENE SOM ET ARRAY			disconnect();														// KOBLER FRA DATABASEN			$erAdmin = $rad[0];													// SETTER EN VERDI FOR OM BRUKERREF ER ADMIN ELLER IKKE 1/0		
			/* 
			 * Hvis brukeren er en admin så sendes vedkommende til vedlikeholdsbiten
			 */			if($erAdmin == 1) {				header('Location: ../vedlikehold/index.php');					// SENDER EN BRUKER SOM ER ADMIN TIL VEDLIKEHOLD			} else {				header('Location: ../nettsted/index.php');						// SENDER EN BRUKER SOM IKKE ER ADMIN TIL NETTSTEDET			}		}
	} else {
		echo "<script> alert('Du har skrevet inn feil passord eller brukernavn') </script>";						// FEILMELDING VED FEIL BRUKERNAVN OG PASSORD
		}
}
?>