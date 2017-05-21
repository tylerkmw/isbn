<?php

include 'db.php';
include 'header.php';

	$searchquery = "SELECT * FROM books WHERE isupdated='1'";
	$terms = 1;

	if(!empty($_POST['salesrankminimum'])) {
		if($terms > 0) {
			$searchquery = $searchquery . " AND ";
		}
		$salesrankminimum = $_POST['salesrankminimum'];
		$searchquery = $searchquery . "salesrank>" . $salesrankminimum;
		$terms++;
	}

	if(!empty($_POST['salesrankmaximum'])) {
		if($terms > 0) {
			$searchquery = $searchquery . " AND ";
		}
		$salesrankmaximum = $_POST['salesrankmaximum'];
		$searchquery = $searchquery . "salesrank<" . $salesrankmaximum;
		$terms++;
	}

	if(!empty($_POST['profitmarginroimin'])) {
		if($terms > 0) {
			$searchquery = $searchquery . " AND ";
		}
		$profitmarginroimin = $_POST['profitmarginroimin'];
		$searchquery = $searchquery . "profit_margin_roi>" . $profitmarginroimin;
		$terms++;
	}

	if(!empty($_POST['profitmarginroimax'])) {
		if($terms > 0) {
			$searchquery = $searchquery . " AND ";
		}
		$profitmarginroimax = $_POST['profitmarginroimax'];
		$searchquery = $searchquery . "profit_margin_roi<" . $profitmarginroimax;
		$terms++;
	}

	if(!empty($_POST['profitmarginmin'])) {
		if($terms > 0) {
			$searchquery = $searchquery . " AND ";
		}
		$profitmarginmin = $_POST['profitmarginmin'];
		$searchquery = $searchquery . "profit_margin>" . $profitmarginmin;
		$terms++;
	}

	if(!empty($_POST['profitmarginmax'])) {
		if($terms > 0) {
			$searchquery = $searchquery . " AND ";
		}
		$profitmarginmax = $_POST['profitmarginmax'];
		$searchquery = $searchquery . "profit_margin<" . $profitmarginmax;
		$terms++;
	}

	if(!empty($_POST['condition'])) {
		if($terms > 0) {
			$searchquery = $searchquery . " AND ";
		}
		$condition = $_POST['condition'];
		$searchquery = $searchquery . "cond='" . $condition . "'";
		$terms++;
	}

	$find = mysqli_query($connect, $searchquery) or die(mysqli_error($connect));
	while($findings = mysqli_fetch_assoc($find)) {
		echo $findings['title'] . " " .$findings['salesrank'];
	}