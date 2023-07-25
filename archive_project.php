<?php
// Include the connect.php file to establish the database connection using PDO
include "connect.php";

// Vérifier si l'action et l'ID du projet sont définis dans l'URL
if (isset($_GET["action"]) && isset($_GET["id"])) {
  $action = $_GET["action"];
  $project_id = $_GET["id"];

  // Vérifier si le projet existe dans la base de données
  $sql_check_project = "SELECT COUNT(*) FROM portfolio_projects WHERE id = :project_id";
  $stmt_check_project = $db->prepare($sql_check_project);
  $stmt_check_project->bindParam(":project_id", $project_id);
  $stmt_check_project->execute();
  $project_exists = $stmt_check_project->fetchColumn();

  if ($project_exists) {
    // Mettre à jour le statut d'archivage du projet
    if ($action === "archive") {
      $is_archived = 1;
    } elseif ($action === "unarchive") {
      $is_archived = 0;
    }

    // Mettre à jour le statut d'archivage dans la base de données
    $sql_update_project = "UPDATE portfolio_projects SET is_archived = :is_archived WHERE id = :project_id";
    $stmt_update_project = $db->prepare($sql_update_project);
    $stmt_update_project->bindParam(":is_archived", $is_archived);
    $stmt_update_project->bindParam(":project_id", $project_id);

    if ($stmt_update_project->execute()) {
      // Redirection vers la page "backoffice.php" après la mise à jour
      header("Location: backoffice.php");
      exit;
    } else {
      echo "Erreur lors de la mise à jour du statut d'archivage du projet.";
    }
  } else {
    echo "Projet non trouvé dans la base de données.";
  }
} else {
  echo "Action ou ID du projet non défini.";
}
?>
