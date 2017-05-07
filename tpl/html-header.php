<div id="container">

<header>

<h1><a href="./">OpenPCK</a></h1>

<?php if(isset($_SESSION['userid'])) { ?>
<section id="userinfo">
    ユーザＩＤ：<?php echo $_SESSION['userid']; ?>

<a href="logout.php">ログアウト</a>
</section>
<?php } ?>

<div class="clear"></div>

<?php /*
<ul id="menu">
    <li>TOP</li>
    <li>前</li>
</ul>
*/ ?>

<div class="clear"></div>

<?php if(!empty($subtitle)) { ?>
<h2><?php echo $subtitle; ?></h2>
<?php } ?>

</header>

<section id="contents">
