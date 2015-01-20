<?php 
/**
 * HEADER NETSTED
 * VISER LOGO SØKER LINJE OG MENYKNAPPER
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


include 'functions.php';						// INKLUDERER FUNKSJONENE
sec_session_start();							// STARTER SESSION
?>


<!DOCTYPE html>

<html lang="no">
<head>
	<title> <?php echo $title ?> </title>										<!-- HENTER INN TITLEN FRA DE UNDERLIGENDE SIDENE -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<link rel="stylesheet" type="text/css" href="../css/stylesNettsted.css">
	<link rel="stylesheet" type="text/css" href="print.css" type="text/css" media="print" />
	<script src="../js/functions.js"></script>									<!-- HER LIGGER DE FORSKJELLIGE CSS OG JS  -->
	<link rel="shortcut icon" type="img/x-icon" href="/favicon.ico">
	
</head>

<body>


	<div class="container">														<!-- STARTEN PÅ CONTAINER -->
		<header>
			<a class="headerLink" href="index.php"><img class="logo" alt="logo" src="../img/layout/meeting-room.jpg">
				<strong class="headerText">roomEDIT</strong>
				<span class="subHeaderText">"Finn ditt rom"</span>
			</a>
			
<?php if($_SESSION['loggedIn'] == true) {?>
		<!--  
			<form class=''  name='findRoomNow' action='ledig-naa.php' method='post'>
				<input type='submit' class='bigSubmitHeader' value='Ledig akkurat nå?' name='findRoomNow' id='findRoomNow'>
			</form>
		--> 
			<nav>																<!-- STARTEN PÅ NAVIGASJONS LINJEN  -->
				<a href="index.php">Bestillinger</a>					
				<a href="finn-ledig-rom.php">Finn ledig rom</a>
				<a href="dagplan.php">Dagplan</a>
				<a href="ukeplan.php">Ukeplan</a>
				<a href="min-informasjon.php">Min informasjon</a>	
				<?php 
				$userRef = $_SESSION['userRef'];								// VIS MAN ER LOGGET IN SOM ADMIN FÅR MAN OPP EN EKSTRA KNAPP TIL VEDLIKEHOLD
					connect();
					$sqlSetning="SELECT Admin FROM User WHERE Ref_User='$userRef';";
					$sqlResultat=mysql_query($sqlSetning) or die(mysql_error());
					$rad=mysql_fetch_array($sqlResultat);
					disconnect();
					
					$erAdmin = $rad[0];
				
					if($erAdmin == 1) { ?>
						<a href="../vedlikehold/index.php">Til vedlikehold</a>
					<?php 
					} 
				?>

				<a href="../includes/logout.php">Logg ut</a>
			</nav>
			
			<div class="leftHourIndicator"> 									<!-- VISER HVILKEN BRUKER SOM ER LOGGET INN OG HVOR MANGE BOOKING TIMER MAN HAR IGJEN -->
				<span><strong>Bruker:</strong> <?php echo $_SESSION['username']; ?>  <br> <strong> ledige timer: </strong> <?php  echo $leftHoursMinutes = showUserLeftHours($userRef); ?> </span>
			</div>
			
		
<?php 
} 
?>
		</header>
		<div class="content">														 <!--HER STARTER INNHOLDE PÅ SIDEN-->

		