<?php
//  ------------------------------------------------------------------------ //
//            JJD-BIBLIO - Bibliothèque de fonction pour modules             //
//                Utilisées nottamment par Lexique et HErmes                 //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique Générale GNU publiée par la Free Software Foundation (version 2 ou bien toute autre version ultérieure choisie par vous). 

Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU pour plus de détails. 

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

Création avril 2006
Dernière modification : septembre 2007
******************************************************************************/


/***************************************************************
function d'affichage personalis&eacute;e
param:  $exp:            expression a afficher
        $binDebug         Variable de type binaire qui sert de masque pour eviter f'afficher 
                          tout a chaque fois.
                          voir les constante _LEXJJD_DEBUG du fichier constante.
        $carLinEntete     Si ce 'est pas une chaine vide tire un trait avec cette chaine au avant l'expression
        $carLineEnqueue   Si ce 'est pas une chaine vide tire un trait avec cette chaine au apr&egrave;s l'expression
        $title            Si ce 'est pas une chaine vide affiche letitre avant l'expression
                          et tire un trait avec cette chaine avant l'expression si elle n'est pas vide
        $lgLine           longueur des traits de s&eacute;paration
****************************************************************/
define ('_JJD_DEBUG_NONE', 0);
define ('_JJD_DEBUG', 1);

function jjd_echo ($exp, $binDebug = 15, $carLinEntete = "_", $carLineEnqueue = "_", $title = "", $lgLine=60){
$br = "<BR>";
  
   if (($binDebug & _JJD_DEBUG) == _JJD_DEBUG_NONE) {return "";}
  //-----------------------------------------------
    echo $br;
  //-----------------------------------------------
  if ($carLinEntete <> ""){
    $line = str_pad("", $lgLine, $carLinEntete, STR_PAD_RIGHT);  
    echo $line.$br;
  }
  //-----------------------------------------------
  if ($title <> ""){
    echo $title.$br;
    if ($carLinEntete <> ""){
      $line = str_pad("", $lgLine, $carLinEntete, STR_PAD_RIGHT);  
      echo $line.$br;
    }
  }
  //-----------------------------------------------
  echo $exp.$br;
  //-----------------------------------------------
  if ($carLineEnqueue <> ""){
    $line = str_pad("", $lgLine, $carLineEnqueue, STR_PAD_RIGHT);  
    echo $line.$br;
  }
  /*
  */
  
}

/***************************************************************************
JJD - 25/07/2006
permet l'affichage d'un tableau. utilis&eacute; pour d&eacute;buger.
il y a peut &ecirc;tre une fonction PHP qui le fait d&eacute;ja, mais je ne l'ai pas trouv&eacute;
****************************************************************************/
/*******************************************************************
 *
 *******************************************************************/
function displayArray($t, $name = "", $ident = 0){
  
  if (is_array($t)){
  	jjd_echo ("displayArray: ".$name." - count = ".count($t), 255, "-") ;
  
    //echo "<table ".getTblStyle().">";
    echo "<table >";
      
    echo "<tr><td>";      
  	jjd_echo ("displayArray: ".$name." - count = ".count($t), 255, "-") ;  
    echo "</td></tr>";  
  
    echo "<tr><td>";
    echo '<pre>'; 
    echo print_r($t); 
    echo '</pre>';
    echo "</td></tr>";
    echo "</table>";

  }else  {
    echo "l'indice ---|{$t}|--- n'est pas un tableau";  
  }
	//jjd_echo ("Fin - ".$name, 255, "-") ;

}

/*

function displayArray($t, $name = "", $ident = 0){
  

	jjd_echo ("displayArray: ".$name." - count = ".count($t), 255, "-") ;
  
  if (is_array($t)){
      $tKeys = array_keys( $t);
      
      for ($h = 0; $h < count($t); $h++){
        if (@is_array($t[$h])){
            displayArray ($t[$h], "Niveau: ".($ident + 1)." - index: {$h}" , $ident + 1);
        }else{
        //echo $h."-JJD<br>";
            $alinea = str_pad ("", $ident * 4, "-");
         //echo $alinea.$tKeys[$h]."<>br";  
            //jd_echo ($alinea."Index = ".$h."-> Key = ".$tKeys[$h]." = ".$t[$tKeys[$h]]."<br>","","") ;
            
            //echo $alinea."Index = ".$h."-> Key = ".$tKeys[$h]." = ".$t[$tKeys[$h]]."<br>","","" ;
            
            //error_reporting(E_NOTICE);            
            $v1 = $alinea."Index = {$h}-> Key = ";
            $v2 = $tKeys[$h]." = ".$t[$tKeys[$h]]."<br>";        

            echo $v1 ;
            echo $v2 ;                    
        }
    	  
    
    	  // jjd_echo ("Index = ".$h."-> Key = ".key($t[$h])." = ".$t[$h]."<br>") ;
      }
  
  }else  {
    echo "l'indice ".$t." n'est pas un tableau";  
  }
	jjd_echo ("Fin - ".$name, 255, "-") ;

}
*/

/***************************************************************************
JJD - 25/07/2006
permet l'affichage d'un tableau. utilis&eacute; pour d&eacute;buger.
il y a peut &ecirc;tre une fonction PHP qui le fait d&eacute;ja, mais je ne l'ai pas trouv&eacute;
****************************************************************************/

function displayArray2($t, $name = "", $ident = 0, $parent = ''){
  

	jjd_echo ("displayArray: ".$name." - count = ".count($t), 255, "-") ;
  
  if (is_array($t)){
      $h = 0;
      reset ($t);
      while (list ($key, $val) = each ($t)) {
      //while ($i = current($t)) {
        $alinea = str_pad ("", $ident * 4, "-");      
        $i = $val;
        if (is_array($i)){  
            $v1 = $alinea."Index = {$h}-> Key = {$parent}.";
            $v2 = Key($t)." = Array(".(count($t)).")<br>";            
            echo $v1 ;   
            echo $v2 ;                     
            displayArray2 ($i, "Key: {$parent} - Niveau: ".($ident + 1)." - index: {$h}" , $ident + 1, $parent.'.'.$v2);        
        }else {

            $v1 = $alinea."Index = {$h}-> Key = ";
            //$v2 = Key($t)." = ".current($t)."<br>";        
            $v2 = "{$key} = {$val}<br>";
            echo $v1 ;
            echo $v2 ;                    
        
        }   
        
        $h++;
        //echo "+++++++++ {$h} ++++++++++++<br>";
        //next($t);      
      

    }

  
  
  
  
  
  
  
  }else  {
    echo "l'indice ---|{$t}|--- n'est pas un tableau";  
  }
	jjd_echo ("Fin - ".$name, 255, "-") ;

}
//---------------------------------------------------
function displayArray3($t, $name = "", $ident = 0){
  

	jjd_echo ("displayArray: ".$name." - count = ".count($t), 255, "-") ;
  
  if (is_array($t)){
      $h = 0;
      reset ($t);
      while ($i = current($t)) {
        if (is_array($i)){  
            $v1 = $alinea."Index = {$h}-> Key = ";
            $v2 = Key($t)." = Array()<br>";            
            echo $v1 ;   
            echo $v2 ;                     
            displayArray2 ($i, "Niveau: ".($ident + 1)." - index: {$h}" , $ident + 1);        
        }else {
            $alinea = str_pad ("", $ident * 4, "-");
            $v1 = $alinea."Index = {$h}-> Key = ";
            $v2 = Key($t)." = ".current($t)."<br>";        

            echo $v1 ;
            echo $v2 ;                    
        
        }   
        
        $h++;
        echo "+++++++++ {$h} ++++++++++++<br>";
        next($t);      
      

    }

  
  
  
  
  
  
  
  }else  {
    echo "l'indice ---|{$t}|--- n'est pas un tableau";  
  }
	jjd_echo ("Fin - ".$name, 255, "-") ;

}


?>
