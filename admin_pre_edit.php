<?php 
/*******w******** 
    
    Name: Azime Ulker
    Date: 10/24/2023
    Description: CMS Project- Admin Edit Page

****************/

require ('connect.php');

$query = "SELECT * FROM books ORDER BY book_id ASC"; 

// A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute().
$statement->execute(); 
   
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
                <form method="post" id="form" action="admin_edit.php"> 
                    <div id="title">
                        <a href="admin_book.php">Add New Book <i class="fa-solid fa-plus"></i></a>
                        <a href="admin_pre_edit.php">Edit Book <i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="admin_delete.php">Delete Book <i class="fa-solid fa-trash"></i></a>
                    </div>    
            
                    <div class="post_input">       
                        <div class="input-container">
                            <input type="text" name="name" required="" list="title_browser">
                            <label>Please Enter Book Name for Editing</label>
                            <datalist id="title_browser">
                                <?php while($book = $statement->fetch()): ?>
                                    <option value="<?= $book['book_name'] ?>"></option>
                                <?php endwhile ?>
                            </datalist>
                        </div>
                          
                        <div><input type="submit" id="button" value="Choose Book"></div>
                    </div>
                </form> 
            </div>
        </section>

        <footer>
            <div class="footer-content">
                <h3>Booktagram</h3>
                <p>Explore a boundless digital realm where every book finds its home!</p>
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
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Register</a></li>                           
                            </ul>
                        </div>
                </div>
        </footer>
    </div>
</body>
</html>