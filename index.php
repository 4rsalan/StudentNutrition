<!-- File which is a wrapper for all php files in the web application -->
<?php @session_start();
?>
<?php include 'inc/header.php'; ?>
<?php include 'inc/nav.php'; ?>
<?php include 'inc/main.php'; ?>
<?php include 'inc/footer.php'; ?>
<a href="/folder_view/vs.php?s=<?php echo __FILE__?>" target="_blank">View Source</a>
<!-- Script to populate any page sources into a dropdown -->
<script>
    var anchors = document.querySelectorAll("a[href^='/folder'");
    dropdownContainer = document.getElementById("dropdownMenu");
    for (var i = 0; i < anchors.length; i++){
        var a = anchors[i].href;
        anchors[i].classList.add("dropdown-item");
        anchors[i].text = a.substring(a.length - 15, a.length);
        dropdownContainer.appendChild(anchors[i]);
    }
</script>