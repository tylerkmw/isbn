<?php
	$connect = mysqli_connect("localhost", "root", "", "wholesale");
	if(mysqli_connect_errno()) {
		echo "Failed to connect. Error: " . mysqli_connect_error();
	}