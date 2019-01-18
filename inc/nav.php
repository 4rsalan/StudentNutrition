<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">COMP1230 Assignment One</a>
    <div class="dropdown">
        <button class="btn nav-link btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            View Source Links
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdownMenu">
        </div>
    </div>
    <form action="inc/userHandler.php" method="post" class="ml-auto">
    <ul class="nav navbar-nav ml-auto">
        <?php
        if (isset($_SESSION["isLoggedIn"])){
            echo "<li><button class='btn nav-link btn-link' name='logout' value='logout'><span></span> Log Out</button></li>";
        }
        else{
            echo "<li><a href=\"inc/register.php\" class=\"nav-link\"><span></span> Register</a></li>
        <li><a href=\"inc/login.php\" class=\"nav-link\"><span></span> Login</a></li>";
        }
        ?>
    </ul>
    </form>
</nav>
<a href="/folder_view/vs.php?s=<?php echo __FILE__?>" target="_blank">View Source</a>