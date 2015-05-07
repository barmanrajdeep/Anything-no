<?php 
	set_time_limit(3600);
	include 'database.php';
	include 'server_side_dom.php';
	//get urls
	$xyz =  "select indexNumber, genreLink from movies";
	$GenreLinks = array();
	$serverName = 'localhost';
	$userName = "rajdeep";
	$password = "barman";
	$dbname = "mdb";

	$db = new database();

	$conn = $db->dbConnect($serverName, $userName, $password, $dbname);

	$result = $db->dbQuery($conn, $xyz);

	while ($row = mysqli_fetch_assoc($result)) {
        /*printf ("%s<br>", getGenre($row[0]));
        set_time_limit(20);*/
        $GenreLinks[$row['indexNumber']] = $row['genreLink'];
    }
    /*print "<pre>";
    print_r($GenreLinks);*/
    
    
    for( $i = 1; $i < count($GenreLinks); $i++) {
    	$abc = "update movies set genre = '".getGenre($GenreLinks[$i])."' where indexNumber = ".$i;
    	$db->dbQuery($conn, $abc);
    }

	$db->dbCloseConnect($conn);
?>