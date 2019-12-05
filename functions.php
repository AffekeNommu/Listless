<?php
// globals for test use
$GLOBALS['$servername'] = "127.0.0.1";
$GLOBALS['$username'] = "listuser";
$GLOBALS['$password'] = "listuser";
$GLOBALS['$dbname'] = "test";
//test input to see which function gets used
    $action = $_GET['action'];
    switch($action) {
        case 'get' : get();break;
        case 'insertitem': insertitem();break;
        case 'getcategory': getcategory();break;
        case 'addcategory': addcategory();break;
        case 'tickitem': tickitem();break;
        case 'removeticked': removeticked();break;
        case 'undoremove': undoremove();break;
        case 'deletecategory': deletecategory();break;
        case 'edit': edit();break;
}

function get(){
  $servername = $GLOBALS['$servername'];
  $username = $GLOBALS['$username'];
  $password = $GLOBALS['$password'];
  $dbname = $GLOBALS['$dbname'];
  $output=array();
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname, 3306);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT item, category, checked, idlist FROM list where display=1";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    //stuff into array
     while($row = $result->fetch_assoc()) {
     //make a class object
     $line = (object) [
         'idlist' => $row['idlist'],
         'line' => $row['item'],
         'category' => $row['category'],
         'checked' => $row['checked']
     ];
     //push into array
     array_push($output,$line);
     }
  } else echo '';//need blank array for datatable if empty
  //return as json
  echo json_encode($output);
  $conn->close();
}

function insertitem(){
  $data=$_GET;
  // Create connection
  $servername = $GLOBALS['$servername'];
  $username = $GLOBALS['$username'];
  $password = $GLOBALS['$password'];
  $dbname = $GLOBALS['$dbname'];
  $output=array();
  $conn = new mysqli($servername, $username, $password, $dbname, 3306);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  //Pretty straightforward, get post values and insert into database
  $Item=$data["item"];
  $Category=$data["category"];
  $sql = "INSERT INTO list (item, category) VALUES ('$Item','$Category')";
  if ($conn->query($sql) === TRUE) {
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}

//simple array of shop names
function getcategory(){
  $servername = $GLOBALS['$servername'];
  $username = $GLOBALS['$username'];
  $password = $GLOBALS['$password'];
  $dbname = $GLOBALS['$dbname'];
  $output=array();
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname, 3306);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT category FROM category";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
     array_push($output,$row['category']);
     }
  } else echo '';
  //return as json
  //array_values($output);
  echo json_encode($output);//,JSON_FORCE_OBJECT);
  $conn->close();
}

function addcategory(){
  $data=$_GET;
  // Create connection
  $servername = $GLOBALS['$servername'];
  $username = $GLOBALS['$username'];
  $password = $GLOBALS['$password'];
  $dbname = $GLOBALS['$dbname'];
  $output=array();
  $conn = new mysqli($servername, $username, $password, $dbname, 3306);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  //Pretty straightforward, get post values and insert into database
  $Category=$data["category"];
  $sql = "INSERT INTO category(category) VALUES('$Category')";
  if ($conn->query($sql) === TRUE) {
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}

function deletecategory(){
  $data=$_GET;
  // Create connection
  $servername = $GLOBALS['$servername'];
  $username = $GLOBALS['$username'];
  $password = $GLOBALS['$password'];
  $dbname = $GLOBALS['$dbname'];
  $output=array();
  $conn = new mysqli($servername, $username, $password, $dbname, 3306);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  //Pretty straightforward, get post values and insert into database
  $Category=$data["category"];
  $sql = "delete from category where category=('$Category')";
  if ($conn->query($sql) === TRUE) {
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();

}

function tickitem(){//can set to 0 or 1
  $data=$_GET;
  // Create connection
  $servername = $GLOBALS['$servername'];
  $username = $GLOBALS['$username'];
  $password = $GLOBALS['$password'];
  $dbname = $GLOBALS['$dbname'];
  $output=array();
  $conn = new mysqli($servername, $username, $password, $dbname, 3306);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  //Pretty straightforward, get post values and insert into database
  $idlist=$data["idlist"];
  $tick=$data["tick"];
  $sql = "UPDATE list SET checked='$tick' where idlist='$idlist'";
  if ($conn->query($sql) === TRUE) {
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}

function removeticked(){
  $data=$_GET;
  // Create connection
  $servername = $GLOBALS['$servername'];
  $username = $GLOBALS['$username'];
  $password = $GLOBALS['$password'];
  $dbname = $GLOBALS['$dbname'];
  $output=array();
  $conn = new mysqli($servername, $username, $password, $dbname, 3306);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  //Pretty straightforward, get post values and insert into database
  $sql = "UPDATE list set display=0 where checked=1";
  if ($conn->query($sql) === TRUE) {
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}

function undoremove(){
  $data=$_GET;
  // Create connection
  $servername = $GLOBALS['$servername'];
  $username = $GLOBALS['$username'];
  $password = $GLOBALS['$password'];
  $dbname = $GLOBALS['$dbname'];
  $output=array();
  $conn = new mysqli($servername, $username, $password, $dbname, 3306);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  //Pretty straightforward, get post values and insert into database
  $sql = "UPDATE list set display=1 where timestamp > DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL -15 MINUTE)";
  if ($conn->query($sql) === TRUE) {
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}

function edit(){
//future expansion - when I can think of a clean way to select an item to edit
}

?>
