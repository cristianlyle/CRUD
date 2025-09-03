<?php

include_once('users.php');

$id = $_POST['id'] ?? null;

if(!$id){
    header('Locatoion: create.php');
    exit;
}

$statement = $conn->prepare("DELETE FROM user_tbl WHERE u_id = :id");
$statement -> bindValue(':id', $id);
$statement -> execute();

header('Location: users.php');


// echo "FILES: ";
// var_dump($id);
// echo '</pre>';

?>