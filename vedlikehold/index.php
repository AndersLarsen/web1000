<?php 
/** * Dashboard
 * Hjemsiden for vedlikehold.
 * Viser en oversikt over hvor mange brukere,
 * bestillinger og rom løsningen har. * * PHP version 5 * * LICENSE: This source file is subject to version 3.01 of the PHP license * that is available through the world-wide-web at the following URI: * http://www.php.net/license/3_01.txt.  If you did not receive a copy of * the PHP License and are unable to obtain it through the web, please * send a note to license@php.net so we can mail you a copy immediately. * * @author		Original Author <andersborglarsen@gmail.com> * @author		Original Author <haavard@ringshaug.net> * @author		Original Author <oyvind.gautestad@gmail.com> * @author		Original Author <linda.fermann@gmail.com> * @copyright 	2013-2018 * @license		http://www.php.net/license/3_01.txt * @link		http://student.hive.no/web10007/1 * */
$title = 'roomEdit - Vedlikehold';
include '../includes/headerVedlikehold.php';		// INKLUDERER HEADER FOR VEDLIKEHOLD
checkLogin();										// SJEKKER OM BRUKER ER LOGGET INN
checkAdmin();										// SJEKKER OM EN BRUKER HAR ADMIN STATUS
?>

<h1>Dashboard</h1>
<h3>I rombestillingssystemet <strong>roomEDIT</strong> er følgende registrert: </h3>

<p>Antall aktive bestillinger (hvor slutttiden ennå ikke er gått ut): <strong> 
<?php 
connect();																					//KOBLER TIL DATABASEN$sql = "SELECT COUNT(BookingId) FROM booking
 		WHERE STR_TO_DATE(CONCAT(`Dato`, ' ', `End_Time`), '%Y-%m-%d %H:%i:%s' ) >= TIMESTAMP(NOW());";		//SQL-SPØRRING SOM TELLER HVOR MANGE BESTILLINGER DET FINNES MED SLUTTID STØRRE ENN ELLER LIKT TIDSPUNKTET FOR VISNINGEN AV SIDEN$result = mysql_query($sql) or die ("Ikke mulig å hente bestillinger fra databasen");		//KJØRER SQL-SPØRRING OG LEGGER RESULTAT I EN VARIABEL ELLER SKRIVER FEILMELDING DERSOM NOE GÅR FEIL$row=mysql_fetch_row($result);																//GJØR OM RESULTAT TIL ET ARRAY
echo $row[0];																				//SKRIVER UT VERDI I FØRSTE POSISJON (ANTALL RESERVASJONER) 
?>
</strong> <br />
(oppdater for nøyaktig antall) 
</p>

<p>Antall aktive brukere: <strong>
<?php 
$sql = "SELECT COUNT(UserId) FROM user;";													//SQL-SPØRRING SOM TELLER HVOR MANGE BRUKERE DET FINNES
$result = mysql_query($sql) or die ("Ikke mulig å hente bestillinger fra databasen");		//KJØRER SQL-SPØRRING OG LEGGER RESULTAT I EN VARIABEL ELLER SKRIVER FEILMELDING DERSOM NOE GÅR FEIL
$row=mysql_fetch_row($result);																//GJØR OM RESULTAT TIL ET ARRAY
echo $row[0];																				//SKRIVER UT VERDI I FØRSTE POSISJON (ANTALL BRUKERE)
?>
</strong><p>

<p>Antall registrerte rom: <strong>
<?php 
$sql = "SELECT COUNT(RoomId) FROM room;";													//SQL-SPØRRING SOM TELLER HVOR MANGE ROM DET FINNES
$result = mysql_query($sql) or die ("Ikke mulig å hente bestillinger fra databasen");		//KJØRER SQL-SPØRRING OG LEGGER RESULTAT I EN VARIABEL ELLER SKRIVER FEILMELDING DERSOM NOE GÅR FEIL
$row=mysql_fetch_row($result);																//GJØR OM RESULTAT TIL ET ARRAY
echo $row[0];																				//SKRIVER UT VERDI I FØRSTE POSISJON (ANTALL RESERVASJONER) 
disconnect();																				//KOBLER FRA DATABASEN
?>
</strong><p>

<?php
include '../includes/footerVedlikehold.php'													//INKLUDERER FOOTER TIL VEDLIKEHOLD
?>