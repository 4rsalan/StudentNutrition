<?php
@session_start();
//File containing functions that are used in the web application
$file_name = 'csvMain.csv';
$file = file($file_name) or die("The file could not be found");
$numCsvEntries = count($file);
$numEntriesPerPage = 20;
$numPages= getMaxPage($numEntriesPerPage);

//Function which generates the CSV cards for the entered page value
function createCsvElements($pageNum){

    $end = round($pageNum*$GLOBALS['numEntriesPerPage']);
    $start = round($end - $GLOBALS['numEntriesPerPage'] + 1);

    if ($end > $GLOBALS['numCsvEntries']){
        $end = $GLOBALS['numCsvEntries'] -1;
        $start = $end - $GLOBALS['numEntriesPerPage'] + 1;
    }

    for ($i = $start; $i <= $end; $i++){
     $csvCard = generateCsvCard($i);
    echo $csvCard;
    }
}
//Function which creates the elements retrieved from the search bar
function createSearchElements($query){
    $file_name = 'csvMain.csv';
    $file = file($file_name);

    for ($i = 1; $i < count($file); $i++){
        $sortedFile = explode(',', $file[$i]);
        if (stripos($sortedFile[0], $query) !== false){
            echo generateCsvCard($i);
        }
    }
}
//Function which creates the buttons to traverse through the CSV array
function createButtons($pageNum){
    $lastPageNum = $GLOBALS['numPages'];
    $nextValue = $pageNum+1;
    $previousValue = $pageNum-1;
    $btnValPlus2 = $pageNum+2;
    $btnValMinus2 = $pageNum-2;

    $previous = "<li class=\"page-item\"><button class=\"page-link\" type=\"submit\" name=\"page\" value=\"$previousValue\">$previousValue</button></li>";
    $next = "<li class=\"page-item\"><button class=\"page-link\" type=\"submit\" name=\"page\" value=\"$nextValue\">$nextValue</button></li>";
    $btnPlus = "<li class=\"page-item\"><button class=\"page-link\" type=\"submit\" name=\"page\" value=\"$btnValPlus2\">$btnValPlus2</button></li>";
    $btnMinus = "<li class=\"page-item\"><button class=\"page-link\" type=\"submit\" name=\"page\" value=\"$btnValMinus2\">$btnValMinus2</button></li>";
    $last = "<li class=\"page-item\"><button class=\"page-link\" type=\"submit\" name=\"page\" value=\"$lastPageNum\">>></button></li>";
    $first = "<li class=\"page-item\"><button class=\"page-link\" type=\"submit\" name=\"page\" value=\"1\"><<</button></li>";
    $current = "<li class=\"page-item active\"><button class=\"page-link\" type=\"submit\" name=\"page\" value=\"$pageNum\">$pageNum</button></li>";


    if ($pageNum >= $GLOBALS['numPages']){
        echo $first.$btnMinus.$previous.$current;
    }
    elseif ($pageNum > 1){
        echo $first.$previous.$current.$next.$last;
    }

    if ($pageNum <= 1){
        echo $current.$next.$btnPlus.$last;
    }
}
//Function which calculates returns the maximum number of CSV cards to display onto the page
function getMaxPage($csvPerPage){
    $sum = $GLOBALS['numCsvEntries']/$csvPerPage;
    $roundSum = round($sum);

    if ($sum > $roundSum){
        $maxPages = $roundSum + 1;
    }
    else{
        $maxPages = $roundSum;
    }

    return $maxPages;
}
//Function which adjusts the value of the Breakfast, Lunch and Snack values depending on what was initially entered
function getFood($foodOption){

    if ($foodOption === "Yes" || "yes"){
       $val = $foodOption;
    }
    elseif(trim($foodOption) === "" || is_null($foodOption) || empty($foodOption)){
        $val = "No";
    }
    else {
        $val = $foodOption;
    }
    return $val;
}
//Function which generates a generic CSV Card used to display information
function generateGenericCard($header, $information, $columnSizeNum){
    $card = "<div class='col-lg-$columnSizeNum'>
        <div class=\"card\">
        <h5 class='card-title mx-auto'>$header</h5>
            <div class=\"card-body mx-auto\">
                <p>$information</p>
            </div>
        </div>
    </div>";

    return $card;
}
//Function which generates an individual CSV card depending on the specific array index in the CSV array
function generateCsvCard($index){
    $file_name = 'csvMain.csv';
    $file = file($file_name);

    $sortedFile = explode(',', $file[$index]);
    $description = "$sortedFile[1], $sortedFile[2], Ontario, $sortedFile[3]";
    $breakfast = getFood($sortedFile[6]);
    $lunch = getFood($sortedFile[7]);
    $snack = getFood($sortedFile[8]);

    $card = "<div class=\"col-sm-4 col-md-3 mx-auto\">
        <div class=\"card\">
            <div class=\"card-body\">             
                <h5 class=\"card-title\">$sortedFile[0]
                    <br>
                    <small class=\"text-muted\">$description</small>
                </h5>
                <p class=\"card-text\"> $sortedFile[4]</p>
                <p class='card-text'>School ID: $sortedFile[5]</p>
                <p><small class='text-muted'>ID#: $index</small></p>
            </div>
            <div class=\"card-footer text-muted mb-2\">
                Breakfast: <b>$breakfast</b> <br>
                Lunch: <b>$lunch</b> <br>
                Snack: <b>$snack</b>
                <form method='post' action='csvMod.php'>
                <div class='mt-2'>
                <button class='btn btn-danger btn-block mb-1' name='delete' value='$index'>Delete Card</button>
                <button class='btn btn-secondary btn-block' name='edit' value='$index'>Edit Card</button>  
                </div>
                </form>
            </div>
        </div>
    </div>";

    return $card;
}
//Function which determines if the user is logged in or not
function isLoggedIn(){
    if (isset($_SESSION["isLoggedIn"])){
        return 1;
    }
    return 0;
}

function redirect($url){
    echo "<script type='text/javascript'>
           window.location.replace('$url');
      </script>";
}

//Checks to see if a user is logged in and if they aren't, relocates them to the homepage and displays a warning message
function authorizeCheck(){
    if (isLoggedIn() === 0){
        $_SESSION['message'] = "You must be logged in to use this feature";
        redirect("index.php");
    }
    else{
        $_SESSION['message'] = "";
    }
}

//Parses through a text file checks to see if a user's username exists by matching an inputted username value
function doesUsernameExist($usersFile, $username){
    for ($i = 0; $i < count($usersFile); $i++) {
        $line = $usersFile[$i];
        $lineArray = explode(",", $line);
        $user = $lineArray[0];
        if($username === $user){
            return true;
        }
    }
    return false;
}

//Function which parses a text file to see if a username and password combination exist for a user
function doesUserAndPassExist($usersFile, $username, $password){
    for ($i = 0; $i < count($usersFile); $i++) {
        $line = $usersFile[$i];
        $lineArray = explode(",", $line);
        $user = $lineArray[0];
        $pass = $lineArray[1];
        if($username === $user && trim($password) === trim($pass)){
            return true;
        }
    }
    return false;
}

//Function which processes a request to register a new username into the system
function registerProcess($file_name, $username,$output, $failAddress, $correctAddress){
    $usersFile = file($file_name) or die("Unable to locate file");

    if (doesUsernameExist($usersFile, $username)){
        $_SESSION['message'] = "There is already an account with that username in the system";
        redirect($failAddress);
    }
    else{
        $fileAdd = fopen($file_name, "a");
        fwrite($fileAdd, $output) or die("Unable to locate file");
        fclose($fileAdd);
        $_SESSION['message'] = "You have registered a new account";
        redirect($correctAddress);
    }
}

//Functions which processes a request to log in to the system
function loginProcess($file_name, $username, $password, $failAddress, $correctAddress){
    $usersFile = file($file_name) or die("Unable to locate file");

    if (doesUserAndPassExist($usersFile, $username, $password)){
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['message'] = "You have logged in";
        redirect($correctAddress);
    }
    else{
        $_SESSION['message'] = "Account information entered incorrectly or it does not exist";
        redirect($failAddress);
    }
}
?>
<a href="/folder_view/vs.php?s=<?php echo __FILE__?>" target="_blank">View Source</a>

