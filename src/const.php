<?php
    require('api/epiphany/Epi.php');

    Epi::init('config');
    getConfig()->load('./config.ini');
    
	//database
    $con_serv = getConfig()->get('database')->dbhost;
	$con_dbname = getConfig()->get('database')->dbname;
	$con_username = getConfig()->get('database')->dbusername;
	$con_password = getConfig()->get('database')->dbpassword;
    
	// Infos
	date_default_timezone_set(getConfig()->get('timezone'));
	$dateNaissance = strtotime(getConfig()->get('user')->birthday_date);
	$ville = getConfig()->get('user')->location;
	$urlViadeo = getConfig()->get('user')->viadeo;
	$urlLinkedIn = getConfig()->get('user')->linkedin;
	$urlTwitter= getConfig()->get('user')->twitter;
	$urlCvPdf = getConfig()->get('user')->pdf_file;
?>