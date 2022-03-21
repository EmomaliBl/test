<?php
    require 'connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Blob</title>
    </head>
    <body>
        <?php
        $pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8mb4", DB_USER, DB_PASSWORD);
        if(isset($_POST['btn'])){
                $name = $_FILES['myfile']['name'];
                $type = $_FILES['myfile']['type'];
                $data = file_get_contents($_FILES['myfile']['tmp_name']);
                $sql = "INSERT INTO Image (`id`,`name`, `mime`, `data`) VALUES ('','$name','$type','$data')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

            }

        ?>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="myfile">
            <button name="btn">Загрузить</button>
        </form>
    <ol>
        <?php
        $sql = "SELECT * FROM Image";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['mime'] . '</td>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' .
                '<img src = "data:image/png;base64,' . base64_encode($row['data']) . '" width = "50px" height = "50px"/>'
                . '</td>';
            echo '</tr>';
        }
        ?>
    </ol>
    </body>

</html>