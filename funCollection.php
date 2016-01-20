<?php

/**
 * Instantiates a PDO object to the db and returns a handle
 */
function dbHandler() {

	global $dbh;
	/* Connect to an ODBC database using driver invocation */
	$dsn = 'mysql:dbname=CS143';
	$user = 'cs143';
	$password = '';

	try {
	    $dbh = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	    die();
	}

	return $dbh;
}

/**
 * Return error page
 */
function print_error() {
	header( 'Error found !' );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Error found !</title>
	</head>
	<body>
		<h1>Error found !</h1>
	</body>
</html>
<?php
	die;
}


function render_table($objects, $link_url, $id_col, $link_col, $table_header = '', $show_headers = true, $skip_col_names = array()) {

	if ( empty( $objects ) ) {
		return ''; 
	}

	$html = '<table border="1">';

	$display_col_names = array_diff_key( $objects[0], $skip_col_names );
	unset( $display_col_names[$id_col] );
	$display_col_names = array_keys( $display_col_names );

	if ( !empty( $table_header) ) {
		$html .= '<tr><th colspan="' . sizeof( $display_col_names ) . '">' . $table_header . '</th></tr>';
	}

	if ( $show_headers ) {
		$html .= '<tr>';
		foreach ( $display_col_names as $col ) {
			$html .= "<td><strong>$col</strong></td>";
		}
		$html .= '</tr>';
	}

	foreach ( $objects as $o ) {
		$html .= '<tr>';
		$id = $o[$id_col];

		foreach ( $display_col_names as $col ) {
			$html .= '<td>';

			if ( $id && $link_url && $col === $link_col ) {
				$html .= hyperlink( $link_url, $id, $o[$col] );
			} else {
				$html .= $o[$col];
			}

			$html .= '</td>';
		}

		$html .= '</tr>';
	}

	$html .= '</table>';
	return $html;
}

/**
 * Appends "?id=" and $id to $url
 */
function url_for_id( $url, $id ) {
	return "$url?id=$id";
}

/**
 * Returns and HTML anchor tag for the given inputs
 * @param $url - url to link to
 * @param $id - parameter to submit as an 'id' GET parameter
 * @param $target
 * @param $text
 */
function hyperlink( $url, $id, $text, $target = NULL ) {
	$a = '<a href="' . url_for_id( $url, $id ) . '"';

	if ( $target )
		$a .= ' target="_blank"';

	$a .= ">$text</a>";
	return $a;
}

/**
 * Redirects to $url and stops execution
 */
function redirect_to( $url ) {
	header( "Location: $url" );
	die;
}

/**
 * Generate the HTML header for each page.
 * @param $title - the page's title
 */
function page_header( $title ) {
?>

<?php
}

/**
 * Generate the HTML footer for each page
 */
function page_footer() {
?>

<?php
}


