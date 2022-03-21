<?php

require 'connect.php';

//https://test.u0605727.plsk.regruhosting.ru/index.php
$pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8mb4", DB_USER, DB_PASSWORD);
//print_r($recipe);
?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Необходимо разработать backend на PHP для книги рецептов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
            crossorigin="anonymous"></script>
</head>
<body>
<main>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11 mt-2 mb-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href='/'">Главное</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Link</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#" tabindex="-1"
                                       aria-disabled="true">Disabled</a>
                                </li>
                            </ul>
                            <form class="d-flex">
                                <input class="form-control mr-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                            <a class="navbar-brand" href='/Edit.php' style="margin-left: 1000px" "><button type="button" class="btn btn-outline-success">Добавить</button></a>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid mb-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-11">
                            <div class="row" style="padding: 15px">
                                <?php
                                $sql = "SELECT * FROM Recipe";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                $sql1 = "SELECT * FROM Book WHERE Book.Book_ID =" . $row['Rec_Book_ID'];
                                $stmt1 = $pdo->prepare($sql1);
                                $stmt1->execute();
                                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                    echo ' 
                                    <div class="col-xs-6 col-sm-4" style="padding: 10px">
                                      <div class="card" style="max-width: 100%; height: auto;">
                                       <img class="card-img-top" src="data:image/png;base64,' . base64_encode($row['img']) . '" style="width: 100%; alt="...">
                                       
                                        <div class="card-body">
                                          <h5 class="card-title">' . $row['Recipe_name'] . '</h5>
                                          <p class="card-text">' . $row['Description_cooking_method'] . '</p>
                                          <ul class="list-group list-group-flush">
                                           
                                            <li class="list-group-item">' . $row1['Title'] . ', ' . $row1['Author'] . ' , ' . $row1['Description'] . '</li>
                                      ';

                                    $sql12 = "SELECT * FROM FK_R_I WHERE Recipe_ID =" . $row['Recipe_ID'];
                                    $stmt12 = $pdo->prepare($sql12);
                                    $stmt12->execute();

                                    echo '<li class="list-group-item">Ингредиенты: </li>';

                                    while ($row12 = $stmt12->fetch(PDO::FETCH_ASSOC)) {
                                        $sql123 = "SELECT * FROM FK_Ing_Edin WHERE FK_Ing_Edin_ID =" . $row12['FK_Ingr_Edin_ID'];
                                        $stmt123 = $pdo->prepare($sql123);
                                        $stmt123->execute();
                                        while ($row123 = $stmt123->fetch(PDO::FETCH_ASSOC)) {
//                                            echo '<li class="list-group-item">' .$row123['IngredientID'].', '.$row123['Edinitsa_IzmerenieID']. '</li>';
                                            $sql1234 = "SELECT Ingredient_NAME, Edinitsa_Izmerenie_NAME FROM Ingredient,Edinitsa_Izmerenie WHERE Ingredient_ID =".$row123['IngredientID']." AND Edinitsa_Izmerenie_ID = ".$row123['Edinitsa_IzmerenieID'];
                                            $stmt1234 = $pdo->prepare($sql1234);
                                            $stmt1234->execute();
                                            while ($row1234 = $stmt1234->fetch(PDO::FETCH_ASSOC)) {
                                                echo $row1234['Ingredient_NAME'] . ' ' . $row123['coll'].$row1234['Edinitsa_Izmerenie_NAME'].', ';
                                            };
                                        };
                                    };
                                        echo '
                                        </ul>
                                        </div>
                                      </div>
                                    </div>
                                 ';
                                    };
                                };

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
<footer>
</footer>
</body>
</html>