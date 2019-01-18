<?php
// Script which handles the processing for registering and logging in as well as logging out
@session_start();
include 'functions.php';
$file_name = "../users.txt";

if (!isset($_POST['logout'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
}

if (isset($_POST['createAccount'])){
    $output = $username.",".$password.PHP_EOL;
    registerProcess($file_name, $username, $output, "register.php", "../index.php");
}
elseif (isset($_POST['login'])){
    loginProcess($file_name, $username, $password, "login.php", "../index.php");
}
elseif (isset($_POST['logout'])){
    unset($_SESSION['isLoggedIn']);
    $_SESSION['message'] = "You have logged out";
    redirect("../index.php");
}
else{
    redirect("../index.php");
}

?>
<a href="/folder_view/vs.php?s=<?php echo __FILE__?>" target="_blank">View Source</a>
