<?php
/** * Bestillinger - hjemside
 * 
 * Siden viser alle bestillinger som brukeren har,
 * alle dagens bestillinger samt fram i tid.
 * Viser ikke bestillinger eldre enn dagens.
 * For hver bestilling har man muligheten å enten endre
 * eller slette bestillingen.
 *  * * PHP version 5 * * LICENSE: This source file is subject to version 3.01 of the PHP license * that is available through the world-wide-web at the following URI: * http://www.php.net/license/3_01.txt.  If you did not receive a copy of * the PHP License and are unable to obtain it through the web, please * send a note to license@php.net so we can mail you a copy immediately. * * @author		Original Author <andersborglarsen@gmail.com> * @author		Original Author <haavard@ringshaug.net> * @author		Original Author <oyvind.gautestad@gmail.com> * @author		Original Author <linda.fermann@gmail.com> * @copyright 	2013-2018 * @license		http://www.php.net/license/3_01.txt * @link		http://student.hive.no/web10007/1 * */


$title = 'roomEdit - Finn ditt rom';
include("../includes/headerNettsted.php");								//INKLUDERER HEADEREN PÅ NETTSTEDET
checkLogin();															//SJEKKER OM BRUKER ER LOGGET INN
?>

<form class=''  name='findRoomNow' action='ledig-naa.php' method='post'>
	<input type='submit' class='bigSubmit' value='Ledig akkurat nå?' name='findRoomNow' id='findRoomNow'>
</form>

<h1 class="print">Mine aktive bestillinger</h1>

<?php 

/********************************* Vis alle mine bookinger ****************************************/
	$userRef= $_SESSION['userRef'];										//HENTER BRUKERREFERANSE FRA SESSION OG LAGRER DET I ANGITT VARIABEL
	$timestamp = $_SERVER['REQUEST_TIME'];								//HENTER TIDSPUNKTET AKKURAT NÅ OG TILORDNER DET TIL VARIABEL
	$today = date('Y-m-d', $timestamp);									//HENTER UT ÅR, MÅNED OG DATO AKKURAT NÅ OG TILORNER DET TIL VARIABEL
	$time = date('H:i:s', $timestamp);									//HENTER UT TIME, MINUTT OG SEKUND AKKURAT NÅ OG TILORNER DET TIL VARIABEL		connect();															//KOBLER TIL DATABASEN	$sql = "SELECT Dato,Start_Time,End_Time,Name,Type,Ref_Booking	FROM Booking AS B INNER JOIN room AS R	ON B.Room_ID = R.RoomId	WHERE B.User_Ref='$userRef'
	AND STR_TO_DATE(CONCAT(`Dato`, ' ', `End_Time`), '%Y-%m-%d %H:%i:%s' ) >= TIMESTAMP(NOW())
	ORDER BY Dato ASC,Start_Time ASC;";									//SQL-SPØRRING SOM HENTER BESTILLINGER I DAG ELLER FRAMOVER SOM TILHØRER BRUKEREN	$result = mysql_query($sql) or die ("Ikke mulig å hente bestillinger fra databasen");	//KJØRER SQL-SPØRRINGEN OG TILORDNER RESULTATET I EN VARIABEL	$numRows= mysql_num_rows($result);									//TELLER ANTALL RADER SOM BLE FUNNET
	disconnect();														//KOBLER FRA DATABASEN
	
	if ($numRows == 0) {												//DERSOM INGEN RADER FUNNET
		echo 'Du har ingen aktive bestillinger';						//SKRIVER UT MELDING OM AT BRUKEREN IKKE HAR NOEN BESTILLINGER
	} else { 															//DERSOM RADER FUNNET SKRIVES BESTILLINGER UT I HTML-SKJEMA
?>															
		
		<table class="standard_table print">		<thead class="print">		<tr class="print">		<th class="standard_table_header print">Dato</th>		<th class="standard_table_header print">Fra kl.</th>		<th class="standard_table_header print">Til kl.</th>		<th class="standard_table_header print">RomNr.</th>		<th class="standard_table_header print">Romtype</th>		<th class="standard_table_header print">Ref.Nr</th>		<th class="print"></th>		<th class="print"></th>		<th class="print"></th>		<th class="print"></th>		</tr>		</thead>		<tbody>
	<?php 	for($t=1; $t<=$numRows;$t++){										//FOR LØKKE SOM GÅR SÅ MANGE GANGER SOM RADER SOM BLE FUNNET		$row=mysql_fetch_array($result);								//HENTER RESULTATET SOM ARRAY OG TILORDNER DET TIL EN VARIABEL		$date=$row[0];													//FØRSTE VERDI I HVER RAD LAGRES I VARIABEL		$start_time=$row[1];											//ANDRE VERDI I HVER RAD LAGRES I VARIABEL		$end_time=$row[2];												//TREDJE VERDI I HVER RAD LAGRES I VARIABEL		$name=$row[3];													//FJERDE VERDI I HVER RAD LAGRES I VARIABEL		$type=$row[4];													//FEMTE VERDI I HVER RAD LAGRES I VARIABEL		$ref_booking=$row[5];											//SJETTE VERDI I HVER RAD LAGRES I VARIABEL
		
		//skriver ut HTML-skjema med de verdier som tilligger hver bestilling. Dato og tid gjøres om gjennom funksjon (se funksjonsfil for forklaring)		echo "
 		<tr>
 			<form class='print' name='editBooking' id='editBooking' action='endre-bestilling.php' method='post'>				<td class='standard_table_data print'>" . normalDate($date) . "</td>				<td class='standard_table_data print'>" . normalTime($start_time) . "</td>				<td class='standard_table_data print'>" . normalTime($end_time) . "</td>				<td class='standard_table_data print'>$name</td>				<td class='standard_table_data print'>$type</td>				<td class='standard_table_data print'>$ref_booking</td>
				<td class='standard_table_data'><input type='hidden' value='$ref_booking' name='ref_booking' id='ref_booking'></td>				<td class='standard_table_data'><input type='submit' value='Endre' name='editBookingSubmit' id='editBookingSubmit'></td>
			</form>
			<form class='' name='deleteBooking' action='index.php' method='post' onSubmit='return confirmDelete()'>
				<td class='standard_table_data'><input type='hidden' value='$ref_booking' name='ref_booking' id='ref_booking'> </td>
				<td class='standard_table_data'><input type='submit' value='Slett' name='deleteBookingSubmit' id='deleteBookingSubmit'></td>
			</form>		</tr>		";	}		echo '</tbody>';	echo '</table>';
?>
	<form><input type="button" class="button" value=" Skriv ut dine bestillinger "
	onclick="window.print();return false;" /></form>
<?php 
	}
?>

	

	<?php 	
/********************************* Slett bestilling ****************************************/
	
	$delete = $_POST["deleteBookingSubmit"];											//LAGER SLETTE-KNAPP
	if ($delete) {																		//LYTTER TIL OM SLETTEKNAPP TRYKKES PÅ
		$ref_booking = $_POST['ref_booking'];											//HENTER BESTILLINGSREFERANSE FRA SKJEMA
		
		connect();																		//KOBLER TIL DATABASEN
		$sql = "DELETE FROM Booking WHERE Ref_Booking='$ref_booking';";					//SQL-KOMMANDO SOM SLETTER DEN AKTUELLE BESTILLINGEN
		mysql_query($sql) or die ("Ikke mulig å slette bestilling fra databasen");		//SQL-KOMMANDO KJØRES ELLER RETURNERER FEILMELDING DERSOM NOE GALT SKJER
		disconnect();		//KOBLER FRA DATABASEN
		
		echo "<script>alert('Bestilling med referansenummer $ref_booking er nå slettet fra databasen'); window.location = 'index.php';</script>";	//SKRIVER UT BEKREFTELSESMELDING OM HVILKEN BESTILLING SOM ER SLETTET I JAVASCRIPT
		
		//skriver ut oppdateringsknapp 
		$self=$_SERVER['PHP_SELF'];		echo "<form method='post' action='$self' id='egetKall' name='egetKall'>		<input type='submit' value='Se oppdatert tabell' id='oppdater' name='oppdater' class='input' />		</form>";
	}
?>


<?php 
if($_SESSION['loggedIn'] == true) {						//DERSOM BRUKER ER LOGGET INN VISES FOOTER, ELLERS AVSLUTTES BARE HTML-TAGGER
	include("../includes/footerNettsted.php");
} else { ?>
	</div> <!--end content-->
	</div> <!--end container--> 
</body>
</html>
<?php }?>