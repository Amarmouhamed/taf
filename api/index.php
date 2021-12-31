<?php
try {
    require './config.php';
    mode($mode_deploiement);

    $query = "desc $table_name";
    $description = $connexion->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $th) {

    echo "<h1>" . $th->getMessage() . "</h1>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAF</title>
    <link href="../bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="bg-light">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <div class="container-fluid">
                <a href='../taf' class="navbar-brand text-danger">TAF</a>
                <a href="https://h24code.com/donate.html" target="_blank" class="px-2 right"><button class="btn btn-secondary">Faire un don</button></a>
            </div>
        </nav>
    </header>
    <main class="container mt-5">
        <div class="row">
            <p class="col-12 fs-3 text-justify">
            <h1>Description de la table <span class="text-danger"><?= $table_name ?></span></h1>
            <ol>
                <?php
                try {
                    foreach ($description as $key => $value) {
                        echo "<li>" . $value["Field"] . "</li>";
                    }
                } catch (\Throwable $th) {
                    $reponse["status"] = false;
                    $reponse["erreur"] = $th->getMessage();

                    echo "<li>" . $th->getMessage() . "</li>";
                }

                ?>
            </ol>
            </p>
            <h1>Action(s) possible(s) dans la table <span class="text-danger"><?= $table_name ?></span></h1>
            <p class="col-12 fs-3 text-justify">
                <?php
                table_documentation($table_name, $description);
                ?>
            </p>
    </main>
</body>

</html>