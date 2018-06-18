<?php
 require '../../dlgConfig.php';
 if(isset($_POST["Import"])){
		//$con=getdb();
		$filename=$_FILES["file"]["tmp_name"];		
 
 
		 if($_FILES["file"]["size"] > 0)
		 {
			
			  $file = fopen($filename, "r");
			  $getDataControl = fgetcsv($file, 10000, ";");

			  if(isset($getDataControl[5])){
				$k = ";";
			  }else{
				$k = ",";
			  }
			  fclose($file);
			  $file = fopen($filename, "r");

	        while (($getData = fgetcsv($file, 10000, $k)) !== FALSE)
	         {
 
			   print_r($getData);
	           $sql = "INSERT into dataGame (slotType,slotContent,slotDesc,slotSentence,active) 
                   values ('".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."')";
				$conn = new mysqli($GLOBALS["servername"], $GLOBALS["dbusername"], $GLOBALS["dbpassword"], $GLOBALS["dbname"]);
                   $result = mysqli_query($conn, $sql);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							//window.location = \"index.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						//window.location = \"index.php\"
					</script>";
				}
	         }
			$conn->close();
	         fclose($file);	
		 }
	}
 ?>