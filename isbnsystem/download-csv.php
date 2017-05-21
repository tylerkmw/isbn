<?php

include 'db.php';
include 'header.php';

?>

<body>

<p>Fill out as many filters as necessary.</p>

<form method="POST" action="csv.php">

<div class="section">
	<p>Sales Rank Minimum:
	<input type="text" name="salesrankminimum" value="">
	</p>
	<p>Sales Rank Maximum:
	<input type="text" name="salesrankmaximum" value=""> 
	</p>
</div>

<div class="section">
	<p>Profit Margin ROI Minimum:
	<input type="text" name="profitmarginroimin" value="">
	</p>
	<p>Profit Margin ROI Maximum:
	<input type="text" name="profitmarginroimax" value="">
	</p>
</div>

<div class="section">
	<p>Profit Margin Dollar Minimum:
	<input type="text" name="profitmarginmin" value="">
	</p>
	<p>Profit Margin Dollar Maximum:
	<input type="text" name="profitmarginmax" value="">
	</p>
</div>

<div class="section">
<select name="condition">
	<option value="">- condition -</option>
	<option value="likenew">like new</option>
	<option value="verygood">very good</option>
</select>
</div>

<button name="submit">submit</button>

</form>


</body>