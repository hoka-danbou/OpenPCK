<?php
require_once(__DIR__.'/functions.php');
session_start();

if(empty($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}
