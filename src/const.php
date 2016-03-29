<?php
	define('MODE_LOCAL', 'local');
	define('MODE_OVH', 'ovh');

	$mode = MODE_LOCAL;

	if($mode == MODE_LOCAL) {
		// Local
		$con_serv = 'localhost';
		$con_dbname = 'base';
		$con_username = 'root';
		$con_password = '';
	} elseif($mode == MODE_OVH) {
		// Distant OVH
		$con_serv = '';
		$con_dbname = '';
		$con_username = '';
		$con_password = '';
	} else {
		throw new Exception('Mode applicatif incorrecte.');
	}

	// Infos
	date_default_timezone_set("Europe/Paris");
	$dateNaissance = mktime(0, 0, 0, 07, 27, 1985);
	$ville = 'Paris, France';
	$urlViadeo = 'http://www.viadeo.com/fr/profile/laurent.gautho.lapeyre';
	$urlLinkedIn = 'http://fr.linkedin.com/in/laurentgautholapeyre';
	$urlTwitter= 'https://twitter.com/Delphes99';
	$urlCvPdf = 'cv_laurent_gautho-lapeyre_public.pdf';
?>