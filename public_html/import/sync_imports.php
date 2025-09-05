<?php
// Error Reporting
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

// Execution Time
ini_set('max_execution_time', 600); // Set Maximum Execution Time 10 minutes ( 10 x 60 sec)

// Timezone
date_default_timezone_set('Europe/Athens');

// Caching
// Do not use browser cache
header('Cache-Control: no-cache, must-revalidate');


$output = '';

// Adam Home
$output .= get_url('https://peiraiashome.gr/import/import_adamhome.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_adamhome_images.php');
sleep(5);


// Borea
$output .= get_url('https://peiraiashome.gr/import/import_borea.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_borea_images.php');
sleep(5);


// Dimcol
$output .= get_url('https://peiraiashome.gr/import/import_dimcol.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_dimcol_images.php');
sleep(5);



// Homeline
$output .= get_url('https://peiraiashome.gr/import/import_homeline.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_homeline_images.php');
sleep(5);


// Lino
$output .= get_url('https://peiraiashome.gr/import/import_linohome.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_linohome_images.php');
sleep(5);


// Makis Tselios
$output .= get_url('https://peiraiashome.gr/import/import_makistselios.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_makistselios_images.php');
sleep(5);


// Omega home
$output .= get_url('https://peiraiashome.gr/import/import_omegahome.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_omegahome_images.php');
sleep(5);


// Palamaiki
$output .= get_url('https://peiraiashome.gr/import/import_palamaiki.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_palamaiki_images.php');
sleep(5);


// Teoran
$output .= get_url('https://peiraiashome.gr/import/import_teoran.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_teoran_images.php');
sleep(5);


// VamVax
$output .= get_url('https://peiraiashome.gr/import/import_vamvax.php');
sleep(5);
$output .= get_url('https://peiraiashome.gr/import/import_vamvax_images.php');
sleep(5);


echo $output;


function get_url($url) {

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 300);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	$response = curl_exec($ch);
	
	curl_close($ch);

	return $response;
}


?>