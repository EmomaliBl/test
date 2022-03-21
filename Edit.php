<?php
    require 'connect.php';
    $pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8mb4", DB_USER, DB_PASSWORD);
    $sql = "SELECT * FROM Recipe";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if(isset($_POST['add_field'])) {
        $recipe = $pdo->prepare("INSERT INTO `Recipe`(`Recipe_name`, `Description_cooking_method`, `Rec_Book_ID`) VALUES('$_POST[Recipe_name]', '$_POST[Description_cooking_method]', '$_POST[id_avtor]')");
        $recipe->execute();
        $r_id = $pdo->lastInsertId();
        $fk_i_e = $pdo->prepare("INSERT INTO `FK_Ing_Edin`(`IngredientID`, `Edinitsa_IzmerenieID`, `coll`) VALUES('$_POST[IngredientID]', '$_POST[Edinitsa_IzmerenieID]', '$_POST[coll]')");
        $fk_i_e->execute();
        $fk_i_e_id = $pdo->lastInsertId();
        $fk_r_e = $pdo->prepare("INSERT INTO `FK_R_I`(`Recipe_ID`, `FK_Ingr_Edin_ID`) VALUES('$r_id', '$fk_i_e_id')");
        $fk_r_e->execute();
        $fk_r_e_id = $pdo->lastInsertId();
        $recipe = $pdo->prepare("UPDATE `Recipe` SET `IngredientID`='$fk_r_e_id' WHERE Recipe_ID = '$r_id'");
        $recipe->execute();
        header("Location: https://test.u0605727.plsk.regruhosting.ru/index.php");
        die();
    }
    if(isset($_POST['button_x'])){
        $id = $_POST['button_x'];
        $recipe = $pdo->prepare("DELETE FROM `Recipe` WHERE `Recipe_ID` = '$id'");
        $recipe->execute();
        header("Location: https://test.u0605727.plsk.regruhosting.ru/index.php");
        die();
    }
    if(isset($_POST['btn'])){
        $id = $_POST['btn'];
        $cite = $_POST['cite'];
        var_dump($id);
            var_dump($cite);
        $data = file_get_contents($cite);
        $sql = "UPDATE `Recipe` SET `img`='$data' WHERE `Recipe_ID` = '$id'";
        $qr = $pdo->exec($sql);
    }
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="style/fields.css">
        <link rel="stylesheet" type="text/css" href="style/main.css">
    </head>
    <body>
        <main>
<?php
    $sql1all = "SELECT * FROM Book";
    $stmt1all = $pdo->prepare($sql1all);
    $stmt1all->execute();
    $iavtor = '';
    while ($row1all = $stmt1all->fetch(PDO::FETCH_ASSOC)) {
        $iavtor .= '<option value="' . $row1all['Book_ID'] . '">' . $row1all['Title'] . ', ' . $row1all['Author'] . ' , ' . $row1all['Description']. '</option>';
    }
    $sql1all = "SELECT * FROM Ingredient";
    $stmt1all = $pdo->prepare($sql1all);
    $stmt1all->execute();
    $ingall = '';
    while ($row1all = $stmt1all->fetch(PDO::FETCH_ASSOC)) {
        $ingall .= '<option value="' . $row1all['Ingredient_ID'] . '">' . $row1all['Ingredient_NAME'].'</option>';
    }
    $sql1all = "SELECT * FROM Edinitsa_Izmerenie";
    $stmt1all = $pdo->prepare($sql1all);
    $stmt1all->execute();
    $edinall = '';
    while ($row1all = $stmt1all->fetch(PDO::FETCH_ASSOC)) {
        $edinall .= '<option value="' . $row1all['Edinitsa_Izmerenie_ID'] . '">' . $row1all['Edinitsa_Izmerenie_NAME'].'</option>';
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $iing = '';
        $sql1 = "SELECT * FROM Book WHERE Book.Book_ID =" . $row['Rec_Book_ID'];
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute();
        $sql12 = "SELECT * FROM FK_R_I WHERE Recipe_ID =" . $row['Recipe_ID'];
        $stmt12 = $pdo->prepare($sql12);
        $stmt12->execute();
        while ($row12 = $stmt12->fetch(PDO::FETCH_ASSOC)) {
            $sql123 = "SELECT * FROM FK_Ing_Edin WHERE FK_Ing_Edin_ID =" . $row12['FK_Ingr_Edin_ID'];
            $stmt123 = $pdo->prepare($sql123);
            $stmt123->execute();
            while ($row123 = $stmt123->fetch(PDO::FETCH_ASSOC)) {
                $sql1234 = "SELECT Ingredient_NAME, Edinitsa_Izmerenie_NAME FROM Ingredient,Edinitsa_Izmerenie WHERE Ingredient_ID =".$row123['IngredientID']." AND Edinitsa_Izmerenie_ID = ".$row123['Edinitsa_IzmerenieID'];
                $stmt1234 = $pdo->prepare($sql1234);
                $stmt1234->execute();
                while ($row1234 = $stmt1234->fetch(PDO::FETCH_ASSOC)) {
                    $iing .=$row1234['Ingredient_NAME'] . ' ' . $row123['coll'].$row1234['Edinitsa_Izmerenie_NAME'].' <br>';
                };
            };
        };
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $iavtor .= '<option value="' .$row['Recipe_ID'].'" type="text" value="'. $row1['Title'] . ', ' . $row1['Author'] . ' , ' . $row1['Description'].'</option>';
            $i .= '
            <tr class="row_for_choose">
                <td>
                    <input autocomplete="off" name="sins'.$row['Recipe_ID'].'" type="text" value="'.$row['Recipe_name'].'">
                </td>
                <td class="green">
                    <input autocomplete="off" name="sins'.$row['Recipe_ID'].'" type="text" value="'.$row['Description_cooking_method'].'">
                </td>
                <td class="red">
                    <input autocomplete="off" name="sins'.$row['Recipe_ID'].'" type="text" value="'. $row1['Title'] . ', ' . $row1['Author'] . ' , ' . $row1['Description'].'">
                </td>
                <td>
                <label>'.$iing.'</label>
                </td>
                <td>
                    <img class="green" src="data:image/png;base64,' . base64_encode($row['img']) . '" style="width: 50%; height: 50%; alt="...">
                     <form method="post" enctype="multipart/form-data">
                        <input style="height: 20%" name="cite" value="" >
                            <button id = "'.$row['Recipe_ID'].'" value = "'.$row['Recipe_ID'].'" name="btn">Загрузить</button>
                    </form>
                </td>
                <td>
                    <button type="submit" class="ok_x_buttons" name="button_x" value="'.$row['Recipe_ID'].'">х</button>
                    <button type="submit" class="ok_x_buttons" name="button_ok" value="'.$row['Recipe_ID'].'">ок</button>
                </td>
                </td>';
        };
    };
    echo '<div class="fields_form">
                <form action="" method="post">
                    <table id="modul_table">
                        <tr id="thead">
                            <td>Название Рецепта</td><td>Описание</td><td>Автор</td><td>Ингредиенты</td><td>Фото</td>
                        </tr>'.$i.'
                        <tr class="bottom_row">
                            <td>
                                <input autocomplete="off" type="text" value="" placeholder="Название" class="add_row" name="Recipe_name">
                            </td>
                            <td>
                                <input autocomplete="off" type="text" value="" placeholder="Описание" class="add_row" name="Description_cooking_method">
                            </td>            
                            <td>
                                <select id="id_avtor" name="id_avtor" >
                                    '.$iavtor.'
                                </select>
                                <input autocomplete="off" type="text" value="" placeholder="Книга" class="add_row" name="add_kniga">
                            </td>
                             <td>
                                <select id="IngredientID" name="IngredientID" >
                                    '.$ingall.'
                                </select>
                                <input autocomplete="off" type="text" value="" placeholder="Количество" class="add_row" name="coll">
                                <select id="Edinitsa_IzmerenieID" name="Edinitsa_IzmerenieID" >
                                    '.$edinall.'
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="add_field" value="addit" class="add_button">Добавить
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>

    </div>';
       ?>
        </main>
    </body>
</html>