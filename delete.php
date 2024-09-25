<?php

    require "database.php";

    session_start();

    if(!isset($_SESSION["user"])){
        header("Location: logout.php");
        return;
    }


    $id = $_GET['id'];
    $statement = $conn->prepare("SELECT * from contacts where id=:id limit 1");
    $statement->execute([":id" => $id]);

    if(!$statement){
        http_response_code(404);
        print("HTTP 404 - NOT Found");
        return;
    }

    // $statement = $conn->prepare("DELETE * from contacts where id=:id");
    // $statement->bindParam(":id", $id);
    // $statement->execute();

    $contact = $statement->fetch(PDO::FETCH_ASSOC);

    if($contact["user_id"] !== $_SESSION["user"]['id']){
        http_response_code(403);
        print("HTTP 403 - Unauthorized");
        return;
    }

    $conn->prepare("DELETE FROM contacts where id=:id")->execute([":id" => $id]);

    $_SESSION["flash"] = ["message" => "Contact {$contact['name']} deleted successfully."];

    header("Location: home.php");
    return;
?>