<?php
session_start();

// Vérifier si la session n'est pas active ou si l'utilisateur n'est pas authentifié
if (!isset($_SESSION["user"])) {
  // Redirection vers la page de connexion
  header("Location: login.php");
  exit();
}


include "connect.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $project_name = $_POST["project_name"];
  $project_details = $_POST["project_details"];
  $project_link = $_POST["project_link"];
  $project_git = $_POST["project_git"];
  $project_screen = $_FILES["project_screen"]["name"];


  move_uploaded_file($_FILES["project_screen"]["tmp_name"], "assets/img/portfolio/" . $project_screen);


  $sql = "INSERT INTO projects (project_name, project_details, project_link, project_git, project_screen) VALUES ('$project_name', '$project_details', '$project_link', '$project_screen')";
  mysqli_query($conn, $sql);


  header("Location: portfolio.php");
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
  <script src="https://usefontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <!-- Google fonts-->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
</head>

<body>


  <div class="container mt-5">
    <div class="row justify-content-center">

      <form action="add_project.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="project_name">Nom du projet</label>
          <input type="text" class="form-control" id="project_name" name="project_name" required>
        </div>
        <div class="form-group">
          <label for="project_details">Détails du projet</label>
          <textarea class="form-control" id="project_details" name="project_details" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <label for="project_link">Lien du projet</label>
          <input type="text" class="form-control" id="project_link" name="project_link" required>
        </div>
        <div class="form-group">
          <label for="project_git">GitHub du projet</label>
          <input type="text" class="form-control" id="project_git" name="project_git" required>
        </div>
        <div class="form-group">
          <label for="project_screen">Screenshot du projet</label>
          <input type="file" class="form-control-file" id="project_screen" name="project_screen" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter le projet</button>
      </form>
    </div>
  </div>

  <style>
    .form-group {
      margin-bottom: 2rem;
    }
  </style>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</body>

</html>