<?php
require_once('../lib//functions.php');
session_start();

$is_auth = isset($_POST['auth']);
if($is_auth) {
    $user = new User();
    $user->userid = $_POST['userid'];
    $user->password = $_POST['password'];

    $login_ok = false;
    if($config['auth_type'] == 'file') {
        $login_ok = $user->auth_from_text('../userdata/passwd.txt');
    }else{
        $login_ok = $user->auth_from_ldap($config['ldap_host'], $config['ldap_domain_name']);
    }
    if($login_ok) {
        $_SESSION['userid'] = $_POST['userid'];
        redirect_to('index.php');
    }else{
        unset($_SESSION['userid']);
    }
}

?>
<html>
<head>
<?php include('../tpl/header.php'); ?>
</head>
<body>
<div class="container">
<?php include('../tpl/html-header.php'); ?>

<?php if($is_auth) { ?>
<p>パスワードが違います</p>
<?php } ?>

<form action="login.php" method="post" class="navbar-form navbar-left" style="font-family:monospace">
	<div class="input-group">
		<span class="input-group-addon">&nbsp;&nbsp;ユーザ&nbsp;&nbsp;</span><input class="form-control" type="text" name="userid">
    </div>
	<div style="clear:both; margin-top: 20px;"></div>
	<div class="input-group">
		<span class="input-group-addon">パスワード</span><input class="form-control" type="password" name="password">
    </div>
	<div style="clear:both; margin-top: 20px;"></div>
	<input  class="btn btn-primary" id="login_btn" type="submit" name="submit" value="ログイン">
    <input type="hidden" name="auth" value="1">
</form>

</div>
</body>
</html>
