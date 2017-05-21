<?php

include 'header.php';
include 'db.php';

if(isset($_POST['submit'])) {
	
	$filelocation = $_FILES['file']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 1:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";

	if(!empty($_FILES["file2"]["tmp_name"])) {
		$filelocation = $_FILES['file2']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 2:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}







	if(!empty($_FILES["file3"]["tmp_name"])) {
		$filelocation = $_FILES['file3']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 3:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}













		if(!empty($_FILES["file4"]["tmp_name"])) {
		$filelocation = $_FILES['file4']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 4:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}
















		if(!empty($_FILES["file5"]["tmp_name"])) {
		$filelocation = $_FILES['file5']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 5:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}


















		if(!empty($_FILES["file6"]["tmp_name"])) {
		$filelocation = $_FILES['file6']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 6:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}















		if(!empty($_FILES["file7"]["tmp_name"])) {
		$filelocation = $_FILES['file2']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 7:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}



















		if(!empty($_FILES["file8"]["tmp_name"])) {
		$filelocation = $_FILES['file8']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 8:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}
















		if(!empty($_FILES["file9"]["tmp_name"])) {
		$filelocation = $_FILES['file9']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 9:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}
















		if(!empty($_FILES["file10"]["tmp_name"])) {
		$filelocation = $_FILES['file10']['tmp_name'];
	$file = fopen($filelocation, "r");
	$filearray = fgetcsv($file); //get the first line (which is columns) so we do nothing with it

	$updated = 0;
	$notfound = 0;

	while(!feof($file)) {

			$filearray 	= fgetcsv($file);
			
			$isbn 						= $filearray['0'];
			$haserror 					= $filearray['1'];
			$salesrank 					= $filearray['5'];
			$lowest_new_price_fba	   	= $filearray['6'];
			$lowest_new_price_merchant 	= $filearray['7'];
			$valueofbook = 0;

			if($haserror == 0) {

				$find = mysqli_query($connect, "SELECT * FROM books WHERE isbn = '$isbn'");

				if(mysqli_num_rows($find) < 1) {
					$notfound++;
				} else {

					$book = mysqli_fetch_assoc($find);// Grab the existing book data
					$condition = $_POST['condition'];

					switch($condition) {

						case 'likenew':
							$cond = 'likenew';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.72;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.72;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .72;
								$valueofbook = $valueofbook - 7;
							}
						break;


						case 'verygood':
							$cond = 'verygood';
							if($salesrank <= 500000 && $lowest_new_price_fba > 0) { // IF LIKE NEW, UNDER 500k, W/ FBA PRICE
								
								$valueofbook = $lowest_new_price_fba * 0.60;
								$valueofbook = $valueofbook - 7;

							} else if ($salesrank <= 500000 && $lowest_new_price_fba < 1) { // LIKE NEW UNDER 500k NO FBA PRICE

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba > 0) { // LIKE NEW, BETWEEN 500k AND 1 MIL, WITH FBA PRICE

								$valueofbook = $lowest_new_price_merchant + $lowest_new_price_fba;
								$valueofbook = $valueofbook / 2;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else if ($salesrank <= 1100000 && $lowest_new_price_fba < 1) { // LIKE NEW, OVER 500k and NO FBA

								$valueofbook = $lowest_new_price_merchant + 4;
								$valueofbook = $valueofbook * 0.60;
								$valueofbook = $valueofbook -7;

							} else { // SALES RANK OVER 1.1 MILLION
								$valueofbook = $lowest_new_price_merchant * .60;
								$valueofbook = $valueofbook - 7;
							}
						break;


						default:
							echo "You did not select a condition.";

					}

					// Now that we have value of book, let's calculate the profit margins

					$rawpercent = $_POST['percentsrp'];

					$percentsrp = round((float)$rawpercent / 100, 2);
					$srp = $book['srp'];
					$srpadj = $srp * $percentsrp;

					$profitmargin = $valueofbook - $srpadj;
					$profitmarginroi = $profitmargin / $srpadj;
					$profitmarginroi = round((float)$profitmarginroi * 100, 2);

					$update = mysqli_query($connect, "UPDATE books SET salesrank='$salesrank', lowest_new_price_fba='$lowest_new_price_fba', lowest_new_price_merchant='$lowest_new_price_merchant', isupdated='1', value_of_book='$valueofbook', profit_margin='$profitmargin', profit_margin_roi='$profitmarginroi', cond='$cond' WHERE isbn = '$isbn'");
					$updated++;
				}

			}

	}
	echo "<p><strong>Sheet 10:</strong></p>";
	echo "<p>Books Updated: " . $updated . "</p>";
	echo "<p>Books Not Found: " . $notfound . "</p>";
	}









}