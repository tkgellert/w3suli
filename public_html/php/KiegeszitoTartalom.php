<?php

function setKiegT() {
    global $MySqliLink;
    $ErrorStr       = "";  
    $KiegTNev       = "";
    $KiegTTartalom  = "";
    $KiegTPrioritas = 0;
    
    if ($_SESSION['AktFelhasznalo'.'FSzint']>5){
        if (isset($_POST['submitKiegTartalom'])) {
            for ($i = 0; $i < 10; $i++){
                $id = INT_post($_POST["ModKTid_$i"]);
                if (!isset($_POST["TorolKiegT_$i"])){
                    if (isset($_POST["ModKTNev_$i"])) {
                        $KiegTNev = test_post($_POST["ModKTNev_$i"]);
                    }
                    if (isset($_POST["ModKTTartalom_$i"]))  {
                        $KiegTTartalom  = SQL_post($_POST["ModKTTartalom_$i"]);
                    }
                    if (isset($_POST["ModKTPrioritas_$i"])) {
                        $KiegTPrioritas = INT_post($_POST["ModKTPrioritas_$i"]);
                    }

                    $UpdateStr = "UPDATE KiegTartalom SET
                                    KiegTNev       = '$KiegTNev',
                                    KiegTTartalom  = '$KiegTTartalom',
                                    KiegTPrioritas =  '$KiegTPrioritas'
                                    WHERE id = '$id'";
                    mysqli_query($MySqliLink,$UpdateStr) OR die("Hiba uUKT 2");
                } else {
                    $UpdateStr = "UPDATE KiegTartalom SET
                                    KiegTNev       = '',
                                    KiegTTartalom  = '',
                                    KiegTPrioritas =  0
                                    WHERE id = '$id'";
                    mysqli_query($MySqliLink,$UpdateStr) OR die("Hiba uUKT 2");
                }
            }
        }
    }
    return $ErrorStr;
}



function getKiegTForm() {
    global $MySqliLink;
    $HTMLkod   = '';
    $ErrorStr  = '';
    $InfoClass = '';

    if ($_SESSION['AktFelhasznalo'.'FSzint']>5)  { // FSzint-et növelni, ha működik a felhasználókezelés!!!  
        $KiegTartalom                   = array();
        $KiegTartalom['id']             = 0;
        $KiegTartalom['KiegTNev']       = '';
        $KiegTartalom['KiegTTartalom']  = '';
        $KiegTartalom['KiegTPrioritas'] = 0;
        $SelectStr = "SELECT * FROM KiegTartalom";
        $result    = mysqli_query($MySqliLink, $SelectStr) OR die("Hiba sKTT 01");
        $rowDB     = mysqli_num_rows($result); 
        if ($rowDB > 0) {        
            if (isset($_POST['submitKiegTartalom']))    {
                if ($_SESSION['ErrorStr'] == '' ){
                    $ErrorStr        = "<p class='time'>".U_MODOSITVA.": ".date("H.i.s.")."<p>".$ErrorStr; 
                } else {
                    $ErrorStr        = "<p class='time'>".U_ELKULDVE.": ".date("H.i.s.")."<p>".$ErrorStr;
                }
                if (strpos($_SESSION['ErrorStr'],'Err')!==false)
                        {$InfoClass  = ' ErrorInfo ';} else {$InfoClass  = ' OKInfo ';}   
            }            
            for ($i = 0; $i < 10; $i++){
                $row = mysqli_fetch_array($result);
                $KiegTartalom['id']            = $row['id'];
                $KiegTartalom['KiegTNev']      = $row['KiegTNev'];
                $KiegTartalom['KiegTTartalom'] = $row['KiegTTartalom'];
                $KiegTartalom['KiegTPrioritas']= $row['KiegTPrioritas'];
                $KiegTTomb[]                   = $KiegTartalom;
            }
            mysqli_free_result($result);
            $HTMLkod .= "<div id='divModKiegTForm' >\n";
            $HTMLkod .= "<form action='?f0=kiegeszito_tartalom' method='post' id='formModKiegTForm'>\n";
            $HTMLkod .= "<h2>".U_KIEGT_INFO_BLOKK."</h2>\n";
            if ($ErrorStr!='') {$HTMLkod .= "<div class='$InfoClass'>$ErrorStr</div>";};

            for ($i = 0; $i < 10; $i++){
                $id             = $KiegTTomb[$i]['id'];
                $KiegTNev       = $KiegTTomb[$i]['KiegTNev'];
                $KiegTTartalom  = $KiegTTomb[$i]['KiegTTartalom'];
                $KiegTPrioritas = $KiegTTomb[$i]['KiegTPrioritas'];

                $HTMLkod .= "<div class='divKiegTElem'>\n ";

                $j        = $i+1;
                $HTMLkod .= "<fieldset> <legend>".$j.". ".U_KIEGT_BLOKK_ADATOK."</legend>";
                //Kiegészítő tartalom neve
                $HTMLkod .= "<p class='pModKTNev'><label for='ModKTNev_$i' class='label_1'>".U_NEV.":</label><br>\n ";
                $HTMLkod .= "<input type='text' name='ModKTNev_$i' id='ModKTNev_$i' placeholder='".U_NEV."' value='$KiegTNev' size='40'></p>\n"; 

                //Kiegészítő tartalom tartalma
                $HTMLkod .= "<p class='pModKTTartalom'><label for='ModKTTartalom_$i' class='label_1'>".U_TARTALOM.":</label><br>\n ";
                $HTMLkod .= "<textarea type='text' name='ModKTTartalom_$i' id='ModKTTartalom_$i' placeholder='".U_TARTALOM."' 
                             rows='4' cols='60'>$KiegTTartalom</textarea></p>\n"; 

                //Kiegészítő tartalom prioritása
                $HTMLkod .= "<p class='pModKTPrioritas'><label for='ModKTPrioritas_$i' class='label_1'>".U_PRIORITAS.":</label>\n ";
                $HTMLkod .= "<input type='number' name='ModKTPrioritas_$i' id='ModKTPrioritas_$i' min='0' max='9' step='1' value='$KiegTPrioritas'></p>\n";  

                //Törlésre jelölés
                $HTMLkod .= "<p class='pTorolKiegT'><label for='pTorolKiegT_$i' class='label_1'>".U_TORTLES.":</label>\n ";
                $HTMLkod .= "<input type='checkbox' name='TorolKiegT_$i' id='TorolKiegT_$i'></p>\n";

                //id
                $HTMLkod .= "<input type='hidden' name='ModKTid_$i' id='ModKTid_$i' value='$id'>\n";
                $HTMLkod .= "</fieldset>";
                $HTMLkod .= "</div>\n ";
            }        
            //Submit
            $HTMLkod .= "<br style='clear:both;float:none;'>\n";
            $HTMLkod .= "<input type='submit' name='submitKiegTartalom' id='submitKiegTartalom' value='".U_BTN_MODOSITAS."'>\n";
            $HTMLkod .= "</form>\n";
            $HTMLkod .= "</div>\n";        
        }
    }
    return $HTMLkod;
}



function getKiegTHTML() {
    global $MySqliLink;
    
    $HTMLkod   = '';
    $SelectStr = "SELECT * FROM KiegTartalom WHERE KiegTPrioritas>0  ORDER BY KiegTPrioritas DESC";
    $result    = mysqli_query($MySqliLink, $SelectStr) OR die("Hiba sKTT 01");
    $rowDB     = mysqli_num_rows($result); 
    if ($rowDB > 0) { 
        while ($row = mysqli_fetch_array($result)){
            if ($row['KiegTTartalom']){
                $HTMLkod .= "<div class ='divKiegTKulso'>\n";
                if ($row['KiegTNev']!='') {$HTMLkod .= "<h2>".$row['KiegTNev']."</h2>\n";}
                $HTMLkod .= "<div class = 'divKiegT'>".$row['KiegTTartalom']."\n";
                $HTMLkod .= "</div></div>\n";
            }
        }
        mysqli_free_result($result);
    }
    return $HTMLkod;
}
