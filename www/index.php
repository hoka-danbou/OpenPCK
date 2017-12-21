<?php
require_once('../lib/init.php');

function make_questions_table() {
    $html = '';
    $ql = new QuizLoader();
    $courses = $ql->getCourses();

    $st = new StatusManager();
    $st->username = $_SESSION['userid'];
    foreach($courses as $course) {
        $num     = substr($course,0,2);
        $status  = $st->load($num);
        if(!$status) {
            $status_text = make_progress_bar(0,0,'&nbsp;');
        }else{
            $summary = $st->getSummary();
			$total = count($ql->getQuizList($num));
            $status_text = make_progress_bar($summary['ok'] , $total, $summary['ok'].'/'.$total);
        }
            
        $html .= '<a href="./quiz_list.php?c='.$num.'">'
               . '<h3>'.$course.'</h3><br>'
               . $status_text.'</a></td>';
    }
    return $html;
}

?>
<html>
<head>
<?php include('../tpl/header.php'); ?>
</head>
<body>
<?php include('../tpl/html-header.php'); ?>

<div class="list-group">
<h2>コース一覧</h2>
<?php echo make_questions_table(); ?>
</div>

<?php include('../tpl/html-footer.php'); ?>
