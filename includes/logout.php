<?php/** * Logout * Destroyer session som er blitt laget når brukeren logget inn slik * at brukeren blir logget ut fra siden. * * PHP version 5 * * LICENSE: This source file is subject to version 3.01 of the PHP license * that is available through the world-wide-web at the following URI: * http://www.php.net/license/3_01.txt.  If you did not receive a copy of * the PHP License and are unable to obtain it through the web, please * send a note to license@php.net so we can mail you a copy immediately. * * @author		Original Author <andersborglarsen@gmail.com> * @author		Original Author <haavard@ringshaug.net> * @author		Original Author <oyvind.gautestad@gmail.com> * @author		Original Author <linda.fermann@gmail.com> * @copyright 	2013-2018 * @license		http://www.php.net/license/3_01.txt * @link		http://student.hive.no/web10007/1 * */include("headerNettsted.php");			// INKLUDERER HEADEREN TIL NETTSTEDET	$_SESSION = array();							// HENTER ET TOMT ARRAY	$params = session_get_cookie_params();			// HENTER COOKIES PARAMETERE	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);	// TØMMER COOKIES	session_destroy();								// DREPER SESSIONEN	header('Location: ../nettsted/index.php');		// SENDER BRUKEREN TIL NETTSTED INDEX FILA NÅR HAN/HUN BLIR LOGGET UT	include("footerNettsted.php");			// INKLUDERER FOOTEREN TIL NETTESTEDET?>