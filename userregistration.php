<?php
$con= mysqli_connect('localhost', 'root', '', 'userregistration');
if (!$con){
    echo "Connection Failed";
}
if (isset($_POST['btn'])){
    $username= $_POST['username'];
    $fn= $_POST['fn'];
    $query= "INSERT INTO registration VALUES ('$username', '$fn')";
    $result= mysqli_query($con, $query);
    if ($result){
        echo "<script>alert('Data inserted Successfully');</script>";
    }
    else{
        echo "<script>alert('Data not inserted');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>User Registration Form</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter your username">
        <input type="text" name="fn" placeholder="Enter your father name">
        <button name="btn">Submit</button>
    </form>
</body>
</html>