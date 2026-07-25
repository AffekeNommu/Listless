<?php
// globals for test use
//$GLOBALS['$listfile'] = "/listfile.json";
//$GLOBALS['$catfile'] = "/catfile.json";
// set the files from the ID when we have it
$GLOBALS['$listfile'] = "/listfile-" . $_GET['listlessID'] . ".json";
$GLOBALS['$catfile'] = "/catfile-" . $_GET['listlessID'] . ".json";
//test input to see which function gets used
$action = $_GET['action'];
switch ($action) {
  case 'get':
    get();
    break;
  case 'insertitem':
    insertitem();
    break;
  case 'getcategory':
    getcategory();
    break;
  case 'addcategory':
    addcategory();
    break;
  case 'tickitem':
    tickitem();
    break;
  case 'removeticked':
    removeticked();
    break;
  case 'undoremove':
    undoremove();
    break;
  case 'deletecategory':
    deletecategory();
    break;
  case 'edititem':
    edit();
    break;
  case 'newlist':
    newlist();
    break; //is this needed?
  default:
    echo "no action specified";
    break;
}

//Should this have been done? Yeah probably not. 
//A database makes a lot of the data manipulation so much easier.
//But here we go on a wild ride of handling the data in json files.
//Buckle up

function get()
{
  $listfile = $GLOBALS['$listfile'];
  //load the file
  $list = file_get_contents(__DIR__ . "$listfile");
  if ($list != "null" && $list != false) {
    //get the entry into an array
    $list = json_decode($list);
    //only show the display ones
    if (sizeof($list) == 1 && $list[0]->display == '0') {
      $list = [];
    } else {
      //remove from array
      $list = array_values(array_filter($list, function($item) {
        return $item->display != "0";
      }));
    }
  } else {
    //file must be empty or missing so we need an array
    $list = [];
  }
  $json = json_encode($list);
  echo $json;
}

function getcategory()
{
  $catfile = $GLOBALS['$catfile'];
  //load the file
  $result = file_get_contents(__DIR__ . "$catfile");
  echo ($result);
}

function insertitem()
{
  $data = $_GET;
  $listfile = $GLOBALS['$listfile'];
  //load the file
  $list = file_get_contents(__DIR__ . "$listfile");
  //did we get an array? Check if it is not empty or no file found
  if ($list != "null" && $list != false) {
    //get the entry into an array
    $list = json_decode($list);
  } else {
    //file must be empty or missing so we need an array
    $list = [];
  }
  //add a line
  $line = new stdClass();
  $line->idlist = uniqid();
  $line->line = $data['item'];
  $line->line = str_replace("''", "'", $line->line);
  $line->category = $data['category'];
  $line->category = str_replace("''", "'", $line->category);
  $line->checked = "0";
  $line->display = "1";
  $line->stamp = date('c');
  array_push($list, $line);
  //write the amended array back to json
  $json = json_encode($list);
  //write the file
  $result = file_put_contents(__DIR__ . "$listfile", $json);
  return $result;
}

function addcategory()
{
  $data = $_GET;
  $catfile = $GLOBALS['$catfile'];
  $cats = file_get_contents(__DIR__ . "$catfile");
  //did we get an array? Check if it is not empty or no file found
  if ($cats != "null" && $cats != false) {
    //get the entry into an array
    $cats = json_decode($cats);
  } else {
    //file must be empty or missing so we need an array
    $cats = [];
  }
  //add a line to the array
  $line = $data['category'];
  $line = str_replace("''", "'", $line);
  array_push($cats, $line);
  //write the amended array back to json
  $json = json_encode($cats);
  //write the file - will create if missing
  $result = file_put_contents(__DIR__ . "$catfile", $json);
  return $result;
}

function deletecategory()
{
  $data = $_GET;
  $catfile = $GLOBALS['$catfile'];
  //load the file
  $cats = file_get_contents(__DIR__ . "$catfile");
  //get the entry into an array
  $cats = json_decode($cats);
  //remove the value from the array
  $cats = array_diff($cats, array($data['category']));
  //write the amended array back to json
  $json = json_encode($cats);
  //write the file
  $result = file_put_contents(__DIR__ . "$catfile", $json);
  return $result;
}

function tickitem()
{
  //can set to 0 or 1
  $data = $_GET;
  //tick flag set on item in list table
  $idlist = $data["idlist"];
  $tick = $data["tick"];
  $listfile = $GLOBALS['$listfile'];
  //load the file
  $list = file_get_contents(__DIR__ . "$listfile");
  //get the entry into an array
  $list = json_decode($list);
  //Now we have an id of a line in the array to tick
  //let's find it and toggle the checked flag
  foreach ($list as $index => $line) {
    if ($list[$index]->idlist == $idlist) {
      if ($list[$index]->checked == '0') {
        $list[$index]->checked = '1';
      } else {
        $list[$index]->checked = '0';
      }
    }
  }
  //write the amended array back to json
  $json = json_encode($list);
  //write the file
  $result = file_put_contents(__DIR__ . "$listfile", $json);
  return $result;
}

function removeticked()
{
  $data = $_GET;
  $listfile = $GLOBALS['$listfile'];
  //load the file
  $list = file_get_contents(__DIR__ . "$listfile");
  //filter out the display=0
  if ($list != "null" && $list != false) {
    //get the entry into an array
    $list = json_decode($list);
    //if timestamp is old then remove it
    foreach ($list as $index => $line) {
      if ($list[$index]->display == '0') {
        //CLean up the old hidden ones using linux timestamps because math works easily
        $now = strtotime(date('c'));
        $stamp = strtotime($list[$index]->stamp);
        //4 hours ago?
        if ($now - $stamp > 14400) {
          array_splice($list, $index, 1);
        }
      }
      if ($list[$index]->checked == '1') {
        //If something is checked=1 set display=0 and set a timestamp 
        $list[$index]->display = '0';
        $list[$index]->stamp = date('c');
      }
    }
    //write the amended array back to json
    $json = json_encode($list);
    //write the file
    $result = file_put_contents(__DIR__ . "$listfile", $json);
    return $result;
  }
  return "file issue";
}

function undoremove()
{
  $data = $_GET;
  //for all that are display=0 change it to 1
  $listfile = $GLOBALS['$listfile'];
  //load the file
  $list = file_get_contents(__DIR__ . "$listfile");
  //filter out the display=0
  if ($list != "null" && $list != false) {
    //get the entry into an array
    $list = json_decode($list);
    foreach ($list as $index => $line) {
      if ($list[$index]->display == '0') {
        $list[$index]->display = '1';
      }
    }
    //write the amended array back to json
    $json = json_encode($list);
    //write the file
    $result = file_put_contents(__DIR__ . "$listfile", $json);
    return $result;
  }
  return "file issue";
}

function edit()
{
  $data = $_GET;

  //Pretty straightforward, get post values and insert into database
  $idlist = $data["idlist"];
  $Item = $data["line"];
  $Item = str_replace("''", "'", $Item);
  $Category = $data["category"];
  $Category = str_replace("''", "'", $Category);
  $listfile = $GLOBALS['$listfile'];
  //load the file
  $list = file_get_contents(__DIR__ . "$listfile");
  //find the one to edit
  if ($list != "null" && $list != false) {
    //get the entry into an array
    $list = json_decode($list);
    foreach ($list as $index => $line) {
      if ($list[$index]->idlist == $idlist) {
        $list[$index]->line = $Item;
        $list[$index]->category = $Category;
      }
    }
    //write the amended array back to json
    $json = json_encode($list);
    //write the file
    $result = file_put_contents(__DIR__ . "$listfile", $json);
    return $result;
  }
  return "file issue";
}

function newlist()
{
  //Give it an ID and it will create the files for it
  $data = $_GET;
  $name = $data['id'];
  $GLOBALS['$listfile'] = "/listfile" + $name + ".json";
  $GLOBALS['$catfile'] = "/catfile" + $name + ".json";
}
