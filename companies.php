<?php

class Companies{

  static function getAll(){
    $sqlstring = "SELECT * FROM companies";
    $result = mysql_query($sqlstring);
    while($row = mysql_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
  }

  static function get($id){
    $sqlstring = "select * from companies where id = " . $id . "";
    $result = mysql_query($sqlstring);
    $row = mysql_fetch_assoc($result);
    return $row;
  }

  static function update($id, $attrs){
    $description = filter_var($attrs['description'], FILTER_SANITIZE_STRING);
    $sqlstring = "update companies set description = '" . $description . "' where id = " . $id . "";
    $result = mysql_query($sqlstring);
    if($result){
      return array('success'=>true);
    }else{
      return array('success'=>false, 'message'=>'there was a problem updating the company record');
    }
  }

 }

 ?>