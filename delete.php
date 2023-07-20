<?php

if (isset($_GET['id']) && !empty($_GET['id'])) {
    require_once("connect.php");

    //remove special characters
    $id = strip_tags($_GET['id']);

    //select all from stagiare where is the url 
    $sql = "SELECT * FROM projects WHERE id = :id";
    $query = $db->prepare($sql);

    //check if 'int' in id
    $query->bindValue(":id", $id, PDO::PARAM_INT);

    $query->execute();
    $result = $query->fetch();
    // if not result
    if (!$result) {
        header('Location: index.php');
    }

    // Check if the user has confirmed the deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // delete from tablename where id is same as url
        $sql = "DELETE FROM projects WHERE id = :id";
        $query = $db->prepare($sql);
        // attach :id too id url
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        require_once('close.php');
        header('Location: backoffice.php');
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
    }
} else {
    header('Location: index.php');
}
?>
