<?php
require 'connec.php'; //appelle le fichier avec les constantes pour connecter à la base de données
$pdo = new \PDO(DSN, USER, PASSWORD); // connexion à la base de données avec 3 paramètres

if($_SERVER["REQUEST_METHOD"]==="POST") {  //Sécurisation du formulaire
    $data = array_map('trim', $_POST);  //boucle sur toutes les lignes et applique la fonction trim qui enlève les espaces
    if(empty($data['firstname'])) {  //vérification du champ firstname obligatoire
        $errors[] = 'Firstname is required';
    }
    if(empty($data['lastname'])) { //vérification du champ lastname obligatoire
        $errors[] = 'Lastname is required';
    }
    $maxlength = 45;
    if(strlen($data['firstname']) > $maxlength) { // vérification que la saisie ne dépasse pas 45 caractères avec fonction strlen (calcul taille d'une chaine)
        $errors[] = 'The firstname must be less than ' . $maxlength . ' characters.';
    }
    if(strlen($data['lastname']) > $maxlength) {
        $errors[] = 'The lastname must be less than ' . $maxlength . ' characters.';
    }
    if(!empty($errors)) { // vérification champs plein = affichage d'erreur, sinon execution bdd avec une requête
        foreach ($errors as $error){
            ?>
            <ul>
                <li> <?= $error;?> </li>
            </ul>
<?php
    }
    } else { // redirection vers base de données avec une requête $query et avec une requête préparée
        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)"; // requète préparée
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $data['firstname']);
        $statement->bindValue(':lastname', $data['lastname']);

        $statement->execute(); // execution de la requète

        header("location:redirection.php");
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Challenge PDO</title>
    </head>
    <body>
        <h1>Add Friend</h1>
            <form method="post">
                <div>
                    <label for="firstname"> Enter your firstname : </label>
                    <input type="text" id="firstname" name="firstname" value="<?= $data['firstname'] ?? ''?>" required/> <br/>
                </div>
                <div>
                    <label for="lastname"> Enter your lastname : </label>
                    <input type="text" id="lastname" name="lastname" value=" <?= $data['lastname'] ?? '' ?>" required/> <br/>
                </div>
                <div><button> Add </button></div>
            </form>
    </body>
</html>
