<?php
    mb_internal_encoding('UTF-8');
    if(!isset($_GET['bookid']) ||
       !$_GET['bookid']) {
        header("Location: index.php"); // redirect back to index page - invalid book id
    }
     
    $pageTitle='Book details and commnents';
    include 'header.php';    
    $username = isset($_SESSION['username'])?$_SESSION['username']:0;    
    $bookid = intval($_GET['bookid']);
?>
<table border="1" style="border-collapse:collapse;">
    <tr><th>Date</th><th>User</th><th>Comment</th></tr>
<?php
    $idx = 0;
    $query = "SELECT * FROM comments AS c LEFT JOIN users AS u ON c.user_id = u.id WHERE c.book_id = ".$bookid." ORDER BY c.time DESC";
    $result = queryDatabase($con, $query);
    if ($result && mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><td>'.$row['time'].'</td><td>'
                .$row['username'].'</td><td>'
                .$row['text'].'</td></tr>';
            $idx++;                
        }
    }    
?>
    <tr><td colspan="4">Total <?= $idx ?> comments</td></tr>
</table>
<?php
    if($username) { // user is logged in - can post comment
        echo '<h4><a href="new-comment.php?bookid='.$bookid.'">Post new comment</a></h4>';
    }
    
    include 'footer.php';
?>