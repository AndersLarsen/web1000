<?php
/**
 *
 * Denne filen blir inkludert ved behov.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URL:
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



/* Funksjon som kobler opp mot databasen */
function connect() {
	$host="localhost";												// ADRESSE
	$user="WEB10007";												// BRUKERNAVN
	$password="Sjakkbord10007";										// PASSORD
	$database="web10007";											// DATABASENAVN

	mysql_connect ($host,$user,$password) or die(mysql_error()); 	// KOBLER TIL DATABASEN,RETURNERER ERROR VED FEIL
	mysql_selectdb ($database) or die(mysql_error());				// VELGER DATABASE, RETURNERER ERROR VED FEIL
}

/* Funksjon som kobler fra databasen */
function disconnect() {
	mysql_close();
}

/* Funksjon for login session */
function sec_session_start() {
	$session_name = 'sec_session_id'; 								// SETTER ET BESTEMT SESSION NAVN
	$secure = false; 											 	// SETTES SOM TRUE HVIS VI BRUKER HTTPS
	$httponly = true; 												// STOPPER JAVASCRIPT FRA Å KUNNE FÅ TILGANG TIL SESSION ID
	// 	ini_set('session.use_only_cookies', 1); 						// FORCER SESSION TIL Å BARE BRUKE EN COOKIE


	$cookieParams = session_get_cookie_params(); 					// HENTER NÅVÆRENDE COOKIE PARAGRAM
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
	session_name($session_name); 									// SETTER SESSION NAVNET TIL Å VÆRE DET SOM BLE BESTEMT OVER

	session_start(); 												// STARTER PHP SESSION
	// 	session_regenerate_id(true); 									// REGENERERER SESSIONEN OG SLETTER DEN GAMLE

}

/*
 * Funksjon for å sjekke om en bruker er logget inn, hvis brukeren ikke er
* logget inn så blir de redirecta til ny side for å logge inn eller registrere seg.
* Denne funksjonen gjelder for nettstedet
*/

function checkLogin() {
	if($_SESSION['loggedIn'] == false) {
		header('Location: ../nettsted/registrer-login.php');
	}
}

function checkAdmin() {
	if($_SESSION['loggedIn'] == true) {
		$userRef = $_SESSION['userRef'];
		connect();															// KOBLER TIL DATABASEN
		$sqlSetning="SELECT Admin FROM User WHERE Ref_User='$userRef';";	// SJEKKER I DATABASEN OM EN BRUKERREF ER ADMIN ELLER IKKE.
		$sqlResultat=mysql_query($sqlSetning) or die(mysql_error());		// RESULTATET AV SPØRRINGEN LAGRES I EN VARIABEL
		$rad=mysql_fetch_array($sqlResultat);								// HENTER UT VARIABLENE SOM ET ARRAY
		disconnect();														// KOBLER FRA DATABASEN
		$erAdmin = $rad[0];													// SETTER EN VERDI FOR OM BRUKERREF ER ADMIN ELLER IKKE 1/0

		/*
		 * Hvis brukeren er en admin så sendes vedkommende til vedlikeholdsbiten
		*/
		if($erAdmin != 1) {
			header('Location: ../nettsted/index.php');									// SENDER EN BRUKER SOM IKKE ER ADMIN TIL NETTSTEDET
		}
	}

/* Krypterer passordet med SHA512 salt */
function cryptPassword($password){
	$salt='2rounds=1234web1000';
	$password=crypt($password,$salt); 								// KRYPTERER PASSORDET OG BRUKER SALT VARIABEL FOR SHA512
	return $password;
}

/*
 * Lager en unik ref for booking
* Eks; AAA-1111
*/
function createBookingRef() {
	$unique_ref_length = 8;									// Definerer lengden på hvor lang den unike nøkkelen skal være
	$unique_ref_found = false;								// True/False variabel som lar oss få vite om vi har funnet en unik nøkkel eller ikke
	$possible_chars = "BCDFGHJKMNPQRSTVWXYZ"; 				// Definer mulige chars som skal brukes, her unngår vi å bruke O fordi den er ganske lik med null.
	$possible_ints = "123456789";							// Definer mulige ints som skal brukes, her unngår vi å bruke null fordi den er ganske lik med O.

	while (!$unique_ref_found) {							// Fortsetter å generere nye nøkler til vi finner en unik en som ikke er i bruk
		$unique_ref = "";									// Starter med en blank nøkkel
		$i = 0;												// Teller for å holde kontroll på hvor mange chars vi har lagt til

		while ($i < $unique_ref_length) {					// Legger til randomchars fra $possible_chars til $unique_ref inntil $unique_ref_length er tilfredsstilt

			// Velger random chars fra $possible_chars strengen
			$char = substr($possible_chars, mt_rand(0, strlen($possible_chars)-1), 1);
			$int = substr($possible_ints, mt_rand(0, strlen($possible_ints)-1), 1);
			if($i < 3)
				$unique_ref .= $char;
			if($i > 3)
				$unique_ref .= $int;
			if($i == 3)
				$unique_ref .= "-";


			$i++;
		}

		// Den unike nøkkelen er generert.
		// Sjekker om den eksisterer i databasen eller ikke.
		connect();

		$query = "SELECT Ref_Booking FROM booking WHERE Ref_Booking='$unique_ref';";
		$result = mysql_query($query) or die(mysql_error().' '.$query);
		$count = mysql_num_rows($result);


		if ($count == 0) {
			$unique_ref_found = true;							// Den unike nøkkelen er funnet, setter $unique_ref_found til true og kommer meg ut av løkken

		}
		disconnect();
	}
	return $unique_ref;
}

/*
 * Lager en unik ref for bruker
* Eks; 111-AAAA
*/
function createUserRef() {
	$unique_ref_length = 8;									// Definerer lengden på hvor lang den unike nøkkelen skal være
	$unique_ref_found = false;								// True/False variabel som lar oss få vite om vi har funnet en unik nøkkel eller ikke
	$possible_chars = "BCDFGHJKMNPQRSTVWXYZ"; 				// Definer mulige chars som skal brukes, her unngår vi å bruke O fordi den er ganske lik med null.
	$possible_ints = "123456789";							// Definer mulige ints som skal brukes, her unngår vi å bruke null fordi den er ganske lik med O.

	while (!$unique_ref_found) {							// Fortsetter å generere nye nøkler til vi finner en unik en som ikke er i bruk
		$unique_ref = "";									// Starter med en blank nøkkel
		$i = 0;												// Teller for å holde kontroll på hvor mange chars vi har lagt til

		while ($i < $unique_ref_length) {					// Legger til randomchars fra $possible_chars til $unique_ref inntil $unique_ref_length er tilfredsstilt

			// Velger random chars fra $possible_chars strengen
			$char = substr($possible_chars, mt_rand(0, strlen($possible_chars)-1), 1);
			$int = substr($possible_ints, mt_rand(0, strlen($possible_ints)-1), 1);
			if($i < 3)
				$unique_ref .= $int;
			if($i > 3)
				$unique_ref .= $char;
			if($i == 3)
				$unique_ref .= "-";


			$i++;
		}

		// Den unike nøkkelen er generert.
		// Sjekker om den eksisterer i databasen eller ikke.
		connect();

		$query = "SELECT Ref_User FROM user WHERE Ref_User='$unique_ref';";
		$result = mysql_query($query) or die(mysql_error().' '.$query);
		$count = mysql_num_rows($result);


		if ($count == 0) {
			$unique_ref_found = true;							// Den unike nøkkelen er funnet, setter $unique_ref_found til true og kommer meg ut av løkken

		}
		disconnect();
	}
	return $unique_ref;
}

/********************Registrering Av Bruker *******************************/

function addNewUser() {
	$reg=$_POST[reg];

	if ($reg) {														//følgende utføres dersom submit er trykket
		$username 		=	$_POST["username"];						//henter verdi fra skjema
		$email 			=	$_POST["email"];						//henter verdi fra skjema
		$password		=	cryptPassword($_POST["password"]);		//henter verdi fra skjema
		$passwordRaw	= 	$_POST["password"];						//henter verdi fra skjema
		$position_Id	=	$_POST["position_Id"];
		$admin			=	$_POST["admin"];
		$Ref_User		=	createUserRef();						//lager unik referansenummer til bruker

		if (!$username||!$email||!$password) {						//sjekker at alle felter er fylt ut
			print ("<script> alert('Alle feltene må fylles ut') </script>");
		} else {
			if (validatorStudent($email,$username,$passwordRaw)) {		//validerer input
				connect();											//kobler til databasen
				$sqlSetning="SELECT username FROM user WHERE username='$username';";	//sjekker om brukernavn finnes fra før
				$sqlResultat=mysql_query($sqlSetning);
				$antallRader=mysql_num_rows($sqlResultat);
				disconnect();

				if($antallRader !==0){								//bruker må velge annet brukernavn dersom det finnes fra før
					echo "<script> alert('Brukernavn $username finnes fra før. Vennligst finn et annet.') </script>";		// returnerer feilmelding hvis finnes
				} else {
					connect();										//kaller på prosedyre regBruker, og registrerer følgende felter i databasen
					$sqlSetning= "Call regBruker(
					'$username',
					'$email',
					'$password',
					'$position_Id',
					'$admin',
					'$Ref_User'
					);" ;

					mysql_query($sqlSetning) or die ("<script> alert('Noe gikk galt med registreringen') </script>");
					disconnect();

					print ("<script> alert('Registreringen var vellykket. Bruker med brukernavn '$username' er nå registrert.') </script>");
					echo ("
				}
			}
		}
	}
}

function addNewStudent() {
		$position_Id	=	'2';									//settes til '2' som er id for student


/************************ Listeboks romtype ****************************************/

function roomTypeList(){
	/* Hensikt
	* Returnerer
	* 		Hvis funsjonen returnerer

	$sql = "SELECT Distinct Roomtype FROM roomtypes;";											// sql setning
	$result = mysql_query($sql) or die ("ikke mulig å hente romtype fra databasen");	// kjører sql spørring
	$numRows = mysql_num_rows($result);													// henter resultat

	// laer dynamisk listeboks basert på rom funnet i databasen
	echo ("<select name='roomType' id='roomType'>");
	echo ("<option value=''>Alle</option>");

	for($t=1; $t<=$numRows; $t++){
		$row=mysql_fetch_array($result);
		echo "<option value='$row[0]'> $row[0] </option> ";

	}

	echo "</select>";
}

/************************ Listeboks brukernavn ****************************************/

function usernameList(){
	connect();
	$sql = "SELECT Username FROM User
			ORDER BY Username ASC;";
	$result = mysql_query($sql) or die ("ikke mulig å hente brukernavn fra databasen");
	$numRows = mysql_num_rows($result);
	disconnect();

	echo("<label for='username' class='clearfloat'>Bruker bestillingen er registrert på</label>");
	echo ("<select name='username' id='username'>");
	echo ("<option value='$username'>$username</option>");

	for($t=1; $t<=$numRows; $t++){
		$row=mysql_fetch_array($result);
		echo "<option value='$row[0]'> $row[0] </option> ";
	}
	echo "</select>";
}




/****************************************************************************************************
 Validering av brukerinput vedrørende registrering av en bruker
*****************************************************************************************************/


/* Validering av input ny bruker */

function validateUsername($username) {						//VALIDERER BRUKERNAVN
	/*	Hensikt
	 Funksjonen sjekker om username er korrekt fylt ut
	Parametre
	username = username som skal sjekkes
	Funksjonsverdi
	Funksjonen returnerer true hvis korrekt fylt ut
	Funksjonen returnerer false ellers
	*/
	if(preg_match("/^[A-Za-z0-9]{3,30}$/",$username)) {
		return true;
	} else {
		return false;
	}
}

function validateEmail($email) {					//VALIDERER EMAIL (HAR HJELP OGS√Ö GJENNOM HTML5 STANDAREN
	/*	Hensikt
	 Funksjonen sjekker email er korrekt fylt ut
	Parametre
	email = email som skal sjekkes
	Funksjonsverdi
	Funksjonen returnerer true hvis korrekt fylt ut
	Funksjonen returnerer false ellers
	*/
	if(filter_var($email,FILTER_VALIDATE_EMAIL)) {
		return true;
	} else {
		return false;
	}
}

function validatePassword($password) {					//VALIDERER AT PASSORD ER FYLT INN
	/*	Hensikt
	 Funksjonen sjekker password er korrekt fylt ut
	Parametre
	password = password som skal sjekkes
	Funksjonsverdi
	Funksjonen returnerer true hvis korrekt fylt ut
	Funksjonen returnerer false ellers
	*/
	if	 (strlen($password)>5) {
	
}

/* I mellom her kommer det kode for å validere ekstra felt når admi
 * nistrator legger inn ansatte, eventuelt
 andre administratorer eller studenter)*/


/* Validering av registrering av ny student */
function validatorStudent($email,$username,$password) {
	/* 	Hensikt
	 Funksjonen sjekker om feltene i registrering er korrekt fylt ut
	Parametre
	username = username som skal sjekkes
	email = email som skal sjekkes
	password = password som skal sjekkes
	Funksjonsverdi
	Funksjonen returnerer true hvis feltene er korrekt fylt ut
	Funksjonen returnerer false ellers
	*/
	$legalEmail = validateEmail($email);
	$legalUsername = validateUsername($username);
	$legalPassword = validatePassword($password);
	
	if(!$legalEmail) {
		echo ("<script>alert('E-post er ikke korrekt fylt ut ')</script>");
	}
	if(!$legalUsername){
		echo ("<script>alert('Brukernavn er ikke korrekt fylt ut ')</script>");
	}
	if(!$legalPassword){
		echo ("<script>alert('Passord er ikke korrekt fylt ut ')</script>");
	}

	

	if ($legalEmail && $legalUsername && $legalPassword) {
		return true;
	} else {
		return false;
	}
}



/* Under her kommer en ny funksjon hvor alle elementer for validering av administrators
 registrering av bruker samles i en funksjon*/

/* Validering av endring av bruker i vedlikehold */


/* Slutt av kode vedrørende validering av brukerinput vedrørende registrering av en bruker*/





/************************Validering rom*********************************/

function validateRoomName($room_name) {

	/* Hensikt
	 * 		Funksjonen validerer at romnavn er fylt ut korrekt.
	* Parametre
	* 		$room_name: romnavnet som skal valideres
	* Returnerer
	* 		"true" eller "false"
	*/
	


		$pattern='/^[A-Z][1-9][\-][0-9][0-9][0-9A-Z]+/';	// mønster som brukes av funksjonen preg_match for å validere input
	
		if(preg_match($pattern, $room_name)){		// sjekker om parameter validerer mot mønster
			return true;							// returnerer "true" hvis det stemmer
		}
		else{
			echo "<script>alert('Romnavn er ikke korrekt utfylt. Skal ha format [Blokk][Etasje]-[Romnummer]')</script>";		// returnerer feilmelding hvis det ikke stemmer
		}
	}

//}

/*End function validateRoomName*/


function validateRoomType($room_type) {
	/* Hensikt
	 * 		Funksjonen validerer at romnavn er fylt ut korrekt
	* Parametre
	* 		$room_type: romtypenavn som skal valideres
	* Returnerer
	* 		"true" eller "false"
	*/

	$pattern='/^[A-ZÆØÅ][a-z æøå]+$/u';			// mønster som brukes av funksjonen preg_match for å validere input

	if(preg_match($pattern, $room_type)){		// sjekker om parameter validerer mot mønster
		return true;							// returnerer "true" hvis det stemmer
	}
	else{
		echo "<script>alert('Romtype er ikke korrekt utfylt. Skal starte med stor forbokstav og kun bestå av bokstaver')</script>";	// returnerer feilmelding hvis det ikke stemmer
	}

}

/*End function validateRoomType*/


// 	function validateRoom($room_name,$room_type) {
// 		/* Hensikt
// 		 * 		Funksjonen validerer at romnavn og romtype er fylt ut korrekt
// 		* Parametre
// 		* 		$room_name: romnavnet som skal valideres
// 		* 		$room_type: romtype som skal valideres
// 		* Returnerer
// 		* 		"true" eller "false", samt viser feilmelding hvis validering resulteter i "false" på parametrene
// 		*/
// 		$legalRoomName = validateRoomName($room_name);		// starter funksjon for validering av romnavn
// 		$legalRoomType = validateRoomType($room_type);		// starter funksjon for validering av romtype

// 		if(!$legalRoomName){								// sjekker resultat av validering av romnavn og viser feilmelding hvis "false"
// 			echo 'Romnavn er ikke korrekt utfylt. Skal ha format [Blokk][Etajse]-[Romnummer] <br>';
// 		}
// 		if(!$legalRoomType){								// sjekker resultat av validering av romtype og viser feilmelding hvis "false"
// 			echo 'Romtype er ikke korrekt utfylt. Skal starte med stor forbokstav og kun bestå av bokstaver <br>';
// 		}
// 		if ($legalRoomName && $legalRoomType){				// sjekker resultat av validering av både romnavn og romtype
// 			return true;
// 		}
// 		else {
// 			return false;
// 		}

// 	}

/*End function validateRoom*/



/************************Presentere spørreresultat i html-tabell****************************************/


/*Funksjon som oppretter tabell og tar imot et array av overskrifter som parameter.
 For innhold i tabellen brukes funksjonen "htmlTableBody" */
function htmlTableHeader($t) {						//tar i mot array som parameter
	echo ('<table>');										//starter tabell
	echo ('<thead>');									//starter tabellheader
	echo ('<tr>');									//starter rad
	foreach ($t as $key=>$value) {		//looper gjennom arrayet og setter overskrift i tabellheader
		echo ('<th>'.$value.'</th>');
	}
	echo ('</tr>');								//lukker rad
	echo ('</thead>');								//lukker tabellheader
}

/* Funksjon som tar imot spørreresultat som parameter og presenterer det i tabellformat. Lukker også tabellen */
function htmlTableBody($r) {							//tar imot spørreresultat som parameter
	echo ('<tbody>');										//starter tabellbody
	$row = mysql_fetch_assoc($r);						//henter ut en rad fra spørreresultatet
	while ($row) {											//utføres en gang for hver rad i spørreresultatet
		echo ('<tr>');										//starter rad
		foreach ($row as $key=>$value) {				//nøstet løkke. Utføres en gang for hver verdi i raden
			echo ('<td>'.$value.'</td>');				//verdien skrives ut i tabellcelle
		}
		echo ('</tr>');									//lukker rad
		$row = mysql_fetch_assoc($r);					//henter ut rad fra spørreresultatet inne i while-løkken
	}
	echo ('</tbody>');									//lukker tabellbody
	echo ('</table>');										//lukker tabell
}

/* Funksjon som viser alle bestillinger til en bruker. Lukker også tabellen
 function htmlTableBodyMyBookings($r) {
echo ('<tbody>');										//starter tabellbody
$row = mysql_fetch_assoc($r);						//henter ut en rad fra spørreresultatet
while ($row) {											//utføres en gang for hver rad i spørreresultatet
echo ('<tr>');										//starter rad
foreach ($row as $key=>$value) {				//nøstet løkke. Utføres en gang for hver verdi i raden
echo ('<td>'.$value.'</td>');				//verdien skrives ut i tabellcelle
}
echo ('<td><input type="radio" name="editBooking" value='.$row[5].'></td>');
echo ('<td><input type="checkbox" name="deleteBooking[]" value='.$row[5].'></td>');
echo ('</tr>');									//lukker rad
$row = mysql_fetch_assoc($r);					//henter ut rad fra spørreresultatet inne i while-løkken
}
echo ('</tbody>');									//lukker tabellbody
echo ('</table>');										//lukker tabell
}*/

function getUserRef($username) {
	connect();
	$sql="SELECT Ref_User FROM User WHERE username='$username';";
	$result=mysql_query($sql) or die ("Ikke mulig å hente bruker fra databasen");
	$numRows=mysql_num_rows($result);
	$rad=mysql_fetch_array($result);
	disconnect();

	return $rad[0];
}

/*
 * getRoomId()
*
* Denne funksjonen tar inn et angitt romnavn og sjekker databasen for å finne hva
* slags id et rom har og returnerer det den finner.
*
* @param	string	$name	Navnet på et bestemt rom.
*
* @return	string	id	Id'en til rommet.
*
*/
function getRoomId($name) {
	connect();
	$sql="Select RoomId FROM room WHERE Name='$name';";
	$result=mysql_query($sql) or die ("ikke mulig å hente rom-data fra databasen");
	$numRows=mysql_num_rows($result);
	$rad=mysql_fetch_array($result);
	disconnect();

	return $rad[0];
}


function checkUserLeftHours($userRef,$startTimeClean,$endTimeClean,$changeTime){
	/* Hensikt
	* 		- Sjekker hvor mange timer brukeren har lov til å reservere
	* 		opp mot antall timer som brukeren ønsker å reservere
	* 		$startTimeClean = starttidspunkt for reservasjon som brukeren ønsker å utføre
	* 		$endTimeClean = sluttidspunkt for reservasjon som brukeren ønsker å utføre
	connect();														// kobler til databasen
	if ($changeTime){
		$minutesBooked = $minutesBooked - $changeTime;
	}
		
	$startTimeSplit = explode(":",$startTimeClean);					// henter parameter for starttidspunkt for ønsket reservasjon og skiller ut timer og minutter i vaiabler
	$sH = $startTimeSplit[0];
	$sM = $startTimeSplit[1];

	$endTimeSplit = explode(":",$endTimeClean);						// henter parameter for slutttidspunkt for ønsket reservasjon og skiller ut timer og minutter i vaiabler
	$eH = $endTimeSplit[0];
	$eM = $endTimeSplit[1];

	$minutesRequested = ($eH-$sH) * 60 + $eM - $sM;					// regner om fra timer til minutter og summerer antall minutter totalt for ønsket reservasjon

	// sql spørring: henter ut hvor mange timer innlogget bruker har lov til å registrere samt om bruker er administator
	$sql="
	SELECT Max_Hours, Admin
	FROM setup JOIN position JOIN user
	WHERE setup.Position_Id = position.PositionId
	AND position.PositionId = user.Position_Id
	AND Ref_User = '$userRef';";
	$result=mysql_query($sql) or die ("ikke mulig å hente gjenstående timer på bruker");	// spørring utføres
	$row2=mysql_fetch_row($result);									// henter resultat
	$maxHoursUser = $row2[0];										// tilordner resultat til variabler
	$isAdmin = $row2[1];

	disconnect();													// frakobling fra database

	if(! $isAdmin ){												// sjekker om innlogget bruker er administrator
		$maxMinutesUser= $maxHoursUser * 60;						// hvis "false" utføres beregning av timer
	} else {
		$maxMinutesUser = 999999;									// hvis true settes lovlige minutter til et høyt tall
	}


	if( ( $minutesBooked + $minutesRequested ) > $maxMinutesUser ) {	// sjekekr om antall minutter i databasen og antall minutter for booking er større en antall lovlige minutter
		return true;													// hvis "true" returneres "true"
	} else {
		return false;													// hvis "false" returneres "false"
	}

}


function showUserLeftHours($userRef){
	/* Hensikt
	if($_SESSION['loggedIn'] == true){

		connect();														// kobler til databasen
		// sql spørring: henter ut antall timer og minutter for aktive bestillinger for innlogget bruker
		$sql="
		$minutesBooked = (array_sum($eHt)-array_sum($sHt)) * 60 + array_sum($eMt) - array_sum($sMt);	// regner om fra timer til minutter og summmerer antall minutter totalt for aktive bestillinger

		// sql spørring: henter ut hvor mange timer innlogget bruker har lov til å registrere samt om bruker er administator
		$sql="
		SELECT Max_Hours, Admin
		FROM setup JOIN position JOIN user
		WHERE setup.Position_Id = position.PositionId
		AND position.PositionId = user.Position_Id
		AND Ref_User = '$userRef';";
		$result=mysql_query($sql) or ("<script> alert('ikke mulig å hente lovlige timer for bruker (start2)')"); 	// utfører spørring
		$row2=mysql_fetch_row($result);									// henter resultat
		$maxHoursUser = $row2[0];										// tilordrer til variabler
		disconnect();													// kobler fra databasen

		if(! $isAdmin ){												// sjekker om bruker er adminisrator
			$userLeftHours = ($maxMinutesUser - $minutesBooked);		// trekker antall minutter booket fra antall lovlige minutter og viser antall minutter igjen
				
			return $isAdminMessage;										// variabel returneres
	}
}





/*
 * checkIfRoomIsBooked()
*
* Denne funksjonen tar inn tre parametere og bruker disse til å sjekke mot databasen
* om et bestemt klokkeslett til et bestemt rom er bestilt fra før av.
* Hvis rommet er bestilt av noen andre i samme tidsperioden så blir det returnert
* true/false
*
* @param int 	$timeStart		Start tiden for booking.
* @param int 	$timeEnd		Slutt tiden for booking.
* @param char	$room			Et bestemt rom.
* @param date	$date			En angitt dato.
*
* @return boolean		Returnerer en true eller false.
*
*/
function checkIfRoomIsBooked($date,$startTime,$endTime,$roomId){
	connect();
	$sql="Select Start_Time,End_Time,Dato,Room_Id FROM booking WHERE
	((CAST('$startTime' AS time) BETWEEN Start_Time AND End_Time OR
	CAST('$endTime' AS time) BETWEEN Start_Time AND End_Time) OR
	(CAST(Start_Time AS time) BETWEEN '$startTime' AND '$endTime' OR
	CAST(End_Time AS time) BETWEEN '$startTime' AND '$endTime')) AND
	Dato='$date' AND
	Room_Id='$roomId';";

	$result=mysql_query($sql) or die ("ikke mulig å sjekke om et rom er booka");
	$numRows=mysql_num_rows($result);
	disconnect();

	if($numRows==0) {
		return false;
	} else {
		return true;
	}
}

/*
 * getRoomType()
*
* Denne funksjonen tar inn et angitt romnavn og sjekker databasen for å finne hva
* slags rom type dette er og returnerer det den finner.
*
* @param	string	$name	Navnet på et bestemt rom.
*
* @return	string	type	Navntypen på det bestemte rommet som ble spurt om.
*
*/
function getRoomType($name) {
	connect();
	$sql="Select Type FROM room WHERE Name='$name';";
	$result=mysql_query($sql) or die ("ikke mulig å hente rom-data fra databasen");
	$numRows=mysql_num_rows($result);
	$rad=mysql_fetch_array($result);
	disconnect();

	return $rad[0];
}

/*
 * isBooked()
*
* Denne funksjonen tar inn tre parametere og bruker disse til å sjekke mot databasen
* om et bestemt klokkeslett til et bestemt rom er bestilt fra før av.
* Hvis rommet er bestilt av noen andre i samme tidsperioden så blir det returnert
* en falsk div verdi.
*
* @param int 	$timeStart	Start tiden for booking.
* @param int 	$timeEnd		Slutt tiden for booking.
* @param char	$room			Et bestemt rom.
* @param date	$date			En angitt dato.
*
* @return string	verdi		Returnerer en true eller false div
*
*/
function isBooked($timeStart,$timeEnd,$room,$date){
	$roomId	= getRoomId($room);
	connect();
	$sql="Select Start_Time,End_Time,Dato,Name room
	FROM booking INNER JOIN room ON Room_Id=RoomId WHERE
	('$timeStart' BETWEEN Start_Time AND End_Time OR
	'$timeEnd' BETWEEN Start_Time AND End_Time) AND
	Dato='$date' AND Name='$room';";

	$result=mysql_query($sql) or die ("ikke mulig å sjekke om et rom er booka");
	$numRows=mysql_num_rows($result);
	disconnect();

	if($numRows==0) {
		$verdi 	=	"<div class='false'></div>";
		return $verdi;
	} else {
// 		$verdi 	=	"<div class='true'></div>";
		$verdi 	=	" ";
		return $verdi;
	}
}

function listRooms($userRef) {

			$type=$row[1];
	if ($result[0] == 0) {

		print $post[0];

		if($post[0] == 2) { // STUDENT
				$name=$row[0];
				$type=$row[1];
				$name=$row[0];
				$type=$row[1];

function listRoomTypes($userRef) {
	/*
	 Hensikt
	Funksjonen sjekker først om gjeldende bruker har administratorrettigheter.
	Dersom brukeren har det, listes all romtyper.
	Dersom bruker ikke er administrator, sjekker funksjonen om brukeren er
	student eller ansatt.
	Dersom bruker ansatt eller andre skal det listes ut	grupperom/møterom/datalab.
	Dersom bruker er student skal det kun listes ut grupperom.
	Parametre
	userRef - brukerens userref
	Funksjonsverdi
	Printer ut forskjellige options i HTML-skjema avhengig av hvem brukeren er.
	*/

	connect();
	$sql="SELECT Admin FROM user WHERE Ref_User='$userRef'; ";
	$result=mysql_query($sql) or die("Ikke mulig å hente adminrettigheter fra databasen.");
	$result = mysql_fetch_array($result);
	disconnect();

	if ($result[0] == 1) {
		connect();
		$sql = "SELECT DISTINCT Type FROM Room ORDER BY Type ASC;";
		$result = mysql_query($sql) or die("Ikke mulig å hente type rom fra databasen.");
		$numRows = mysql_num_rows($result);
		disconnect();

		for($t=1; $t<=$numRows; $t++){
			$row=mysql_fetch_array($result);
			$type=$row[0];
			print("<option value='$type'>$type</option>");
		}
	} else {
		connect();
		$sql="SELECT Position_Id FROM user WHERE Ref_User='$userRef';";
		$result=mysql_query($sql) or die("Ikke mulig å hente data fra databasen.");
		disconnect();


		$post=mysql_fetch_array($result);
		if($post[0] == 2) { // STUDENT
			print("<option value='Grupperom'>Grupperom</option>");
		}
		elseif($post[0] == 3 || $post[0] == 1) { // ANSATT OG ANDRE
			print("<option value='Grupperom'>Grupperom</option>");
			print("<option value='Datalab'>Datalab</option>");
			print("<option value='Møterom'>Møterom</option>");
		}
	}
}


/************************Konvertering av tid og dato til normalt skriveformat****************************************/

function normalDate($d) {
	$datePart = explode ("-",$d);
	$year = $datePart[0];
	$month = $datePart[1];
	$date = $datePart[2];
	$normalDate = $date."/".$month."-".$year;
	return $normalDate;
}

function normalTime($t) {
	$timePart = explode (":",$t);
	$hour = $timePart[0];
	$minute = $timePart[1];
	$normalTime = $hour.":".$minute;
	return $normalTime;
}

function norwegianWeekDayName($weekDayName) {



function bookedTimeArray( $startTime, $endTime, $timeInterval ) {
	// Konverterer starttidspunkt (hh:mm) til minutter
		startTimeMinute  = tidspunkt (minutt) som brukeren ønsker å reservere
		date = dato som brukeren ønsker å utføre reservasjon
		room = rom som brukeren ønsker å reservere
	$today = date("Y-m-d H:i");												// HENTER GJELDENDE DATO OG TIDSPUNKT 
	
	$sql="SELECT Start_Time, End_time
	FROM booking JOIN room
	WHERE Room_Id = RoomId
	AND Dato='$date'
	AND Name='$room';";
			if ( $varStartTime > $today ){
				echo ">";
			}
//sjekker når den neste bestillingen starter på det valgte rommet på sjekktidspunktet
		//DERSOM DET BLE FUNNET RADER HAR ROMMET EN BESTILLING SENERE PÅ DAGEN. BRUKER INFORMERES OM HVOR LENGE ROMMET ER LEDIG FRAM TIL.



	/* Hensikt
	* 		Valgt dato hentes ut fra skjema med $_POST["selectDate"];
	echo "<form method='post' action='' name='formCal' id='formCal'>";				// html skjema for å velge måned og dato

	$monthsarray = array("Januar","Februar","Mars","April","Mai","Juni","Juli","August","September","Oktober","November","Desember");	//array med alle måneder

	echo "<select name='selectMonth' id='selectMonth'>";							//  listeboks med måned
	$s=1;
	foreach ($monthsarray as $montharray){											// genererer listeboks basert på array
		echo "<option ";
		if(date("n")==$s){
			echo "selected ";
		}																			// setter gjeldende måned som forhåndsvalgt
		echo "value='$s'>$montharray</option>";										// skriver ut månedsnavn
		$s++;
	}
	echo "</select>";

	$yearStart = date("Y");															// legger inn gjeldende år i variabel
	$yearStop = date('Y', strtotime($yearStart . " + 5 years"));					// legger inn hvilket år som maksimalt skal vises (startår + 5 år)

	echo "<select name='selectYear' id='selectYear'>";								// listeboks med år
	while ($yearStart <= $yearStop){												// generer listeboks basert på start og stopp år
		echo "<option ";
		if(date("Y")==$yearStart){
			echo "selected ";
		}																			// setter gjeldende år som forhåndsvalgt
		echo "value='$yearStart'>$yearStart</option>";
		$yearStart++;

	}

	echo "<input type='submit' name='submitCal' id='submitCal' value='Velg'>";

	echo "</form>";


	$month = date("m");																// Tilegner gjeldende måned til variabel
	$year = date("Y");																// Tilegner gjeldende år til variabel

	$submitCal = $_POST["submitCal"];												// lytter på submit-knapp

																					//Hvis brukeren velger måned og år i kalender tilegnes disse til variabler
	if($submitCal){																	// hvis submit-knapp trykkes hentes valgt måned og år fra skjema
		$month = $_POST["selectMonth"];
		$year = $_POST["selectYear"];


		$monthDisplay = $monthsarray[$month-1];										// henter valgt måned som skal vises i tabell (-1 på grunn av index 0 i array)
																					// lager tabell og tabell-head
		echo "
		<table class='calTable'>
		<thead class='calTableHeader'>
		<tr>
		<th colspan='7'>$monthDisplay $year </th>
		</tr>
		<tr>
		<th>M</th>
		<th>T</th>
		<th>O</th>
		<th>T</th>
		<th>F</th>
		<th>L</th>
		<th>S</th>
		</tr>
		</thead>
		<tbody>
		";


		connect();																	// kobler til databasen
																					// sql spøring: henter ut antall lovlige dager som bruker kan reservere frem i tid samt om brukeren er administrator
		$sql="
		SELECT PreDays, Admin
		FROM setup JOIN position JOIN user
		WHERE setup.Position_Id = position.PositionId
		AND position.PositionId = user.Position_Id
		AND Ref_User = '$userRef';";
		$result=mysql_query($sql) or die ("ikke mulig å hente gjenstående timer på bruker");
		$row=mysql_fetch_row($result);
		$preDays = $row[0];
		$isAdmin = $row[1];
		disconnect();

		date_default_timezone_set("Europe/Oslo");									//Setter tidssone
		$first_day = mktime(0,0,0,$month, 1, $year) ; 								//Henter UNIX timestamp - beregner antall sekunder siden 1 januar 1970 og spesifisert tidspunkt
		$start_week_day = date('D', $first_day);									//Bruker timestamp til å beregne hvilken dag som er den første dagen i måneden
		$cal_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);				//Beregner antall dager i valgt måned
		$dateNow = date('Y-m-d');
		
		if(!$isAdmin){
			$varDateMaxDays = date('Y-m-d', strtotime($dateNow . " +$preDays days"));
		} else {
			$varDateMaxDays = 99999;
		}
		
		
		echo "<form method='post' action='' name='selectDateForm' id='selectDateForm'>";

																					// Starter bygging av tabelldata

		echo "<tr>";

																					// Setter variabler som brukes for å starte kalenderen på riktig ukedag
		switch($start_week_day){

			case "Mon":
				$daysLeft = 7;														// Setter hvor mange dager som skal tegnes opp den første uken (7 dager betyr at alle dager skal fylles, etc..)
				$spacesBefore = 0;													// Setter hvor mange "tomme" felt som skal være før den første dagen (0 betyr ingen felt)
				break;

			case "Tue":
				$daysLeft = 6;
				$spacesBefore = 1;
				break;

			case "Wed":
				$daysLeft = 5;
				$spacesBefore = 2;
				break;

			case "Thu":
				$daysLeft = 4;
				$spacesBefore = 3;
				break;
					
			case "Fri":
				$daysLeft = 3;
				$spacesBefore = 4;
				break;

			case "Sat":
				$daysLeft = 2;
				$spacesBefore = 5;
				break;
					
			case "Sun":
				$daysLeft = 1;
				$spacesBefore = 6;
				break;
		}

		while( $spacesBefore > 0 ){
			$spacesBefore--;
			echo "<td></td>";
		}

		for ($dayOfMonth=1; $dayOfMonth <= $daysLeft; $dayOfMonth++ ){
			$varDate=date('Y-m-d', strtotime($year."-".$month."-".$dayOfMonth));
			echo "<td><button class='";
			if ( $dateNow == $varDate) {
				echo "calButtonNow";
			} else {
				echo "calButton";
			};
			echo "' type='submit' form='selectDateForm' name='selectDate' value='$varDate' ";
			if($dateNow > $varDate || $varDateMaxDays < $varDate ){
				echo "disabled";
			}
			echo ">$dayOfMonth</button></td>";
		}

		echo "</tr>";

		// Skriver ut fra uke 2 og utover

		$weekOfMonth=2;

		while($weekOfMonth <= 6){
			$weekOfMonth++;

			$dayOfWeek=1;
			echo "<tr>";
			for ($dayOfMonth; $dayOfWeek <= 7; $dayOfMonth++ ){
				$dayOfWeek++;
					
				if ($dayOfMonth <= $cal_days){
					$varDate = date('Y-m-d', strtotime($year."-".$month."-".$dayOfMonth));
					echo "<td><button class='";
					if ( $dateNow == $varDate) {
						echo "calButtonNow";
					} else {
						echo "calButton";
					};
					echo "' type='submit' form='selectDateForm' name='selectDate' value='$varDate' ";
					if($dateNow > $varDate || $varDateMaxDays < $varDate ){
						echo "disabled";
					}
					echo ">$dayOfMonth</button></td>";
				}
			}
			echo "</tr>";
		}

		echo "	</tbody>
				</table>
				</form>";
	}

}

function isAdminString($s) {
	/*
	slik at det bytter ut true false i en tabell
	if($s == '1') {					// SJEKKER OM INPUT DATAEN ER LIK 1
		return "Ja";
	} else {
		return "Nei";
	}
}

?>