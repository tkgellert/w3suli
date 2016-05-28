<?php
  global $oURL;
  $oURL           = ''; 
  $MySqliLink     = '';
  $Aktoldal       = array();
  $SzuloOldal     = array();
  $NagyszuloOldal = array();
  $DedSzuloId     = 0;

  require_once 'php/AlapFgvek.php';
  //MUNKAMENET INDÍTÁSA
  session_start();
  $mm_azon   = session_id(); 
  //Ha első bejelentkezés, akkor AktFelhasznalo tömb inicializálása
  //FSzint=1 > Látogató
  //FSzint=2 > Bejelentkezett felhasználó
  //FSzint=3 > Oldal moderátora
  //FSzint=4 > Rendszergazda
  //FSzint=5 > Kiemelt rendszergazda
  if (!isset($_SESSION['AktFelhasznalo'.'FSzint'])) {
      $_SESSION['AktFelhasznalo'.'id']     = 0;
      $_SESSION['AktFelhasznalo'.'FNev']   = '';
      $_SESSION['AktFelhasznalo'.'FFNev']  = '';
      $_SESSION['AktFelhasznalo'.'FEmail'] = '';
      $_SESSION['AktFelhasznalo'.'FSzint'] =  1;
      $_SESSION['AktFelhasznalo'.'FSzerep']= '';
      $_SESSION['AktFelhasznalo'.'FKep']   = '';  
      
      $_SESSION['ElozoOldalId']            = 1; 
      $_SESSION['SzerkFelhasznalo']        = 0;
      $_SESSION['SzerkFCsoport']           = 0;
      $_SESSION['SzerkModerator']          = 0;
      $_SESSION['SzerkMCsoport']           = 0;
      
      $_SESSION['SzerkCikk'.'id']          = 0;
      $_SESSION['SzerkCikk'.'Oid']         = 0;
  }  
  
  $_SESSION['ErrorStr']   = '';
  if ($_SESSION['AktFelhasznalo'.'FSzint']==3) {$_SESSION['AktFelhasznalo'.'FSzint']=2;} // A moderátor oldalanként változik  
  if (isset($_GET['f0'])) { $oURL = $_GET['f0'];} else { $oURL = '';}  
  
  //ADATBÁZIS MEGNYITÁSA
  require_once("php/DB/Adatbazis.php");
  require_once("php/Init.php");  
  //Alapadatok lekérdezése
  require_once("php/Alapbeallitasok.php");
  $_SESSION['ErrorStr']   .= setAlapbeallitasok();  
  $AlapAdatok = getAlapbeallitasok();
  
  //BE- vagy KIJELENTKEZÉS; FELHASZNÁLÓI ADATOK MÓDOSÍTÁSA
  require_once("php/Felhasznalo.php");
  if ($_SESSION['AktFelhasznalo'.'FSzint'] > 0) {
    $_SESSION['ErrorStr']   .= setBelepes(); 
    $_SESSION['ErrorStr']   .= setKilepes(); 
    $_SESSION['ErrorStr']   .= SetUjJelszo();
  }
  if ($_SESSION['AktFelhasznalo'.'FSzint'] > 3) {
    $_SESSION['ErrorStr']   .= setFelhasznalo();
    $_SESSION['ErrorStr']   .= setUjFelhasznalo();  
    $_SESSION['ErrorStr']   .= setFelhasznaloTorol();    
  }
  require_once("php/Oldal.php");
  require_once("php/FelhasznaloCsoport.php");  
  require_once("php/FCsoportTagok.php");
  require_once 'php/KiegeszitoTartalom.php';
  require_once 'php/FoMenu.php';
  require_once 'php/OldalModerator.php';
  require_once 'php/OldalLathatosag.php';
  require_once 'php/Menu.php';
  require_once 'php/OldalCikkei.php';
  require_once 'php/Cikk.php';
  require_once 'php/CikkKep.php';
  
  require_once 'php/OldalKeptar.php';
  require_once 'php/morzsa.php';
  require_once 'php/Lablec.php';
  
  require_once 'php/OldalElozetesek.php';
  require_once 'php/Oldalterkep.php';
  require_once 'php/MenuPlusz.php';
  
  //AZ AKTUÁLIS OLDAL ADATAINAK BEOLVASÁSA
  getOldalData($oURL);  
  
  //A MODERÁTOR STÁTUSZ ELLENŐRZÉSE
  if ($_SESSION['AktFelhasznalo'.'FSzint'] == 2) 
  {
    if (getOModeratorTeszt($Aktoldal['id']) > 0)    // Csak akkor érdekes, ha bejelentkezett, de nem rendszergazda     
    {
        $_SESSION['AktFelhasznalo'.'FSzint'] =  3;
    }
  } 
  
  //FELHASZNÁLÓI CSOPORTADATOK MÓDOSÍTÁSA
  if ($_SESSION['AktFelhasznalo'.'FSzint'] > 3) {
    $_SESSION['ErrorStr']   .= setUjFCsoport();  
    $_SESSION['ErrorStr']   .= setFCsoport(); 
    $_SESSION['ErrorStr']   .= setFCsoportTorol(); 
    $_SESSION['ErrorStr']   .= setCsoportTagok(); 
  }
    
  //AZ OLDAL ADATAINAK MÓDOSÍTÁSA
  if ($_SESSION['AktFelhasznalo'.'FSzint'] > 3) {  
    $_SESSION['ErrorStr']   .= setUjOldal();
    $_SESSION['ErrorStr']   .= setOldal();
    $_SESSION['ErrorStr']   .= setOldalTorol();  
    $_SESSION['ErrorStr']   .= setOldalKepek();
    $_SESSION['ErrorStr']   .= setOldalKepFeltolt();
    $_SESSION['ErrorStr']   .= setOldalKepTorol();
    $_SESSION['ErrorStr']   .= setOModerator();
    $_SESSION['ErrorStr']   .= setOLathatosag();
  }

  //A CIKKEK ADATAINAK MÓDOSÍTÁSA
  if ($_SESSION['AktFelhasznalo'.'FSzint'] > 2) {
    $_SESSION['ErrorStr']   .= setUjCikk();
    $_SESSION['ErrorStr']   .= setCikk();  
    $_SESSION['ErrorStr']   .= setCikkTorol();  
    $_SESSION['ErrorStr']   .= setCikkKepek();
    $_SESSION['ErrorStr']   .= setCikkKepFeltolt();
  }
  
  //KIEGÉSZÍTŐ TARTALOM MÓDOSÍTÁSA
  if ($_SESSION['AktFelhasznalo'.'FSzint'] > 3) {   
    $_SESSION['ErrorStr']   .= setKiegT(); 
    $_SESSION['ErrorStr']   .= setFoMenu();
    $_SESSION['ErrorStr']   .= setMenuPlusz();
  }
 
?>



<!DOCTYPE html>
<html lang="hu">
  <head> 
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
     <link type="text/css" rel="stylesheet" media="all"   href="css/w3suli_alap.css" />  
     <link type="text/css" rel="stylesheet" media="all"   href="css/w3suli_szerkeszt.css" />  
     <link type="text/css" rel="stylesheet" media="all"   href="css/w3suli_responsive.css" />
     <link href='https://fonts.googleapis.com/css?family=Istok+Web:700,400&amp;subset=latin-ext,latin' rel='stylesheet' type='text/css'>
     <link  rel="icon" type="image/png" href="img/ikonok/FavIcon/<?php echo $AlapAdatok['FavIcon']; ?>">
     <?php echo getHead(); ?>
     
<script>     
// A menü gombot nagy felbontásnál, az oldal letöltése után eldugjuk. A menü látszik.
function MenuNagyFelbontasnal() { 
    if (parseInt(window.innerWidth) > 1500) {
     document.getElementById('MenuLabel').style.display='none';
     document.getElementById('chmenu').checked=0;
    }
}
// A menüt kis felbontásnál, az oldal letöltése után eldugjuk
function MenuKisFelbontasnal() { 
    if (parseInt(window.innerWidth) < 800) {
     document.getElementById('chmenu').checked=1;
    }
}
// Az oldal letöltését követően hívandó JS fgv-ek
function JSonLoad()
{
   MenuNagyFelbontasnal();
   MenuKisFelbontasnal();
}
</script>
     
  </head>
  <body onLoad='JSonLoad()'>	  
     <div id='Keret'> 
       <header id='FoHeder'>
		   <a href="./" id="logoImgLink"><img src="img/ikonok/HeaderImg/<?php echo $AlapAdatok['HeaderImg']; ?>" alt="logó" title="Oldal neve" style="float:left;"></a>
		   <a href="./" id="logoLink"> <?php echo $AlapAdatok['HeaderStr']; ?></a>
	   </header>
	   <input name="chmenu" id="chmenu" value="chmenu" type="checkbox" style='display:none;'>
       <nav id='FoNav'> 
		 <div id='FoNavBal'>  
		   <label for="chmenu" class="MenusorElem" id="MenuLabel">
             <img src="img/ikonok/menu128.png" alt="Menü" title="Menü" style="float:left;" id="MenuIkon1">
             <img src="img/ikonok/menu228.png" alt="Menü" title="Menü" style="float:left;" id="MenuIkon2">     
             <span id="MENUGombDiv">Menü </span>
           </label>
         </div>
         <div id='FoNavJobb'>  
	     <?php echo getFoMenuHTML(); ?>
	 </div>  		    		 
       </nav>
       <div id='BelsoKeret'>
		  <nav id='HelyiNav'>
                     <?php echo getMenuHTML(); ?>		  
		  </nav>		   
		  <div id='Tartalom'>
                        <?php echo getMorzsaHTML(); ?>
                        <?php echo getOldalHTML(); ?>
			
		  </div> 		     
		  <aside id='KiegeszitoInfo'><?php echo getKiegTHTML(); ?></aside>       
       </div>     
       <footer id='FoFooter'><?php echo getLablecHTML(); ?></footer>
     
     </div>
      
    <?php if (($AlapAdatok['GoogleKod']!='') && (strlen($AlapAdatok['GoogleKod'])>10)){
    echo "    
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', '".$AlapAdatok['GoogleKod']."', 'auto');
            ga('send', 'pageview');

        </script>";
    //UA-76662941-1
    } ?>
    
    
    <!-- Helyezd el ezt a címkét a head szakaszban vagy közvetlenül a záró body címke elé. -->
    <?php if ($AlapAdatok['GooglePlus']==1){ 
    echo "       
    <script src='https://apis.google.com/js/platform.js' async defer>
      {lang: 'hu'}
    </script>";
    } ?>
    
  </body>

</html>
