<?php
    $pageTitle='All Books By Author';
    $con = 0;
    if (!isset($_GET['id'])){ // if author id is not supplied
        header("Location: index.php"); // redirect back to all bookspage
    }
    
    $aid = intval($_GET['id']);
    include 'header.php';

    $ascSort = !isset($_GET['sort']);
    
    // the query is the same as in index.php except WHERE clause  
    $query = 'SELECT list.book_id AS id, b.book_title AS title, a.author_name AS author, a.author_id AS aid '
                    .'FROM books_authors AS list '
             .'LEFT JOIN authors AS a ON list.author_id = a.author_id '
             .'LEFT JOIN books AS b ON list.book_id = b.book_id '
             // here from all books selects only those that have author with specified id (from list of book-author pairs)
             .'WHERE list.book_id IN (SELECT book_id FROM books_authors WHERE author_id = '.$aid.') '             
             .'ORDER BY title'.($ascSort?'':' DESC').', id, author;';
?>
    <a href="index.php">All books</a><br />
    <a href="books-by-author.php<?=($ascSort)?'?sort=desc':''?>">Sort books <?=($ascSort)?'DESCENDING':'ASCENDING'?></a>
    <table border="1" style="border-collapse:collapse">
        <tr><th>No</th><th>Book Title</th><th>Book Authors</th></tr>
<?php
    $idx = 0;
    $currentBook = 0;
    $result = queryDatabase($con, $query);
    if ($result && mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            if ($currentBook != $row['id']) {
                if ($currentBook)  echo '</td></tr>';
                $currentBook = $row['id'];
                echo '<tr><td>'.(++$idx).'</td><td>'
                    .'<a href="book-details.php?bookid='.$row['id'].'">'
                    .$row['title'].'</a></td><td>';
            } 
            
            echo '<a href="books-by-author.php?id='.$row['aid'].'">'.$row['author'].'</a><br />';            
        }
        
        echo '</td></tr>';
    }
    
    echo '</table>';
    include 'footer.php';
?>