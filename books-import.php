<?php

include 'header.php';
include 'db.php';
include 'functions.php';

if(isset($_POST['submit'])) {
	
	$filelocation = $_FILES['file']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file);

	$imported = 0;
	$duplicates = 0;

	while(!feof($file)) {

		$filearray 	= fgetcsv($file);
		$cleanfilearray = array();

		foreach ($filearray as $item) {

			$item = sanitize($item);
			$cleanfilearray[] = $item;

		}


		$subject 	= $cleanfilearray['0'];
		$booknumber = $cleanfilearray['1'];
		$isbn 		= $cleanfilearray['2'];
		$title 		= $cleanfilearray['3'];
		$author 	= $cleanfilearray['4'];
		$publisher 	= $cleanfilearray['5'];
		$year 		= $cleanfilearray['6'];
		$format 	= $cleanfilearray['7'];
		$mark 		= $cleanfilearray['8'];
		$hurt 		= $cleanfilearray['9'];
		$pubprice 	= $cleanfilearray['10'];
		$srp 		= $cleanfilearray['11'];
		$avail 		= $cleanfilearray['12'];



		$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'"); // check if book import is duplicate
		if(mysqli_num_rows($find) > 0) {

			$duplicates++;

		} 
		else {


				$insert = mysqli_query($connect, "INSERT INTO books (subject, booknum, isbn, title, author, publisher, year, format, mark, hurt, pubprice, srp, avail) VALUES ('$subject', '$booknumber', '$isbn', '$title', '$author', '$publisher', '$year', '$format', '$mark', '$hurt', '$pubprice', '$srp', '$avail')") or die(mysqli_error($connect));



				$imported++;

			}
	}

	echo "<p>Imported: " . $imported . "</p>";
	echo "<p>Duplicates: " . $duplicates . "</p>";
}