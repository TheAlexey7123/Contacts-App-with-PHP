<?php
    require "database.php";

    session_start();

    if(!isset($_SESSION["user"])){
        header("Location: logout.php");
        return;
    }


    $id = $_GET['id'];
    $statement = $conn->prepare("SELECT * from contacts where id=:id LIMIT 1");
    $statement->execute(['id'=> $id]);;
    $error = null;

    if(!$statement){
        http_response_code(404);
        $error="HTTP 404 - Contact not found";
        return;
    }

    $contact = $statement->fetch(PDO::FETCH_ASSOC);

    if($_SESSION["user"]["id"] !== $contact['user_id']){
        http_response_code(403);
        print("HTTP 403 - Unauthorized");
        return;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty($_POST["name"]) || empty($_POST["phone_number"])){
            $error = "Please fill all the fields";
        }

        else if(strlen($_POST["phone_number"]) < 9){
            $error = "Phone number must be at least 9 characters";
        }

        else{

            $statement = $conn->prepare("UPDATE contacts set name=:name, phone_number=:phone_number where id=:id");
    
            $statement->execute([
                ":id" => $id,
                ":name" => $_POST["name"],
                ":phone_number" => $_POST["phone_number"]
            ]);

            $_SESSION["flash"] = ["message" => "Contact {$_POST['name']} updated."];

            header("Location: home.php");

            return;
        }

    }

?>

<?php require "./partials/header.php"; ?>

    <main>
        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Add New Contact</div>
                        <div class="card-body">
                            <?php if ($error): ?>
                                <p class="text-danger">
                                    <?= $error ?>
                                </p>
                            <?php endif ?>

                            <form method="POST" action="edit.php?id=<?=$contact['id'];?>">
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                                    <div class="col-md-6">
                                        <input value="<?= $contact["name"]; ?>" id="name" type="text" class="form-control" name="name"
                                            autocomplete="name" autofocus>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

                                    <div class="col-md-6">
                                        <input value="<?= $contact["phone_number"]; ?>" id="phone_number" type="tel" class="form-control" name="phone_number"
                                            autocomplete="phone_number" autofocus>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php require "./partials/footer.php"; ?>