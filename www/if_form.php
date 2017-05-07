<?php
require_once('../lib/init.php');
$ql = new QuizLoader();
$course_num = $_GET['c'];
$quiz_num = $_GET['n'];

//エラー時の戻り用
$src = isset($_POST['src']) ? $_POST['src'] : '';

//前回のプログラムを復元ボタン
$is_revert = isset($_POST['revert']) ? $_POST['revert'] : '';
if($is_revert) {
    $st = new StatusManager();
    $st->load($course_num);
    $src = $st->getSource($quiz_num);
}
?>
<html>
<head>
<?php include('../tpl/header.php'); ?>
<style>
body {
	width: 100%;
}
#editor {
    width:  100%;
    height: 500px;
}
</style>
</head>
<body>

<form action="if_form.php<?php echo make_query_string($course_num, $quiz_num); ?>" method="post">
    <input type="submit" class="btn btn-info" name="submit" value="前回のプログラムを復元">
	<button type="button" class="btn btn-info" data-toggle="button" id="btn_autobehaviour" autocomplete="false">括弧閉じの自動入力</button>
	<input type="hidden" name="revert" value="1">
    <input type="hidden" name="c" value="<?php echo $course_num; ?>">
    <input type="hidden" name="n" value="<?php echo $quiz_num; ?>">
</form>

<form action="if_compile.php<?php echo make_query_string($course_num, $quiz_num); ?>" method="post">
    <div id="editor"><?php echo htmlspecialchars($src); ?></div>

    <br>

    <input type="hidden" id="src" name="src" value="">

    <input id="submit_btn" type="submit" class="btn btn-primary" name="submit" value="提出">
</form>

<script src="ace/ace.js"></script>
<script>
editor = ace.edit("editor");
editor.getSession().setUseWrapMode(true);
editor.setFontSize(14);
editor.getSession().setMode("ace/mode/c_cpp");
editor.setBehavioursEnabled(false);

$('#submit_btn').click(function() {
    $('#src').val(editor.getSession().getValue());
});
$('#btn_autobehaviour').click(function() {
	editor.setBehavioursEnabled(!editor.getBehavioursEnabled());
});
</script>

</body>
</html>
