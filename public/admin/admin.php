<?php
    if (isset($_POST['upload'])) {
        $db = mysqli_connect("localhost", "root", "", "pickdb");
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $text = $_POST['text'];

        $query = "INSERT INTO images (image,text) VALUES('$image','$text')";  
        $qry = mysqli_query($db, $query);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Image Upload</title>
        <link rel="stylesheet" type="text/css" href="../styles/admin.css">
    </head>

    <body>
        <div id="content">
            <br/><h3 align="center">Welcome, Admin</h3><br/> 
            <?php
                $db = mysqli_connect("localhost", "root", "", "pickdb");
                $sql = "SELECT * FROM images";
                $result = mysqli_query($db, $sql);
                
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div id='img_div'>";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image']).'"/>';
                    echo "<p>".$row['text']."</p>";
                    echo "</div>";
                }
            ?> 
            <form method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="size" value="1000000">
                <div><input type="file" name="image"></div>
                <div><textarea name="text" cols="40" rows="4" placeholder="about image..."></textarea></div>
                <div><button type="submit" name="upload" value="Upload Image">Add A Game</button></div>
            </form>
        </div>
    </body>
</html>