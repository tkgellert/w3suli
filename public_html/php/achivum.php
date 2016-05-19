<?php 



function getArchivHTML() {  
    global $MySqliLink;
    $HTMLkod   = '';
    $SelectStr =   "SELECT C.id, C.CNev, O.OImgDir, C.CTartalom, C.CLeiras, OC.Cid, C.CSzerzoNev, C.CModositasTime
                    FROM Cikkek AS C
                    LEFT JOIN OldalCikkei AS OC                    
                    ON OC.Cid = C.id
                    LEFT JOIN Oldalak AS O
                    ON OC.Oid = O.id
                    WHERE C.CLathatosag='-1'";
    $result    = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba sMC 01 ");
    $rowDB     = mysqli_num_rows($result);
    if ($rowDB > 0) {
        while ($row    = mysqli_fetch_array($result)){
           $Cid        = $row['Cid']; 
           $CNev       = $row['CNev'];
           $OImgDir    = $row['OImgDir'];
           $CTartalom  = $row['CTartalom'];
           $CLeiras    = $row['CLeiras'];
           if ($OImgDir!='') {
               $KepUtvonal = "img/oldalak/".$OImgDir."/";
           } else {
               $KepUtvonal = "img/oldalak/";
           }
           $HTMLimg    = getElsoKepHTML($Cid,$KepUtvonal);
           
           $HTMLkod   .= "<div class ='divOElozetesKulso'>\n";          
           $HTMLkod   .= "<div class = 'divOElozetesKep'>$HTMLimg</div>\n";   
           $HTMLkod   .= "<div class='divOElozetesTartalom'>\n";
           $HTMLkod   .= "<h3>".$CNev."</h3>\n";
           if ($CLeiras!='') {$HTMLkod .= "<div class = 'divOElozetesLeir'>".$CLeiras."</div>\n";}    
           $HTMLkod .= "</div>\n";
           $HTMLkod .= "</div>\n";
           
                    $CTartalom = getCikkepCsereL($Cid,$CTartalom,$KepUtvonal);  // Képek beillesztése #0, #1,.. helyére
                    $CTartalom = SzintaxisCsere($CTartalom);
                    $HTMLkod .= "<div class ='divCikkKulso'><h2>".$CNev."</h2>\n";                    
                    $HTMLkod .= "<div class = 'divCikkTartalom'>\n";
                    $HTMLkod .= $CTartalom."\n";
                    $HTMLkod .= "</div>\n";
                    $HTMLkod .= "<p class='pCszerzoNev'> Szerző: ".$row['CSzerzoNev']."</p><p class='pCModTime'>Közzétéve: ".$row['CModositasTime']."</p></div>\n";
                

        }
    } else {
        $HTMLkod   = 'Az archívum még üres';        
    }
    
    
    
    
    return $HTMLkod;
}

function getElsoKepHTML($Cid,$KepUtvonal) {   
    global $MySqliLink;
    $HTMLkod     = '';
    $SelectStr   = "SELECT KFile, KNev FROM CikkKepek WHERE Cid=$Cid ORDER BY KSorszam DESC LIMIT 1";
    $result      = mysqli_query($MySqliLink,$SelectStr) OR die("Hiba gEKH 1 ");
    $rowDB       = mysqli_num_rows($result); 
    if ($rowDB > 0) {
        $row     = mysqli_fetch_array($result);  mysqli_free_result($result); 
        $Src     = $KepUtvonal.$row['KFile'];
        $Alt     = $row['KNev'];
        $HTMLkod.= "<img src='$Src'  class = 'imgOE' alt='$KNev'>";
    }
    return $HTMLkod;    
}

?>