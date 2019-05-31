<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
//variables
$id = $_POST['id'];
$imgId = $_POST['imgId'];
$img = $_FILES['file']['name'];
$newfolder = "../../images/project_img/".$id;
$setImg = "images/project_img/".$id."/".$img;
//---------------------------------------
//ADD FOLDER CODE
//---------------------------------------

// check to see if the directory exists
if (file_exists($newfolder)) {
   // echo "The $newfolder directory exists!!!!<br /><br />";
} else {
    mkdir($newfolder, 0777); // Make new folder and set file permissions on it ( chmod )
   // echo "The $newfolder directory has been created<br /><br />";
}
//---------------------------------------
//ADD IMG CODE
//---------------------------------------


$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))

&& in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
      //  echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
         


        if (file_exists($newfolder."/" . $_FILES["file"]["name"]))
        {
           // echo $_FILES["file"]["name"] . " <span style='color: red; font-weight: bold;'>もう存在しています</span>. ";
        }
        else
        {
            move_uploaded_file($_FILES["file"]["tmp_name"],
            $newfolder."/" . $_FILES["file"]["name"]);
           // echo "Stored in: " . $newfolder."/" . $_FILES["file"]["name"];

        }
    }
}
else
{
   // echo "Invalid file";
}
//---------------------------------------
//ADD IMG CODE
//---------------------------------------
$sqlID = "UPDATE tfProject
					SET 
				$imgId = '$setImg'
					WHERE
				id = '$id'";


$resID = mysql_query($sqlID);

header("location: ../tfProject.php?pr=2&id=$id&message=success&info=イメージアプロード完成!!!!");
?>