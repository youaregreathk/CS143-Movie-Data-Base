
 <link rel="stylesheet" type="text/css" href="<?php echo 'css.php';?>">
<?php
require_once( 'funCollection.php' );

$dbh = dbHandler();

function relation_generator( $name, $values, $key_col, $display_col ) {
	$box = '<select name="' . $name . '">';
	foreach ( $values as $value ) {
		$box .= '<option value="' . $value[$key_col] . '">' . $value[$display_col] . '</option>';
	}
	$box .= '</select>';
	return $box;
}

if ( isset( $_POST['submit'] ) ) {
	$mode = $_POST['mode'];

	if ( !in_array( $mode, array('director') ) )
		die('Invalid mode.');

	
		$sql = 'INSERT INTO MovieDirector (mid, did) VALUES(:mid, :did)';
		$stmt = $dbh->prepare( $sql );
		$stmt->execute( array( ':mid' => $_POST['movie'], ':did' => $_POST['director'] ) );
	

	redirect_to( url_for_id( 'viewMovie.php', $_POST['movie'] ) );

} else {
	$movie_sql = 'SELECT CONCAT(title, " (", year, ")") as title, id FROM Movie ORDER BY title';
	//$actor_sql = 'SELECT Actor.id, CONCAT(Actor.first, " ", Actor.last, " (", dob, ")") as Name FROM Actor ORDER BY Actor.first, Actor.last';
	$director_sql = 'SELECT Director.id, CONCAT(Director.first, " ", Director.last, " (", dob, ")") as Name FROM Director ORDER BY Director.first, Director.last';

	$stmt = $dbh->prepare( $movie_sql );
	$stmt->execute();
	$movies = $stmt->fetchAll( PDO::FETCH_ASSOC );

	/*
	$stmt = $dbh->prepare( $actor_sql );
	$stmt->execute();
	$actors = $stmt->fetchAll( PDO::FETCH_ASSOC );
    */
	$stmt = $dbh->prepare( $director_sql );
	$stmt->execute();
	$directors = $stmt->fetchAll( PDO::FETCH_ASSOC );
}

page_header( 'Add Relation' );
?>
	
	

	<div>
		<h1>Add Director to Movie</h1>
		<form method="post">
			<input type="hidden" name="mode" value="director">
			Director: <?php echo relation_generator( 'director', $directors, 'id', 'Name' ); ?><br>
			Movie: <?php echo relation_generator( 'movie', $movies, 'id', 'title' ); ?><br>
			<input type="submit" name="submit" value="Save">
		</form>
	</div>
			<a href="<?php echo 'index.php'; ?>" >Back to Main Menu</a>
<?php

page_footer();
?>
