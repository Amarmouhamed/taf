<?php
echo "<h1><a href='../taf'>Accueil</a></h1>";
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
    <title>Amar-API</title>
</head>

<body>
    <div class="description">
        <h1>Description de la table "<?= $table_name ?>"</h1>
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
    </div>
    <div class="action">
        <h1>Action(s) possible(s) dans la table "<?= $table_name ?>"</h1>
        <ol>
            <?php
            table_documentation($table_name,$description);
            ?>
        </ol>
    </div>

</body>

</html>