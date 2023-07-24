<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    require_once("connect.php");

    //remove special characters
    $id = strip_tags($_GET['id']);

    //select all from projects where the id matches the URL
    $sql = "SELECT * FROM projects WHERE id = :id";
    $query = $db->prepare($sql);

    //check if 'int' in id
    $query->bindValue(":id", $id, PDO::PARAM_INT);

    $query->execute();
    $result = $query->fetch();

    // if no result
    if (!$result) {
        header('Location: index.php');
        exit; // Terminate script execution after redirection
    }

    // Get the image filename from the fetched result (assuming the column is named 'project_screen')
    $imageFilename = $result['project_screen'];

    // Delete the image file from the folder
    $imageFolderPath = 'assets/img/portfolio/'; // Use the correct image folder path
    $imageFilePath = $imageFolderPath . $imageFilename;
    if (file_exists($imageFilePath)) {
        unlink($imageFilePath);
    }

    // Check if the user has confirmed the deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // delete from projects where the id matches the URL
        $sql = "DELETE FROM projects WHERE id = :id";
        $query = $db->prepare($sql);
        // attach :id to id URL
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        require_once('close.php');
        header('Location: backoffice.php');
        exit; // Terminate script execution after redirection
    } else {
        // Display confirmation dialog using JavaScript
        echo "
        <script>
        if (confirm('confirm?')) {
            window.location.href = 'delete.php?id=$id&confirm=yes';
        } else {
            window.location.href = 'backoffice.php';
        }
        </script>
        ";
        exit; // Terminate script execution after displaying the confirmation dialog
    }
} else {
    header('Location: index.php');
    exit; // Terminate script execution after redirection
}
?>
