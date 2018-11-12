<?php
//Page which handles all CRUD operations and generates a page according to the HTTP request
@session_start();
include 'inc/header.php';
include 'inc/nav.php';
include 'inc/functions.php';
?>
<div class="container">
    <div class="row">
    <?php
    $file_name = 'csvMain.csv';
    $newCsv = file($file_name);
    authorizeCheck();

//Request which generates a page to take inputs for adding a new entry to the system
    if (isset($_POST['add'])) {
        $sortedFile = explode(',', $newCsv[0]);
        $inputs = "";

        echo "<div class='col-lg-6'>
        <form method=\"post\" action='inc/addProcess.php'>";
        for ($i = 0; $i < count($sortedFile); $i++) {
            $inputs .= $sortedFile[$i] . "<br> <input type=\"text\" name=\"$sortedFile[$i]\"><br>";
        }

        echo "<div class=\"\">
        <div class=\"card\">
            <div class=\"card-body\">
                $inputs
                <div class=' mt-1 mb-1'>
                <input type=\"submit\" class=\"btn btn-primary\" name='addEntry'>
                <input type=\"submit\" class=\"btn btn-danger\" name='goToHome' value='Go Back'>  
                </div>              
            </div>
        </div>
    </div>
    </form>
    </div>";

        $infoCard = generateGenericCard("Adding a new Entry","Please enter all the information to add a new entry to the CSV file. For the Breakfast, 
                Lunch and Dinner categories please put either Yes or No." ,6);
        echo $infoCard;
    }

//Request which generates a page to take inputs for editing an entry in the system
    elseif(isset($_POST['edit'])){
    $id = $_POST['edit'];
    $sortedFile = explode(',', $newCsv[0]);
    $sortedFileValues = explode(",", $newCsv[$id]);
    $inputs= "";

    echo "<div class='col-lg-6'>
            <form method='post' action='inc/addProcess.php'>";
        for ($i = 0; $i < count($sortedFile); $i++) {
            $inputs .= $sortedFile[$i] . "<br> <input type=\"text\" name=\"$sortedFile[$i]\" value='$sortedFileValues[$i]'><br>";
        }

        echo "
        <div class=\"card\">
            <div class=\"card-body\">
                $inputs
                <button type=\"submit\" class=\"btn btn-primary mt-1 mb-1\" name='editEntry' value='$id'>Submit</button>
                <input type=\"submit\" class=\"btn btn-danger mt-1 mb-1\" name='goToHome' value='Go Back'>                
            </div>
    </div>
    </form>
    </div>
    ";
    echo generateGenericCard("Editing CSV Entry #: $id","Please modify whatever information needed and press submit", 6);

    }

//Request which generates a page to take inputs for deleting an entry in the system
    elseif(isset($_POST['delete'])){
    $id = $_POST['delete'];

        $infoCard = "<div class='col-lg-12 mb-5'>
        <div class=\"card\">
        <h5 class='card-title mx-auto'>Deleting Cards</h5>
            <div class=\"card-body mx-auto\">
                <p>Are you sure you want to delete the card below?</p>
            <div class='mx-auto'>
            <form method='post' action='inc/addProcess.php'>
            <ul class=>
            <div class='col-lg-12'>
            <button class='btn btn-primary btn-block' type='submit' name='yesDelete' value='$id'>Yes</button>
            <button class='btn btn-danger btn-block' type='submit' name='goToHome' value='$id'>No</button></div>
            </ul>
            </form>
            </div>
            </div>
        </div>
    </div>";

    $card = generateCsvCard($id);

    echo $infoCard;
    echo $card;

    }

    //Request which generates a page to upload a CSV file to the system
    elseif(isset($_POST['upload'])){

        $infoCard = "<div class='col-lg-12 mb-5'>
        <div class=\"card\">
        <h5 class='card-title mx-auto'>Importing new CSV</h5>
            <div class=\"card-body mx-auto\">
                <p>Please upload a CSV File</p>
            <div class='mx-auto'>
    <form action=\"inc/addProcess.php\" method=\"post\" enctype=\"multipart/form-data\">
    <br>
        <input type=\"file\" name=\"newFile\" id=\"newFile\">
        <input type=\"submit\" name=\"uploadFile\" value=\"Upload\" class='btn btn-primary'>
    </form>
            </div>
            </div>
        </div>
    </div>";

        echo $infoCard;
    }
    else{
        $_SESSION['message'] = "ERROR invalid procedure. Please log in and try again";
        redirect("../index.php");
    }
    ?>
</div>
</div>
<a href="/folder_view/vs.php?s=<?php echo __FILE__?>" target="_blank">View Source</a>
<?php include 'inc/footer.php'; ?>
<script>
    var anchors = document.querySelectorAll("a[href^='/folder'");
    var addProcess = document.createElement("a");
    addProcess.text = "addProcess";
    addProcess.href = "http://f8144384.gblearn.com/folder_view/vs.php?s=/home/f8144384/public_html/comp1230/assignment/assignmentOne/inc/addProcess.php";
    addProcess.target = "_blank";
    addProcess.classList.add("dropdown-item");
    dropdownContainer = document.getElementById("dropdownMenu");
    for (var i = 0; i < anchors.length; i++){
        var a = anchors[i].href;
        anchors[i].classList.add("dropdown-item");
        anchors[i].text = a.substring(a.length - 15, a.length);
        dropdownContainer.appendChild(anchors[i]);
    }
    dropdownContainer.appendChild(addProcess);
</script>