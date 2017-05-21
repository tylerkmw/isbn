<?php
	include 'db.php';
	include 'header.php';
?>
<body>

<form method="POST" action="books-import.php" enctype="multipart/form-data">
<input type="file" name="file" required>
<button name="submit">submit</button>
</form>

</body>
</html>