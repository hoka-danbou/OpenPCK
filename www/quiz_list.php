<?php
require_once('../lib/init.php');

$course_num = sprintf('%02d', intval($_GET['c']));

function make_quizzes_table() {
    global $course_num;

    $html = '';
    $ql = new QuizLoader();
    $items = $ql->getQuizList($course_num);
    $stm = new StatusManager();
    $stm->username = $_SESSION['userid'];
    $st = $stm->load($course_num);
    $i = 0;
    foreach($items as $item) {
        $num = substr($item,0,2);
        $name = substr($item, 3);
        $status = array_key_exists($num, $st) ? $st[$num]['status'] : '';
		$status_msg = get_msg('answer_status',$status);
		$status_icon = ($status == 'ok') ? '<img style="height: 20px; " src="img/good.png">' : '';


        $html .= '<tr>'
               . '<td>'.$num.'</td>'
               . '<td><a href="./detail.php?c='.$course_num.'&n='.$num.'">'.$name.'</a></td>'
               . '<td>'.$status_icon.$status_msg.'</td>'
               . '</tr>';
        $i++;
    }
    return $html;
}

function get_title() {
    global $course_num;

    $ql = new QuizLoader();
    return $ql->getCourseName($course_num, false);
}

?>
<html>
<head>
<?php include('../tpl/header.php'); ?>
</head>
<body>
<?php include('../tpl/html-header.php'); ?>
<ol class="breadcrumb">
    <?php echo make_breadcrumb($course_num); ?>
</ol>

<table id="questions" class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>問題</th>
            <th>回答状況</th>
        </tr>
    </thead>
    <tbody>
        <?php echo make_quizzes_table(); ?>
    </tbody>

</table>

<?php include('../tpl/html-footer.php'); ?>
