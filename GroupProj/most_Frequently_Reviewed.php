<?php
	require_once('../../mysqli_config.php'); //Connect to the database
	$query = "SELECT album_Name, artist_Name, COUNT(album_ID) rCount
						 FROM Album_Rating ar JOIN Album_Contributors ac USING (album_ID) JOIN Artist a USING (artist_ID)
						 GROUP BY album_ID, album_Name, artist_Name
						 ORDER BY rCount DESC
						 LIMIT 20";
	$result = mysqli_query($dbc, $query);
	if($result)
		mysqli_fetch_all($result, MYSQLI_ASSOC);
	else {
		echo "<h2>We are unable to process this request right now.</h2>";
		echo "<h3>Please try again later.</h3>";
		exit;
	}
	mysql_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Frequently Reviewed</title>
	<meta charset ="utf-8">
</head>
<body>
	<h2>20 Most Frequently Reviewed Albums</h2>

	<table>
		<tr>
			<th>Album Name</th>
			<th>Artist Name</th>
			<th>Number of Reviews</th>
		</tr>
		<?php foreach ($result as $album) {
			echo "<tr>";
			echo "<td>".$album['album_Name']."</td>";
			echo "<td>".$album['artist_Name']."</td>";
			echo "<td>".$album['rCount']."</td>";
			echo "</tr>";
		}
		?>
	</table>
 	<h4><a href="index.html">Back to Home</a></h4>
</body>
</html>
