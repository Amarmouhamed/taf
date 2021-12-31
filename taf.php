<?php
try {
    require './config.php';
    require './function.php';
    $reponse = array();

    $query = "SHOW TABLES";
    $tables = $connexion->query($query)->fetchAll(PDO::FETCH_ASSOC);
    json_encode($tables);
} catch (\Throwable $th) {
    echo "<h1>veillez éditer le fichier de configuration (config.php), renseigner la bonne base de donnée et un utilisateur</h1>";
    echo "<h1>" . $th->getMessage() . "</h1>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amar-API</title>
</head>

<body>
    <h1>Bienvenue sur Amar-API</h1>
    <h4>Le générteur automatique d'api à partir d'une base de données MYSQL</h4>
    <br>
    <h3>Prérequis</h3>
    <p>
        NB: veillez éditer le fichier de configuration (config.php)
        <ol>
            <li>Remplacer {{{host}}} par le nom de la base de donneée</li>
            <li>Remplacer {{{db_name}}} par le nom de la base de donneée</li>
        </ol>
    </p>
    <div class="action">
        <h1>La(es) table(s) de la base de données "<?= $database_name ?>"</h1>
        <button><a href="./generate.php?tout=oui">Tout générer</a></button>
        <ol>
            <?php
            $dir    = './';
            $files = scandir($dir);
            foreach ($tables as $key => $value) {
                $table_name = $value["Tables_in_" . $database_name];
                if(array_search($table_name,$files)){
                    echo "<li>" . $table_name . "<a href='./$table_name'> --------> voir exemple</a></li>";
                }else{
                    echo "<li>" . $table_name ."<button ><a href='generate?table=$table_name'>Générer les routes</a> </button>";
                }
                
            }
            ?>
        </ol> 
    </div>
</body>

</html>