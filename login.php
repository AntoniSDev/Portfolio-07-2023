<?php

// Démarrer la session
session_start();

// Vérifier si le formulaire a été soumis
if (!empty($_POST)) {

  // Vérifier si les champs "login" et "password" sont renseignés
  if (isset($_POST["login"], $_POST["password"]) && !empty($_POST["login"]) && !empty($_POST["password"])) {

    // Connecter à la base de données
    require_once("connect.php");

    // Exécuter la requête SQL
    $sql = "SELECT * FROM portfolio_user WHERE user_name = :user_name AND user_password = :password";
    $query = $db->prepare($sql);
    $query->bindValue(":user_name", $_POST["login"]);
    $query->bindValue(":password", $_POST["password"]);
    $query->execute();

    // Récupérer l'utilisateur
    $user = $query->fetch();

    // Vérifier si l'utilisateur existe
    if ($user) {

      // Créer une session
      $_SESSION["user"] = $user;

      // Rediriger vers la page de l'espace membre
      header("Location: backoffice.php");
      exit();
    } else {

      // Afficher un message d'erreur
      echo "L'utilisateur et/ou le mot de passe est incorrect";
    }
  } else {

    // Afficher un message d'erreur
    echo "Veuillez remplir tous les champs";
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>AntoniSDev</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Font Awesome icons (free version)-->
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <!-- Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-4">
        <h2 class="mb-4">Connexion</h2>
        <form method="post">
          <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" id="login" name="login" placeholder="Entrez votre login">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe">
          </div>
          <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</body>

</html>