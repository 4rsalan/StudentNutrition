<?php
include "functions.php";
@session_start();
//Script which handles the processing for the CRUD operations retrieving requests from the csvMod.php file

//Request which handles adding an entry
if(isset($_POST['addEntry']))
{
    $school = filter_input(INPUT_POST,"School_Name");
    $address = filter_input(INPUT_POST, "Address");
    $city = filter_input(INPUT_POST, "City_Town");
    $areaCode = filter_input(INPUT_POST, "Postal_Code");
    $board = filter_input(INPUT_POST, "School_Board");
    $schoolId = filter_input(INPUT_POST, "School_ID");
    $breakfast = filter_input(INPUT_POST, "Breakfast");
    $lunch = filter_input(INPUT_POST, "Lunch");
    $snack = filter_input(INPUT_POST, "Snack");

    $output = "$school,$address,$city,$areaCode,$board,$schoolId,$breakfast,$lunch,$snack".PHP_EOL;

    $file = fopen("../csvMain.csv", 'a');
    fwrite($file, $output);
    fclose($file);

    $_SESSION['message'] = "You have added a new entry into the system";
    redirect("../index.php");
}

//Request which handles deleting an entry
elseif(isset($_POST['yesDelete'])){
    $file_name = "../csvMain.csv";
    $id = $_POST['yesDelete'];

    $file = file($file_name);
    unset($file[$id]);
    file_put_contents($file_name, implode("", $file));

    $_SESSION['message'] = "Entry #$id was deleted successfully";
    redirect("../index.php");
}

//Request which handles editing an entry
elseif(isset($_POST['editEntry'])){
    $id = $_POST['editEntry'];
    $file_name = "../csvMain.csv";

    $school = filter_input(INPUT_POST,"School_Name");
    $address = filter_input(INPUT_POST, "Address");
    $city = filter_input(INPUT_POST, "City_Town");
    $areaCode = filter_input(INPUT_POST, "Postal_Code");
    $board = filter_input(INPUT_POST, "School_Board");
    $schoolId = filter_input(INPUT_POST, "School_ID");
    $breakfast = filter_input(INPUT_POST, "Breakfast");
    $lunch = filter_input(INPUT_POST, "Lunch");
    $snack = filter_input(INPUT_POST, "Snack");

    $output = "$school,$address,$city,$areaCode,$board,$schoolId,$breakfast,$lunch,$snack".PHP_EOL;
    $file = file($file_name);
    $file[$id] = $output;

    file_put_contents($file_name, implode("", $file));

    $_SESSION['message'] = "Entry #$id was edited successfully";
    redirect("../index.php");
}

//Request which handles importing a CSV file to the server
elseif(isset($_POST['uploadFile'])){
    $currentDir = getcwd();
    $uploadDirectory = "/../";

    $file_name = $_FILES['newFile']['name'];
    $fileSize = $_FILES['newFile']['size'];
    $fileTmpName  = $_FILES['newFile']['tmp_name'];
    $fileExtension = pathinfo($file_name, PATHINFO_EXTENSION);
    $uploadPath = $currentDir . $uploadDirectory . "csvMain.csv";

        if ($fileExtension != "csv") {
            $_SESSION['message'] = "This file extension is not allowed. You must upload a CSV file";
            redirect("../index.php");
        }
        elseif ($fileSize > 4000000) {
            $_SESSION['message'] = "This file is greater than 4MB. Please upload a smaller file";
            redirect("../index.php");
        }
        else {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) {
                $_SESSION['message'] = "The file has been uploaded successfully";
                redirect("../index.php");
            } else {
                $_SESSION['message'] = "The file did not upload correctly";
            }
        }
}

//Request which redirects users to the home page
elseif(isset($_POST['goToHome'])){
    header("Location: ../index.php");
}
else{
    echo "The file was not submitted correctly";
}
?>
<a href="/folder_view/vs.php?s=<?php echo __FILE__?>" target="_blank">View Source</a>

