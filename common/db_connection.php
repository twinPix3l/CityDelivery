<?php

function dbConnection()
{
    global $hostname,$username,$password,$db;
    $res = array("status"=>"ok", "value"=>null);
    $cid = new mysqli($hostname,$username,$password,$db);  
    if ($cid)
    {
        $res["value"] = $cid; 
    }
    else
    {
        $res["status"] = "ko"; 
        $res["value"] = $cid; 
    } 
    return $res;     
}

?>