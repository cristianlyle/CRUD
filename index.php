

    <?php 
    include_once("connect.php");

    if (!isset($conn)) {
        die("Database connection not established.");
    }

    try {
        $statement = $conn->prepare("SELECT * FROM user_tbl");
        $statement->execute();
        $dental = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
?>





<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <title></title>

  </head>
  <body>
    <div>
    <h1 style="text-align: center">ACCOUNT DETAILS</h1>

    <a href="add.php" type="button" class="btn btn-success">Add User</a>
    
    <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">User ID</th>
      <th scope="col">User Pic</th>
      <th scope="col">Firstname</th>
      <th scope="col">Lastname</th>
      <th scope="col">Sex</th>
      <th scope="col">Age</th>
      <th scope="col">Contact</th>
      <th scope="col">Address</th>
      <th scope="col">Birthdate</th>
      <th scope="col">Account Type</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($dental as $i => $dental): ?>
        <tr>
            <th scope="row"><?php echo $i + 1 ?> </th>
            <td> <?php echo $dental['u_id'] ?> </td>
            <td> <img src= <?php echo $dental['u_image'] ?> class = "size"></td>
            <td> <?php echo $dental['u_firstname'] ?> </td>
            <td> <?php echo $dental['u_lastname'] ?> </td>
            <td> <?php echo $dental['u_sex'] ?> </td>
            <td> <?php echo $dental['u_age'] ?> </td>
            <td> <?php echo $dental['u_contact'] ?> </td>
            <td> <?php echo $dental['u_address'] ?> </td>
            <td> <?php echo $dental['u_birthdate'] ?> </td>
            <td> <?php echo $dental['u_account'] ?> </td>
            
            <td>
                <a href = "update.php?id= <?php echo htmlspecialchars($dental['u_id']); ?>" type="button" class="btn btn-primary btn-sm">Edit</a>
           
                <!-- <a href ="delete.php?id=<?php echo $dental['u_id']?>" type="button" class="btn btn-danger btn-sm ">Delete</a> -->
                
                <form style ="display: inline-block" method = "POST" action="delete.php">
                    <input type="hidden" name = "id"  value = "<?php echo $dental['u_id']?>">
                    <button type="submit" class="btn btn-danger btn-sm ">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    </div>
  </body>

</html>
