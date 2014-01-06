<?php
    $pageTitle='Add New Book';
    $con = 0;
    include 'header.php';

    // process POST request
    if (isset($_POST['send-book']) && isset($_POST['book-title'])){
        $book = $_POST['book-title'];
        if (isValid($book) && strlen($book) > 3) { // insert book's title into database
                $result = queryDatabase($con, "INSERT INTO books VALUES (NULL,'".$book."');");
                if ($result && isset($_POST['book-authors'])){
                    // if successfull and there is selected book's authors add them also to the database
                    $newBookId = mysqli_insert_id($con);                    
                    $authors = $_POST['book-authors'];
                    $query = 0;
                    foreach ($authors as $aid){ // separate record for each book-author pair but within one INSERT query
                        if (!$query) $query = "INSERT INTO books_authors VALUES ";
                        else $query = $query.',';
                        $query = $query."('".$newBookId."','".$aid."')";
                    } 
                    
                    if ($query) {
                        $query = $query.';';           
                        $result = queryDatabase($con, $query);
                    }
                } else echo '<p>Error on inserting title into database or no authors</p>';
        } else echo '<p>Book\'s title is too short or has illegal characters</p>';
    }
    
    // generates form
    $ascSort = !isset($_GET['sort']);
    $query = 'SELECT * FROM authors '
             .'ORDER BY author_name'.($ascSort?'':' DESC').';';
?>
    <a href="index.php">All books</a><br />
    <form method="post">
        <label for="book-title">Please enter the title of the new book: </label>
        <input type="text" id="book-title" name="book-title" />
        <input type="submit" name="send-book" value="Add book" /><br />
        <a href="new-book.php<?=($ascSort)?'?sort=desc':''?>">Sort authors <?=($ascSort)?'DESCENDING':'ASCENDING'?></a><br />
        <label for="book-authors">Please select one or more authors: </label>
        <select name="book-authors[]" id="book-authors" multiple="multiple">
<?php
    $idx = 0;
    $currentBook = 0;
    $result = queryDatabase($con, $query);
    if ($result && mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            echo '<option value="'.$row['author_id'].'">'
                .$row['author_name'].'</option>';            
        }
    }

    echo '</select></form>';
    include 'footer.php';
?>
