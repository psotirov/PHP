<?php
    $pageTitle='All Books database';
    $con = 0;    
    include 'header.php';

    $ascSort = !isset($_GET['sort']);
    
    $query = 'SELECT list.book_id AS id, b.book_title AS title, a.author_name AS author, a.author_id AS aid '
                    .'FROM books_authors AS list '
             .'LEFT JOIN authors AS a ON list.author_id = a.author_id '
             .'LEFT JOIN books AS b ON list.book_id = b.book_id '
             .'ORDER BY title'.($ascSort?'':' DESC').', id, author;';
    

?>
    <a href="new-book.php">New book</a>
    <a href="new-author.php">New author</a>    
    <a href="index.php<?=($ascSort)?'?sort=desc':''?>">Sort books <?=($ascSort)?'DESCENDING':'ASCENDING'?></a>
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