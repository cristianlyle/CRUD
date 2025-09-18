<?php

include_once("connect.php");

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header('Location: index.php');
    exit;
}

$statement = $conn->prepare("SELECT * FROM user_tbl WHERE u_id = :id");
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$users = $statement->fetch(PDO::FETCH_ASSOC);

if (!$users) {
    header('Location: index.php');
    exit;
}

$errors = [];
$result = false;
$ufname = $users['u_firstname'] ?? '';
$ulname = $users['u_lastname'] ?? '';
$usex = $users['u_sex'] ?? '';
$uage = $users['u_age'] ?? '';
$ucontact = $users['u_contact'] ?? '';
$uaddress = $users['u_address'] ?? '';
$ubirthdate = $users['u_birthdate'] ?? '';
$uaccount = $users['u_account'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ufname = $_POST['fname'];
    $ulname = $_POST['lname'];
    $usex = $_POST['sex'];
    $uage = $_POST['idad'];
    $ucontact = $_POST['contact'];
    $uaddress = $_POST['address'];
    $ubirthdate = $_POST['bdate'];
    $uaccount = $_POST['atype'];

    // Validate inputs
    if (!$ufname) {
        $errors[] = 'User Firstname is required';
    }
    if (!$ulname) {
        $errors[] = 'User Lastname is required';
    }

 

    if (empty($errors)) {
        $statement = $conn->prepare("UPDATE user_tbl SET u_firstname = :ufname, u_lastname = :ulname, u_contact = :ucontact, u_sex = :usex, u_age = :uage, u_address = :uaddress, u_birthdate = :ubirthdate, u_account = :uaccount WHERE u_id = :id");

        $statement->bindValue(':ufname', $ufname);
        $statement->bindValue(':ulname', $ulname);
        $statement->bindValue(':ucontact', $ucontact);
        $statement->bindValue(':usex', $usex);
        $statement->bindValue(':uage', $uage);
        $statement->bindValue(':uaddress', $uaddress);
        $statement->bindValue(':ubirthdate', $ubirthdate);
        $statement->bindValue(':uaccount', $uaccount);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $result = $statement->execute();
        if ($result) {
            echo "<script>alert('Record Updated Successfully'); window.location.href='users.php';</script>";
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
    <title>Update User</title>
</head>
<body>
    <div>
        <h1></h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="row g-3" method="post" action="" enctype="multipart/form-data">
          
        
            <div class="col-md-6">
                <label for="fname" class="form-label">Firstname</label>
                <input type="text" name="fname" class="form-control" id="fname" value="<?php echo htmlspecialchars($ufname); ?>">
            </div>
            <div class="col-md-6">
                <label for="lname" class="form-label">Lastname</label>
                <input type="text" name="lname" class="form-control" id="lname" value="<?php echo htmlspecialchars($ulname); ?>">
            </div>
            <div class="col-md-3">
                <label for="sex" class="form-label">Gender</label>
                <select class="form-select" name="sex" id="sex">
                    <option value="Male" <?php echo $usex === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $usex === 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="idad" class="form-label">Age</label>
                <input type="text" name="idad" class="form-control" id="idad" value="<?php echo htmlspecialchars($uage); ?>">
            </div>
            <div class="col-md-6">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" id="contact" value="<?php echo htmlspecialchars($ucontact); ?>">
            </div>
            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" class="form-control" id="address"><?php echo htmlspecialchars($uaddress); ?></textarea>
            </div>
            <div class="col-md-6">
                <label for="bdate" class="form-label">Birth Date</label>
                <input type="date" name="bdate" class="form-control" id="bdate" value="<?php echo htmlspecialchars($ubirthdate); ?>">
            </div>
            <div class="col-md-6">
                <label for="atype" class="form-label">Account Type</label>
                <select class="form-select" name="atype" id="atype">
                    <option value="Manager" <?php echo $uaccount === 'Manager' ? 'selected' : ''; ?>>Manager</option>
                    <option value="FrontDesk" <?php echo $uaccount === 'FrontDesk' ? 'selected' : ''; ?>>Front Desk</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="users.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
