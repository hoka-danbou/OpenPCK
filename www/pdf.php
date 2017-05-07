<?php
require_once('../lib/init.php');
$course_num = $_GET['c'];
$quiz_num   = $_GET['n'];

$ql = new QuizLoader();

$dir = $ql->getQuizDir($course_num, $quiz_num);

header('Content-Type: application/pdf');
readfile($dir.'/mondai.pdf');
