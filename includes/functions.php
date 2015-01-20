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
	}}

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
					echo ("					<form method='post' action='vis-brukere.php'>						<input type='submit' value='Gå til brukeroversikt' id='back' name='back'>					</form>					");
				}
			}
		}
	}
}

function addNewStudent() {	$reg=$_POST['registrerStudent'];	if ($reg) {														//følgende utføres dersom submit er trykket		$username 		=	$_POST["username"];						//henter verdi fra skjema		$email 			=	$_POST["email"];						//henter verdi fra skjema		$password		=	cryptPassword($_POST["password"]);		//henter verdi fra skjema		$passwordRaw	= 	$_POST["password"];						//henter verdi fra skjema
		$position_Id	=	'2';									//settes til '2' som er id for student		$admin			=	'0';									//settes til false		$Ref_User		=	createUserRef();						//lager unik referansenummer til bruker		if (!$username||!$email||!$password) {						//sjekker at alle felter er fylt ut			print ("<script> alert('Alle feltene må fylles ut') </script>");		} else {			if (validatorStudent($email,$username,$passwordRaw)) {		//validerer input				connect();											//kobler til databasen				$sqlSetning="SELECT username FROM user WHERE username='$username';";	//sjekker om brukernavn finnes fra før				$sqlResultat=mysql_query($sqlSetning);				$antallRader=mysql_num_rows($sqlResultat);				disconnect();				if($antallRader !==0){								//bruker må velge annet brukernavn dersom det finnes fra før					print("<script> alert('Brukernavn ".$brukernavn."finnes fra før') </script>");				} else {					connect();										//kaller på prosedyre regBruker, og registrerer følgende felter i databasen					$sqlSetning= "Call regBruker(					'$username',					'$email',					'$password',					'$position_Id',					'$admin',					'$Ref_User'					);" ;					mysql_query($sqlSetning) or die ("<script> alert('Noe gikk galt med registreringen') </script>");					disconnect();					print ("<script> alert('Registreringen var vellykket. Du kan nå logge inn.') </script>");				}			}		}	}}


/************************ Listeboks romtype ****************************************/

function roomTypeList(){
	/* Hensikt	 * 		Beskrivelse av hensikt	* Parametre	* 		Hvis funksjonen mottar parametre
	* Returnerer
	* 		Hvis funsjonen returnerer	*/

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
	if	 (strlen($password)>5) {		return true;	} else {		return false;	}
	
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

/* Validering av endring av bruker i vedlikehold */function validatorChangeUser($email,$username) {	/* 	Hensikt	 Funksjonen sjekker om feltene i registrering er korrekt fylt ut	Parametre	username = username som skal sjekkes	email = email som skal sjekkes	password = password som skal sjekkes	Funksjonsverdi	Funksjonen returnerer true hvis feltene er korrekt fylt ut	Funksjonen returnerer false ellers	*/	$legalEmail = validateEmail($email);	$legalUsername = validateUsername($username);	if(!$legalEmail) {		echo ("<script>alert('E-post er ikke korrekt fylt ut')</script>");	}	if(!$legalUsername){		echo ("<script>alert('Brukernavn er ikke korrekt fylt ut')</script>");	}	if ($legalEmail && $legalUsername) {		return true;	} else {		return false;	}}


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
	
	//$sql="SELECT Name FROM room WHERE name='$room_name';"; // sql spøøring	//$result=mysql_query($sql);						// kjører spørring	//$numRows=mysql_num_rows($result);				// returnerer resultat		//if($numRows !==0){								//DERSOM DET BLE FUNNET RADER SÅ FINNES ROMNAVN ALLEREDE	//	echo ("<script>alert('Romnavn $room_name finnes allerede.')</script>");	//} else {

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
	/* Hensikt	 * 		Brukes når brukeren ønsker å registrere en ny reservasjon:
	* 		- Sjekker hvor mange timer brukeren har lov til å reservere
	* 		opp mot antall timer som brukeren ønsker å reservere	* Parametre	* 		$userRef = unik referanse for en bruker i systemet
	* 		$startTimeClean = starttidspunkt for reservasjon som brukeren ønsker å utføre
	* 		$endTimeClean = sluttidspunkt for reservasjon som brukeren ønsker å utføre	* Returnerer	* 		"true" eller "false"	*/
	connect();														// kobler til databasen	// sql spørring: henter ut antall timer og minutter for aktive bestillinger for innlogget bruker	$sql="	SELECT	IFNULL(EXTRACT( HOUR from End_time ), 0 ) AS eH,	IFNULL(EXTRACT( MINUTE from End_time ), 0) AS eM,	IFNULL(EXTRACT( HOUR from Start_Time ), 0) AS sH,	IFNULL(EXTRACT( MINUTE from Start_Time ), 0) AS sM	FROM booking	WHERE User_Ref='$userRef'	AND STR_TO_DATE(CONCAT(`Dato`, ' ', `End_Time`), '%Y-%m-%d %H:%i:%s' ) >= TIMESTAMP(NOW());	";	$result=mysql_query($sql) or ("<script> alert('ikke mulig å hente gjenstående timer på bruker (start1)') ");	// utfører spørring	$numRows = mysql_num_rows($result);													//TELLER ANTALL RADER I RESULTATET		for($t=1; $t<=$numRows; $t++){														//FOR LØKKE SOM GJENTAS LIKE MANGE GANGER SOM DET ER RADER I RESULTATET		$row=mysql_fetch_array($result);			$eHt[] = $row[eH];		$eMt[] = $row[eM];		$sHt[] = $row[sH];		$sMt[] = $row[sM];	}		$minutesBooked = (array_sum($eHt)-array_sum($sHt)) * 60 + array_sum($eMt) - array_sum($sMt);				// regner om fra timer til minutter og summmerer antall minutter totalt for aktive bestillinger	
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
	/* Hensikt	 * 		Viser hvor mange timer en bruker har igjen for reservasjoner	* Parametre	* 		$userRef = unik referanse for en bruker i systemet	* Returnerer	* 		returnerer timer og minutter for vanlige brukere og tekst "Ubegrenset" for administrator	*/
	if($_SESSION['loggedIn'] == true){

		connect();														// kobler til databasen
		// sql spørring: henter ut antall timer og minutter for aktive bestillinger for innlogget bruker
		$sql="		SELECT		IFNULL(EXTRACT( HOUR from End_time ), 0 ) AS eH,		IFNULL(EXTRACT( MINUTE from End_time ), 0) AS eM,		IFNULL(EXTRACT( HOUR from Start_Time ), 0) AS sH,		IFNULL(EXTRACT( MINUTE from Start_Time ), 0) AS sM		FROM booking		WHERE User_Ref='$userRef'		AND STR_TO_DATE(CONCAT(`Dato`, ' ', `End_Time`), '%Y-%m-%d %H:%i:%s' ) >= TIMESTAMP(NOW());		";		$result=mysql_query($sql) or ("<script> alert('ikke mulig å hente gjenstående timer på bruker (start1)') ");	// utfører spørring		$numRows = mysql_num_rows($result);													//TELLER ANTALL RADER I RESULTATET		for($t=1; $t<=$numRows; $t++){														//FOR LØKKE SOM GJENTAS LIKE MANGE GANGER SOM DET ER RADER I RESULTATET			$row=mysql_fetch_array($result);			$eHt[] = $row[eH];			$eMt[] = $row[eM];			$sHt[] = $row[sH];			$sMt[] = $row[sM];		}		
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
		$maxHoursUser = $row2[0];										// tilordrer til variabler		$isAdmin = $row2[1];
		disconnect();													// kobler fra databasen

		if(! $isAdmin ){												// sjekker om bruker er adminisrator			$maxMinutesUser= $maxHoursUser * 60;						// hvis brukeren ikke er administrator: regnes det om fra timer til minutter
			$userLeftHours = ($maxMinutesUser - $minutesBooked);		// trekker antall minutter booket fra antall lovlige minutter og viser antall minutter igjen			return $leftHoursMinutes = sprintf("%02d timer og %02d minutter", floor($userLeftHours/60), $userLeftHours%60); // konverterer fra minutter til timer og minutter og returnerer dette		} else {			$isAdminMessage = "Ubegrenset";								// hvis brukeren er administrator tilordnes tekst til variabel
				
			return $isAdminMessage;										// variabel returneres		}
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

function listRooms($userRef) {	/*	 Hensikt	Funksjonen sjekker først om gjeldende bruker har administratorrettigheter.	Dersom brukeren har det, listes all rom.	Dersom bruker ikke er administrator, sjekker funksjonen om brukeren er	student eller ansatt.	Dersom bruker ansatt eller andre skal det listes ut	grupperom/møterom/datalab.	Dersom bruker er student skal det kun listes ut grupperom.	Parametre	userRef - brukerens userref	Funksjonsverdi	Printer ut forskjellige options i HTML-skjema avhengig av hvem brukeren er.	*/	connect();	$sql="SELECT Admin FROM user WHERE Ref_User='$userRef'; ";	$result=mysql_query($sql) or die("Ikke mulig å hente adminrettigheter fra databasen.");	$result = mysql_fetch_array($result);	disconnect();
	if ($result[0] == 1) {		connect();		$sql="SELECT Name, Type FROM room ORDER BY Type ASC, Name ASC;";		$result=mysql_query($sql) or die ("ikke mulig å hente data fra databasen");		$numRows=mysql_num_rows($result);		disconnect();		for($t=1; $t<=$numRows; $t++){			$row=mysql_fetch_array($result);			$name=$row[0];
			$type=$row[1];			print("<option value='$name'>$name $type</option>");		}	}
	if ($result[0] == 0) {		connect();		$sql="SELECT Position_Id FROM user WHERE Ref_User='$userRef';";		$result=mysql_query($sql) or die("Ikke mulig å hente data fra databasen.");		$numRows=mysql_num_rows($result);		disconnect();		$post=mysql_fetch_array($result);

		print $post[0];

		if($post[0] == 2) { // STUDENT			connect();			$sql="SELECT Name, Type FROM room WHERE Type='Grupperom' ORDER BY Type ASC, Name ASC;";			$result=mysql_query($sql) or die ("ikke mulig å hente data fra databasen");			$numRows=mysql_num_rows($result);			disconnect();			for ($r=1;$r<=$numRows;$r++){				$row=mysql_fetch_array($result);
				$name=$row[0];
				$type=$row[1];				print("<option value='$name'>$name $type</option>");			}		}		elseif($post[0] == 1) { // ANSATT			connect();			$sql="SELECT Name, Type FROM room WHERE Type='Grupperom' OR Type='Datalab' OR Type='Møterom' ORDER BY Type ASC, Name ASC;";			$result=mysql_query($sql) or die ("ikke mulig å hente data fra databasen");			$numRows=mysql_num_rows($result);			disconnect();			for ($r=1;$r<=$numRows;$r++){				$row=mysql_fetch_array($result);
				$name=$row[0];
				$type=$row[1];				print("<option value='$name'>$name $type</option>");			}		}	}}

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

function norwegianWeekDayName($weekDayName) {	if ($weekDayName == 'Monday') {		$day = 'Mandag';		return $day;	}	if ($weekDayName == 'Tuesday') {		$day = 'Tirsdag';		return $day;	}	if ($weekDayName == 'Wednesday') {		$day = 'Onsdag';		return $day;	}	if ($weekDayName == 'Thursday') {		$day = 'Torsdag';		return $day;	}	if ($weekDayName == 'Friday') {		$day = 'Fredag';		return $day;	}	if ($weekDayName == 'Saturday') {		$day = 'Lørdag';		return $day;	}	if ($weekDayName == 'Sunday') {		$day = 'Søndag';		return $day;	}}



function bookedTimeArray( $startTime, $endTime, $timeInterval ) {	/*	 Hensikt		Funksjonen konverterer start- og sluttidspunkt for en reservasjon		til minutter, eks. kl.10:00 = 600 og kl.11:00 = 660. Så bereger		den tidsintervaller som er mellom disse punktene, eks.		hvis det er satt 15 min intervaller vil det være 615, 630, 645.		Dette konverteres så tilbake til tidsformat og legges inn som tidsluker		i et array sammen med start- og sluttidspunkt	Parametre		startTime = starttidspunkt for reservasjon		endTime = sluttidspunkt for reservasjon		timeInterval = ønsket tidsintervall (eks. 15,30,60)	Funksjonsverdi	A	rray som inneholder alle tidsluker fra starttidspunkt til slutttidspunkt	*/
	// Konverterer starttidspunkt (hh:mm) til minutter	$startPart = explode(":", $startTime);	$startMin = ($startPart[0] * 60 ) + ($startPart[1]);	// Konverterer sluttidspunkt (hh:mm) til minutter	$endPart = explode(":", $endTime);	$endMin = ($endPart[0] * 60 ) + ($endPart[1]);	$i=0;	for($t=$startMin; $t < $endMin; $t = $t + $timeInterval){				// Regner ut alle tidsluker mellom start- og sluttidspunkt ihht satt tidsintervall (15,30,60)		$i++;		$timeSlots[] = sprintf("%02d:%02d", floor($t/60), $t%60);	}	return $timeSlots;														// returerer tidsluker i array}function showBookingsRoom( $date, $room, $timeInterval, $startOfView, $endOfView ){	/*	 Hensikt		Funksjonen henter alle resrvasjoner for et spesifisert rom på en		spesifisert dato. Start- og sluttidspunkt for hver resvervasjon		kjøres gjennom funksjonen bookedTimeArray og lagres i et		multidimensjonalt array. Så genereres alle tidsintervallene for en dag		(08:00-20:00) i en tabell. I denne tabellgenereringen gjøre det også		en sjekk mot array med alle tidsluker for reservasjoner, og hvis det		er treff markeres tidsluke som opptatt. Hvis ikke settes den ledig.		Hvis tidsluke er ledig legges også inn et html skjema som sender starttidspunkt,		romnavn og dato som kan brukes til f.eks. booking	Parametre		date = hvilken dato det skal hentes reservasjoner fra		roomName = hvilket rom det skal hentes reservasjoner fra		timeInterval = ønsket tidsintervall (eks. 15,30,60)	Funksjonsverdi		startTimeHour = tidspunkt (time) som brukeren ønsker å reservere
		startTimeMinute  = tidspunkt (minutt) som brukeren ønsker å reservere
		date = dato som brukeren ønsker å utføre reservasjon
		room = rom som brukeren ønsker å reservere	*/
	$today = date("Y-m-d H:i");												// HENTER GJELDENDE DATO OG TIDSPUNKT 
		connect();																// Kobler til databasen
	$sql="SELECT Start_Time, End_time
	FROM booking JOIN room
	WHERE Room_Id = RoomId
	AND Dato='$date'
	AND Name='$room';";	$result = mysql_query($sql) or die ("ikke mulig å hente reservasjoner fra databasen");	// kjører spørring	$numRows = mysql_num_rows($result);										// henter resultat	disconnect();															// kobler fra databasen	for($t=1; $t<=$numRows; $t++){											// Legger til hver rad med start og slutt- tidspunkter inn i array i array		$row=mysql_fetch_array($result);		$bookings[]=$row;	}	foreach($bookings as $booking){							  				// Behandler hver rad (array i arrray) og konverterer fra tid til string i format mm:hh		$startPart = explode(":", $booking['Start_Time']);		$startTime = $startPart[0]. ":" . $startPart[1];		$endPart = explode(":", $booking['End_time']);		$endTime = $endPart[0]. ":" .$endPart[1];					$bookedTimeslots[] = bookedTimeArray( $startTime, $endTime, $timeInterval );		// Legger til hver rad med string i format mm:hh i array i array	}	// Tabell som inneholder alle tidsluker og reserverte tidsluker	echo "<table class='booking_table' align='center'>			<thead>			<tr>			<th class='room_header'>Rom</th>			";	for( $r=$startOfView ; $r<=$endOfView; $r = $r + $timeInterval){		 // skriver ut alle tidsluker for en dag i tabell ihht satt tidsintervall og start og slutttidspunkt (eks. 08:00-20:00)					echo "<th class='booking_table_header'>";		echo $timeList = sprintf("%02d:%02d", floor($r/60), $r%60); 		 // teller minutter fra starttidspunkt til sluttidspunkt i satt tidsintervall, konverterer fra minutter til tid (hh:mm) og skriver ut		echo "</th>";	}	echo "</tr>	</thead>	<tbody>	<tr>	<td class='room'><strong>$room</strong></td>	";	for( $y=$startOfView ; $y<=$endOfView ; $y = $y + $timeInterval){		// skriver ut celler som viser status for reservasjon samt skjema for å velge tidspunkt		echo "<form method='post' action='bestill-rom.php' name='selectTimeBooking' id='selectTimeBooking'>"; 	// Skjema som gjør det mulig å velg et ledig tidspunkt og sende med POST til f.eks romreservasjon		echo "<td ";		$timeList = sprintf("%02d:%02d", floor($y/60), $y%60); 					// bruker teller i for() loop til å legge til satt tidsintevall for hver iterasjon og konverterer fra minutter til tid (hh:mm)		for ($x=0 ; $x<= count($bookedTimeslots) ; $x++){						//			if( in_array( $timeList, $bookedTimeslots[$x] ) ){				$isOccupied=true;			}		}		if( $isOccupied ){			echo "class='tableRed'>";			echo "</td>";			echo "</form>";		} else {			$varStartTime = $date . " " . $timeList;								// SETTER SAMMEN DATO OG STARTTIDSPUNKT I EN VARIABEL (SKAL BRUKES I VALIDERING)
			if ( $varStartTime > $today ){				echo "class='tableGreen'>";				$startTimeElement = explode(":", $timeList);							//skiller time og minutt for å kunne la verdien sendes til bestilling dersom bruker trykker på klokkeslett				$startTimeHour = $startTimeElement[0];				$startTimeMinute = $startTimeElement[1];					echo "				<input type='hidden' value='$startTimeHour' name='startTimeHour' id='startTimeHour'>				<input type='hidden' value='$startTimeMinute' name='startTimeMinute' id='startTimeMinute'>				<input type='hidden' value='$date' name='date' id='date'>				<input type='hidden' value='$room' name='room' id='room'>					<input class='buttonTimeBooking' type='submit' name='submitTimeBooking' id='submitTimeBooking'>				";			} else {
				echo ">";
			}			echo "</td>";			echo "</form>";		}		unset($isOccupied);	}	echo "			</tr>			</tbody>			</table>			";}
//sjekker når den neste bestillingen starter på det valgte rommet på sjekktidspunktetfunction getNextBooking($time,$roomId,$room,$date) {	connect();																		//KOBLER TIL DATABASEN	$sql="Select Start_Time,Dato,Room_Id FROM booking WHERE	Start_Time > '$time'	AND Dato='$date'	AND room_id='$roomId'	ORDER BY Start_Time ASC;";														//SQL-SPØRRING SOM SJEKKER OM ROMMET HAR BESTILLINGER SENERE PÅ DAGEN. DEN FØRSTEBESTILLINGEN I TID KOMMER FØRST	$result=mysql_query($sql) or die ("Ikke mulig å hente ledige rom");				//KJØRER SPØRRINGEN OG LEGGER RESULTAT I VARIABEL ELLER SKRIVER UT FEILMELDING DERSOM NOE GIKK GALT	$numRows=mysql_num_rows($result);												//TELLER ANTALL RADER I RESULTATET OG LEGGER DET I EN VARIABEL	$row=mysql_fetch_array($result);												//GJØR OM RESULTATET TIL ET ARRAY OG LEGGER DET I EN VARIABEL	$startNextBooking=$row[0];														//VELGER KUN DEN FØRSTE FOREKOMSTEN	$startNextBooking=explode(":", $startNextBooking);								//SPLITTER OPP DEN FØRSTE FOREKOMSTEN I TIMER OG MINUTTER	$bookedStartHour = $startNextBooking[0];										//TILORDNER TIMER I EN VARIABEL	$bookedStartMinute = $startNextBooking[1];										//TILORDNER MINUTTER I EN VARIABEL	//finne ut hvor mange minutter et tidsintervall er. Trenger dette for å sette riktig tid som skal hentes til bestillingsskjema	$sqlTime="SELECT DISTINCT SUBSTRING(Klokka,4,2) as Timer FROM time;"; 			//SQL-SPØRRING SOM JEKKER FOR DISTINKTE TREFF I MINUTTER	$resultTime=mysql_query($sqlTime) or die ("Ikke mulig å hente tidsintervall");	//KJØRER SQL-SPØRRINGEN OG LEGGER RESULTAT I VARIABEL ELLER SKRIVER FEILMELDING DERSOM NOE GIKK GALT	$numRowsTime=mysql_num_rows($resultTime);										//TELLER ANTALL RADER I RESULTATET	//setter numerator avhengig av hvor mange distinkte minutter	if ($numRowsTime==4) {															//DERSOM ANTALL RADER FUNNET ER 4, ER DET FUNNET 00,15,30,45 MINUTTER I RESULTATET		$numerator = 15;															//VARIABEL NUMERATOR SETTES TIL 15 (TIDSINTERVALLET ER 15 MIN)	} elseif ($numRowsTime==2) {													//DERSOM ANTALL RADER FUNNET ER 2, ER DET FUNNET 00,30 MINUTTER I RESULTATET		$numerator = 30;															//VARIABEL NUMERATOR SETTES TIL 30 (TIDSINTERVALLET ER 30 MIN)	} else {																		//DERSOM ANTALL RADER FUNNET IKKE ER 4 ELLER 2 KJØRES DENNE KODEN (TABELLEN KAN KUN SETTES MED 15, 30 ELLER 60 MIN TIDSINTERVALL, OG DERMED VIL ALT SOM IKKE ER 2 ELLER 4 VÆRE 1, 00 MIN FUNNET I SPØRRINGEN)		$numerator = 60;															//VARIABEL NUMERATOR SETTES TIL 60 (TIDSINTERVALLET ER 60 MIN)	}	//sette riktig tid med hensyn til tidsintervall løsningen har	$timeNow=explode(":", $time);													//SPLITTER TIDSPUNKTET SOM ER NÅ OPP I TIMER OG MINUTTER	$timeNowHour = $timeNow[0];														//TILORDNER TIMEN NÅ I EN VARIABEL	$roundNumerator = 60 * $numerator;												//GANGER NUMERATOREN MED 60 (MIN)	$roundedMinute = ( round ( time() / $roundNumerator ) * $roundNumerator );		//TILORDNER AVRUNDET MINUTT I VARIABEL	$roundedMinute = date('i', $roundedMinute); 									//AVRUNDER TIDEN NÅ (MINUTTER) TIL NÆRMESTE TIDSINTERVALL I MINUTTER (DERSOM INTERVALL ER 15 MIN, SÅ AVRUNDES 10:06 TIL 10:00 ELLER 10:10 TIL 10:15)	disconnect();	//DERSOM DEN FØRSTE SQL-SPØRRING SOM BLE GJORT I FUNKSJONEN IKKE FANT NOEN RADER, SÅ HAR ROMMET INGEN BESTILLINGER RESTEN AV DAGEN, OG BRUKER INFORMERES OM AT ROMMET ER LEDIG DAGEN UT.	if ($numRows==0) {																//STARTTIDSPUNKT SETTES TIL AVRUNDET TID NÅ, OG SLUTTTIDSPUNKT FOR BESTILLINGEN SETTES DERFOR SOM UTGANGSVERDI TIL KL 20:00.		echo "<div>Rommet er ledig resten av dagen		<form action='bestill-rom.php' method='post' name='notBookedNow' id='notBookedNow'>		<input type='submit' value='Bestill nå' name='bookNow' id='bookNow'>		<input type='hidden' value='$timeNowHour' name='startTimeHour' id='startTimeHour'>		<input type='hidden' value='$roundedMinute' name='startTimeMinute' id='startTimeMinute'>		<input type='hidden' value='20' name='endTimeHour' id='endTimeHour'>		<input type='hidden' value='00' name='endTimeMinute' id='endTimeMinute'>		<input type='hidden' value='$date' name='date' id='date'>		<input type='hidden' value='$room' name='room' id='room'>		</form>		</div>";
		//DERSOM DET BLE FUNNET RADER HAR ROMMET EN BESTILLING SENERE PÅ DAGEN. BRUKER INFORMERES OM HVOR LENGE ROMMET ER LEDIG FRAM TIL.	} else {																		//STARTTIDSPUNKT SETTES TIL AVRUNDET TID NÅ, OG SLUTTTIDSPUNKT FOR BESTILLINGEN SETTES TIL SAMME VERDI SOM NESTE BESTILLING HAR SOM STARTVERDI.		echo "<div>Rommet er ledig fram til: $bookedStartHour:$bookedStartMinute		<form action='bestill-rom.php' method='post' name='notBookedNow' id='notBookedNow'>		<input type='submit' value='Bestill nå' name='bookNow' id='bookNow'>		<input type='hidden' value='$timeNowHour' name='startTimeHour' id='startTimeHour'>		<input type='hidden' value='$roundedMinute' name='startTimeMinute' id='startTimeMinute'>		<input type='hidden' value='$bookedStartHour' name='endTimeHour' id='endTimeHour'>		<input type='hidden' value='$bookedStartMinute' name='endTimeMinute' id='endTimeMinute'>		<input type='hidden' value='$date' name='date' id='date'>		<input type='hidden' value='$room' name='room' id='room'>		</form>		</div>";	}}//Sjekker om et gitt rom er ledig på sjekktidspunktetfunction isBookedNow($time,$room,$type,$date){	$roomId	= getRoomId($room);														//KALLER PÅ FUNKSJON SOM FINNE IDNUMMER TIL ROMMET SOM ER VALGT	connect();																		//KOBLER TIL DATABASEN	$sql="Select Start_Time,End_Time,Dato,Room_Id FROM booking WHERE	('$time' BETWEEN Start_Time AND End_Time)	AND Dato='$date'	AND room_id='$roomId';";														//SQL-SPØRRING SOM HENTER DE NØDVENDIGE VERDIER KUN HVOR VALGT TID/DATO/ROM FINNES REGISTRERT I SAMME OPPFØRING	$result=mysql_query($sql) or die ("Ikke mulig å hente ledige rom");				//KJØRER SQL-SPØRRINGEN OG LEGGER RESULTATET I EN VARIABEL ELLER GIR FEILMELDING DERSOM NOE GÅR GALT	$numRows=mysql_num_rows($result);												//TELLER ANTALL RADER I RESULTATET	disconnect();																	//KOBLER FRA DATABASEN	if($numRows==0) {																//DERSOM INGEN RADER BLIR FUNNET ER ROMMET LEDIG PÅ VALGT TIDSPUNKT		echo "<div class='clearfloat'><h2 class=''>$room $type</h2></div>";			//ROMNUMMER OG TYPE ROM SKRIVES UT		getNextBooking($time,$roomId,$room,$date);									//FUNKSJONSKALL SOM SJEKKER OM DET ER NOEN BESTILLING PÅ ROMMET SENERE PÅ DAGEN	}}


function phpCalendar($userRef){
	/* Hensikt	 * 		Vise kalender hvor bruker kan velge dato og legger inn denne i et html skjema	* Parametre	* 		$userRef = Unik referanse som identifiserer brukeren	* Returnerer
	* 		Valgt dato hentes ut fra skjema med $_POST["selectDate"];	*	*/
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
	/*	 Hensikt	Får inn 1 eller 0 og gir et ja nei svar utifra dette
	slik at det bytter ut true false i en tabell	Parametre	s = input fra tabellen	*/
	if($s == '1') {					// SJEKKER OM INPUT DATAEN ER LIK 1
		return "Ja";
	} else {
		return "Nei";
	}
}

?>