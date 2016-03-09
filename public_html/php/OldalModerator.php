<?php
$OModeratorok         = array();
$OModeratorok['id']   = 0;
$OModeratorok['Oid']  = 0;
$OModeratorok['Fid']  = -1;
$OModeratorok['CSid'] = -1;


function initModerator() {
    trigger_error('Not Implemented!', E_USER_WARNING); 
} 
function setOModerator() {
    global $MySqliLink, $Aktoldal;
    $Oid = $Aktoldal['id'];
    $ErrorStr = '';
    //Csoport kiválasztása
    
    if ($_SESSION['AktFelhasznalo'.'FSzint']>3)  {
        $ErrorStr .= setOModeratorCsoportValaszt();
    }
    
    //Felhasználók kiválasztása
    
    if ($_SESSION['AktFelhasznalo'.'FSzint']>3)  {
        if (isset($_POST['submitOModeratorValaszt'])) {
            $MValasztDB = test_post($_POST['MValasztDB']);
            for ($i = 0; $i < $MValasztDB; $i++){
                $id = test_post($_POST["MValasztId_$i"]);
                if ($_POST["MValaszt_$i"]){
                    $SelectStr = "SELECT * FROM OModeratorok WHERE Fid=$id AND OId=$Oid "; //echo $SelectStr."<br>";
                    $result     = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sMod 01 ");
                    $rowDB  = mysqli_num_rows($result);
                    mysql_free_result($result);
                    
                    if($rowDB<1){
                        $InsertIntoStr = "INSERT INTO OModeratorok VALUES ('','$Oid','$id','0')";
                        //echo $InsertIntoStr."<br>";
                        $result     = mysqli_query($MySqliLink,$InsertIntoStr) OR die("Hiba sMod 02 ");
                    }     
                }
                else
                {
                    $SelectStr = "SELECT * FROM OModeratorok WHERE Fid=$id AND OId=$Oid "; //echo $SelectStr."<br>";
                    $result     = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sMod 01 ");
                    $rowDB  = mysqli_num_rows($result);
                    mysql_free_result($result);
                    
                    if($rowDB>0){
                        $DeleteStr = "DELETE FROM OModeratorok WHERE Fid = $id AND Oid = $Oid";
                        //echo $DeleteStr."<br>";
                        $result    = mysqli_query($MySqliLink, $DeleteStr) OR die("Hiba sMod 03 ");
                    }  
                }
            }
        }
    }
    return $ErrorStr;
}
function getOModeratorForm() {
    global $MySqliLink, $Aktoldal;
    $OUrl = $Aktoldal['OUrl'];
    $Oid  = $Aktoldal['id'];
    $HTMLkod  = '';
    $ErrorStr = ''; 
    
    if ($_SESSION['AktFelhasznalo'.'FSzint']>3)  { // FSzint-et növelni, ha működik a felhasználókezelés!!!  
        $HTMLkod .= "<div id='divOModeratorForm' >\n";
        if ($ErrorStr!='') {$HTMLkod .= "<p class='ErrorStr'>$ErrorStr</p>";}
        
        //Csoport kiválasztása
        
        $HTMLkod .= getOModeratorCsoportValasztForm();
        
        //Felhasználó kiválasztása
        
        if($_SESSION['SzerkMCsoport']>0)
        {
            $HTMLkod .= "<div id='divOModeratorValasztForm' >\n";
            
            $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formOModeratorValaszt'>\n";
            $CsId = $_SESSION['SzerkMCsoport'];
            $SelectStr ="SELECT F.id, F.FNev, F.FFNev
                        FROM Felhasznalok AS F
                        LEFT JOIN FCsoportTagok AS FCsT
                        ON FCsT.Fid= F.id 
                        WHERE FCsT.Csid=$CsId";
            $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba gMod 01 ");
            $rowDB  = mysqli_num_rows($result);
            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                $FNev = $row['FNev'];
                $id = $row['id'];
                //Lekérdezzük, van-e már az oldalon moderátor a csoporton belül
                $SelectStr ="SELECT * FROM OModeratorok AS OM
                            JOIN Oldalak AS O
                            ON OM.Oid=O.id 
                            WHERE OM.Fid=$id AND OM.Oid=$Oid";
                $result2      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba gMod 02 ");
                mysqli_free_result(result2);
                $rowDB_2  = mysqli_num_rows($result2);
                if($rowDB_2>0){$checked="checked";}else{$checked="";}
                $HTMLkod .= "<input type='checkbox' name='MValaszt_$i' id='MValaszt_$i' $checked>\n";
                $HTMLkod .= "<label for='MValaszt_$i' class='label_1'>$FNev</label>\n ";
                //id
                $HTMLkod .= "<input type='hidden' name='MValasztId_$i' id='MValasztId_$i' value='$id'><br>\n";
                $i++;
            }
            $HTMLkod .= "<input type='hidden' name='MValasztDB' id='MValasztDB' value='$rowDB'>\n";
            //Submit
            $HTMLkod .= "<input type='submit' name='submitOModeratorValaszt' value='Kiválaszt'><br>\n";        
            $HTMLkod .= "</form>\n";    
            $HTMLkod .= "</div>\n";
        }
        $HTMLkod .= "</div>\n";
    }
    return $HTMLkod;  
}
function getOModeratorCsoportValasztForm(){
    global $MySqliLink, $Aktoldal;
    $OUrl = $Aktoldal['OUrl'];
    $HTMLkod  = '';
    if ($_SESSION['AktFelhasznalo'.'FSzint']>3)  { // FSzint-et növelni, ha működik a felhasználókezelés!!!  
        $CsNev    = '';
        
        $HTMLkod .= "<div id='divOModeratorCsoportValaszt' >\n";
        if ($ErrorStr!='') {
        $HTMLkod .= "<p class='ErrorStr'>$ErrorStr</p>";}
        $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formOModeratorCsoportValaszt'>\n";
        //Felhasználó(k) kiválasztása
        
        $HTMLkod .= "<select name='selectOModeratorCsoportValaszt' size='1'>";
        $SelectStr   = "SELECT id, CsNev FROM FelhasznaloCsoport";  //echo "<h1>$SelectStr</h1>";
        $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sMCsV 01 ");
        while($row = mysqli_fetch_array($result))
        {
            $CsNev = $row['CsNev'];
            if($_SESSION['SzerkMCsoport'] == $row['id']){$Select = " selected ";}else{$Select = "";}
            $HTMLkod.="<option value='$CsNev' $Select >$CsNev</option>";
        }	
        //Submit
        $HTMLkod .= "<input type='submit' name='submitOModeratorCsoportValaszt' value='Kiválaszt'><br>\n";        
        $HTMLkod .= "</form>\n";            
        $HTMLkod .= "</div>\n";    
    }     
    return $HTMLkod;   
}
function setOModeratorCsoportValaszt(){
    global $MySqliLink;
    $ErrorStr = '';
    if ($_SESSION['AktFelhasznalo'.'FSzint']>3)  { // FSzint-et növelni, ha működik a felhasználókezelés!!! 
        
        $CsNev     = '';
        // ============== FORM ELKÜLDÖTT ADATAINAK VIZSGÁLATA ===================== 
        if (isset($_POST['submitOModeratorCsoportValaszt'])) {
            if (isset($_POST['selectOModeratorCsoportValaszt'])) 
            {$CsNev = test_post($_POST['selectOModeratorCsoportValaszt']);}      
            if($CsNev!='')
            {
                $SelectStr   = "SELECT id FROM FelhasznaloCsoport WHERE CsNev='$CsNev' LIMIT 1";  //echo "<h1>$SelectStr</h1>";
                $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sMCsV 02 ");
                $row         = mysqli_fetch_array($result);  mysqli_free_result($result);
                //Ha kiválasztottunk egy másik csoportot, akkor újratöltjük a felhasználókat
                
                if($_SESSION['SzerkMCsoport'] != $row['id']){$_SESSION['SzerkModerator']=0;}
                $_SESSION['SzerkMCsoport'] = $row['id'];
            }
        }
    }
    return $ErrorStr;  
}
function getOModeratorTeszt($Oid) {
    $ModeratorOK = 0;
    global $MySqliLink, $Aktoldal, $SzuloOldal, $NagyszuloOldal;
    
    $Fid = $_SESSION['AktFelhasznalo'.'id'];
    $Oid = $Aktoldal['id'];
    
    $Szulo_Oid     = $SzuloOldal['id']; 
    $Nagyszulo_Oid = $NagyszuloOldal['id'];
    $Dedszulo_Oid  = $NagyszuloOldal['OSzuloId'];
    
    $SelectStr   = "SELECT * FROM OModeratorok WHERE Fid=$Fid AND (Oid=$Oid OR Oid=$Szulo_Oid OR Oid=$Nagyszulo_Oid OR Oid=$Dedszulo_Oid)";
    $result     = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba gMT 01 ");
    $rowDB  = mysqli_num_rows($result);
    mysql_free_result($result);
                    
    if($rowDB>0){$ModeratorOK=1;}

    return $ModeratorOK;
}
?>