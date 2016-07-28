<?php

/* 
    Author     : Szép Balázs
*/

/* Példatömb
$CikkKepek = array();
$CikkKepek['id']         = 0;
$CikkKepek['Cid']        = 0;
$CikkKepek['KFile']      = '';
$CikkKepek['KNev']       = '';
$CikkKepek['KLeiras']    = '';
$CikkKepek['KSzelesseg'] = 0;
$CikkKepek['KMagassag']  = 0;
$CikkKepek['KStilus']    = 0;
$CikkKepek['KSorszam']   = 0;
*/

function setCikkKepFeltolt() {
    global $Aktoldal, $SzuloOldal, $NagyszuloOldal, $MySqliLink;
    $ErrorStr = '';
    $Cid      = $_SESSION['SzerkCikk'.'id'];  
    //Csak rendszergazdáknak, moderátoroknak és regisztrált felhasználóknak!
    if (($_SESSION['AktFelhasznalo'.'FSzint']>2) && (isset($_POST['submit_CikkKepekFeltoltForm'])) && ($Cid>0))   {          
        $Oid          = $Aktoldal['id'];
        $UploadErr    = '';
        if ($Aktoldal['OImgDir']!='') {
          $KepUtvonal = "img/oldalak/".$Aktoldal['OImgDir']."/";
        } else {
          $KepUtvonal = "img/oldalak/";
        }
        //=============== Lehetséges Fájlnevek ==================
        // Fájlnév felépítése cikk_$Cid_$KSorszam.kiterjesztés
        $lehetKFile  = array();
        $SelectStr   = "SELECT CNev FROM Cikkek WHERE id=$Cid ";  //echo "<h1>$SelectStr</h1>";
        $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba CKx 01aa ");
        $rowDB       = mysqli_num_rows($result); 
        if ($rowDB > 0) {
                    $row   = mysqli_fetch_array($result);                    
                    $CKNev = $row['CNev'];
                    mysqli_free_result($result);
        }
        if (strlen($CKNev)>50) {$CKNev=substr($CKNev,0,50);} //echo "<h1>CNev: $CKNev</h1>";
        $CKNev = getTXTtoURL($CKNev);
        
        for($i=9; $i>=0; $i--) {
          $lehetKFile[] = $CKNev.'_'.$i; 
        }
        //print_r($lehetKFile);
        //=============== Létező Fájlnevek ==================
        $vanKFile     = array();
        $SelectStr    = "SELECT KFile FROM CikkKepek WHERE Cid=$Cid" ;
        $result       = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba CKF 01");
        $rowDB        = mysqli_num_rows($result);
        if ($rowDB > 0) {
          while($row  = mysqli_fetch_array($result))
          {
            $temp       = explode(".", $row['KFile']);
            $vanKFile[] = $temp[0];
          }
          mysqli_free_result($result);
        }
      //=============== Használható Fájlnevek ==================
        $UploadErr   = '';
        $OkKFile     = array();
        $OkKFile0    = array_diff($lehetKFile,$vanKFile);
        foreach ($OkKFile0 as $key => $value) {$OkKFile[] = $value;}
        $OkKFileCt   = count($OkKFile);
        $KFileDb     = count($_FILES['COKepFile']['name']);
        if (($KFileDb==1) && ($_FILES["COKepFile"]["name"][0]=='')) {
            $KFileDb=0; $UploadErr = 'ErrK00'; 
            
        } else {
            if (isset($_FILES["COKepFile"])) {
                $i=0;
                while (($i<$KFileDb) && ($OkKFileCt>0)) {
                  $allowedExts = array("gif", "jpeg", "jpg", "png");
                  $temp        = explode(".", $_FILES["COKepFile"]["name"][$i]);
                  $extension   = end($temp);
                  $AktFileNev  = $OkKFile[$OkKFileCt-1].'.'.$extension;
                  $FNev        = $_FILES["COKepFile"]["name"][$i];
                  if (( ($_FILES["COKepFile"]["type"][$i] == "image/gif")
                     || ($_FILES["COKepFile"]["type"][$i] == "image/jpeg")
                     || ($_FILES["COKepFile"]["type"][$i] == "image/jpg")
                     || ($_FILES["COKepFile"]["type"][$i] == "image/pjpeg")
                     || ($_FILES["COKepFile"]["type"][$i] == "image/x-png")
                     || ($_FILES["COKepFile"]["type"][$i] == "image/png"))
                     && ($_FILES["COKepFile"]["size"][$i] < 2000000)
                     && in_array($extension, $allowedExts))
                    {
                        if ($_FILES["COKepFile"]["error"][$i] > 0) {                           
                          $UploadErr .= "ErrK02".$_FILES["COKepFile"]["name"][$i]."<br>"; 
                        } else {
                          if (file_exists($KepUtvonal.$AktFileNev)) {
                            //Meglévő kép felülírása
                            if (!@unlink($KepUtvonal.$AktFileNev)) {                                
                                $UploadErr = 'ErrK02'.$FNev."<br>"; // Nem sikerült a törlés
                            } else {     
                                if (move_uploaded_file($_FILES["COKepFile"]["tmp_name"][$i],$KepUtvonal.$AktFileNev)) {
                                    $UploadErr    .=   "OK001".$FNev." <br>"; $KepOK=true;
                                    $InsertIntoStr = "INSERT INTO CikkKepek VALUES ('', $Cid,'$AktFileNev','','',0,0,0,0)";
                                    if (!mysqli_query($MySqliLink,$InsertIntoStr)) {die("Hiba CKF 02");}
                                } else {
                                    $UploadErr .= "ErrK05".$FNev."<br>";                     
                                }
                            }
                          } else {
                            //Új kép feltöltése
                            if (move_uploaded_file($_FILES["COKepFile"]["tmp_name"][$i],$KepUtvonal.$AktFileNev)) {
                                $UploadErr    .=   "OK001".$FNev." <br>"; $KepOK=true;      
                                $InsertIntoStr = "INSERT INTO CikkKepek VALUES ('', $Cid,'$AktFileNev','','',0,0,0,0)";
                                if (!mysqli_query($MySqliLink,$InsertIntoStr)) {die("Hiba CKF 03");}
                            } else {
                                    $UploadErr .= "ErrK05".$FNev."<br>";                     
                            }
                          }
                        }
                    } else {
                        if ($AktFileNev >'') {$UploadErr .= "ErrK01".$FNev."<br>"; }
                    }
                    $i++; $OkKFileCt--;
                }
            if ($i<$KFileDb) { $UploadErr .= "<p class='Error'>".U_CSAK_10_KEP."!</p>\n";}
          }
    }
      return $UploadErr;
    }
}


function getCikkKepFeltoltForm($ErrorStr) {
    global $Aktoldal;
    $OUrl       = $Aktoldal['OUrl'];
    $HTMLkod    = " <div id='CikkKepekFeltoltForm'>                           
                    <form action='?f0=$OUrl'  method='post' enctype='multipart/form-data' id='CikkKepTolForm'>
                    <h2>".U_CKEP_FEL."</h2>
                    <p class='ErrClassKep'>$ErrorStr </p>
                    <fieldset> <legend>".U_CKEP_VAL.":</legend>
                    <input type='file' name='COKepFile[]' id='file_CikkKepekFeltoltForm' multiple='multiple'>
                    </fieldset>     
                    <input type='submit' name='submit_CikkKepekFeltoltForm' id='submit_CikkKepekFeltoltForm' value='".U_BTN_FELTOLT."'>   <br>   <br>                                 
                    </form>
                    </div>";
    return $HTMLkod;
}

function setCikkKepek() {
    global $Aktoldal, $MySqliLink;
    $ErrorStr   = '';
    $Oid        = 0;    
    $Cid        = $_SESSION['SzerkCikk'.'id'];
    $SelectStr  = "SELECT Oid From OldalCikkei WHERE Cid='$Cid'";
    $result     = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sCK 02");
    $rowDB      = mysqli_num_rows($result); 
    if ($rowDB > 0) {
        $row    = mysqli_fetch_array($result);    mysqli_free_result($result);
        $Oid    = $row['Oid'];
        if (($_SESSION['AktFelhasznalo'.'FSzint']>2) && (isset($_POST['submitCikkKepForm'])))   {
            if (isset($_POST["rowDB"])) {$rowDB=test_post($_POST["rowDB"]);}
            $KNev       = '';
            
            //=============================HIBAKEZELÉS==============================
      /*      for($i=0; $i<$rowDB; $i++) {
                if (isset($_POST["CKNev_$i"])) {
                    $KNev=test_post($_POST["CKNev_$i"]);
                    if(strlen($KNev)>40) {                         
                        $ErrorStr .= "ErrH01 $KNev <br>\n";
                        $KNev=substr($KNev,0,40);                        
                    }
                }
            }*/
            //====================POST beillesztése adatbázisba=====================
            if ($Oid == $Aktoldal['id']) {
                for($i=0; $i<$rowDB; $i++) {
                    if  ((isset($_POST["CKFile_$i"]))&&($_POST["CKFile_$i"]!='')) {
                        $KFile      = FileNevTisztit($_POST["CKFile_$i"]);                        
                        $KLeiras    = '';
                        $KSzelesseg = 0;
                        $KMagassag  = 0;
                        $KStilus    = 0;
                        $KSorszam   = 0;                        
                        if (isset($_POST["CKLeiras_$i"]))    {$KLeiras   =test_post($_POST["CKLeiras_$i"]);}
                        if (isset($_POST["CKSzelesseg_$i"])) {$KSzelesseg=test_post($_POST["CKSzelesseg_$i"]);}
                        if (isset($_POST["CKMagassag_$i"]))  {$KMagassag =test_post($_POST["CKMagassag_$i"]);}
                        if (isset($_POST["CKStilus_$i"]))    {$KStilus   =test_post($_POST["CKStilus_$i"]);}
                        if (isset($_POST["CKSorszam_$i"]))   {$KSorszam  =test_post($_POST["CKSorszam_$i"]);}
                        if (isset($_POST["CKNev_$i"])) {
                            $KNev=test_post($_POST["CKNev_$i"]);
                            if(strlen($KNev)>40) {                         
                                $ErrorStr .= "ErrH01 $KNev <br>\n";
                                $KNev=substr($KNev,0,40);                        
                            }
                        }
                    }
                    $UpdateStr = "UPDATE CikkKepek SET 
                                KNev='$KNev', 
                                KLeiras='$KLeiras', 
                                KSzelesseg='$KSzelesseg', 
                                KMagassag='$KMagassag', 
                                KStilus='$KStilus', 
                                KSorszam='$KSorszam' 
                                WHERE KFile='$KFile' 
                                AND Cid=$Cid";
                    mysqli_query($MySqliLink,$UpdateStr) OR die("Hiba uCK 01");
                    setCikkKepTorol($i);
                }
            }
        }
    }
    return $ErrorStr;
}

function getCikkKepForm() {
    global $Aktoldal, $MySqliLink;
    $Oid        = $Aktoldal['id'];
    $Cid        = $_SESSION['SzerkCikk'.'id']; 
    $OUrl       = $Aktoldal['OUrl'];
    $ErrorStr   = '';
    $ErrorStr1  = '';
    $HTMLkod    = '';
    if ($_SESSION['AktFelhasznalo'.'FSzint']>2){     
      if ($_SESSION['SzerkCikk'.'id']>0) {             
        $ErrClassKep    = '';
        if (isset($_POST['submit_CikkKepekFeltoltForm'])) {
            $ErrorStr        = $_SESSION['ErrorStr'];
            if (strpos($ErrorStr,'ErrK00')!==false) {
               $ErrArr      = array('ErrK00' => U_FETOLT_ER000);  
               $ErrorStr    = strtr($ErrorStr ,$ErrArr); 
               $ErrClassKep = 'ErrorStr1';
            }            
            if (strpos($ErrorStr,'ErrK01')!==false) {
               $ErrArr      = array('ErrK01' => U_FETOLT_ER001);  
               $ErrorStr    = strtr($ErrorStr ,$ErrArr); 
               $ErrClassKep = 'ErrorStr1';
            }
            if (strpos($ErrorStr,'ErrK02')!==false) {
               $ErrArr       = array('ErrK02' => U_FETOLT_ER002);  
               $ErrorStr     = strtr($ErrorStr ,$ErrArr); 
               $ErrClassKep  = 'ErrorStr1';
            }
            if (strpos($ErrorStr,'ErrK03')!==false) {
               $ErrArr       = array('ErrK03' => U_FETOLT_ER003);  
               $ErrorStr     = strtr($ErrorStr ,$ErrArr);
               $ErrClassKep  = 'ErrorStr1';
            }    
            if (strpos($ErrorStr,'ErrK05')!==false) {
               $ErrArr       = array('ErrK05' => U_FETOLT_ER002);  
               $ErrorStr     = strtr($ErrorStr ,$ErrArr); 
               $ErrClassKep  = 'ErrorStr1';
            }
            if (strpos($ErrorStr,'OK001')!==false) {
               $ErrArr       = array('OK001' => U_FETOLT_OK);  
               $ErrorStr     = strtr($ErrorStr ,$ErrArr); 
            }  
            if ($ErrClassKep == '' ){
               $ErrorStr      = "<p class='time'>".U_MODOSITVA.": ".date("H.i.s.")."<p>".$ErrorStr; 
            } else {
               $ErrorStr      = "<p class='time'>".U_ELKULDVE.": ".date("H.i.s.")."<p>".$ErrorStr;
            }
        } 
        
        if (isset($_POST['submitCikkKepForm'])) {
            $ErrorStr1        = $_SESSION['ErrorStr'];
            $CikkKepOK        = 1;
            if (strpos($ErrorStr1,'ErrH01')!==false) {
               $ErrArr        = array('ErrH01' => U_HOSSZ_ER001);  
               $ErrorStr1     = strtr($ErrorStr1 ,$ErrArr); 
               $CikkKepOK     = 0;
            }
            if ($CikkKepOK    = 0 ){
               $ErrorStr1     = "<p class='time'>".U_MODOSITVA.": ".date("H.i.s.")."<p>".$ErrorStr1; 
            } else {
               $ErrorStr1     = "<p class='time'>".U_ELKULDVE.": ".date("H.i.s.")."<p>".$ErrorStr1;
            }
        }            
        $HTMLkod .= "<div id='divCikkKepForm' >\n";
        $HTMLkod .= getCikkKepFeltoltForm($ErrorStr);   
        
        
        // a $_SESSION['SzerkCik'][id] és a $_SESSION['SzerkCik'][Oid] által meghatározott cikk képeinek kezelése
        // Minta OldalKeptar.php getOldalKepForm()- fgv-e. 
        // Változás: a képek feltöltéséhez szüksége form saját fgv-t kap. >> getCikkKepFeltoltForm()

        if ($Aktoldal['OImgDir']!='') {
          $KepUtvonal = "img/oldalak/".$Aktoldal['OImgDir']."/";            
        } else {
          $KepUtvonal = "img/oldalak/";    
        }
        //Az aktuális cikkhez kapcsolódó képek beolvasása adatbázisból 
        $SelectStr   = "SELECT * FROM CikkKepek WHERE Cid=$Cid order by KSorszam ";
        $SelectStr   = "SELECT *
                        FROM CikkKepek AS CK
                        LEFT JOIN OldalCikkei AS OC
                        ON OC.Cid= CK.Cid 
                        WHERE OC.Oid=$Oid
                        AND CK.Cid=$Cid";
        $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sCK 01 ");
        $rowDB       = mysqli_num_rows($result);
        if (strpos($_SESSION['ErrorStr'],'Err_')==false)  {
            while($row   = mysqli_fetch_array($result)) {
                $CikkKep               = array();
                $CikkKep['id']         = $row['id'];
                $CikkKep['KFile']      = $row['KFile'];
                $CikkKep['KNev']       = $row['KNev'];
                $CikkKep['KLeiras']    = $row['KLeiras'];
                $CikkKep['KSzelesseg'] = $row['KSzelesseg'];
                $CikkKep['KMagassag']  = $row['KMagassag'];
                $CikkKep['KStilus']    = $row['KStilus'];
                $CikkKep['KSorszam']   = $row['KSorszam'];
                $CikkKep['KTorol']     = $row['KFile'];
                $CikkKepek[]           = $CikkKep;
            }
        } else {
            if (isset($_POST['rowDB'])) {
                for($i = 0; $i < $_POST['rowDB']; $i++) {
                    $CikkKep                      = array();
                    if (isset($_POST["CKFile_$i"]))      {$CikkKep['KFile']      = test_post1($_POST["CKFile_$i"]);} 
                      else {$CikkKep['KFile']     ='';}
                    if (isset($_POST["CKNev_$i"]))       {$CikkKep['KNev']       = test_post1($_POST["CKNev_$i"]);}
                      else {$CikkKep['KNev']      ='';}
                    if (isset($_POST["CKLeiras_$i"]))    {$CikkKep['KLeiras']    = test_post1($_POST["CKLeiras_$i"]);}
                      else {$CikkKep['KLeiras']   ='';}
                    if (isset($_POST["CKSzelesseg_$i"])) {$CikkKep['KSzelesseg'] = INT_post($_POST["CKSzelesseg_$i"]);}
                      else {$CikkKep['KSzelesseg'] =0;}
                    if (isset($_POST["CKMagassag_$i"]))  {$CikkKep['KMagassag']  = INT_post($_POST["CKMagassag_$i"]);}
                      else {$CikkKep['KMagassag']  =0;}
                    if (isset($_POST["CKStilus_$i"]))    {$CikkKep['KStilus']    = INT_post($_POST["CKStilus_$i"]);}
                      else {$CikkKep['KStilus']    =0;}
                    if (isset($_POST["CKSorszam_$i"]))   {$CikkKep['KSorszam']   = INT_post($_POST["CKSorszam_$i"]);}
                      else {$CikkKep['KSorszam']   =0;}
                    if (isset($_POST["CKTorol_$i"]))     {$CikkKep['KTorol']     = INT_post($_POST["CKTorol_$i"]);}
                      else {$CikkKep['KTorol']     =0;}
                    $CikkKepek[]                   = $CikkKep;
                }
            }
        }
        if ($rowDB != 0){
            $HTMLkod .= "<h2>".U_CKEP_MOD."</h2>\n";
            $HTMLkod .= "<p class='$ErrClassKep'>$ErrorStr1 </p>";
            
            mysqli_free_result($result); 
            $HTMLkod1    ='';
            $ErrClassCNev='';
            for($i = 0; $i < $rowDB; $i++) {
                $checked = "";
                if (strpos($_SESSION['ErrorStr'],'Err_')!=false) {
                    if (isset($_POST["CKTorol_$i"])) {$checked = " checked ";}
                }
                
                if (strpos($_SESSION['ErrorStr'],"Err_$i")!=false) {
                    $ErrClassCNev = "Error";
                } else {$ErrClassCNev='';}
                $HTMLkod1 .= "<div class='Kepszerk'>"; 

                $j        = $i+1;
                $HTMLkod1.= "<fieldset> <legend>".$j.". ".U_CKEP_ADAT."</legend>";
            
                $Src       = $KepUtvonal.$CikkKepek[$i]['KFile']; //echo "<h1>$Src</h1>";
                $HTMLkod1 .= "<img src='$Src' alt='$i. kép' >";
                $HTMLkod1 .= "<input type='hidden' name='CKFile_$i' value='".$CikkKepek[$i]['KFile']."'>";

                $HTMLkod1 .= "<div style='float:left;'>";
                $HTMLkod1 .= "<p class='pKSorszam'><label for='CKSorszam_$i' class='label_1'>".U_SORSZAM.":</label>\n ";
                $HTMLkod1 .= "<input type='number' name='CKSorszam_$i' id='CKSorszam_$i' min='0' max='1000' step='1' value='".$CikkKepek[$i]['KSorszam']."' ></p>\n"; 

                $HTMLkod1 .= "<p class='pKNev'><label for='CKNev_$i' class='label_1'>".U_CIKK_CIM.":</label>\n ";
                $HTMLkod1 .= "<input type='text' name='CKNev_$i' id='CKNev_$i' placeholder='".U_CIKK_CIM."' 
                               class='$ErrClassCNev' value='".$CikkKepek[$i]['KNev']."' size='1000'></p>\n"; 

                $HTMLkod1 .= "<p class='pKLeiras'><label for='CKLeiras_$i' class='label_1'>".U_LEIRAS.":</label>\n ";
                $HTMLkod1 .= "<input type='text' name='CKLeiras_$i' id='CKLeiras_$i' placeholder='".U_LEIRAS."'  value='".$CikkKepek[$i]['KLeiras']."' size='60'></p>\n"; 

                $HTMLkod1 .= "<p class='pKSzelesseg'><label for='CKSzelesseg_$i' class='label_1'>".U_SZELESSEG.":</label>\n ";
                $HTMLkod1 .= "<input type='number' name='CKSzelesseg_$i' id='CKSzelesseg_$i' min='0' max='1000' step='1' value='".$CikkKepek[$i]['KSzelesseg']."' ></p>\n"; 

                $HTMLkod1 .= "<p class='pKMagassag'><label for='CKMagassag_$i' class='label_1'>".U_MAGASSAG.":</label>\n ";
                $HTMLkod1 .= "<input type='number' name='CKMagassag_$i' id='CKMagassag_$i' min='0' max='1000' step='1' value='".$CikkKepek[$i]['KMagassag']."' ></p>\n"; 

                $HTMLkod1 .= "<p class='pKStilus'><label for='CKStilus_$i' class='label_1'>".U_STILUS.":</label>\n ";
                $HTMLkod1 .= "<input type='number' name='CKStilus_$i' id='CKStilus_$i' min='0' max='1000' step='1' value='".$CikkKepek[$i]['KStilus']."' ></p>\n";           

                $HTMLkod1 .= "<p class='pKTorol'><label for='CKTorol_$i' class='label_1'>".U_TORTLES.":</label>\n ";
                $HTMLkod1 .= "<input type='checkbox' name='CKTorol_$i' id='CKTorol_$i'  value='".$CikkKepek[$i]['KFile']."' $checked ></p>\n";           
                $HTMLkod1 .= "</div>";
                $HTMLkod1 .= "</fieldset> ";
                $HTMLkod1 .= "</div>";  
            }
            // ============== A HTML KÓD ÖSSZEÁLLÍTÁSA =====================   
            $HTMLkod1 .= "<input type='hidden' name='rowDB' value='$rowDB'>";
          //  $HTMLkod .= $_SESSION['ErrorStr'];
            $HTMLkod  .= "<div id='divCikkKepForm1'><form action='?f0=$OUrl' method='post' id='formCikkKepForm'>\n";
            $HTMLkod  .= $HTMLkod1;
            $HTMLkod  .=  "<input type='submit' name='submitCikkKepForm' value='".U_BTN_MODOSITAS."' style='clear:left;'><br><br>\n";        
            $HTMLkod  .= "</form></div>\n";
        } else {
            $HTMLkod  .= "<div id='divCikkKepForm1'><form action='?f0=$OUrl' method='post' id='formCikkKepForm'>\n";
            $HTMLkod  .= "<h2>".U_CKEP_NINCS."!</h2>\n";
            
            $HTMLkod  .= "</form></div>\n";
        }
        $HTMLkod .= "</div> <br style='clear:left;'>\n";
      } else {
        $HTMLkod .= "<div id='divCikkKepForm' >\n";       
        $HTMLkod .= "<h2>".U_CIKK_NINCS."!</h2>\n";;
        $HTMLkod .= "</div>\n";
      }
    }
    return $HTMLkod;
}


function setCikkKepTorol($i) {
    global $Aktoldal, $MySqliLink;
    $Cid            = $_SESSION['SzerkCikk'.'id'];
    if (isset($_POST["rowDB"])) {$rowDB=test_post($_POST["rowDB"]);}
    if ($Aktoldal['OImgDir']!='') {
      $KepUtvonal   = "img/oldalak/".$Aktoldal['OImgDir']."/";
    } else {
      $KepUtvonal   = "img/oldalak/";
    }
    if  (isset($_POST["CKTorol_$i"]) && $_POST["CKTorol_$i"]) {
        $KFile      = test_post($_POST["CKTorol_$i"]); //echo "<h1>KFile:$KFile</h1>";
        unlink($KepUtvonal.$KFile);
        $DeletetStr = "Delete FROM CikkKepek  WHERE KFile='$KFile' AND Cid=$Cid";
        mysqli_query($MySqliLink,$DeletetStr) OR die("Hiba dCK 01");
    }
}

function CikkOsszesKepTorol($Cid,$OImgDir) {
    global $MySqliLink;
    $ErrorStr     = '';   
    if ($OImgDir !='') {
      $KepUtvonal = "img/oldalak/".$OImgDir."/";
    } else {
      $KepUtvonal = "img/oldalak/";
    }
    $SelectStr    = "SELECT KFile FROM CikkKepek WHERE Cid=$Cid";  
    $result       = mysqli_query($MySqliLink, $SelectStr) OR die("Hiba COT 01");
    $rowDB        = mysqli_num_rows($result); 
    if ($rowDB > 0) {
        while ($row = mysqli_fetch_array($result)){        
            $Src    = $KepUtvonal.$row['KFile'];
            if (!unlink($Src)) {$ErrorStr .= 'Err200'.$row['KFile'].' '; }
            $DeletetStr = "Delete FROM CikkKepek  WHERE Cid=$Cid";
            mysqli_query($MySqliLink,$DeletetStr) OR die("Hiba ddCK 01");
        }
        mysqli_free_result($result); 
    }
    return $ErrorStr; 
}


function getCikkKepTorolForm() {
    // Integrálható a getCikkKepForm() fgv-be.
    trigger_error('Not Implemented!', E_USER_WARNING);
}

function getCikkKepekHTML($Cid) {
    global $MySqliLink, $Aktoldal;
    $HTMLkod      = '';    
    if ($Aktoldal['OImgDir']!='') {
      $KepUtvonal = "img/oldalak/".$Aktoldal['OImgDir']."/";
    } else {
      $KepUtvonal = "img/oldalak/";
    }
    
    $HTMLkod  .= "<div class = 'divCikkKepek'>\n";
    $SelectStr = "SELECT KNev, KFile FROM CikkKepek WHERE Cid=$Cid ORDER BY KSorszam DESC"; //echo $SelectStr;
    $result    = mysqli_query($MySqliLink, $SelectStr) OR die("Hiba sGC 01z");
    $rowDB     = mysqli_num_rows($result); 
    if ($rowDB > 0) {    
        while ($row   = mysqli_fetch_array($result)){
            $Src      = $KepUtvonal.$row['KFile'];
            $KNev     = $row['KNev'];
            $HTMLkod .= "<div class = 'divCikkKep'>";
            $HTMLkod .= "<img src='$Src'  class = 'imgCikkKep' alt='$KNev'>";
                //$HTMLkod .= $row['KFile'];
            $HTMLkod .= "</div>\n";
        }
        mysqli_free_result($result); 
    }
    $HTMLkod .= "</div>\n";
    return $HTMLkod;
}


function KepekAtnevez($RFNev,$UFNev,$Cid) { 
global $Aktoldal, $MySqliLink;       
    $ErrorStr   = '';
    $Konytar    = 'img/oldalak/'.$Aktoldal['OImgDir']."/";     
    $SelectStr  = "SELECT * FROM CikkKepek WHERE Cid=$Cid";
    $result     = mysqli_query($MySqliLink, $SelectStr) OR die("Hiba sGC 01ab");
    $rowDB      = mysqli_num_rows($result); 
    if ($rowDB > 0) {  
        while ($row  = mysqli_fetch_array($result)){
            $KFile   = $row['KFile'];
            $UFNev   = getTXTtoURL($UFNev);
            if (strlen($UFNev)>50) {$UFNev=substr($UFNev,0,50);}
            $RFNev   = getTXTtoURL($RFNev);
            if (strlen($RFNev)>50) {$RFNev=substr($RFNev,0,50);}

            $arr     = array($RFNev => $UFNev);
            $UKFile  = strtr($KFile ,$arr);

            $KFileM  = $Konytar.$KFile;
            $UKFileM = $Konytar.$UKFile;

            if (file_exists($KFileM)) {
                if (!rename($KFileM, $UKFileM)) {
                        $ErrorStr = 'Err100'; // Nem sikerült átnevezni
                }       
            } else {$ErrorStr = 'Err101';} // A fájl nem létezik

            if ($ErrorStr=='') {
               $UpdateStr = "UPDATE CikkKepek SET 
                               KFile='$UKFile'
                               WHERE Cid=$Cid AND KFile='$KFile' LIMIT 1";          
               if (!mysqli_query($MySqliLink,$UpdateStr))  {echo "Hiba setOK 01 ";}  
            }
        }
        mysqli_free_result($result); 
    }
    return $ErrorStr;    
}

?>
