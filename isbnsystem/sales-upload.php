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
<input type="text" name="percentsrp" placeholder="Percent of SRP" required><br>
<input type="file" name="file2"><br>
<input type="file" name="file3"><br>
<input type="file" name="file4"><br>
<input type="file" name="file5"><br>
<input type="file" name="file6"><br>
<input type="file" name="file7"><br>
<input type="file" name="file8"><br>
<input type="file" name="file9"><br>
<input type="file" name="file10"><br><br>
<button name="submit">submit</button>
</form>

</body>
</html>