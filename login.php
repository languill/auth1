<?php
session_start();

require 'functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if(login($email, $password)) {
		set_flash_message("success", "Вы залогинены");
		redirect_to("/users.php");
	} else {
		set_flash_message("danger", "Логин или пароль неверны");
		redirect_to("/page_login.php");
	}
}

