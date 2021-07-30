<?php 
session_start(); 
require 'functions.php';

logout($_SESSION['login']);
redirect_to("/page_login.php");