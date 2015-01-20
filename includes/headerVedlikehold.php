<?php 
/** * HEADER VEDLIKEHOLD
 * VISER LOGO SØKER LINJE OG MENYKNAPPER * * PHP version 5 * * LICENSE: This source file is subject to version 3.01 of the PHP license * that is available through the world-wide-web at the following URI: * http://www.php.net/license/3_01.txt.  If you did not receive a copy of * the PHP License and are unable to obtain it through the web, please * send a note to license@php.net so we can mail you a copy immediately. * * @author		Original Author <andersborglarsen@gmail.com> * @author		Original Author <haavard@ringshaug.net> * @author		Original Author <oyvind.gautestad@gmail.com> * @author		Original Author <linda.fermann@gmail.com> * @copyright 	2013-2018 * @license		http://www.php.net/license/3_01.txt * @link		http://student.hive.no/web10007/1 * */
include 'functions.php';										//INKLUDERER FUNKSJONSFILEN DER FUNKSJONEN ER

sec_session_start();											// STARTER SESSION
?>


<!DOCTYPE html>

<html lang="no">
<head>
	<title> <?php echo $title ?> </title> 									<!-- 	TITLENE HENTES INN HER SOM VISES I FANER	 -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<link rel="stylesheet" type="text/css" href="../css/stylesVedlikehold.css">
	 <script type="text/javascript" src="../js/functions.js"></script>			<!-- INKLUDERER DE FORSKJELLIGE CSS FILEN OG JS -->
</head>

<body>


	<div class="container">
		<header>
			<a class="headerLink" href="index.php">
				<img class="logo" alt="logo" src="../img/layout/meeting-room.jpg">
				<strong class="headerText">roomEDIT</strong>
				<span class="subHeaderText">Vedlikehold</span>
			</a>

<?php if($_SESSION['loggedIn'] == true) {															//VISER MENYKNAPPER VIS MAN ER LOGGER INN
?>
														
			 
			
			<div class="search" id="search_header">											<!-- SØKER BOKSEN -->
				<form method="post" action="search.php" name="searchForm" id="searchForm" >
					<label class="searchLabel" for="checkNoBooking">Søk i bestillinger</label><input type="checkbox" name="checkNoBooking" id="checkNoBooking" value="noBooking">
					<input type="text" name="searchBox" id="searchBox" placeholder=" søk ">
					<input type="submit" value="Søk" name="searchButton" id="searchButton">
				</form>
			</div>
			<nav>																				<!-- NAVIGASJONS LINJEN PÅ SIDEN -->
				<a href="vis-brukere.php">Vis Brukere</a>						
				<a href="registrer-bruker.php">Legg til bruker</a>
				<a href="vis-rom.php">Vis rom</a>				
				<a href="registrer-rom.php">Legg til rom</a>
				<a href="bestillinger.php">Vis bestillinger</a>
				<a href="romoversikt.php">Romoversikt</a>
				<a href="innstillinger.php">Innstillinger</a>
				<a href="../nettsted/index.php">Til nettsted</a>
				<a href="../includes/logout.php">Logg ut</a>
			</nav>
		
		<div class="leftHourIndicator"> 									<!-- VISER HVILKEN BRUKER SOM ER LOGGET INN OG HVOR MANGE BOOKING TIMER MAN HAR IGJEN -->
				<span><strong>Bruker:</strong> <?php  echo $_SESSION['username']; ?>  <br> <strong> ledige timer: </strong> <?php  echo $leftHoursMinutes = showUserLeftHours($_SESSION['userRef']); ?> </span>
		</div>	
		
		
<?php 
} 
?>
	</header>	
		<div class="content clearfloat"> 												<!--her kommer inholdet på siden-->

		