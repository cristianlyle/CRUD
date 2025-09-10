<?php

include_once("connect.php");

$errors = [];
$result = false;
$ufname = '';
$ulname = '';
$usex = '';
$uage = '';
$ucontact = '';
$uaddress = '';
$ubirthdate = '';
$uaccount = '';
$ustatus = 'active';
$imagePath = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ufname = trim($_POST['fname']);
    $ulname = trim($_POST['lname']);
    $usex = trim($_POST['sex']);
    $uage = trim($_POST['idad']);
    $ucontact = trim($_POST['contact']);
    $uaddress = trim($_POST['address']);
    $ubirthdate = trim($_POST['bdate']);
    $uaccount = trim($_POST['atype']);

    // Validate inputs
    if (!$ufname) {
        $errors[] = 'User Firstname is required';
    }
    if (!$ulname) {
        $errors[] = 'User Lastname is required';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = randomString(8) . '-' . basename($_FILES['image']['name']);
        $uploadDir = 'images/';
        $imagePath = $uploadDir . $imageName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($imageTmpPath, $imagePath)) {
            $errors[] = 'Error uploading the image';
        }
    } else {
        $errors[] = 'Image is required';
    }

    if (empty($errors)) {
        $statement = $conn->prepare("INSERT INTO user_tbl (u_firstname, u_lastname, u_contact, u_sex, u_age, u_address, u_birthdate, u_account, u_status, u_image) 
        VALUES (:ufname, :ulname, :ucontact, :usex, :uage, :uaddress, :ubirthdate, :uaccount, :ustatus, :uimage)");

        $statement->bindValue(':ufname', $ufname);
        $statement->bindValue(':ulname', $ulname);
        $statement->bindValue(':ucontact', $ucontact);
        $statement->bindValue(':usex', $usex);
        $statement->bindValue(':uage', $uage);
        $statement->bindValue(':uaddress', $uaddress);
        $statement->bindValue(':ubirthdate', $ubirthdate);
        $statement->bindValue(':uaccount', $uaccount);
        $statement->bindValue(':ustatus', $ustatus);
        $statement->bindValue(':uimage', $imagePath);

        $result = $statement->execute();
        if ($result) {
            echo "<script>alert('Create Successfully')</script>";
        } else {
            $errors[] = 'Database error';
        }
    }
}

function randomString($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Reservation</title>
</head>
<body>
    <div>
        <h1>Create User!</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($result): ?>
            <div class="alert alert-success">
                <?php echo 'Create Successfully!' ?>
            </div>
        <?php endif; ?>

        <form class="row g-3" method="post" action="create.php" enctype="multipart/form-data">
            <div class="md-3">
                <label for="image" class="form-label">User Picture</label>
                <input type="file" name="image" class="form-control" id="image">
            </div>
            <div class="col-md-6">
                <label for="fname" class="form-label">Firstname</label>
                <input type="text" name="fname" class="form-control" id="fname">
            </div>
            <div class="col-md-6">
                <label for="lname" class="form-label">Lastname</label>
                <input type="text" name="lname" class="form-control" id="lname">
            </div>
            <div class="col-md-3">
                <label for="sex" class="form-label">Gender</label>
                <select class="form-select" name="sex" id="sex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="idad" class="form-label">Age</label>
                <input type="text" name="idad" class="form-control" id="idad">
            </div>
            <div class="col-md-6">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" id="contact">
            </div>
            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" class="form-control" id="address"></textarea>
            </div>
            <div class="col-md-6">
                <label for="bdate" class="form-label">Birth Date</label>
                <input type="date" name="bdate" class="form-control" id="bdate">
            </div>
            <div class="col-md-6">
                <label for="atype" class="form-label">Account Type</label>
                <select class="form-select" name="atype" id="atype">
                    <option value="Manager">Manager</option>
                    <option value="FrontDesk">Front Desk</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
