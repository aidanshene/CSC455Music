<?php
  if(!empty($_GET['lowEnd'] && !empty($_GET['highEnd'])) {
    require_once('../../mysqli_config.php');

    $low = $_GET['lowEnd'];
    $high = $_GET['highEnd'];

    $query = "SELECT album_Name, artist_Name, release_Date
              FROM Album JOIN Artist USING (artist_ID) JOIN Album_Contributors USING(album_ID)
              WHERE release_Date BETWEEN ? AND ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "ss", $low, $high);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
  }
  else {
    echo "<h2>You were missing either a start or end date</h2>";
    echo "<h3><a href=\"betweenDates.html\">Try entering search parameters again</a><h3>";
    exit;
  }
  mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Album Results</title>
    <meta charset="utf-8">
</head>
<body>
  <h2>Albums released between<?php echo $low?>and<?php echo $high?></h2>

  <table>
    <tr>
      <th>Album Name</th>
      <th>Artist Name</th>
      <th>Release Date</th>
    </tr>
    <?php foreach ($result as $album) {
      echo "<tr>";
      echo "<td>".$album['album_Name']."</td>";
      echo "<td>".$album['artist_Name']."</td>";
      echo "<td>".$album['release_Date']."</td>";
      echo "</tr>";
    }
    ?>
  </table>
  <h4><a href="betweenDates.html">Search between other dates</a></h4>
  <h4><a href="index.html">Back to Home</a></h4>
</body>
</html>
