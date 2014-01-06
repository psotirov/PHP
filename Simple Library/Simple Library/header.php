<!DOCTYPE html>
<html>
<head>
    <title><?= $pageTitle;?></title>
    <meta charset="UTF-8">
    <style>
        body { width:100% }
        #wrapper {
            width:80%;
            margin:20px auto;
            border:1px solid black;
            text-align:center;
        }
        #content { padding:20px; }
        table { margin:0 auto; } 
    </style>
</head>
<body>
<div id="wrapper">
    <h2><?= $pageTitle;?></h2><hr />
    <div id="content">
<?php
session_start();        
if (isset($_SESSION['logged']) && $_SESSION['logged']) {
    echo '<h4>User logged in as '. $_SESSION['username'];
    echo '&nbsp;<a href="login.php?logout=1">Logout</a><h4>';        
} else if  ($pageTitle!='Login form') {
    echo '<h4><a href="login.php">Login</a></h4>';
}

$con = 0;
// global functions
function queryDatabase(&$con, $query) {
    if (!$con) {
        $con = mysqli_connect("localhost","root", "", "books") or die("No connection to database");
        mysqli_set_charset($con, "utf8");
    }
    $result = mysqli_query($con, $query);
    return $result;
}

function isValid($text) {
    return preg_match("/^[a-zà-ÿ-!?,\s\(\)0-9]+$/i", $text); // case insesitive check if string contains only alphanumerics, space, brackets, ! and ? 
}
?>
