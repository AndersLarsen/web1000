<?php
/**
 * 
 * Siden viser alle bestillinger som brukeren har,
 * alle dagens bestillinger samt fram i tid.
 * Viser ikke bestillinger eldre enn dagens.
 * For hver bestilling har man muligheten å enten endre
 * eller slette bestillingen.
 * 


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
	$time = date('H:i:s', $timestamp);									//HENTER UT TIME, MINUTT OG SEKUND AKKURAT NÅ OG TILORNER DET TIL VARIABEL
	AND STR_TO_DATE(CONCAT(`Dato`, ' ', `End_Time`), '%Y-%m-%d %H:%i:%s' ) >= TIMESTAMP(NOW())
	ORDER BY Dato ASC,Start_Time ASC;";									//SQL-SPØRRING SOM HENTER BESTILLINGER I DAG ELLER FRAMOVER SOM TILHØRER BRUKEREN
	disconnect();														//KOBLER FRA DATABASEN
	
	if ($numRows == 0) {												//DERSOM INGEN RADER FUNNET
		echo 'Du har ingen aktive bestillinger';						//SKRIVER UT MELDING OM AT BRUKEREN IKKE HAR NOEN BESTILLINGER
	} else { 															//DERSOM RADER FUNNET SKRIVES BESTILLINGER UT I HTML-SKJEMA
?>															
		
		<table class="standard_table print">
	<?php 
		
		//skriver ut HTML-skjema med de verdier som tilligger hver bestilling. Dato og tid gjøres om gjennom funksjon (se funksjonsfil for forklaring)
 		<tr>
 			<form class='print' name='editBooking' id='editBooking' action='endre-bestilling.php' method='post'>
				<td class='standard_table_data'><input type='hidden' value='$ref_booking' name='ref_booking' id='ref_booking'></td>
			</form>
			<form class='' name='deleteBooking' action='index.php' method='post' onSubmit='return confirmDelete()'>
				<td class='standard_table_data'><input type='hidden' value='$ref_booking' name='ref_booking' id='ref_booking'> </td>
				<td class='standard_table_data'><input type='submit' value='Slett' name='deleteBookingSubmit' id='deleteBookingSubmit'></td>
			</form>
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
		$self=$_SERVER['PHP_SELF'];
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