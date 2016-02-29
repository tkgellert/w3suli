<?php


$OModeratorok         = array();
$OModeratorok['id']   = 0;
$OModeratorok['Oid']  = 0;
$OModeratorok['Fid']  = -1;
$OModeratorok['CSid'] = -1;


    function setOModerator() {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }


    function getOModeratorForm() {
		$HTMLkod = "";
		
		$HTMLkod .= getFelhasznaloCsoportValasztForm();
		
		
        return $HTMLkod;
    }


    function getOModeratorTeszt() {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }



?>
