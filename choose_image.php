<?php
    $files = scandir('uploads');
    session_start();
    $_SESSION["image"] = "delete";


    require ('ImageResize.php');
    require ('ImageResizeException.php');
    use \Gumlet\ImageResize;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        // Check if the file is an allowed type (JPG, PNG, GIF, PDF)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

        if (in_array($_FILES['file']['type'], $allowedTypes)) {

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                echo 'File is valid, and was successfully uploaded.';
;
                // Perform image resizing for supported image types
                if ($_FILES['file']['type'] === 'image/jpeg' || $_FILES['file']['type'] === 'image/png' || $_FILES['file']['type'] === 'image/gif') {
                
                    $image = new ImageResize($uploadFile);
                    $image->save('uploads/original_' . basename($_FILES['file']['name']));

                    // Resize to 400px width
                    $image->resizeToWidth(400);
                    $image->save('uploads/medium_' . basename($_FILES['file']['name']));

                    // Resize to 50px width
                    $image->resizeToWidth(50);
                    $image->save('uploads/thumbnail_' . basename($_FILES['file']['name']));
                }
            } else {
                echo 'File upload failed.';
            }
        } else {
            echo 'Invalid file type. Only JPG, PNG, GIF, and PDF files are allowed.';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="choose_image.css">
    <script src="https://kit.fontawesome.com/1b22186fee.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Choose Image Page</title>
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
                    <h1><i class="fa-solid fa-bars-staggered"></i>  Images Gallery <i class="fa-solid fa-bars-staggered"></i></h1>
                </div>	
            </div>
            
            <div class="admin">                  
                <a href="admin_book.php"><i class="fa-solid fa-circle-user"></i></a>                    
            </div>
            <a href="logout.php" class="logout">Logout</a>
        </div>    

        <section class="main">
            <div class="scene">
                <?php foreach($files as $file): ?>  
                    <?php if($file !== "." && $file !== ".."): ?>                                                               
                        <div class="card">
                            <div class="card__face card__face--front">
                                <img src="uploads/<?= $file?>" />
                            </div>
                            <div class="card__face card__face--back">
                                <h2><?= $file ?></h2>
                                <?php if($_SESSION["key"] == "upload"): ?>
                                    <a href="admin_book.php?cover=<?= $file ?>">Choose Cover</a>
                                <?php else: ?> 
                                    <a href="admin_edit.php?cover=<?= $file ?>">Choose Cover</a>
                                <?php endif ?>
                                <form onsubmit="return confirm('Do you really want to delete this image?');" method="post" id="form" action="delete.php"> 
                                    <input name="cover" type="hidden" value="<?= $file ?>">    
                                    <div><input type="submit" id="button" value="Delete Image"></div>
                                </form>
                            </div>
                        </div>
                    <?php endif ?>                      
                <?php endforeach ?>
            </div>

            <form action="choose_image.php" method="post" enctype="multipart/form-data">
                <h2>Upload your cover Image to the Gallery</h2>    
                <input type="file" name="file" id="file">
                <div><input type="submit" name="submit" id="button1"  value="Upload Cover"></div>
            </form> 
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