<?php
session_start();

// Vérifier si la session n'est pas active ou si l'utilisateur n'est pas authentifié
//if (!isset($_SESSION["user"])) {
// Redirection vers la page de connexion
//header("Location: login.php");
//exit();
//}

// Include the connect.php file to establish the database connection using PDO
include "connect.php";

// Function to handle form submission and insert a new project into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $project_name = $_POST["project_name"];
  $project_details = $_POST["project_details"];
  $project_link = $_POST["project_link"];
  $project_git = $_POST["project_git"];
  $project_screen = $_FILES["project_screen"]["name"];

  // Prepare the SQL query using placeholders
  $sql = "INSERT INTO projects (project_name, project_details, project_link, project_git, project_screen) VALUES (:name, :details, :link, :git, :screen)";
  $stmt = $conn->prepare($sql);

  // Bind the parameters to the prepared statement
  $stmt->bindParam(":name", $project_name);
  $stmt->bindParam(":details", $project_details);
  $stmt->bindParam(":link", $project_link);
  $stmt->bindParam(":git", $project_git);
  $stmt->bindParam(":screen", $project_screen);

  // Upload the image file to a directory on the server (you may need to adjust the path)
  $target_dir = "assets/img/portfolio/";
  $target_file = $target_dir . basename($_FILES["project_screen"]["name"]);
  move_uploaded_file($_FILES["project_screen"]["tmp_name"], $target_file);

  // Execute the prepared statement
  if ($stmt->execute()) {
    // The project was successfully added to the database
    header("Location: portfolio.php");
    exit;
  } else {
    // An error occurred
    echo "Error: " . $stmt->errorInfo()[2];
  }
}

// Fetch all projects from the database using PDO directly
$sql = "SELECT * FROM projects";
$stmt = $db->query($sql);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

      <form action="backoffice.php" method="post" enctype="multipart/form-data">
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

  <div class="container mt-5">
    <div class="row justify-content-center">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nom du projet</th>
            <th>Détails du projet</th>
            <th>Lien du projet</th>
            <th>GitHub du projet</th>
            <th>Screenshot du projet</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
            foreach ($projects as $project) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($project["project_name"]) . "</td>";
              echo "<td>" . htmlspecialchars($project["project_details"]) . "</td>";
              echo "<td>" . htmlspecialchars($project["project_link"]) . "</td>";
              echo "<td>" . htmlspecialchars($project["project_git"]) . "</td>";
              echo "<td><img src='assets/img/portfolio/" . htmlspecialchars($project["project_screen"]) . "' alt='Screenshot' style='max-width: 100px;'></td>";
              echo "</tr>";
            }
          ?>
          
        </tbody>
      </table>
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
