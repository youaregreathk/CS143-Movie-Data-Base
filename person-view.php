
 <link rel="stylesheet" type="text/css" href="<?php echo 'css.php';?>">
<?php

require_once('funCollection.php');

$id = $_GET['id'] ? $_GET['id'] : '0';

$actor_sql = 'SELECT last, first, sex, dob, dod
	FROM Actor
	WHERE id = :id
	LIMIT 1
';

$director_sql = 'SELECT last, first, dob, dod
	FROM Director
	WHERE id = :id
	LIMIT 1
';

$dbh = dbHandler();
$sth = $dbh->prepare( $actor_sql );
$sth->execute( array( ':id' => $id ) );
$actor = $sth->fetch( PDO::FETCH_ASSOC );

// Check if person is listed as a Director
if ( empty( $actor ) ) {
	$sth = $dbh->prepare( $director_sql );
	$sth->execute( array( ':id' => $id ) );
	$actor = $sth->fetch( PDO::FETCH_ASSOC );
}

if ( empty( $actor ) ) {
	print_error();
}

$acted = 'SELECT Movie.id as id, title as Title, role as Role, year as Year, rating as `Rating`, company as `Producing Company`
	FROM Movie
	JOIN MovieActor ON MovieActor.mid = Movie.id
	WHERE MovieActor.aid = :id
	ORDER BY year, title
';

$sth = $dbh->prepare( $acted );
$sth->execute( array( ':id' => $id ) );
$acted = $sth->fetchAll( PDO::FETCH_ASSOC );

$directed_sql = 'SELECT Movie.id as id, title as Title, year as Year, rating as `Rating`, company as `Producing Company`
	FROM Movie
	JOIN MovieDirector ON MovieDirector.mid = Movie.id
	JOIN Director ON MovieDirector.did = Director.id
	WHERE Director.id = :id
	ORDER BY year, title
';

$sth = $dbh->prepare( $directed_sql );
$sth->execute( array( ':id' => $id ) );
$directed = $sth->fetchAll( PDO::FETCH_ASSOC );

page_header( $actor['first'] . ' ' . $actor['last'] );
?>
		<!--
		<table border=1'>
			<tr><td><?php echo 'Name: ' . $actor['first'] . ' ' . $actor['last']; ?></td></tr>
			<br>
			<tr><td><?php if ( !empty( $actor['sex'] ) ) echo 'Sex: ' . ucfirst( $actor['sex'] ) . '<br>'; ?></td></tr>
			<tr><td><?php echo $actor['dob'] ? 'Born: ' . date( 'F j, Y', strtotime( $actor['dob'] ) ) . '<br>' : ''; ?></td></tr>
			<tr><td><?php echo $actor['dod'] ? 'Died: ' . date( 'F j, Y', strtotime( $actor['dod'] ) ) . '<br>' : ''; ?></td></tr>
		</table>

		-->
        <!--
        <table border=1'>
             <tr>
                  <td><?php echo Name ?></td>
                  <td><?php echo $actor['first']. ' ' . $actor['last']?></td>
             </tr>
             <tr>
                  <td><?php if ( !empty( $actor['sex'] ) ) echo 'Sex: '?></td>
                  <td><?php  echo ucfirst( $actor['sex'] )?></td>
             </tr>
             <tr>
                  <td><?php echo Born ?></td>
                  <td><?php  echo date( 'F j, Y', strtotime( $actor['dob'] ) )?></td>

             </tr>
             <tr>
                  <td><?php echo Died ?></td>
                  <td><?php echo  date( 'F j, Y', strtotime( $actor['dod'] ) ) ?></td>
             </tr>


        </table>
        -->
        <h1> Information</h1>
        <table border='1' class="outPerson">
           <?php
               echo'<tr>';
               echo "<td>Name</td>";
               echo '<td>' . $actor['first']. ' ' . $actor['last'] . '</td>';
               echo'</tr>';
               
              

               if ( !empty( $actor['sex'] ) ) {
               echo'<tr>';
               echo "<td>Sex</td>";
               echo '<td>' . ucfirst( $actor['sex'] ). '</td>';
               echo'</tr>';
              }
              
               echo'<tr>';
               echo "<td>Born</td>";
               echo '<td>' . date( 'F j, Y', strtotime( $actor['dob'] ) ) . '</td>';
               echo'</tr>';
              
            
             	echo'<tr>';
              echo "<td>Died</td>";
              if ($actor['dod'] != '0000-00-00')
                echo '<td>' . date( 'F j, Y', strtotime( $actor['dod'] ) ) . '</td>';
              else
                echo '<td>' . 'Still Alive' . '</td>';
              echo'</tr>';


             ?>
        </table>
        <br>
        
		<?php echo render_table( $directed, 'viewMovie.php', 'id', 'Title', 'Films Directed' ) . '<br>'; ?>
		<?php echo render_table( $acted, 'viewMovie.php', 'id', 'Title', 'Filmography' ); ?>
<?php page_footer(); ?>
    <br>
    <a href="<?php echo 'index.php'; ?>" >Back to Main Menu</a>
