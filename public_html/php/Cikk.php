<?php

// http://webfejlesztes.gtportal.eu/index.php?f0=7_tobbtbl
// http://webfejlesztes.gtportal.eu/index.php?f0=7_friss_04
// CLathatosag értékei: 0 = rendszergazdák, moderátorok, tulajdonos
//                      1 = csoport tagjai ????
//                      2 = bejelentkezett felhasználók
//                      3+ = nyilvános
/*
//Minta tömb
$Cikkek                      = array();
$Cikkek['id']                = '';
$Cikkek['CNev']              = '';
$Cikkek['CLeiras']           = '';
$Cikkek['CTartalom']         = '';
$Cikkek['CLathatosag']       = 0;
$Cikkek['CSzerzo']           = '';
$Cikkek['CSzerzoNev']        = '';
$Cikkek['CLetrehozasTime']   = '';
$Cikkek['CModositasTime']    = '';
 
 */


// ==================== ÚJ CIKK LÉTREHOZÁSA =================
function setUjCikk() {
    global $MySqliLink, $Aktoldal;

    $ErrorStr = "";
    if (($_SESSION['AktFelhasznalo'.'FSzint']>2) && (isset($_POST['submitUjCikkForm']))) {
        $FNev = $_SESSION['AktFelhasznalo'.'FNev'];
        $Fid  = $_SESSION['AktFelhasznalo'.'id'];
        $Oid  = $Aktoldal['id'];
        // ============== HIBAKEZELÉS =====================
        //Az oldalnév ellenőrzése  
        if (isset($_POST['UjCNev'])) {
            $UjCNev      = test_post($_POST['UjCNev']);
            $SelectStr   = "SELECT id FROM Cikkek WHERE CNev = '$UjCNev' LIMIT 1"; 
            $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sUC 01 ");
            $rowDB       = mysqli_num_rows($result); mysqli_free_result($result);
            if ($rowDB > 0) { $ErrorStr .= ' Err002,';}
            if (strlen($UjCNev)>60) { $ErrorStr .= ' Err003,';}
            if (strlen($UjCNev)<3)  { $ErrorStr .= ' Err004,';}
        } else {$ErrorStr = ' Err001,';}
        //Tartalom ellenőrzése
        if (isset($_POST['UjCTartalom'])) {
            $UjCTartalom = test_post($_POST['UjCTartalom']);             
            if ($_SESSION['AktFelhasznalo'.'FSzint']<6) {$UjCTartalom = SzintaxisCsere($UjCTartalom); } // Saját kódolás cseréje HTML elemekre
            if (strlen(!$UjCTartalom)){ $ErrorStr .= ' Err005';}
            
        }
        if (isset($_POST['UjCLeiras']))   {$UjCLeiras   = test_post($_POST['UjCLeiras']);}  else {$UjCLeiras   ='';}
        if (isset($_POST['CLathatosag'])) {$CLathatosag = INT_post($_POST['CLathatosag']);} else {$CLathatosag =0;} 
        if (isset($_POST['CPrioritas']))  {$CPrioritas  = INT_post($_POST['CPrioritas']);}  else {$CPrioritas  =0;} 
        if (isset($_POST['KoElozetes']))  {$KoElozetes  = INT_post($_POST['KoElozetes']);}  else {$KoElozetes  =0;} 
        if (isset($_POST['SZoElozetes'])) {$SZoElozetes = INT_post($_POST['SZoElozetes']);} else {$SZoElozetes =0;} 
        //=========REKORDOK LÉTREHOZÁSA =============
        if ($ErrorStr=='') {
            $InsertStr = "INSERT INTO Cikkek VALUES ('', '$UjCNev', '$UjCLeiras', '$UjCTartalom', $CLathatosag, '$KoElozetes', '$SZoElozetes',
                                                     '$Fid', '$FNev', NOW(), NOW())";
            mysqli_query($MySqliLink, $InsertStr) OR die("Hiba iUC 01 ");

            $InsertStr = "INSERT INTO OldalCikkei VALUES ('', '$Oid', LAST_INSERT_ID(), $CPrioritas)";
            mysqli_query($MySqliLink, $InsertStr) OR die("Hiba iUC 02 ");
        }
    }
    return $ErrorStr;
}

function getUjCikkForm() {
// Az aktuális oldalhoz tartozó cikk létrehozásához szükséges form
    global $Aktoldal;
    $HTMLkod     = '';
    $OUrl        = $Aktoldal['OUrl'];
    $UjCNev      = '';
    $UjCTartalom = '';
    $UjCLeiras   = '';
    $CLathatosag = 0;
    $CPrioritas  = 0;
    if ($_SESSION['AktFelhasznalo'.'FSzint']>2) {
        if (!isset($_POST['submitUjCikkForm']) || $_SESSION['ErrorStr']==''){
        //Ha még nem lett elküldve vagy az új cikk már létrelött
            if (isset($_POST['UjCNev']))      {$UjCNev      = test_post($_POST['UjCNev']);}
            if (isset($_POST['UjCTartalom'])) {$UjCTartalom = STR_post($_POST['UjCTartalom']);}
            if (isset($_POST['UjCLeiras']))   {$UjCLeiras   = test_post($_POST['UjCLeiras']);}
            if (isset($_POST['CLathatosag'])) {$CLathatosag = INT_post($_POST['CLathatosag']);} 
            if (isset($_POST['CPrioritas']))  {$CPrioritas  = INT_post($_POST['CPrioritas']);}
            $OKstr    = '';
            if (isset($_POST['submitUjCikkForm'])){
              $OKstr  = "<div class='OKInfo'>".U_CIKK_OK.". ".U_CIKK_CIM.": ".$UjCNev."</div>";
              $OKstr .= "<p class='time'>".U_LETREHOZVA.":".date("H.i.s.")."<p>";
            } 
            //============FORM ÖSSZEÁLLÍTÁSA===================
            $HTMLkod .= "<div id='divUjCikkForm' >\n";
            $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formUjCikkForm'>\n";
            $HTMLkod .= "<p class='ErrorStr'>$OKstr</p>";
            $HTMLkod .= "<h2>".U_CIKK_LETREHOZ."</h2>\n ";
            $HTMLkod .= "<fieldset> <legend>".U_CIKK_ADAT.":</legend>";
            //Cikk neve
            $HTMLkod .= "<p class='pUjCNev'><label for='CUjNev' class='label_1'>".U_CIM.":</label><br>\n ";
            $HTMLkod .= "<input type='text' name='UjCNev' id='UjCNev' placeholder='".U_CIM."' value='$UjCNev' size='60'></p>\n";
            //Cikk rövid leírása
            $HTMLkod .= "<p class='pUjCLeiras'><label for=UjCLeiras class='label_1'>".U_LEIRAS.":</label><br>\n ";
            $HTMLkod .= "<textarea name='UjCLeiras' id='UjCLeiras' placeholder='".U_LEIRAS."' rows='2' cols='88'>".$UjCLeiras."</textarea></p>\n";
            //Cikk tartalma
            $HTMLkod .= "<p class='pUjCTartalom'><label for='UjCTartalom' class='label_1'>".U_TARTALOM.":</label><br>\n ";
            $HTMLkod .= "<textarea name='UjCTartalom' id='UjCTartalom' placeholder='".U_TARTALOM."' rows='8' cols='88'>".$UjCTartalom."</textarea></p>\n";
            $HTMLkod .= "</fieldset>";
            $HTMLkod .= "<fieldset> <legend>".U_CIKK_LATHATOSAG.":</legend>";
            if ($_SESSION['AktFelhasznalo'.'FSzint']>3) {
                //Láthatóság
                $HTMLkod .="<input type='radio' id='CLathatosag_0' name='CLathatosag' value='0' checked>";
                $HTMLkod .="<label for='CLathatosag_0' class='label_1'>".U_CLA_MODTUL."</label><br>";

                $HTMLkod .="<input type='radio' id='CLathatosag_1' name='CLathatosag' value='1'>";
                $HTMLkod .="<label for='CLathatosag_1' class='label_1'>".U_CLA_FELH."</label><br>";     

                $HTMLkod .="<input type='radio' id='CLathatosag_2' name='CLathatosag' value='2' >";
                $HTMLkod .="<label for='CLathatosag_2' class='label_1'>".U_CLA_CSOP."</label><br>";

                $HTMLkod .="<input type='radio' id='CLathatosag_3' name='CLathatosag' value='3' >";
                $HTMLkod .="<label for='CLathatosag_3' class='label_1'>".U_CLA_MINDENKI."</b></label><br>";  

                $HTMLkod .="<input type='radio' id='CLathatosag_A' name='CLathatosag' value='-1' >";
                $HTMLkod .="<label for='CLathatosag_A' class='label_1'>".U_CLA_ARCHIV."</label><br>";                 
            }
            $HTMLkod .= "</fieldset>";
            $HTMLkod .= "<fieldset> <legend>".U_CIKK_POZ.":</legend>";
            //Prioritas
            $HTMLkod .= "<p class='pCPrioritas'><label for='CPrioritas' class='label_1'>".U_PRIORITAS.":</label>\n ";
            $HTMLkod .= "<input type='number' name='CPrioritas' id='CPrioritas' min='0' max='100' step='1' value='$CPrioritas'></p>\n";
            
            $HTMLkod .= "</fieldset>";
            //Submit
            $HTMLkod .= "<input type='submit' name='submitUjCikkForm' value='".U_BTN_LETRHOZAS."'><br>\n";

            $HTMLkod .= "</form>\n";
            $HTMLkod .= "</div>\n";
        } else {//Ha elküldték és hibás
            if (isset($_POST['UjCNev']))      {$UjCNev      = test_post($_POST['UjCNev']);}
            if (isset($_POST['UjCTartalom'])) {$UjCTartalom = STR_post($_POST['UjCTartalom']);}
            if (isset($_POST['UjCLeiras']))   {$UjCLeiras   = test_post($_POST['UjCLeiras']);}
            if (isset($_POST['CLathatosag'])) {$CLathatosag = INT_post($_POST['CLathatosag']);} 
            if (isset($_POST['CPrioritas']))  {$CPrioritas  = INT_post($_POST['CPrioritas']);}
            
            // ============== HIBAKEZELÉS ===================== 
            $ErrorStr          = '';
            $ErrClassCNev      = ''; 
            $ErrClassCTartalom = ''; 

             //Cikknév
            if (strpos($_SESSION['ErrorStr'],'Err001')!==false) {
              $ErrClassCNev = ' Error '; 
              $ErrorStr    .= U_CERR_CIMNINCS.'!<br>';
            }
            if (strpos($_SESSION['ErrorStr'],'Err002')!==false) {
              $ErrClassCNev = ' Error '; 
              $ErrorStr    .= U_CERR_CIMVANMAR.'!<br>';
            }
            if (strpos($_SESSION['ErrorStr'],'Err003')!==false) {
              $ErrClassCNev = ' Error '; 
              $ErrorStr    .= U_CERR_CIMHOSSZU.'!<br>';
            }
            if (strpos($_SESSION['ErrorStr'],'Err004')!==false) {
              $ErrClassCNev = ' Error '; 
              $ErrorStr    .= U_CERR_CIMROVID.'!<br>';
            }         
            //Cikk tartalom
            if (strpos($_SESSION['ErrorStr'],'Err005')!==false) {
              $ErrClassCTartalom = ' Error '; 
              $ErrorStr         .= U_CERR_TARTNINCS.'!<br>';
            }
            
            $ErrorStr           .= "<p class='time'>".U_ELKULDVE.":".date("H.i.s.")."<p>";  
            $InfoClass           = ' ErrorInfo ';  
            
            //============FORM ÖSSZEÁLLÍTÁSA===================
            $HTMLkod .= "<div id='divUjCikkForm' >\n";
            if ($ErrorStr!='') {$HTMLkod .= "<p class='$InfoClass'>$ErrorStr</p>";} 
            $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formUjCikkForm'>\n";
            $OKstr    = '';

            $HTMLkod .= "<h2>".U_CIKK_LETREHOZ."</h2>\n ";

            $HTMLkod .= "<fieldset> <legend>".U_CIKK_ADAT.":</legend>";
            //Cikk neve
            $HTMLkod .= "<p class='pUjCNev'><label for='CUjNev' class='label_1'>".U_CIKK_CIM.":</label><br>\n ";
            $HTMLkod .= "<input type='text' name='UjCNev' id='UjCNev' class='$ErrClassCNev' placeholder='".U_CIKK_CIM."' value='$UjCNev' size='60'></p>\n";
            //Cikk rövid leírása
            $HTMLkod .= "<p class='pUjCLeiras'><label for=UjCLeiras class='label_1'>".U_LEIRAS.":</label><br>\n ";
            $HTMLkod .= "<textarea name='UjCLeiras' id='UjCLeiras' placeholder='".U_LEIRAS."' rows='2' cols='88'>".$UjCLeiras."</textarea></p>\n";
            //Cikk tartalma
            $HTMLkod .= "<p class='pUjCTartalom'><label for='UjCTartalom' class='label_1'>".U_TARTALOM.":</label><br>\n ";
            $HTMLkod .= "<textarea name='UjCTartalom' id='UjCTartalom' class='$ErrClassCTartalom' placeholder='".U_TARTALOM."' rows='8' cols='88'>".$UjCTartalom."</textarea></p>\n";
           
            $HTMLkod .= "</fieldset>";
            $HTMLkod .= "<fieldset> <legend>".U_CIKK_LATHATOSAG.":</legend>";
            
            if ($_SESSION['AktFelhasznalo'.'FSzint']>3) {
                if($CLathatosag==0){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_0' name='CLathatosag' value='0' $checked>";
                $HTMLkod .="<label for='CLathatosag_0' class='label_1'>".U_CLA_MODTUL."</label><br>";

                if($CLathatosag==1){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_1' name='CLathatosag' value='1' $checked>";
                $HTMLkod .="<label for='CLathatosag_1' class='label_1'>".U_CLA_FELH."</label><br>";     

                if($CLathatosag==2){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_2' name='CLathatosag' value='2' $checked>";
                $HTMLkod .="<label for='CLathatosag_2' class='label_1'>".U_CLA_CSOP."</label><br>";

                if($CLathatosag==3){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_3' name='CLathatosag' value='3' $checked>";
                $HTMLkod .="<label for='CLathatosag_3' class='label_1'>".U_CLA_MINDENKI."</label><br>";  

                if($CLathatosag==-1){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_A' name='CLathatosag' value='-1' $checked>";
                $HTMLkod .="<label for='CLathatosag_A' class='label_1'>".U_CLA_ARCHIV."</b></label><br>";   
            }

            $HTMLkod .= "</fieldset>";
            $HTMLkod .= "<fieldset> <legend>".U_CIKK_POZ.":</legend>";
            //Prioritas
            $HTMLkod .= "<p class='pCPrioritas'><label for='CPrioritas' class='label_1'>".U_PRIORITAS.":</label>\n ";
            $HTMLkod .= "<input type='number' name='CPrioritas' id='CPrioritas' min='0' max='100' step='1' value='$CPrioritas'></p>\n";
            
            $HTMLkod .= "</fieldset>";
            //Submit
            $HTMLkod .= "<input type='submit' name='submitUjCikkForm' value='".U_BTN_LETRHOZAS."'><br>\n";

            $HTMLkod .= "</form>\n";
            $HTMLkod .= "</div>\n";
        }
    }
    return $HTMLkod;
}

// ==================== MEGLÉVŐ CIKK MÓDOSÍTÁSA =================

// egy DIV-be kerül a cikk kiválasztását és a módosítását lehetővé tévő form
// Minte a: Felhasznalo.php

function getCikkValasztForm() {
	// A felhasználóknál készített getFelhasznaloValasztForm() fgv-hez hasonló módon lehetővé teszi 
	// a választást az oldal cikkei közül
	// A $_SESSION['SzerkCik'][id] és a $_SESSION['SzerkCik'][Oid] munkamenet változókban tároljuk az 
	// aktuális cikk adatait
    global $MySqliLink, $Aktoldal;
    $HTMLkod  = '';
    $ErrorStr = '';
    $OUrl     = $Aktoldal['OUrl'];
    $Oid      = $Aktoldal['id'];
    $Fid      = $_SESSION['AktFelhasznalo'.'id'];
    
    if ($_SESSION['AktFelhasznalo'.'FSzint']>2)  { // FSzint-et növelni, ha működik a felhasználókezelés!!!  

        $HTMLkod .= "<div id='divCikkValaszt' >\n";
        if ($ErrorStr!='') {
            $HTMLkod .= "<p class='ErrorStr'>$ErrorStr</p>";
        }
        $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formCikkValaszt'>\n";
        $HTMLkod .= "<h2>".U_CIKK_VAL."</h2>\n";
        $HTMLkod .= "<i>".U_CIKK_VALI1."</i><br>\n";
        //Cikk kiválasztása a lenyíló listából
        $HTMLkod .= "<label for='selectCikkValaszt' class='label_1' id='labelCikkValaszt'>".U_CIKK_MCIM.":</label>\n ";
        $Felkover = '';
        if(($_SESSION['SzerkCikk'.'id']) && (($_SESSION['SzerkCikk'.'id'])>0)) {$Felkover = "class='felkover'";}
        $HTMLkod .= "<select id='selectCikkValaszt' name='selectCikkValaszt' size='1' $Felkover>";
        if ($_SESSION['AktFelhasznalo'.'FSzint']==3) {
            $SelectStr = "SELECT C.id, C.CNev
                            FROM Cikkek AS C
                            LEFT JOIN OldalCikkei AS OC
                            ON OC.Cid= C.id 
                            WHERE OC.Oid=$Oid 
                            AND C.CSzerzo=$Fid";
        } else {
            $SelectStr = "SELECT C.id, C.CNev
                            FROM Cikkek AS C
                            LEFT JOIN OldalCikkei AS OC
                            ON OC.Cid= C.id 
                            WHERE OC.Oid=$Oid";
        }
        $HTMLkod  .= "<option value='Nincs' >".U_CIKK_VALNINCS."</option>";
        $result    = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sCV 01 ");
        $rowDB     = mysqli_num_rows($result); 
        if ($rowDB > 0) {
            while($row    = mysqli_fetch_array($result))
            {
                $CNev     = $row['CNev'];
                if($_SESSION['SzerkCikk'.'id'] == $row['id']){
                    $Select = " selected ";                    
                }else{
                    $Select = "";                    
                }
                $HTMLkod .= "<option value='$CNev' $Select >$CNev</option>";
            }
            mysqli_free_result($result); 
        }
        $HTMLkod .= "</select>";
        //Submit
        $HTMLkod .= "<input type='submit' name='submitCikkValaszt' value='".U_BTN_KIVALASZT."'><br>\n";        
        $HTMLkod .= "</form>\n";            
        $HTMLkod .= "</div>\n";    
    }
           
    return $HTMLkod;
}

function getCikkForm() {
    global $Aktoldal, $MySqliLink;    
    $HTMLkod    = '';
    $OUrl       = $Aktoldal['OUrl'];
    $Oid        = $Aktoldal['id'];
    if ($_SESSION['AktFelhasznalo'.'FSzint']>2) {
        $CNev        = '';
        $CTartalom   = '';
        $CLeiras     = '';
        $CLathatosag = 0;
        $CPrioritas  = 0;
        $KoElozetes  = 0;
        $SZoElozetes = 0;
        $CPrioritas  = 1;
        $ErrorStr    = '';
        $InfoClass   = '';
        if (!isset($_POST['submitCikkForm']) || $_SESSION['ErrorStr']==''){
        //Ha még nem lett elküldve vagy a cikk már módosítva lett
            $id = 0;
            if (isset($_SESSION['SzerkCikk'.'id'])) {$id = $_SESSION['SzerkCikk'.'id'];}
            $SelectStr   = "SELECT * FROM Cikkek WHERE id=$id LIMIT 1"; 
            $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sC 02a ");
            $rowDB       = mysqli_num_rows($result); 
            if ($rowDB > 0) {
                $row         = mysqli_fetch_array($result);  mysqli_free_result($result);            
                $CNev        = $row['CNev'];
                $CLeiras     = $row['CLeiras'];
                $CTartalom   = $row['CTartalom'];
                $CLathatosag = $row['CLathatosag'];
                $KoElozetes  = $row['KoElozetes'];
                $SZoElozetes = $row['SZoElozetes'];
            }
            $SelectStr   = "SELECT * FROM OldalCikkei WHERE Cid=$id AND Oid=$Oid LIMIT 1"; 
            $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sC 02axc ");
            $rowDB       = mysqli_num_rows($result); 
            if ($rowDB > 0) {
                $row         = mysqli_fetch_array($result);              
                $CPrioritas  = $row['CPrioritas'];   
                mysqli_free_result($result);
            }
            if (isset($_POST['submitCikkForm'])){
                $ErrorStr    = "<p class='time'>".U_MODOSITVA.": ".date("H.i.s.")."<p>".$ErrorStr;
                $InfoClass   = ' OKInfo ';
            }   
            

            if ($_SESSION['SzerkCikk'.'id']>0)
            {   //============FORM ÖSSZEÁLLÍTÁSA===================
                $HTMLkod .= "<div id='divCikkForm' >\n";
                $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formCikkForm'>\n"; 
                $HTMLkod .= "<div class='$InfoClass'>$ErrorStr </div>";
                $HTMLkod .= "<h2>".U_CIKK_MOD."</h2>\n";
                $HTMLkod .= "<fieldset> <legend>".U_CIKK_ADAT.":</legend>";
                //Cikk neve
                $HTMLkod .= "<p class='pCNev'><label for='CNev' class='label_1'>".U_CIKK_CIM.":</label><br>\n ";
                $HTMLkod .= "<input type='text' name='CNev' id='CNev' placeholder='".U_CIKK_CIM."' value='$CNev' size='60'></p>\n";
                //Cikk rövid leírása
                $HTMLkod .= "<p class='pCLeiras'><label for=CLeiras class='label_1'>".U_LEIRAS.":</label><br>\n ";
                $HTMLkod .= "<textarea name='CLeiras' id='CLeiras' placeholder='".U_LEIRAS."' rows='2' cols='88'>".$CLeiras."</textarea></p>\n";
                //Cikk tartalma
                $HTMLkod .= "<p class='pCTartalom'><label for='CTartalom' class='label_1'>".U_TARTALOM.":</label><br>\n ";
                $HTMLkod .= "<textarea name='CTartalom' id='CTartalom' placeholder='".U_TARTALOM."' rows='8' cols='88'>".$CTartalom."</textarea></p>\n";
                $HTMLkod .= "</fieldset>";

                if ($_SESSION['AktFelhasznalo'.'FSzint']>3) {
                    //Láthatóság                    
                    $HTMLkod .= "<fieldset> <legend>".U_CIKK_LATHATOSAG.":</legend>";        

                    if($CLathatosag==0){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='CLathatosag_0a' name='CLathatosag' value='0' $checked>";
                    $HTMLkod .="<label for='CLathatosag_0a' class='label_1'>".U_CLA_MODTUL."</label><br>";

                    if($CLathatosag==1){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='CLathatosag_1a' name='CLathatosag' value='1' $checked>";
                    $HTMLkod .="<label for='CLathatosag_1a' class='label_1'>".U_CLA_FELH."</label><br>";     

                    if($CLathatosag==2){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='CLathatosag_2a' name='CLathatosag' value='2' $checked>";
                    $HTMLkod .="<label for='CLathatosag_2a' class='label_1'>".U_CLA_CSOP."</label><br>";

                    if($CLathatosag==3){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='CLathatosag_3a' name='CLathatosag' value='3' $checked>";
                    $HTMLkod .="<label for='CLathatosag_3a' class='label_1'>".U_CLA_MINDENKI."</label><br>";  

                    if($CLathatosag==-1){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='CLathatosag_Aa' name='CLathatosag' value='-1' $checked>";
                    $HTMLkod .="<label for='CLathatosag_Aa' class='label_1'>".U_CLA_ARCHIV."</b></label><br>";  

                    //Előzetes kezdőlapra
                    //$HTMLkod .= "<h2>Cikkelőzetesek megjelenítése kezdőlapon</h2>"; 
                    $HTMLkod .= "</fieldset>";
                    $HTMLkod .= "<fieldset> <legend>".U_CIKKE_KLAP.":</legend>";  
                    if($KoElozetes==0){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='KoElozetes0' name='KoElozetes' value='0' $checked>";
                    $HTMLkod .="<label for='KoElozetes0' class='label_1'>".U_CIKKE_KLAP_N."</label><br>";
                    if($KoElozetes==1){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='KoElozetes1' name='KoElozetes' value='1' $checked>";
                    $HTMLkod .="<label for='KoElozetes1' class='label_1'>".U_CIKKE_KLAP_I."</label><br>";  
                    if($KoElozetes==2){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='KoElozetes2' name='KoElozetes' value='2' $checked>";
                    $HTMLkod .="<label for='KoElozetes2' class='label_1'>".U_CIKKE_KLAP_K."</label>";

                    //Előzetes szülőoldalra
                    //$HTMLkod .= "<h2>Cikkelőzetesek megjelenítése szülőoldalon</h2>";
                    $HTMLkod .= "</fieldset>";
                    $HTMLkod .= "<fieldset> <legend>".U_CIKKE_SZLAP.":</legend>"; 
                    if($SZoElozetes==0){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='SZoElozetes0' name='SZoElozetes' value='0' $checked>";
                    $HTMLkod .="<label for='SZoElozetes0' class='label_1'>".U_CIKKE_SZLAP_N."</label><br>";  
                    if($SZoElozetes==1){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='SZoElozetes1' name='SZoElozetes' value='1' $checked>";
                    $HTMLkod .="<label for='SZoElozetes1' class='label_1'>".U_CIKKE_SZLAP_I."</label><br>"; 
                    if($SZoElozetes==2){$checked=" checked ";}else{$checked="";}
                    $HTMLkod .="<input type='radio' id='SZoElozetes2' name='SZoElozetes' value='2' $checked>";
                    $HTMLkod .="<label for='SZoElozetes2' class='label_1'>".U_CIKKE_SZLAP_K."</label><br>";                     

                    //Prioritas
                    $HTMLkod .= "</fieldset>";
                    $HTMLkod .= "<fieldset> <legend>".U_CIKK_POZ.":</legend>";
                    $HTMLkod .= "<p class='pCPrioritas'><label for='CPrioritas' class='label_1'>".U_PRIORITAS.":</label>\n ";
                    $HTMLkod .= "<input type='number' name='CPrioritas' id='CPrioritas' min='0' max='127' step='1' value='$CPrioritas'></p>\n";
                    $HTMLkod .= "</fieldset>";
                }
                //Submit
                $HTMLkod .= "<input type='submit' name='submitCikkForm' value='".U_BTN_MODOSITAS."'><br>\n";
                $HTMLkod .= "</form>\n";
                $HTMLkod .= "</div>\n";
            } else {
                $HTMLkod .= "<div id='divCikkForm' >\n";
                $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formCikkForm'>\n"; 

                $HTMLkod .= "<h2>".U_CIKK_NINCS."!</h2>\n";
                $HTMLkod .= "</form>\n";
                $HTMLkod .= "</div>\n";
            }
        } else {//Ha elküldték és hibás 
                      
            if (isset($_POST['CNev']))        {$CNev        = test_post($_POST['CNev']);}
            if (isset($_POST['CTartalom']))   {$CTartalom   = STR_post($_POST['CTartalom']);}
            if (isset($_POST['CLeiras']))     {$CLeiras     = test_post($_POST['CLeiras']);}
            if (isset($_POST['CLathatosag'])) {$CLathatosag = INT_post($_POST['CLathatosag']);} 
            if (isset($_POST['CPrioritas']))  {$CPrioritas  = INT_post($_POST['CPrioritas']);}
            
            if (isset($_POST['KoElozetes']))  {$KoElozetes  = INT_post($_POST['KoElozetes']);}
            if (isset($_POST['SZoElozetes'])) {$SZoElozetes = INT_post($_POST['SZoElozetes']);}
            
            // ============== HIBAKEZELÉS ===================== 
            $ErrorStr            = '';
            $ErrClassCTartalom   = '';
            $ErrClassCNev        = '';
            echo "ErrorStr:".$_SESSION['ErrorStr'];
            if (strpos($_SESSION['ErrorStr'],'Err0')!==false) {
                //Cikknév
               if (strpos($_SESSION['ErrorStr'],'Err001')!==false) {
                 $ErrClassCNev      = ' Error '; 
                 $ErrorStr         .= U_CERR_CIMNINCS.'!<br>';
               }
               if (strpos($_SESSION['ErrorStr'],'Err002')!==false) {
                 $ErrClassCNev      = ' Error '; 
                 $ErrorStr         .= U_CERR_CIMVANMAR.'!<br>';
               }
               if (strpos($_SESSION['ErrorStr'],'Err003')!==false) {
                 $ErrClassCNev      = ' Error '; 
                 $ErrorStr         .= U_CERR_CIMHOSSZU.'!<br>';
               }
               if (strpos($_SESSION['ErrorStr'],'Err004')!==false) {
                 $ErrClassCNev      = ' Error '; 
                 $ErrorStr         .= U_CERR_CIMROVID.'!<br>';
               }         
               //Cikk tartalom
               if (strpos($_SESSION['ErrorStr'],'Err005')!==false) {
                 $ErrClassCTartalom = ' Error '; 
                 $ErrorStr         .= U_CERR_TARTNINCS.'!<br>';
               }
               $ErrorStr        = "<p class='time'>".U_ELKULDVE.": ".date("H.i.s.")."<p>".$ErrorStr;
               $InfoClass     = ' ErrorInfo ';
            } else {
                $ErrorStr        = "<p class='time'>".U_MODOSITVA.": ".date("H.i.s.")."<p>".$ErrorStr;
                $InfoClass     = ' OKInfo ';
            }    
            
            //============FORM ÖSSZEÁLLÍTÁSA===================
            $HTMLkod .= "<div id='divCikkForm' >\n";
            if ($ErrorStr!='') {$HTMLkod .= "<div class='$InfoClass'>$ErrorStr </div>";}
            $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formCikkForm'>\n";
            $HTMLkod .= "<h2>".U_CIKK_MOD."</h2>\n";
            
            $HTMLkod .= "<fieldset> <legend>".U_CIKK_ADAT.":</legend>";

            //Cikk neve
            $HTMLkod .= "<p class='pCNev'><label for='CNev' class='label_1'>".U_CIKK_CIM.":</label><br>\n ";
            $HTMLkod .= "<input type='text' name='CNev' id='CNev' class='$ErrClassCNev' placeholder='".U_CIKK_CIM."' value='$CNev' size='60'></p>\n";
            //Cikk rövid leírása
            $HTMLkod .= "<p class='pCLeiras'><label for=CLeiras class='label_1'>".U_LEIRAS.":</label><br>\n ";
            $HTMLkod .= "<textarea name='CLeiras' id='CLeiras' placeholder='".U_LEIRAS."' rows='2' cols='88'>".$CLeiras."</textarea></p>\n";
            //Cikk tartalma
            $HTMLkod .= "<p class='pCTartalom'><label for='CTartalom' class='label_1'>".U_TARTALOM.":</label><br>\n ";
            $HTMLkod .= "<textarea name='CTartalom' id='CTartalom' class='$ErrClassCTartalom' placeholder='".U_TARTALOM."' rows='8' cols='88'>".$CTartalom."</textarea></p>\n";
            $HTMLkod .= "</fieldset>";
            
            if ($_SESSION['AktFelhasznalo'.'FSzint']>3) {        
                 //Láthatóság
                    
                $HTMLkod .= "<fieldset> <legend>".U_CIKK_LATHATOSAG.":</legend>";        

                if($CLathatosag==0){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_0b' name='CLathatosag' value='0' $checked>";
                $HTMLkod .="<label for='CLathatosag_0b' class='label_1'>".U_CLA_MODTUL."</label><br>";

                if($CLathatosag==1){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_1b' name='CLathatosag' value='1' $checked>";
                $HTMLkod .="<label for='CLathatosag_1b' class='label_1'>".U_CLA_FELH."</label><br>";     

                if($CLathatosag==2){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_2b' name='CLathatosag' value='2' $checked>";
                $HTMLkod .="<label for='CLathatosag_2b' class='label_1'>".U_CLA_CSOP."</label><br>";

                if($CLathatosag==3){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_3b' name='CLathatosag' value='3' $checked>";
                $HTMLkod .="<label for='CLathatosag_3b' class='label_1'>".U_CLA_MINDENKI."</label><br>";  

                if($CLathatosag==-1){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='CLathatosag_Ab' name='CLathatosag' value='-1' $checked>";
                $HTMLkod .="<label for='CLathatosag_Ab' class='label_1'>".U_CLA_ARCHIV."</label><br>";  

                //Előzetes kezdőlapra
                //$HTMLkod .= "<h2>Cikkelőzetesek megjelenítése kezdőlapon</h2>"; 
                $HTMLkod .= "</fieldset>";
                $HTMLkod .= "<fieldset> <legend>".U_CIKKE_KLAP.":</legend>";  
                if($KoElozetes==0){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='KoElozetes0' name='KoElozetes' value='0' $checked>";
                $HTMLkod .="<label for='KoElozetes0' class='label_1'>".U_CIKKE_KLAP_N."</label><br>";
                if($KoElozetes==1){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='KoElozetes1' name='KoElozetes' value='1' $checked>";
                $HTMLkod .="<label for='KoElozetes1' class='label_1'>".U_CIKKE_KLAP_I."</label><br>";  
                if($KoElozetes==2){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='KoElozetes2' name='KoElozetes' value='2' $checked>";
                $HTMLkod .="<label for='KoElozetes2' class='label_1'>".U_CIKKE_KLAP_K."</label>";

                //Előzetes szülőoldalra
                //$HTMLkod .= "<h2>Cikkelőzetesek megjelenítése szülőoldalon</h2>";
                $HTMLkod .= "</fieldset>";
                $HTMLkod .= "<fieldset> <legend>".U_CIKKE_SZLAP.":</legend>"; 
                if($SZoElozetes==0){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='SZoElozetes0' name='SZoElozetes' value='0' $checked>";
                $HTMLkod .="<label for='SZoElozetes0' class='label_1'>".U_CIKKE_SZLAP_N."</label><br>";  
                if($SZoElozetes==1){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='SZoElozetes1' name='SZoElozetes' value='1' $checked>";
                $HTMLkod .="<label for='SZoElozetes1' class='label_1'>".U_CIKKE_SZLAP_I."</label><br>"; 
                if($SZoElozetes==2){$checked=" checked ";}else{$checked="";}
                $HTMLkod .="<input type='radio' id='SZoElozetes2' name='SZoElozetes' value='2' $checked>";
                $HTMLkod .="<label for='SZoElozetes2' class='label_1'>".U_CIKKE_SZLAP_K."</label><br>"; 
                $HTMLkod .= "</fieldset>";

                //Prioritas            
                $HTMLkod .= "<fieldset> <legend>".U_CIKK_POZ.":</legend>";
                $HTMLkod .= "<p class='pCPrioritas'><label for='CPrioritas' class='label_1'>".U_PRIORITAS.":</label>\n ";
                $HTMLkod .= "<input type='number' name='CPrioritas' id='CPrioritas' min='0' max='127' step='1' value='$CPrioritas'></p>\n";
                $HTMLkod .= "</fieldset>";            
            }
            //Submit
            $HTMLkod .= "<input type='submit' name='submitCikkForm' value='".U_BTN_MODOSITAS."'><br>\n";

            $HTMLkod .= "</form>\n";
            $HTMLkod .= "</div>\n";
        }
    }
    return $HTMLkod;
}

function setCikkValaszt() {
// I.) A $_SESSION['SzerkCik'][id] és a $_SESSION['SzerkCik'][Oid] munkamenet változók beállítása, ha
// a cikkválasztó űrlapot elküdték

// II.) A $_SESSION['SzerkCik'][id] és a $_SESSION['SzerkCik'][Oid] munkamenet változók törlése, ha
// sem a cikkválasztó űrlapot sem a cikk módosítása elküdték nem küldték el (pl. új oldalt töltenek le)	
    global $MySqliLink;
    $ErrorStr = '';
    if ($_SESSION['AktFelhasznalo'.'FSzint']>2)  { // FSzint-et növelni, ha működik a felhasználókezelés!!! 
        $CNev = '';
        // ============== FORM ELKÜLDÖTT ADATAINAK VIZSGÁLATA ===================== 
        if (isset($_POST['submitCikkValaszt'])) {
            if (isset($_POST['selectCikkValaszt'])) {$CNev = test_post($_POST['selectCikkValaszt']);}      

            if($CNev!='')
            {
                if($CNev!='Nincs') {
                    $SelectStr   = "SELECT id FROM Cikkek WHERE CNev='$CNev' LIMIT 1";
                    $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sCV 02 ");
                    $rowDB       = mysqli_num_rows($result); 
                    if ($rowDB > 0) {                    
                        $row     = mysqli_fetch_array($result);  
                        $_SESSION['SzerkCikk'.'id'] = $row['id'];
                        mysqli_free_result($result);
                    } else {
                        $_SESSION['SzerkCikk'.'id'] = 0;                        
                    }
                } else {
                    $_SESSION['SzerkCikk'.'id'] = 0;
                }
            }
        }
    }
    return $ErrorStr;
}


function setCikk() {
  global $MySqliLink, $Aktoldal;
    $ErrorStr    = "";
    $ErrorStr   .= setCikkValaszt();
    $id          = $_SESSION['SzerkCikk'.'id'];
    $CLeiras     = '';
    $CPrioritas  = 0;
    $CLathatosag = 0;
    $KoElozetes  = 0;
    $SZoElozetes = 0;    
    
    if (($_SESSION['AktFelhasznalo'.'FSzint']>2) && (isset($_POST['submitCikkForm']))) {
        $Oid = $Aktoldal['id'];
        // ============== HIBAKEZELÉS =====================
        //Az oldalnév ellenőrzése  
        if (isset($_POST['CNev'])) {
            $CNev      = test_post($_POST['CNev']);
            
            $SelectStr =   "SELECT C.id, C.CNev
                            FROM Cikkek AS C
                            LEFT JOIN OldalCikkei AS OC
                            ON OC.Cid = C.id
                            WHERE OC.Oid=$Oid
                            AND C.CNev='$CNev'";
            $result    = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sMC 01x ");
            $rowDB     = mysqli_num_rows($result);
            if ($rowDB > 0) {
		$row   = mysqli_fetch_array($result);
		if($id!=$row['id']) {$ErrorStr .= ' Err002,';}
                mysqli_free_result($result);
            }                        
            if (strlen($CNev)>60) { $ErrorStr .= ' Err003,';}
            if (strlen($CNev)<3)  { $ErrorStr .= ' Err004,';}
        } else {$ErrorStr = ' Err001,';}
        
         
        //Tartalom ellenőrzése
        if (isset($_POST['CTartalom'])) {
            //$CTartalom = test_post($_POST['CTartalom']); 
            if ($_SESSION['AktFelhasznalo'.'FSzint']<6) {$CTartalom = test_post($_POST['CTartalom']); } else {$CTartalom = SQL_post($_POST['CTartalom']); }
            if ($_SESSION['AktFelhasznalo'.'FSzint']<6) {$CTartalom = SzintaxisCsere($CTartalom); }
            if (strlen(!$CTartalom)){ $ErrorStr .= ' Err005';}
        }
        if (isset($_POST['CLeiras']))     {$CLeiras     = test_post($_POST['CLeiras']);}
        if (isset($_POST['CLathatosag'])) {$CLathatosag = INT_post($_POST['CLathatosag']);}
        if (isset($_POST['CPrioritas']))  {$CPrioritas  = INT_post($_POST['CPrioritas']);}
        if (isset($_POST['KoElozetes']))  {$KoElozetes  = INT_post($_POST['KoElozetes']);}
        if (isset($_POST['SZoElozetes'])) {$SZoElozetes = INT_post($_POST['SZoElozetes']);}

        if ($ErrorStr =='') {
            //==========Névváltozás ellenőrzése===========        
            $SelectStr = "SELECT CNev From Cikkek WHERE id=$id";                       
            $result    = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba CKnv 02345");
            $rowDB     = mysqli_num_rows($result);
            if ($rowDB > 0) {
                $row   = mysqli_fetch_array($result);  mysqli_free_result($result);
                $RCNev = $row['CNev'];
                if ($RCNev!=$CNev) {$ErrorStr=KepekAtnevez($RCNev,$CNev,$id);}

                if ($ErrorStr == '') {
                    //=========REKORDOK MÓDOSÍTÁSA =============        
                    $UpdateStr = "UPDATE Cikkek SET
                                CNev           = '$CNev',
                                CTartalom      = '$CTartalom',
                                Cleiras        =  '$CLeiras',
                                CLathatosag    =  '$CLathatosag', 
                                KoElozetes     =  '$KoElozetes',
                                SZoElozetes    =  '$SZoElozetes',     
                                CModositasTime = NOW()
                                WHERE       id = $id";
                    mysqli_query($MySqliLink,$UpdateStr) OR die("Hiba uMC 01 ");
                    $UpdateStr   = "UPDATE OldalCikkei SET
                                    CPrioritas = $CPrioritas
                                    WHERE   Cid=$id AND Oid=$Oid LIMIT 1"; 
                    mysqli_query($MySqliLink,$UpdateStr) OR die("Hiba uMC 02 ");
                }
            }
            
        }
    }
    return $ErrorStr;
}




// ==================== CIKK TÖRLÉSE =================

function setCikkTorol() { 
    global $MySqliLink, $Aktoldal;
    $ErrorStr = '';
    if (isset($_POST['submitCikkTorol'])) { 
        $SelectStr      = "SELECT Cid FROM OldalCikkei WHERE Oid=".$Aktoldal['id'];
        $result         = mysqli_query($MySqliLink, $SelectStr) OR die("Hiba COT 01");
        $rowDB          = mysqli_num_rows($result); 
        if ($rowDB > 0) {
            while ($row = mysqli_fetch_array($result)){ 
                $i      = $row['Cid']; 
                $SelectStr1 = "SELECT CNev FROM Cikkek WHERE id=".$i;
                $result1    = mysqli_query($MySqliLink, $SelectStr1) OR die("Hiba COT 01");
                $rowDB1     = mysqli_num_rows($result1);
                if ($rowDB1 > 0) {
                    $row1   = mysqli_fetch_array($result1);

                    if (isset($_POST["CikkTorolId_$i"])) {$id = $_POST["CikkTorolId_$i"];} 
                    if (isset($_POST["CikkTorol_$i"])){  
                        $ErrorStr .= U_TOROLVE.":".$row1['CNev']."<br>";
                        $DeleteStr = "DELETE FROM Cikkek WHERE id = $id";
                        mysqli_query($MySqliLink, $DeleteStr);
                        $DeleteStr = "DELETE FROM OldalCikkei WHERE Cid = $id";
                        mysqli_query($MySqliLink, $DeleteStr);
                        CikkOsszesKepTorol($id,$Aktoldal['OImgDir']);
                    }    
                }
            }
            mysqli_num_rows($result);
        }
    }
    return $ErrorStr;
}

function EgyCikkTorol($Cid) {
    global $MySqliLink, $Aktoldal;
    $DeleteStr = "DELETE FROM Cikkek WHERE id = $id";
    mysqli_query($MySqliLink, $DeleteStr);
    $DeleteStr = "DELETE FROM OldalCikkei WHERE Cid = $id";
    mysqli_query($MySqliLink, $DeleteStr);
    CikkOsszesKepTorol($id,$Aktoldal['OImgDir']);
}

function OldalOsszesCikkekTorol($Oid) {
    global $MySqliLink;
    $ErrorStr   = ""; 
    $SelectStr  = "SELECT OImgDir FROM Oldalak WHERE id = $Oid";     
    $result     = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba OOCT1 1"); 
    $rowDB      = mysqli_num_rows($result); 
    if ($rowDB > 0) {
        $row        = mysqli_fetch_array($result, MYSQLI_ASSOC); mysqli_free_result($result);
        $OImgDir    = $row['OImgDir'];
        
        $SelectStr  = "SELECT Cid FROM OldalCikkei WHERE Oid=$Oid";  
        $result     = mysqli_query($MySqliLink, $SelectStr) OR die("Hiba OOCT2 01");
        $rowDB      = mysqli_num_rows($result); 
        if ($rowDB > 0) {
            while ($row = mysqli_fetch_array($result)){   
                $id     = $row['Cid'];
                $ErrorStr .= CikkOsszesKepTorol($id,$OImgDir);
                $DeleteStr = "DELETE FROM Cikkek WHERE id = $id";
                mysqli_query($MySqliLink, $DeleteStr);
                $DeleteStr = "DELETE FROM OldalCikkei WHERE Cid = $id";
                mysqli_query($MySqliLink, $DeleteStr);
            } 
            mysqli_free_result($result);
        }
    }
    return $ErrorStr;
}

function getCikkTorolForm() {
    global $MySqliLink, $Aktoldal;
    $HTMLkod = "";
    $Oid     = $Aktoldal['id'];
    $OUrl    = $Aktoldal['OUrl'];
    $ErrorStr= $_SESSION['ErrorStr'];  
    $Fid     = $_SESSION['AktFelhasznalo'.'id'];
    if ($_SESSION['AktFelhasznalo'.'FSzint']>2) {
        if ($_SESSION['AktFelhasznalo'.'FSzint']==3) {
            $SelectStr = "SELECT C.id, C.CNev
                            FROM Cikkek AS C
                            LEFT JOIN OldalCikkei AS OC
                            ON OC.Cid= C.id 
                            WHERE OC.Oid=$Oid 
                            AND C.CSzerzo=$Fid";
            $result    = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sCT 01 ");
        } else {
            $SelectStr = "SELECT C.id, C.CNev
                            FROM Cikkek AS C
                            LEFT JOIN OldalCikkei AS OC
                            ON OC.Cid= C.id 
                            WHERE OC.Oid=$Oid";
            $result    = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sCT 01 ");
        }
        
        $HTMLkod .= "<div id='divCikkTorolForm' >\n";
        $HTMLkod .= "<h2>".U_CIKK_TOR."</h2>\n";
        $HTMLkod .= "<form action='?f0=$OUrl' method='post' id='formCikkTorolForm'>\n";
        if ($ErrorStr!='') { $HTMLkod .= "<div class=' OKInfo '>$ErrorStr </div>";}
        
        $HTMLkod .= "<p class='FontosStr'>".U_CIKK_TOR1."!</p>";
        $HTMLkod .= "<fieldset> <legend>".U_CIKK_OCIKKEL.":</legend>";
        $i = 0;
        $rowDB       = mysqli_num_rows($result); 
        if ($rowDB > 0) {
            while ($row   = mysqli_fetch_array($result)) {
                $CNev     = $row['CNev'];
                $id       = $row['id'];
                //Törlésre jelölés
                $HTMLkod .= "<p class='pCikkTorol'>".U_TORTLES.":<input type='checkbox' name='CikkTorol_$id' id='CikkTorol_$id'>"
                        . "<label for='CikkTorol_$id' class='label_1'>$CNev</label>\n ";
                $HTMLkod .= "</p>\n";
                //id
                $HTMLkod .= "<input type='hidden' name='CikkTorolId_$id' id='CikkTorolId_$id' value='$id'>\n";
                $i++;
            }
            mysqli_free_result($result);
        }
        $HTMLkod .= "<input type='hidden' name='TorolDB' id='TorolDB' value='$i'>\n";
        $HTMLkod .= "</fieldset>";
        
        $HTMLkod .= "<input type='submit' name='submitCikkTorol' id='submitCikkTorol' value='".U_BTN_TOROL."'>\n";
        $HTMLkod .= "</form>\n";
        $HTMLkod .= "</div>\n";
    }
    return $HTMLkod;
}

function getKezdolapCikkelozetesekHTML($SelStr) {  
    global $MySqliLink, $AlapAdatok;
    $HTMLkod      = '';
    $SelectStr    = $SelStr; 
    $result       = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sMC 01y ");
    $rowDB        = mysqli_num_rows($result);
    if ($rowDB > 0) {
        $AlapKep  = 'img/ikonok/HeaderImg/'.$AlapAdatok['HeaderImg'];
        while ($row    = mysqli_fetch_array($result)){
           $Cid        = $row['Cid']; 
           $CNev       = $row['CNev'];
           $OImgDir    = $row['OImgDir'];
           $CTartalom  = $row['CTartalom'];
           $CLeiras    = $row['CLeiras'];
           $Horgony    = "#".getTXTtoURL($row['CNev']);
           $CCim       = "&amp;cim=".getTXTtoURL($row['CNev']);
           $CikkLink   = "<a class='Jobbra CikkelozetesLink' href='?f0=".$row['OUrl'].$CCim.$Horgony."'>".$row['CNev']." részletesen...</a>";
           if ($OImgDir!='') {
               $KepUtvonal = "img/oldalak/".$OImgDir."/";
           } else {
               $KepUtvonal = "img/oldalak/";
           }
           $HTMLimg    = getElsoKepHTML($Cid,$KepUtvonal);  
           if ($HTMLimg==''){ $HTMLimg="<img src='$AlapKep'  class = 'imgOE' alt=''>";}
           $HTMLkod   .= "<div class ='divCikkElozetesKulso'>\n";          
           $HTMLkod   .= "<div class = 'divOElozetesKep'>$HTMLimg</div>\n";   
           $HTMLkod   .= "<div class='divOElozetesTartalom'>\n";
           $HTMLkod   .= "<h3>".$CNev."</h3>\n";
           if ($CLeiras!='') {$HTMLkod .= "<div class = 'divOElozetesLeir'>".$CLeiras."</div>\n";}    
           $HTMLkod .= "</div>\n";
           $HTMLkod .= "<div class='divClear'></div>\n"; 
           $HTMLkod .= "<div class='divCszerzoNev'> <span class='pCszerzoNev'> ".U_SZERZO.": ".$row['CSzerzoNev']."</span><br>\n";           
           $HTMLkod .= "<span class='pCModTime'>".U_KOZZETEVE.": ".$row['CModositasTime']." </span></div>\n";
           $HTMLkod .= "<div class='divCikkLink'> $CikkLink </div>";
           $HTMLkod .= "</div>\n";    
        }
        mysqli_free_result($result);
    }
    if ($HTMLkod!='') {$HTMLkod = "<div class ='divCElozetesKulso'>\n <h2>".U_HIRELOZETESEK."</h2> $HTMLkod</div>"; }
    return $HTMLkod;
}

function getSzulooldalCikkelozetesekHTML($SelStr) {  
    global $MySqliLink, $Aktoldal, $AlapAdatok,  $CCim;
    $Oid       = $Aktoldal['id'];
    $HTMLkod   = '';
    $SelectStr = $SelStr;  
    $result    = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sMC 01 ");
    $rowDB     = mysqli_num_rows($result);
    if ($rowDB > 0) {
        $AlapKep  = 'img/ikonok/HeaderImg/'.$AlapAdatok['HeaderImg']; 
        while ($row    = mysqli_fetch_array($result)){ 
           $Cid        = $row['Cid']; 
           $CNev       = $row['CNev'];         
           $OImgDir    = $row['OImgDir'];
           $CTartalom  = $row['CTartalom'];
           $CLeiras    = $row['CLeiras'];
           $Horgony    = "#".getTXTtoURL($row['CNev']);
           $CCim       = "&amp;cim=".getTXTtoURL($row['CNev']);
           $CikkLink   = "<a class='OElink CikkelozetesLink' href='?f0=".$row['OUrl'].$CCim.$Horgony."'>".$row['CNev']." ".U_RESZLETESEN."...</a>";
           if ($OImgDir!='') {
               $KepUtvonal = "img/oldalak/".$OImgDir."/";
           } else {
               $KepUtvonal = "img/oldalak/";
           }           
           $HTMLimg    = getElsoKepHTML($Cid,$KepUtvonal);  
           if ($HTMLimg==''){ $HTMLimg="<img src='$AlapKep'  class = 'imgOE' alt=''>";}
           $HTMLkod   .= "<div class ='divOElozetesKulso'>\n";          
           $HTMLkod   .= "<div class = 'divOElozetesKep'>$HTMLimg</div>\n";   
           $HTMLkod   .= "<div class='divOElozetesTartalom'>\n";
           $HTMLkod   .= "<h3>".$CNev."</h3>\n";
           if ($CLeiras!='') {$HTMLkod .= "<div class = 'divOElozetesLeir'>".$CLeiras."</div>\n";}    
           $HTMLkod .= "</div>\n";
           $HTMLkod .= $CikkLink;
           $HTMLkod .= "<p class='pCszerzoNev'>".U_SZERZO.": ".$row['CSzerzoNev']."</p>\n";           
           $HTMLkod .= "<p class='pCModTime'>".U_KOZZETEVE.": ".$row['CModositasTime']." </p>\n";
           $HTMLkod .= "</div>\n";           
        }
        mysqli_free_result($result);
    }
    if ($HTMLkod!='') {$HTMLkod = "<div class ='divCElozetesKulso'>\n <h2>".U_HIRELOZETESEK."</h2> $HTMLkod</div>"; }   
    return $HTMLkod;
}



?>
