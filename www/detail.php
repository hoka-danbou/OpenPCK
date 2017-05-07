<?php
require_once('../lib/init.php');
$course_num = $_GET['c'];
$quiz_num   = $_GET['n'];

$ql = new QuizLoader();
$dir = $ql->getQuizDir($course_num, $quiz_num);

?>
<html>
<head>
<?php include('../tpl/header.php'); ?>
<style>
#question, #src_form {
	width: 50%;
	float:left;
}
iframe {
	width: 98%;
	height: 700px;
	border: 0;
	border-left: 1px solid gray;
	padding-left: 5px;
}

</style>

</head>
<body>
<?php include('../tpl/html-header.php'); ?>

<ol class="breadcrumb">
    <?php echo make_breadcrumb($course_num, $quiz_num); ?>
</ol>

<div class="clear"></div>

<div id="question">
<?php if(file_exists($dir.'/mondai.pdf')) { ?>
  <object class="pdf" data="./pdf.php?c=<?php echo $course_num; ?>&n=<?php echo $quiz_num; ?>" type="application/pdf"></object>
<?php }elseif(file_exists($dir.'/mondai.html')) { ?>
  <?php include($dir.'/mondai.html'); ?>
<?php }elseif(file_exists($dir.'/mondai.jpg')) { ?>
  <img src="<?php echo $dir.'/mondai.jpg'; ?>">
<?php }elseif(file_exists($dir.'/mondai.txt')) { ?>
  <pre><?php include($dir.'/mondai.txt'); ?></pre>
<?php } ?>
</div>

<div id="src_form">
<iframe src="if_form.php?c=<?php echo $course_num; ?>&n=<?php echo $quiz_num; ?>">
</div>

<form target="src_form" action="if_form.php?c=<?php echo $course_num; ?>&n=<?php echo $quiz_num; ?>" method="post">
    <input id="src_form_open" data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit" name="submit" value="回答する">
</form>



<script>
$('#src_form_open').click(function() {
	$('#myModal').show();
});
</script>


<?php include('../tpl/html-footer.php'); ?>
