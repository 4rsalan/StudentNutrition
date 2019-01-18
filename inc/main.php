<?php
//This file contains the main interface for the web application
include 'functions.php';
if (empty($_GET['page'])){
    $page = 1;
}
elseif ($_GET['page'] > $GLOBALS['numPages']){
    $page = $GLOBALS['numPages'];
}
else{
    $page = $_GET['page'];
}
if (!empty($_SESSION['message'])){
    $message  = $_SESSION['message'];
    echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">$message
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>";
    $_SESSION['message'] = "";
}
else{
    $_SESSION['message'] = "";
}
?>

<div class="container mt-2">
    <div class="buttonsBox">
    <nav aria-label="" class="navbar">
        <form method="get">
        <ul class="pagination">
            <?php
            if (isset($_GET['search'])){
                echo "<a href='index.php' class='btn btn-primary'><li>Back to main page</li></a>";
            }
            else {
                createButtons($page);
            }
            ?>
        </ul>
        </form>
        <form method="post" action="csvMod.php">
        <ul class="pagination">
            <li><button class="btn btn-primary mr-2" name="add" value="add" type="submit">Add New Entry</button></li>
            <li><a class="btn btn-dark" href="csvMain.csv" download>Export CSV</a></li>
            <li><button class="btn btn-info ml-2" type="submit" name="upload">Import CSV</button></li>
        </ul>
        </form>
        <form class="form-inline my-2 my-lg-0" method="get" action="index.php">
            <ul class="pagination">
                <li><input class="form-control mr-sm-2" type="search" placeholder="Search by Title" aria-label="Search" name="search"></li>
                <li><button class="btn btn-success my-2 my-sm-0" type="submit">Search</button></li>
            </ul>
    </nav>
    </div>
<div class="row">
    <?php
        if (isset($_GET['search'])){
            echo "<form></form>";
        createSearchElements($_GET['search']);
        }
        else {
            echo "<form></form>";
            createCsvElements($page);
        }
    ?>
</div>
</div>
<a href="/folder_view/vs.php?s=<?php echo __FILE__?>" target="_blank">View Source</a>