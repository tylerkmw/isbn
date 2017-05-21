<?php

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=data.csv');
	$openfile = fopen('php://output', 'w');
	$columns = array("ISBN", "Book Number", "Title", "Author", "Publisher", "Year", "Format", "Mark", "Hurt", "Pub Price", "SRP", "Avail", "Sales Rank", "Lowest New Price FBA", "Lowest New Price Merchant", "Subject", "Value of Book", "Profit Margin", "Profit Margin ROI");
	fputcsv($openfile, $columns);
	fclose($openfile);
	include 'db.php';

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

	$find = mysqli_query($connect, $searchquery);

	if(mysqli_num_rows($find) < 1) {
		echo "There are no books to download!";
	} else {
		while ($book = mysqli_fetch_assoc($find)) {

			$openfile = fopen('php://output', 'w');

			
			$isbn = $book['isbn'];
			$booknumber = $book['booknum'];
			$title = $book['title'];
			$author = $book['author'];
			$publisher = $book['publisher'];
			$year = $book['year'];
			$format = $book['format'];
			$mark = $book['mark'];
			$hurt = $book['hurt'];
			$pubprice = $book['pubprice'];
			$srp = $book['srp'];
			$avail = $book['avail'];
			$salesrank = $book['salesrank'];
			$lowestnewpricefba = $book['lowest_new_price_fba'];
			$lowestnewpricemerchant = $book['lowest_new_price_merchant'];
			$subject = $book['subject'];
			$valueofbook = $book['value_of_book'];
			$profitmargin = $book['profit_margin'];
			$profitmarginroi = $book['profit_margin_roi'];

			$info = array($isbn, $booknumber, $title, $author, $publisher, $year, $format, $mark, $hurt, $pubprice, $srp, $avail, $salesrank, $lowestnewpricefba, $lowestnewpricemerchant, $subject, $valueofbook, $profitmargin, $profitmarginroi);
			fputcsv($openfile, $info);
			fclose($openfile);
		}
	}

