<?php

function db_connect(){

  $config = parse_ini_file( dirname(__FILE__). "/db.ini", true);
  // $config = parse_ini_file( dirname(__FILE__). "/db_local.ini", true);

  $host = $config['database']['host'];
  $user = $config['database']['user'];
  $pass = $config['database']['pass'];
  $dbname = $config['database']['dbname'];

  $conn = mysql_connect($host, $user, $pass);

  if(! $conn ) {
    die('Could not connect: ' . mysql_error());
  }

  mysql_select_db($dbname, $conn);

  return $conn;
}

function db_disconnect($conn){
  mysql_close($conn);
}