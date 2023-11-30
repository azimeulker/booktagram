<?php 
/*******w******** 
    
    Name: Azime Ulker
    Date: 10/24/2023
    Description: CMS Project- Admin Edit Page

****************/

require ('connect.php');

session_start();
$_SESSION["key"] = "edit";

if($_POST && isset($_POST['name'])){
    $_SESSION["book"] = $_POST["name"];
    $book_name = $_POST['name'];
} 
else if(isset($_SESSION["book"])){
    $book_name = $_SESSION["book"];
}

// SQL is written as a String.
$query = "SELECT * FROM books b
JOIN genres g ON g.genre_id = b.genre_id 
JOIN authors a ON a.author_id = b.author_id
WHERE book_name = :book_name";  


// A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);
$statement->bindParam(":book_name", $book_name);

// Execution on the DB server is delayed until we execute().
$statement->execute(); 

$book = $statement->fetch();


// Prepare query to get genre_name from genre_id in Genres table
$genre_query = "SELECT * FROM genres ORDER BY genre_id ASC";
$genre_statement = $db->prepare($genre_query);
$genre_statement->execute();

// Prepare query to get pen_name from author_id in Authors table
$author_query = "SELECT * FROM authors ORDER BY author_id ASC";
$author_statement = $db->prepare($author_query);
$author_statement->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_edit.css">
    <script src="https://kit.fontawesome.com/1b22186fee.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Edit Page</title>
</head>
<body>
    <div class="main_page">

        <div class="header">
            <img src="images/logo.png" alt="logo">
            
            <div class="navContainer">
                <nav class="navMenu">
                    <a href="index.php" class="navigation">Home</a>
                    <a href="genre.php" class="navigation">Genre</a>
                    <a href="author.php" class="navigation">Author</a>
                    <a href="#" class="navigation">Library</a>
                    <a href="#" class="navigation">About</a>
                    <a href="sign_up.php" class="navigation">Register Now</a>
                </nav>

                <div class="welcome">
                    <h1>Editing Book <i class="fa-brands fa-teamspeak"></i></h1>
                </div>

            </div>
            
            <div class="add_book">
                <a href="admin_book.php"><i class="fa-solid fa-book-medical"></i></a>
            </div>
        </div> 

        
        <section class="main">
            <div id="admin_book">  
                <form method="post" id="form" action="edit.php"> 
                    <div id="title">
                        <a href="admin_book.php">Add New Book <i class="fa-solid fa-plus"></i></a>
                        <a href="admin_pre_edit.php">Edit Book <i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="admin_delete.php">Delete Book <i class="fa-solid fa-trash"></i></a>
                    </div>    
            
                    <div class="post_input">    
                        <input name="id" type="hidden" value="<?= $book['book_id'] ?>">  

                        <div class="input-container">
                            <input type="text" name="title" required="" value="<?= $book['book_name'] ?>">
                            <label>Title</label>
                        </div>
                                
                        <div class="input-container">
                            <input type="text" name="genre" list="genre_browser" required="" value="<?= $book['genre_name'] ?>">
                            <label>Genre</label>
                            <datalist id="genre_browser">
                                <?php while($genre = $genre_statement->fetch()): ?>
                                    <option value="<?= $genre['genre_name'] ?>"></option>
                                <?php endwhile ?>
                            </datalist>
                        </div>    

                        <div class="input-container">
                            <input type="text" name="author" list="author_browser" required="" value="<?= $book['pen_name'] ?>">
                            <label>Author</label>
                            <datalist id="author_browser">
                                <?php while($author = $author_statement->fetch()): ?>
                                    <option value="<?= $author['pen_name'] ?>"></option>
                                <?php endwhile ?>
                            </datalist>
                        </div>    

                        <div class="input-container">
                            <textarea id="content" name="content" required=""><?= $book['book_description'] ?></textarea>
                            <label>Short Description</label>
                        </div>

                        <div class="input-container">
                            <p>Cover Image</p>
                            <?php if(isset($_GET['cover'])): ?>
                                <input name="cover" type="text" value="<?= $_GET['cover'] ?>">
                                <img src="uploads/<?= $_GET['cover'] ?>" alt="">
                                <a href="choose_image.php">+ Choose Other Covers</a>
                            <?php elseif(!is_null($book['cover'])): ?>
                                <p><?= $book['cover'] ?></p>
                                <input name="cover" type="text" value="<?= $book['cover'] ?>">
                                <img src="uploads/<?= $book['cover']?>" alt="">
                                <a href="choose_image.php">+ Choose Other Cover</a>
                            <?php else: ?>
                                <p>NO COVER IMAGE FOUND</p>
                                <a href="choose_image.php">+ Choose Cover</a>
                            <?php endif ?>
                            
                        </div>

                        <div class="input-container">
                            <input type="text" name="rating" required="" value="<?= $book['rating'] ?>">
                            <label>Rating</label>
                        </div>

                        <div><input type="submit" id="button" value="Edit Book"></div>
                    </div>
                </form>   
            </div>
        </section>

        <footer>
            <div class="footer-content">
                <h3>Booktagram</h3>
                <p>Explore a boundless digital realm where every book finds its home!!</p>
                <ul class="socials-media">
                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
                </ul>
            </div>

            <div class="footer-bottom">
                    <p>copyright &copy; <a href="#">Booktagram</a></p>
                        <div class="footer-menu">
                            <ul class="f-menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="sign_up.php">Register</a></li>                           
                            </ul>
                        </div>
                </div>
        </footer>
    </div>
</body>
</html>