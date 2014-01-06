<?php
    $pageTitle='Add New Author';
    $con = 0;    
    include 'header.php';

    // process POST request
    if (isset($_POST['send-name']) && isset($_POST['author-name'])){
        $author = $_POST['author-name'];
        if (isValid($author) && strlen($author) > 3) {
            $result = queryDatabase($con, "SELECT * FROM authors WHERE author_name ='".$author."';");
            if (!$result || !mysqli_num_rows($result)){ // checks if the author not exists into the database
                $result = queryDatabase($con, "INSERT INTO authors VALUES (NULL,'".$author."');");
                if (!$result) echo '<p>Error on inserting into database</p>';
            } else echo '<p>Author\'s name exists into database</p>';
        } else echo '<p>Author\'s name is too short or has illegal characters</p>';
    }
    
    // generates form
    $ascSort = !isset($_GET['sort']);
    $query = 'SELECT * FROM authors '
             .'ORDER BY author_name'.($ascSort?'':' DESC').';';
?>
    <a href="index.php">All books</a><br />
    <form method="post">
        <label for="author-name">Please enter the name of the new author: </label>
        <input type="text" id="author-name" name="author-name" />
        <input type="submit" name="send-name" value="Add author" />
    </form>
    <a href="new-author.php<?=($ascSort)?'?sort=desc':''?>">Sort authors <?=($ascSort)?'DESCENDING':'ASCENDING'?></a>
    <table border="1" style="border-collapse:collapse">
        <tr><th>No</th><th>Author</th></tr>
<?php
    $idx = 0;
    $currentBook = 0;
    $result = queryDatabase($con, $query);
    if ($result && mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><td>'.(++$idx).'</td><td>'
            .'<a href="books-by-author.php?id='.$row['author_id'].'">'.$row['author_name'].'</a></td></tr>';            
        }
    }

    echo '</table>';
    include 'footer.php';
?>
