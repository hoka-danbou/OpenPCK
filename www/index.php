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
            
        $html .= '<tr>'
               . '<td><a href="./quiz_list.php?c='.$num.'">'.$course.'</a></td>'
               . '<td>'
               . $status_text
               .'</td>'
               . '</tr>';
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

<table id="questions" class="table table-striped">
    <thead>
        <tr>
            <th>コース</th>
            <th>回答状況</th>
        </tr>
    </thead>
    <tbody>
        <?php echo make_questions_table(); ?>
    </tbody>

</table>

<?php include('../tpl/html-footer.php'); ?>
