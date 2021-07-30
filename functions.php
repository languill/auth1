<?php

function get_all_users() {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$sql = "SELECT * FROM users";
	$statement = $pdo->prepare($sql);
	$statement->execute();
	$user = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $user;
}

function get_user_by_id($id) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$sql = "SELECT * FROM users WHERE id=:id";
	$statement = $pdo->prepare($sql);
	$statement->execute(["id" => $id]);
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	return $user;
}



function get_user_by_email($email) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$sql = "SELECT * FROM users WHERE email=:email";
	$statement = $pdo->prepare($sql);
	$statement->execute(["email" => $email]);
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	return $user;
}

function add_user($email, $password) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	$statement = $pdo->prepare($sql);
	$result = $statement->execute([
		"email" => $email,
		"password" => password_hash($password, PASSWORD_DEFAULT)
	]);
	return $pdo->lastInsertId();
}

function edit_user_information($user_name, $job_title, $phone, $address, $id) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$data = [
		"id"    =>  $id,
		"user_name" =>  $user_name,
		"job_title" =>  $job_title,
		"phone" =>  $phone,
		"address" =>  $address,		
	];

	$sql = "UPDATE users SET user_name=:user_name, job_title=:job_title, phone=:phone, address=:address 
				WHERE id=:id";
	$statement = $pdo->prepare($sql);	
	$statement->execute($data); 
}


function edit_credentials($email, $password, $id) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$data = [
		"id"    =>  $id,		
		"email" => $email,
		"password" => password_hash($password, PASSWORD_DEFAULT)		
	];

	$sql = "UPDATE users SET email=:email, password=:password WHERE id=:id";
	$statement = $pdo->prepare($sql);	
	$statement->execute($data); 
	$_SESSION['login'] = $email;
}

function set_user_status($status, $id) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$data = [
		"id"    =>  $id,		
		"status" =>  $status,		
	];

	$sql = "UPDATE users SET status=:status WHERE id=:id";
	$statement = $pdo->prepare($sql);	
	$statement->execute($data); 
}


function upload_avatar($avatar, $id) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$data = [
		"id"    =>  $id,		
		"avatar" =>  $avatar,		
	];

	$sql = "UPDATE users SET avatar=:avatar WHERE id=:id";
	$statement = $pdo->prepare($sql);	
	$statement->execute($data); 
}

function add_social_links($vk, $telegram, $instagram, $id) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$data = [
		"id"    =>  $id,		
		"vk" =>  $vk,		
		"telegram" =>  $telegram,		
		"instagram" =>  $instagram,		
	];

	$sql = "UPDATE users SET vk=:vk, telegram=:telegram, instagram=:instagram WHERE id=:id";
	$statement = $pdo->prepare($sql);	
	$statement->execute($data); 
}

function add_user_by_admin(
	$email,
	$password,
	$user_name,
	$job_title,
	$phone,
	$address,
	$status,
	$avatar,	
	$vk,
	$telegram,
	$instagram) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$sql = "INSERT INTO users (email, 	
								password,
								role,
								user_name,
								job_title,
								phone,
								address,
								status,
								avatar,
								vk,
								telegram,
								instagram) 
	
						VALUES (:email, 
								:password,
								:role,
								:user_name,
								:job_title,
								:phone,
								:address,
								:status,
								:avatar,
								:vk,
								:telegram,
								:instagram)";
	
	$statement = $pdo->prepare($sql);
	$result = $statement->execute([
		"email" => $email,
		"password" => password_hash($password, PASSWORD_DEFAULT),
		"role" => "user",
		"user_name" => $user_name,
		"job_title" => $job_title,
		"phone" => $phone,
		"address" => $address,
		"status" => $status,
		"avatar" => $avatar,
		"vk" => $vk,
		"telegram" => $telegram,
		"instagram" => $instagram,
	]);
	return $pdo->lastInsertId();
}

function delete_user($id) {
	$pdo = new PDO("mysql:host=localhost;dbname=register", "root", "root");	
	$sql = "DELETE FROM users WHERE id=:id";
	$statement = $pdo->prepare($sql);
	$statement->execute(["id" => $id]);	
}

// создание уникального имени файла
function setUniqueFileName($path) {
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$avatar = uniqid().'.'.$ext;
	return $avatar;
}

// загрузка файла на сервер	
function upload_file($file_name, $file_tmp) {
	$avatar = setUniqueFileName($file_name);	
	$uploadfile = "images/".$avatar;
	move_uploaded_file($file_tmp, $uploadfile);	
	return $avatar;
}

// проверка аватара у пользователя: если нет, то выводит дефолтный аватар	
function has_image($user_id, $image = 'images/avatar.png') {
	$user = get_user_by_id($user_id);
	if($user['avatar']) {
		echo "images/{$user['avatar']}";
	} else {
		echo $image;
	}
}

// удаление автара
function delete_image($image, $path) {
	if($image !== NULL) {			
			if (file_exists($path)){
				unlink($path);
			}
	}
}	

		
function set_flash_message($name, $message) {
	$_SESSION[$name] = $message;
}


function display_flash_message($name) {
	if($_SESSION[$name]) {
		echo "<div class='alert alert-{$name} text-dark' role='alert'>{$_SESSION[$name]}</div>";
		unset($_SESSION[$name]);
	}
}

function redirect_to($path) {
	header("Location: {$path}");
	exit;
}

function login($email, $password) {
	$user = get_user_by_email($email);
	if($user) {
		if (password_verify($password, $user["password"])) {
			$_SESSION['login'] = $email;
			return true;
		} else {
			return false;
		}
	}
}


function is_not_logged_in()
{
    if (!isset($_SESSION['login'])) {		
		return true;
	} else {		
		return false;
	}        
}

function logout($session) {
	unset($session); 
	session_destroy();
}

// валидация данный формы
function text_validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// является ли залогиненный пользователь текущим пользователем
function is_author($logged_user_id, $edit_user_id) {
	if($logged_user_id == $edit_user_id) {
		return true;
	} else {
		return false;
	}	
}



