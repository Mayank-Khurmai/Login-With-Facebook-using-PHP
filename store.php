<?php

	$db = new mysqli("localhost","root","","users");

	$email = $_POST['email'];
	$name = $_POST['name'];
	$picture = $_POST['picture'];
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];
	$address = $_POST['address'];

	$sql = "INSERT INTO facebook_users(email,name,picture,dob,gender,address)VALUE('$email','$name','$picture','$dob','$gender','$address')";

	$r = $db->query($sql);

	if($r)
	{
		echo "success";
	}
?>