<?php
//Page which allows the user to log in parsing a text file for the correct user information
@session_start();
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sign In</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/signin.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body class="sky">

<div class="text-center">
    <form method="post" action="userHandler.php">
        <h2>Log in</h2>
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Username" name="username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password"required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Log In</button>
        <a class="btn btn-danger btn-block" href="../index.php">Go Back</a>
    </form>
    <?php
    echo $_SESSION['message'];
    $_SESSION['message'] = "";

    ?>
    <hr id="link">
</div>
<a href="/folder_view/vs.php?s=<?php echo __FILE__?>" target="_blank">View Source</a>
</body>
</html>
<script>
    var anchors = document.querySelectorAll("a[href^='/folder'");
    var handler = document.createElement("a");
    handler.text = "userHandler";
    handler.href = "http://f8144384.gblearn.com/folder_view/vs.php?s=/home/f8144384/public_html/comp1230/assignment/assignmentOne/inc/userHandler.php";
    handler.target = "_blank";
    handler.classList.add("dropdown-item");

    dropdownContainer = document.getElementById("link");
    for (var i = 0; i < anchors.length; i++){
        var a = anchors[i].href;
        anchors[i].classList.add("dropdown-item");
        anchors[i].text = a.substring(a.length - 15, a.length);
        dropdownContainer.appendChild(anchors[i]);
    }
    dropdownContainer.appendChild(handler);
</script>
