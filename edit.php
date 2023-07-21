<?php
session_start();

// Vérifier si l'utilisateur n'est pas authentifié
if (!isset($_SESSION["user"])) {
  // Redirection vers la page de connexion
  header("Location: login.php");
  exit();
}

// Inclure le fichier connect.php pour établir la connexion à la base de données via PDO
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Vérifier si les données du formulaire ont été soumises
  if (
    isset($_POST['id']) &&
    isset($_POST['project_name']) &&
    isset($_POST['project_details']) &&
    isset($_POST['project_link']) &&
    isset($_POST['project_git'])
  ) {
    // Nettoyer les données du formulaire
    $id = strip_tags($_POST['id']);
    $project_name = strip_tags($_POST['project_name']);
    $project_details = strip_tags($_POST['project_details']);
    $project_link = strip_tags($_POST['project_link']);
    $project_git = strip_tags($_POST['project_git']);

    // Vérifier si un nouveau fichier d'image est téléchargé
    if ($_FILES["project_screen"]["name"] !== "") {
      // Supprimer l'image existante du serveur
      $existing_screen = $_POST["existing_screen"];
      if ($existing_screen !== "") {
        $existing_image_path = "assets/img/portfolio/" . $existing_screen;
        if (file_exists($existing_image_path)) {
          unlink($existing_image_path);
        }
      }

      // Télécharger le nouveau fichier d'image sur le serveur
      $project_screen = $_FILES["project_screen"]["name"];
      $target_dir = "assets/img/portfolio/";
      $target_file = $target_dir . basename($project_screen);
      move_uploaded_file($_FILES["project_screen"]["tmp_name"], $target_file);

      // Préparer la requête SQL UPDATE avec le nouveau fichier d'image
      $sql = "UPDATE projects SET project_name=:project_name, project_details=:project_details, project_link=:project_link, project_git=:project_git, project_screen=:project_screen WHERE id=:id";
      $query = $db->prepare($sql);
      $query->bindParam(':project_screen', $project_screen);
    } else {
      // Si aucun nouveau fichier d'image n'est téléchargé, conserver l'image existante dans la base de données
      $project_screen = $_POST["existing_screen"];

      // Préparer la requête SQL UPDATE sans modifier le champ project_screen
      $sql = "UPDATE projects SET project_name=:project_name, project_details=:project_details, project_link=:project_link, project_git=:project_git WHERE id=:id";
      $query = $db->prepare($sql);
    }

    // Lier les paramètres et exécuter la requête
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':project_name', $project_name);
    $query->bindParam(':project_details', $project_details);
    $query->bindParam(':project_link', $project_link);
    $query->bindParam(':project_git', $project_git);

    if ($query->execute()) {
      // Redirection vers la page d'accueil après la mise à jour réussie
      header('Location: index.php');
      exit();
    } else {
      // Gérer les erreurs qui pourraient survenir lors de la mise à jour
      // Vous pouvez implémenter ici une gestion des erreurs, par exemple afficher un message d'erreur à l'utilisateur
    }
  }
}

// Assurer que l'ID du projet est fourni dans l'URL
if (!isset($_GET["id"])) {
  header("Location: index.php");
  exit();
}

$project_id = $_GET["id"];

// Récupérer les détails du projet depuis la base de données
$sql = "SELECT * FROM projects WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(":id", $project_id);
$stmt->execute();
$project = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le projet n'est pas trouvé, rediriger vers la page d'accueil
if (!$project) {
  header("Location: index.php");
  exit();
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
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $project_id ?>" />
        <input type="hidden" name="existing_screen" value="<?= $project["project_screen"] ?>">
        <div class="form-group">
          <label for="project_name">Nom du projet</label>
          <input type="text" class="form-control" id="project_name" name="project_name" value="<?= $project["project_name"] ?>" required>
        </div>
        <div class="form-group">
          <label for="project_details">Détails du projet</label>
          <textarea class="form-control" id="project_details" name="project_details" rows="3" required><?= $project["project_details"] ?></textarea>
        </div>
        <div class="form-group">
          <label for="project_link">Lien du projet</label>
          <input type="text" class="form-control" id="project_link" name="project_link" value="<?= $project["project_link"] ?>" required>
        </div>
        <div class="form-group">
          <label for="project_git">GitHub du projet</label>
          <input type="text" class="form-control" id="project_git" name="project_git" value="<?= $project["project_git"] ?>" required>
        </div>
        <div class="form-group">
          <label for="existing_screen">Image actuelle du projet</label>
          <img src="assets/img/portfolio/<?= $project["project_screen"] ?>" alt="<?= $project["project_name"] ?>" style="max-width: 200px;" class="img-fluid">
        </div>

        <div class="form-group">
          <label for="project_screen">Nouveau screenshot du projet (laissez vide pour conserver l'image existante)</label>
          <input type="file" class="form-control-file" id="project_screen" name="project_screen">
        </div>
        <button type="submit" class="btn btn-primary">Modifier le projet</button>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
</body>

</html>