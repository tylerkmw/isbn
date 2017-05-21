<?php

include 'db.php';

function sanitize($string) {

	global $connect;
	$string = str_replace("$", "", $string);
	$string = mysqli_real_escape_string($connect, $string);
	return $string;

}