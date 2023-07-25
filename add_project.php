<?php

session_start();

// Vérifier si la session n'est pas active ou si l'utilisateur n'est pas authentifié
//if (!isset($_SESSION["user"])) {
  // Redirection vers la page de connexion
  //header("Location: login.php");
  //exit();
//}

include "connect.php";

$project_name = $_POST["project_name"];
$project_details = $_POST["project_details"];
$project_link = $_POST["project_link"];
$project_git = $_POST["project_git"];
$project_screen = $_FILES["project_screen"]["name"];


if (!empty($project_screen)) {
  move_uploaded_file($_FILES["project_screen"]["tmp_name"], "assets/img/portfolio/" . $project_screen);
}

if ($_FILES["project_screen"]["error"] !== UPLOAD_ERR_OK) {
  // Handle the error (e.g., display an error message)
  echo "Error: File upload failed with error code " . $_FILES["project_screen"]["error"];
  exit();
}

$sql = "INSERT INTO portfolio_projects (project_name, project_details, project_link, project_git, project_screen) VALUES ('$project_name', '$project_details', '$project_link', '$project_git', '$project_screen')";

if ($db->query($sql)) {
  // The project was successfully added to the database
  header("Location: index.php");
} else {
  // An error occurred
  echo "Error:";
}

?>
