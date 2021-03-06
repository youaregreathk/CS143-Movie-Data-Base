<?php
/**
 * This file exists as a .php file (instead of a static file) to get around some caching oddities
 * with static files and shared folders on VirtualBox for Windows.
 */
header( 'Content-Type: text/css' );
?>
body {
	font-family: 'Lustria', "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
	font-weight: 300;
	font-size: 14px;
	line-height: 18px;
	width: 1100px;
	margin: 0 auto;
	color: #1A2B2B;
	background-color:#ADD8E6
}

.err-msg {
    color: red;
}

h1, h2, h3, h4, h5, h6 {
	font-family: 'Lato';
}

header {
	margin-bottom: 40px;
}

header h1 {
	font-size: 24px;
	font-weight: bold;
	width: 100%;
	text-align: center;
	margin-top: 25px;
}

ul {
	width: 100%;
	float: left;
	font-size: 14px;
}

li {
	list-style-type: none;
	padding: 5px 20px 5px 0;
}



li a, li a:visited {
	color: #556270;
	font-size: 16px;
}

p, div {
	width: 100%;
	clear: both;
	float: right;
}

.div1{
    float:right;
}

.comment-wrapper {
	width: 45%;
}



.comment {
	border: 4px double gray;
	margin: 5px 0 5px 0;
}

.comment p {
	margin: 5px;
}

<?php
/**
 * End of file...
 */
