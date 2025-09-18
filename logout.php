<?php
// [file name]: logout.php
session_start();
include("includes/config.php");
$_SESSION['login'] = "";
$_SESSION['userid'] = "";
$_SESSION['utype'] = "";
session_unset();
session_destroy();
?>
<script language="javascript">
    document.location = "index.php";
</script>