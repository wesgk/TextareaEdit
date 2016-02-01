<?php

require_once 'config.php';
require_once 'companies.php';

$conn = db_connect();

$operation = isset( $_POST["operation"] ) ? $_POST["operation"] : null;

if( $operation == 'read' ){
  
  $id = $_POST["id"];
  $call = Companies::get($id);
  echo json_encode($call);

} else if( $operation == 'update' ){
  
  $id = $_POST["id"];
  $attrs['description'] = $_POST["description"];
  $call = Companies::update($id, $attrs);
  if( $call['success'] == true ){
    echo 'success';
  }else{
    echo $call['message'];
  }
}

db_disconnect($conn);

?>