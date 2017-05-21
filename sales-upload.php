<?php
	include 'db.php';
	include 'header.php';
?>
<body>

<form method="POST" action="sales-import.php" enctype="multipart/form-data">
<input type="file" name="file" required>
<select name="condition" required>
	<option value="">- condition -</option>
	<option value="likenew">like new</option>
	<option value="verygood">very good</option>
</select>
<input type="text" name="percentsrp" placeholder="Percent of SRP" required>
<button name="submit">submit</button>
</form>

</body>
</html>