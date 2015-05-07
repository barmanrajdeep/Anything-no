<?php
	
	// uploading csv data to uploads folder
	if ($_FILES['userfile']['error'] == 4) {
		header('Location: http://localhost/anything-no/admin.php');
		exit;
	}
	$uploaddir = '../uploads/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

	print "<pre>";
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	    echo "File is valid, and was successfully uploaded.\n";
	} else {
	    echo "Possible file upload attack!\n";
	}
	print "</pre>";


	// getting csv data to an array
	$fileHandle = fopen('../uploads/'.$_FILES['userfile']['name'],'r');
	if ($fileHandle !== false) {
		$row = 0;
		$meta_data = array();
		$data = array();
		while( ($row_data = fgetcsv($fileHandle, 0, ',', '"')) !== false) {
            	print "<pre>";
            	if ( $row <= 0 ) array_push($meta_data, $row_data);
            	else array_push($data, $row_data);
            	$row++;
		}
	}
	/*print '<pre>';
	print_r($data);*/
	fclose($fileHandle);

	include 'database.php';
	$serverName = 'localhost';
	$userName = "rajdeep";
	$password = "barman";
	$dbname = "mdb";

	$db = new database();
	$conn = $db->dbConnect($serverName, $userName, $password, $dbname);

	// creating the insert string
	$lengthOfDataArray = count($data);
	$queryStr = "insert into movies(name, imdbRating, cast, year) values";
	$ing = "";
	for ( $i = 0; $i < $lengthOfDataArray; $i++ ) {
		$ing = $ing ."('". $data[$i][0]."',". $data[$i][1] .",'".$data[$i][2] ."',".$data[$i][3] .")";
		if ($i < $lengthOfDataArray - 1) $ing = $ing .", ";
	}
	$queryString = $queryStr . $ing;
	$db->dbQuery($conn, $queryString);
	$db->dbCloseConnect($conn);
?>