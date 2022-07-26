<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.html">
    <link rel="stylesheet" href="data.php">
</head>
<body>
  <style>
    .error{
      color:  #fc0a0a;
    }
  </style>
<?php


$errors = array('nameErr'=> '', 'surnameErr' =>'', 'idErr' => '', 'dobErr' => '','not_match' => '');
$name = $surname = $id = $dob = "";
if(isset($_POST['submit'])){


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $errors['nameErr'] = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $errors['nameErr'] = "Only letters and white space allowed";
    }
  }
}
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["surname"])) {
    $errors['surnameErr'] = "Surname is required";
  } else {
    $surname =test_input ($_POST["surname"]);
  
    if (!preg_match("/^[a-zA-Z-' ]*$/",$surname)) {
      $errors['surnameErr'] = "Only letters and white space allowed";
    }
  }
}
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["id"])) {
    $errors['idErr'] = "ID is required";
  } else {
    $id = test_input($_POST["id"]);
   
  }
}

  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["dob"])) {
    $errors['dobErr'] = "Date of birth is required";
  } else {
    $dob = test_input($_POST["dob"]);
   
  }
}
$year = date(strtotime('19'.substr($id,0,2)));
if($year != date('Y'($_POST["dob"])))
{
  $errors['not_match']= "date of birth not matching id"; 
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if(array_filter($errors))
{
  //echo 'error inserting data';
}
else{

  
$con = new mysqli('localhost',"root",'','glanzito');
if($con->connect_error){
    die('Failed to connect :'.$con->connect_error);
}else{

    $stmt = $con->prepare("insert into user(name,surname,id,dob)
    values(?,?,?,?)");
    $stmt->bind_param("ssss",$name,$surname,$id,$dob);
    $stmt->execute();
    echo "registerd";
    $stmt->close();
    $con->close(); 
}
}
}
// 


?>

    <div class="page">
        <div>
          <form class="form" action="index.php" method="post" >
          Name: <input type="name" type="name" placeholder="name" name="name">
          <div class = "error"><?php echo $errors['nameErr'] ?></div>
          Surname: <input type="surname" placeholder="surname" name="surname">
          <div class = "error"><?php echo $errors['surnameErr'] ?></div>
          ID: <input type="id" placeholder="id" name="id">
          <div class = "error" ><?php echo $errors['idErr'] ?></div>
          DOB: <input id="dob" type="date" placeholder="date of birth" name="dob" required >
          <div class = "error"><?php echo $errors['dobErr'] ?></div>
          <div class = "error"><?php echo $errors['not_match'] ?></div>
          
          
          
          <button id="btn" type = "submit" name = "submit">Submit</button>
          </form>
          
          
        </div>
    </div>
  
    
</body>
</html>