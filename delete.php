<?php

    require "database.php";

    if(!isset($_SESSION["user"])){
        header("Location: logout.php");
        return;
    }


    $id = $_GET['id'];
    $statement = $conn->prepare("SELECT * from contacts where id=:id");
    $statement->execute([":id" => $id]);

    if(!$statement){
        http_response_code(404);
        print("HTTP 404 - NOT Found");
        return;
    }

    // $statement = $conn->prepare("DELETE * from contacts where id=:id");
    // $statement->bindParam(":id", $id);
    // $statement->execute();

    $conn->prepare("DELETE FROM contacts where id=:id")->execute([":id" => $id]);
    header("Location: home.php");
?>