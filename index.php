<?php 
	include 'database.php';
	include 'server_side_dom.php';
	$serverName = 'localhost';
	$userName = "rajdeep";
	$password = "barman";
	$dbname = "mdb";

	$db = new database();
	$conn = $db->dbConnect($serverName, $userName, $password, $dbname);

	$q = 'select name, genre from movies where genre like "%thriller" and year > 2010';
	$result = $db->dbQuery($conn, $q);

	$movies = array();
	$genre = array();
	while ($row = mysqli_fetch_row($result)) {
		array_push($movies, $row[0]);
		array_push($genre, $row[1]);

	}
	$db->dbCloseConnect($conn);
	$str = "<h1>Top 10 movies</h1>";
	$str = $str."<table>";
	for ( $i = 0; $i < count($movies); $i++ ) {
		$str = $str. "<tr><td>".$movies[$i]."</td><td>".$genre[$i]."</td></tr>";
	}
	$str = $str . "</table>";
?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			.serverMessages {display: none;}
		</style>
	</head>
	<body>
		<?php if ( isset($str) && $str != "") print $str?>
	</body>
</html>