<?php
require_once('../lib/init.php');

$ql = new QuizLoader();

$course_num = $_GET['c'];
$quiz_num   = $_GET['n'];
$src        = $_POST['src'];

//アップロードされたソースを保存
$filename = $ql->getUserDir() . '/' . $course_num . '-' . $quiz_num . '-src.c';
file_put_contents($filename, $src);

$status = new StatusManager();
$status->load($course_num);

$compiler = new CompilerC();
$exe_file = $compiler->compile($filename);

if(empty($compiler->err)) {
    $tester = new Tester();
    $tester->test_dir = $ql->getQuizDir($course_num, $quiz_num);
    $tester->course_num = $course_num;
    $tester->quiz_num = $quiz_num;
    $tester->exe = $exe_file;
    if($tester->start()) {
        $status->setStatus($quiz_num, 'ok');
    }else{
        $status->setStatus($quiz_num, 'ng');
    }
}else{
    $status->setStatus($quiz_num, 'err');
}
$status->write();

$is_success = false;

?>
<html>
<?php include('../tpl/header.php'); ?>
</head>
<body>

    <?php if(!empty($compiler->err)) { ?>
        <h2>コンパイルエラー</h2>
        <pre>
        <?php echo htmlspecialchars($compiler->err); ?>
        </pre>
    <?php }else{ ?>
        <h2>提出しました</h2>
        <pre>
        <?php
          $is_success = ($tester->test_result['ng'] > 0) ? false : true;
          if($is_success) {
              echo '<img class="status_icon" src="img/ok.png">正解です';
          }else{
              echo '<img class="status_icon" src="img/error.png">実行結果に誤りがあります';
          }
        ?>
        </pre>
    <?php } ?>

    <?php if(!$is_success) { ?>
        <form action="if_form.php<?php echo make_query_string($course_num, $quiz_num); ?>" method="post">
            <input type="hidden" name="src" value="<?php echo htmlspecialchars($src); ?>">
            <input type="submit" class="btn btn-info" value="戻る">
        </form>
    <?php }else{ ?>
			<a href="#">問題一覧に戻る</a>
    <?php } ?>


</body>
</html>
