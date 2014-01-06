<?php
    session_start();
    if(!isset($_SESSION['logged']) ||
       !isset($_GET['bookid']) ||
       !$_SESSION['logged'] ||
       !$_GET['bookid']) {
        header("Location: index.php"); // redirect back to index page
    }
    
    $bookid = intval($_GET['bookid']);
    if(isset($_POST['upload'])) { // user uploading the selected message
        $content = (isset($_POST['content']))?htmlspecialchars($_POST['content']):'';
        $con = mysqli_connect("localhost","root", "", "books");
        if ($con && strlen($content)) {
            mysqli_set_charset($con, "utf8");
            // check if username exists
            $insertQuery = "INSERT INTO comments (user_id,book_id,text) VALUES ("
                .$_SESSION['userid'].", "
                .$bookid.", '"
                .mysqli_real_escape_string($con, $content)."');";
            if(mysqli_query($con, $insertQuery)){
                header("Location: book-details.php?bookid=".$bookid); // redirect back to book details page
            } else {
                echo "<p>Error on comment uploading</p>";
            }
        } else { // no connection to database error
            echo "<p>Empty string or No connection to database</p>";
        }
    }

    $pageTitle='Book comment form';
    include 'header.php';
?>
<form method="POST">
    <label for="contentId">Your comment:</label>
    <textarea id="contentId" name="content">Enter comment here</textarea><br /><br />
    <input type="submit" name="upload" value="Upload comment" />
</form>
<?php
    include 'footer.php';
?>