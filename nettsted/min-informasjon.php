<?php/** * Endre min informasjon *  * Tar imot et brukernavn og passord fra brukeren og kjører * dette gjennom SHA512 kryptering for å så sende et kall til * database serveren for å sjekke om dette er gyldig, hvis dataene * stemmer så før man lov til å logge inn på siden. * * PHP version 5 * * LICENSE: This source file is subject to version 3.01 of the PHP license * that is available through the world-wide-web at the following URI: * http://www.php.net/license/3_01.txt.  If you did not receive a copy of * the PHP License and are unable to obtain it through the web, please * send a note to license@php.net so we can mail you a copy immediately. * * @author		Original Author <andersborglarsen@gmail.com> * @author		Original Author <haavard@ringshaug.net> * @author		Original Author <oyvind.gautestad@gmail.com> * @author		Original Author <linda.fermann@gmail.com> * @copyright 	2013-2018 * @license		http://www.php.net/license/3_01.txt * @link		http://student.hive.no/web10007/1 * */$title = 'Min informasjon - roomEdit';include("../includes/headerNettsted.php");					// Inkluderer headercheckLogin();												// Sjekker om brukeren er logget inn?><h1>Endre informasjon</h1><?php$userRef = $_SESSION['userRef'];							// henter userRef som er lagret i session$username = $_SESSION['username'];							// henter username som er lagret i sessionconnect();													// kobler til databasen$sql= "SELECT Mail FROM User WHERE Ref_User = '$userRef';";								// sql spørring$result = mysql_query($sql) or die ("ikke mulig å hente Bruker fra  fra databasen");	// utfører spørring$row=mysql_fetch_row($result);															// henter resultat fra spørring$mail = $row[0];											// e-post adresse hentet fra databasendisconnect();												// kobler fra databasen	echo "<form method='post' action='' name='changeForm' id='changeForm'>		<fieldset>			<legend> Endre e-post for din bruker</legend>			<p>Brukernavn: $username</p>			<input type='hidden' name='username' id='username' value='$username' /><br />						<label for='endreEmail' class='clearfloat'> E-post </label>			<input type='email' name='email' id='email' value='$mail' autofocus='autofocus' tabindex='1' required /> <br />						<label for='password' class='clearfloat'> Bekreft endring med passord </label>			<input type='password' name='password' id='password' tabindex='2' pattern='.{6,}' required /><br />						<input type='submit' value='Endre' id='endreBruker' name='endreBruker' tabindex='5' />		</fieldset>	</form>";echo "		<form method='post' action='index.php'>		<input type='submit' value='Avbryt' id='back' name='back'>		</form>		";																					//AVBRYTER ENDRING OG DIRIGERER TIL FORSIDENecho "<form method='post' action='nytt-passord.php' name='changePasswordForm' id='changePasswordForm'>		<input type='hidden' name='userRef' id='userRef' value='$userRef' />		<input type='submit' value='Endre passord?' id='changePassword' name='changePassword' />		</form>"; $endreBruker = $_POST["endreBruker"];							// henter submitknapp fra skjemaif($endreBruker){												// sjekker om submitknapp er trykkket på	$email = $_POST["email"];									// henter e-post fra skjema	$username = $_POST["username"];								// henter brukernavn fra skjema	$password = cryptPassword($_POST["password"]);				// henter gammelt passord fra skjema		if (!$username||!$email||!$password) {								// sjekker at alle felter er fylt ut		echo "<script> alert('E-post og gjeldende passord må fylles ut') </script>";	} else {		if (validatorStudent($email,$username,$password)) { 			//validerer input						connect();			$username=mysql_real_escape_string("$username");			// fjerner spesialtegn for å ungå missbruk av SQL databasen			$password=mysql_real_escape_string("$password");			// fjerner spesialtegn for å ungå missbruk av SQL databasen			$sql="SELECT Ref_User,Username,Passord FROM user WHERE Username='$username' AND Passord='$password';";	// sql spøring			$sqlResultat=mysql_query($sql) or die("ikke mulig å hente bruker fra  fra databasen");					// utfører spøring			$row=mysql_num_rows($sqlResultat);													// henter resultat			disconnect();												// kobler fra databasen			if($row==0){												// sjekker om det er treff på brukernavn og passord i databasen				echo "<script> alert('Du har skrevet inn feil passord') </script>";  // hvis ikke returneres feilmelding			} else {													// går videre hvis det er treff								connect();												// kobler til databasen				$sql="UPDATE user SET Mail='$email' WHERE Ref_User='$userRef';";		// sql spøring				$result = mysql_query($sql) or die ("<script> alert('ikke mulig å hente Bruker fra  fra databasen') </script>");	// kjører spørring								disconnect();											// kobler fra databasen						echo "<script> alert('Din e-post er nå endret'); window.location = 'min-informasjon.php';</script>";	// bekreftelse til bruker							}		}			}	} include("../includes/footerNettsted.php"); 								// inkluderer footer på side ?>