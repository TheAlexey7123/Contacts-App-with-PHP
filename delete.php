<?php

    require "database.php";

    $id = $_GET['id'];
    $contacts = $conn->prepare("SELECT * from contacts where id=:id")->bindParam(":id", $id);

    if(!$contacts){
        http_response_code(404);
        print("HTTP 404 - NOT Found");
        return;
    }

    // $statement = $conn->prepare("DELETE * from contacts where id=:id");
    // $statement->bindParam(":id", $id);
    // $statement->execute();

    $conn->prepare("DELETE FROM contacts where id=:id")->execute([":id" => $id]);
    header("Location: index.php");
?>