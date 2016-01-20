<?php
require_once('funCollection.php');
page_header( 'Index' );
?>
<p>Welcome to the movie and actor database. To begin, please select an option below.</p>
<?php page_footer(); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>CS143 Project 1C - Movie Database - <?php echo htmlspecialchars( $title ); ?></title>
		<link href='http://fonts.googleapis.com/css?family=Lustria|Lato' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo 'css.php'; ?>">
	</head>
	<body>
		<header>
			<h1>Movie Database System</h1>	
			<ul>
				<li><a href="<?php echo 'addActor.php';   ?>">Add Actor</a></li>
				<li><a href="<?php echo 'addDirector.php';   ?>">Add Director</a></li>
				<li><a href="<?php echo 'addMovie.php';    ?>">Add Movie</a></li>
				<li><a href="<?php echo 'relation.php'; ?>">Add (Existing) Actor to movie</a></li>
				<li><a href="<?php echo 'DirectorMovie.php'; ?>">Add (Existing) Director to movie</a></li>
				<li><a href="<?php echo 'search.php';       ?>">Find Person or Movie</a></li>
			</ul>
		</header>
	</body>
</html>
