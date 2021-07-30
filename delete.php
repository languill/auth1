<?php 
session_start(); 
require 'functions.php';

if(is_not_logged_in()) {
	redirect_to("/page_login.php");
}

$logined_user = get_user_by_email($_SESSION['login']);
$user = get_user_by_id($_GET['id']);


if($logined_user['role'] != 'admin' && !is_author($logined_user['id'], $user['id'])) {	
	set_flash_message("warning", "У вас нет прав для редактирования данного пользователя");
	redirect_to("/users.php");
	
}

if(isset($_GET['id'])) {
	$image = $user['avatar'];
	$path = "images/" . $image;
		
	if($logined_user['id'] == $user['id']) {
		delete_image($image, $path);		
		delete_user($user['id']);		
		logout($_SESSION['login']);
		redirect_to("/page_login.php");
	} else {
		delete_image($image, $path);
		delete_user($user['id']);
		set_flash_message("info", "Пользователь удален");
		redirect_to("/users.php");
	}
	
}