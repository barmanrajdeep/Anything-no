<html>
	<head>
		<title></title>
		<style>
			form[name='consoleData'] textarea {
				height: 180px;
				width: 1001px;
			}
		</style>
	</head>
	<body>
		<form action="admin.php" method="get">
			<table>
				<tr>
					<td>Name: <input type="text" name="name" value=""/></td>
					<td>IMDB Rating: <input type="number" step="0.1" name="iRating" value=""/></td>
					<td>Cast: <input type="text" name="cast" value=""/></td>
					<td>Year: <input type="number" name="year" value=""/></td>
					<td><input type="submit" name="submit" value="Single Submit"/></td>
				</tr>
			</table>
		</form>

		<!-- The data encoding type, enctype, MUST be specified as below -->
		<form enctype="multipart/form-data" action="fileUpload.php" method="POST">
		    <!-- MAX_FILE_SIZE must precede the file input field -->
		    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
		    <!-- Name of input element determines name in $_FILES array -->
		    Send this file: <input name="userfile" type="file" />
		    <input type="submit" value="Send File" />
		</form>
		
		<form name="consoleData" action="admin.php" method="post">
			<table>
				<tr><td>All: </td><td><textarea name="all"><?php if (!isset($_POST['all'])) echo ""; else echo $_POST['all']; ?></textarea></td></tr>
				<tr><td></td><td><input type="submit" name="submit" value="Submit Console Data"/></td></tr>
			</table>
		</form>

		<script src="consoleData.js">
		</script>
	</body>
</html>
<?php

	include 'database.php';
	include 'server_side_dom.php';
	$serverName = 'localhost';
	$userName = "rajdeep";
	$password = "barman";
	$dbname = "mdb";

	$db = new database();
	
	if ( isset($_GET['submit']) ) {

		$conn = $db->dbConnect($serverName, $userName, $password, $dbname);

		$name = mysqli_real_escape_string($conn, $_GET['name']);
		$rating = mysqli_real_escape_string($conn, $_GET['iRating']);
		$cast = mysqli_real_escape_string($conn, $_GET['cast']);
		$year = mysqli_real_escape_string($conn, $_GET['year']);
		$abc = "insert into movies(name, imdbRating, cast, year) values('".$name."',".$rating.",'".$cast."',".$year.")";
		$db->dbQuery($conn, $abc);
		$db->dbCloseConnect($conn);
	}

	if ( isset($_POST['submit']) ) {

		$infoArray = json_decode($_POST['all'], true);
		$conn = $db->dbConnect($serverName, $userName, $password, $dbname);
		
		// creating the insert string
		$lengthOfDataArray = count($infoArray['titles']);
		$queryStr = "insert into movies(name, genreLink, imdbRating, cast, year, director) values";
		$ing = "";
		for ( $i = 0; $i < $lengthOfDataArray; $i++ ) {
			$title = mysqli_real_escape_string($conn, $infoArray['titles'][$i]);
			$genreLink = $infoArray['pageUrls'][$i];
			if ( !$infoArray['ratings'][$i] ) $rate = 0; else $rate = $infoArray['ratings'][$i]; 
			$rating = mysqli_real_escape_string($conn, $rate);
			$cast = mysqli_real_escape_string($conn, implode(', ', $infoArray['names'][$i]));
			$date = mysqli_real_escape_string($conn, substr($infoArray['dates'][$i], 1, 4));
			$director = mysqli_real_escape_string($conn, $infoArray['directors'][$i]);
			$ing = $ing ."('". $title ."',"."'". $genreLink ."',". $rating .",'". $cast ."',". $date .",'".$director. "')";
			if ($i < $lengthOfDataArray - 1) $ing = $ing .", ";
			set_time_limit(0);
		}
		$queryString = $queryStr . $ing;
		
		// saving to database
		$db->dbQuery($conn, $queryString);
		print '<div>';
		print $queryString;
		print '</div>';
		$db->dbCloseConnect($conn);

	}
		
?>