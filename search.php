
 <link rel="stylesheet" type="text/css" href="<?php echo 'css.php';?>">
<?php

require_once( 'funCollection.php' );

$term = isset ( $_GET['term'] ) ? $_GET['term'] : '';

if ( '' === $term ) {
	page_header( 'Search ' );
	?>
	<form method="get">
	    <br>
		<h3>To search for an actor or movie, input your search term before. Multiple terms (e.g. "a b") will be treated as "a AND b".</h3>
		<input type="text" name="term">
		<input type="submit" value="Search">
	</form>
			
	<?php
	page_footer();
} else {
	page_header( 'Search Results for ' . $term );

	$term_list = explode( ' ', strtolower( $term ) );

	$actor_sql = 'SELECT Actor.id, CONCAT(Actor.first, " ", Actor.last, " (", dob, ")") as Name FROM Actor WHERE 1';
	$director_sql = 'SELECT Director.id, CONCAT(Director.first, " ", Director.last, " (", dob, ")") as Name FROM Director WHERE 1';
	$movie_sql = 'SELECT Movie.id, CONCAT(Movie.title, " (", year, ")") as title FROM Movie WHERE 1';

	// No PDO bindings here because of some wonkiness concerning bindings that are not surrounded by whitespace
	foreach ( $term_list as $individual_term ) {
		$actor_sql .= ' AND ( LOWER(Actor.first) LIKE "%' . $individual_term . '%" OR LOWER(Actor.last) LIKE "%' . $individual_term . '%" )';
		$director_sql .= ' AND ( LOWER(Director.first) LIKE "%' . $individual_term . '%" OR LOWER(Director.last) LIKE "%' . $individual_term . '%" )';
		$movie_sql .= ' AND LOWER(Movie.title) LIKE "%' . $individual_term . '%"';
	}

	$dbh = dbHandler();

	$stmt = $dbh->prepare( $actor_sql );
	$stmt->execute();
	$actors = $stmt->fetchAll( PDO::FETCH_ASSOC );

	$stmt = $dbh->prepare( $director_sql );
	$stmt->execute();
	$directors = $stmt->fetchAll( PDO::FETCH_ASSOC );

	$stmt = $dbh->prepare( $movie_sql );
	$stmt->execute();
	$movies = $stmt->fetchAll( PDO::FETCH_ASSOC );

	echo '<div><h2>Actor Results for <em>' . implode( $term_list, ' AND ' ) . '</em></h2>';
	echo render_table( $actors, 'person-view.php', 'id', 'Name', '', false ) . '</div>';

	echo '<div><h2>Director Results for <em>' . implode( $term_list, ' AND ' ) . '</em></h2>';
	echo render_table( $directors, 'person-view.php', 'id', 'Name', '', false ) . '</div>';

	echo '<div><h2>Movie Results for <em>' . implode( $term_list, ' AND ' ) . '</em></h2>';
	echo render_table( $movies, 'viewMovie.php', 'id', 'title', '', false ) . '</div>';
     
	page_footer();

}
?>
<br>
<a href="<?php echo 'index.php'; ?>" >Back to Main Menu</a>