<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/QuizLoader.php');
require_once(__DIR__ . '/Compiler.php');
require_once(__DIR__ . '/StatusManager.php');
require_once(__DIR__ . '/Tester.php');
require_once(__DIR__ . '/User.php');

function redirect_to($page) {
    header('Location: '.$page);
}

function make_query_string($cource_num, $quiz_num = -1) {
    $ret = '?c='.$cource_num;
    if($quiz_num >= 0) {
        $ret .= '&n='.$quiz_num;
    }
    return $ret;
}

function get_msg($key, $value) {
    switch ($key) {
        case 'answer_status':
            $ANSWER_MSGS = [
                'ok'          => '正解',
                'sent'        => '提出済み（正解確認中）',
                'compile-err' => 'コンパイルエラー',
            ];
            if(array_key_exists($value, $ANSWER_MSGS)) {
                return $ANSWER_MSGS[$value];
            }else{
                return '未挑戦';
            }

            break;
    }
}

function make_breadcrumb($course_num, $quiz_num = null) {
    $ql = new QuizLoader();
    $ret = '<li class="breadcrumb-item"><a href="./">TOP</a></li>'
         . '<li class="breadcrumb-item"><a href="./quiz_list.php?c='.$course_num.'">'
         . $ql->getCourseName($course_num, false)
         . '</a></li>';
    if(!is_null($quiz_num)) {
        $ret .= '<li class="breadcrumb-item"><a href="./detail.php?c='.$course_num.'&n='.$quiz_num.'">'
              . $ql->getQuizName($course_num, $quiz_num, false)
              . '</a></li>';
    }
    return $ret;
}

function make_progress_bar($now, $max, $text = false) {
	if($max == 0) {
	    $len_percent = 0;
    }else{
	    $len_percent = floor($now / $max * 100);
	}
	if(!$text) $text = $len_percent. '%';
	$ret = '<div class="progress">'
         . '<div class="progress-bar" role="progressbar" style="width: '.$len_percent.'%;">'.$text.'</div>'
         . '</div>';
    return $ret;
}
