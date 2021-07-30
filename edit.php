<?php 
session_start(); 
require 'functions.php';

if(is_not_logged_in()) {
	redirect_to("/page_login.php");
}

$logined_user = get_user_by_email($_SESSION['login']);
$user = get_user_by_id($_GET['id']);


// $logined_user['id'] != $user['id']
if($logined_user['role'] != 'admin' && !is_author($logined_user['id'], $user['id'])) {	
	set_flash_message("warning", "У вас нет прав для редактирования данного пользователя");
	redirect_to("/users.php");
	
}



//($logined_user['id'] != $user['id'])
//($logined_user['role'] != 'admin')


if($_SERVER['REQUEST_METHOD'] == 'POST') {		
	$user_name = text_validate($_POST['user_name']);
	$job_title = text_validate($_POST['job_title']);
	$phone = text_validate($_POST['phone']);
	$address = text_validate($_POST['address']);
	$id = text_validate($_POST['id']);
	edit_user_information($user_name, $job_title, $phone, $address, $id);
	set_flash_message("info", "Информация о пользователе обновлена");
	redirect_to("/users.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
        <a class="navbar-brand d-flex align-items-center fw-500" href="users.html"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="page_login.html">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
            </h1>

        </div>
        <form action="edit.php?id=<?php echo $user['id']?>" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Общая информация</h2>
                            </div>
                            <div class="panel-content">
                                <!-- username -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Имя</label>
                                    <input name="user_name" type="text" id="simpleinput" class="form-control" value="<?php echo $user['user_name']; ?>">
                                </div>

                                <!-- title -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Место работы</label>
                                    <input name="job_title" type="text" id="simpleinput" class="form-control" value="<?php echo $user['job_title']; ?>">
                                </div>

                                <!-- tel -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Номер телефона</label>
                                    <input name="phone" type="text" id="simpleinput" class="form-control" value="<?php echo $user['phone']; ?>">
                                </div>

                                <!-- address -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Адрес</label>
                                    <input name="address" type="text" id="simpleinput" class="form-control" value="<?php echo $user['address']; ?>">
									<input name="id" type="hidden" value="<?php echo $user['id']; ?>">
                                </div>
                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button type="submit" class="btn btn-warning">Редактировать</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
</body>
</html>