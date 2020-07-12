<?php
//  ------------------------------------------------------------------------ //

/****************************************************************************
 * 
 ****************************************************************************/
function buildNotation($note, $total, $img, $modeArrondi = 0, $indexImg1 = 1, $indexImg0 = 0){
//$modeArrondi = 0 : pas d'arrondi, les ima   ge seront partielles
//             = 1 : Arrondi a l'entier le plus pres 4/5
//             = 2 : arrondi a l'entier inferieur
//             = 3 : Arrondi a l'entie superrieur

  //$note = round($note,0);
  //$note = 2.5;
  //$nbDec = 0;
  
    switch ($modeArrondi){
    case 1:
        $note =  round($note, 0);    
        break;  
              
    case 2:    
        $note =  intval($note, 0);    
        break;
        
    case 3:
        $note =  intval($note + 1, 0);        
        break;
    default:
    
        break;
        
    }
  
  //-----------------------------------------------------------
//<iframe   style="border:0; width:135px; height:32px; background: url('file:///D:/notation/band/fire-vert=27x32.gif') no-repeat -189px 0px ; " >
  $p = "#([0-9]+).#";  
  preg_match_all($p,$img,$t);
  
  
  $size = $t[1];
  if (!isset ($size[2])) {
    $size[2] = 10;
  }else if ($size[2] == 0){
    $size[2] = 10;  
  }
  
  //displayArray($size, "----------buildNotation--{$img}---{$note}-------");  
  
  $nbImgMax = $size[2]; //nombre d'image par bande
  $lwDemiBande = ($nbImgMax * $size[0]) / 2;
  $lwt = $size[0] * $total;
  
  $ll1 = 0;  
  $lw1 = round($size[0] * $note, 0); 
  $lt1 = -($size[1] * $indexImg1);  
 
  
  $ll2 = -$lw1+1; //($nbImgMax - $note) * - $size[0];  
  $lw2 = $lwt - $lw1 ;  
  $lt2 = -($size[1] * $indexImg0) ;
  
  
  //$lwt = $lw1 + $lw2;

  $f1 = _JJD_NOTATION_URL.$img;
  
  //echo "lw1={$lw1} : lw2={$lw2} : lwt={$lwt} : ll2={$ll2}";
/*
  
  echo "ll1={$ll1} | lw1={$lw1} | lt1={$lt1}<br>"
      ."ll2={$ll2} | lw2={$lw2} | lt2={$lt2}<br>"
      ."lwt={$lwt} | note={$note}<br>"
      ."img={$f1}<hr>";  
  
*/  


   //echo "<hr> {$f1}<br>{$note} | {$total} |<br>ll:{$ll2} | lw:{$lw} | mw1:{$size[1]}<hr>";  
  //-----------------------------------------------------
 
  $link = "<iframe   style=\"border:0;background-color:transparent;"
        ."width:{$lw1}px; "
        ."height:{$size[1]}px; "
        ."background: url('{$f1}') no-repeat {$ll1}px {$lt1}px ;\" >"
        ."</iframe>"
        ."<iframe   style=\"border:0;background-color:transparent;"
        ."width:{$lw2}px; "
        ."height:{$size[1]}px; "
        ."background: url('{$f1}') no-repeat {$ll2}px {$lt2}px ;\" >"
        ."</iframe>";
        
  //-----------------------------------------------------------  
  return $link;

}

/****************************************************************************
 * 
 ****************************************************************************/
function buildImgString($exp, 
                        $modele, 
                        $link = '', 
                        $op='chr', 
                        $casse = 0, 
                        $alt = '',
                        $title = ''){
//$modeArrondi = 0 : pas d'arrondi, les ima   ge seront partielles
    if ($casse > 0){
        $exp = strtoupper();
    }else if ($casse < 0){
        $exp = strtolower();    
    }
    //--------------------------------------------
    $t = array();
    for ($h = 0; $h < strlen($exp); $h++){
        $l = substr($exp,$h,1);
        $chr = substr('00000' . ord($l), -3);
        $f = str_replace('?', $chr, $modele);
        if ($alt <> '')   $alt   = "Alt='{$alt}'";
        if ($title <> '') $title = "title='{$title}'";    
        
        $chaine =  "<img src='"._JJD_ALPHABET_URL."{$f}' border=0 {$alt} {$titel} ALIGN='absmiddle'>";            
        //$chaine =  "img src='"._JJD_ALPHABET_URL."{$f}' border=0 {$alt} {$titel} ALIGN='absmiddle'";
        
        if ($link <> ''){
            if ($op <> '') $op = 'chr';
            $sep = ((strpos($link, '?')  === false ) ? "?" : '&');
            $chaine = "<A HREF='{$link}{$sep}{$op}={$l}'>{$chaine}</A>";            
        }
        $t [] = $chaine;  
    }

    //displayArray($t,"------buildImgString--------");

    return implode ('', $t);

}


/****************************************************************************
 * 
 ****************************************************************************/
function deleteNotation($code, $idParent, $idChild = 0){

}


/****************************************************************************
 * 
 ****************************************************************************/
function addNewNotation($note, $code, $idParent, $idChild = 0){

}

?>
