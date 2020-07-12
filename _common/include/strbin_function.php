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



//***************************************************************
require_once ("functions.php");
include_once ("constantes.php");


/*************************************************************************
 *transforme un tableau récupére via 'getArrayOnPrefix' en une valeur binaire 
 *ou chaque bit represente un des objet HTML
 *permet de stockcker les valeur de plusieurs case à cocher par exemple 
 * dans un seul champ de type entier long.
 *par exemple suposons les case à cocher suivante:
 * chk_0 = off
 * chk_1 = on
 * chk_2 = off
 * chk_3 = off
 * chk_4 = on
 * chk_5 = on
 * la valeur retourn&eacute; sera &eacute;gal Ó (2^1)+(2^4)+(2^5) =
 *                               =  2  + 16  +  32
 *                               =  50
 * voir la fonction 'bin2Array' qui fait l'inverse enfin presque
  *************************************************************************/
function array2Bin($t){
  $b = 0;
  for ($h = 0; $h < count($t); $h++){
    //jjd_echo ("array2Bin -> ".$h." = ".$t[$h]) ;
    if (!empty($t[$h] )){
      //jjd_echo ("|trouv&eacute;: ".$h."|") ;
       $b = $b | pow(2, $h);
    }
    //else {jjd_echo ("|pas trouve: ".$h."|") ;}
      //jjd_echo ("<BR>") ;
  }
  //jjd_echo ("array2Bin - bin = ".$b."<BR>") ;
  return $b;
}


/*************************************************************************
 *construit un tableau de valeur 0 ou 1, a partir d'une valeur binaire
 *permet de construire une liste d'objet comme des case à cocher dant la valeur
 *est stock&eacute;e souforme d'un entier long dans une table
 *un entier de 4 octet permet de stocket 32 valeur binaire, soit 32 cases Ó cocher
 *exemple:
 *soit la valeur 304 stock&eacute;e dans une table cette fonction va reconstituer le tableau
 * t$[0] = 0 
 * t$[1] = 1 -> 0000000000000010
 * t$[2] = 0
 * t$[3] = 1 -> 0000000000001000
 * t$[4] = 1 -> 0000000000010000
 * t$[5] = 1 -> 0000000000100000
 * t$[6] = 0
 * t$[7] = 0
 * t$[8] = 1 -> 0000000100000000
 * t$[9] = 0
 *      soit -> 0000000100111010  = 304 en decimal
 *************************************************************************/
function bin2Array($b, $lgMax = 32){
  $t = array ();
  
  for ($h = 0; $h < $lgMax; $h++){
    if ((($b & pow(2, $h)) <> 0 ) )  {$t[$h] = 1;} else {$t[$h] = 0;}
  }

  return $t;
}
/*************************************************************************
 *Transforme un tableau de valeur booleanne en une chaine de "0" et de "1"
 *************************************************************************/
function array2BinStr($t, $lgMax= 32){
  
  //for ($h = 0; $h < $lgMax; $h++){$tb[$h]="0";}
  $tb = array ();
  $tb = array_pad ($tb, $lgMax, "0");
  
  //--------------------------------------------------
  for ($h = 0; $h < count($t); $h++){
    //jjd_echo ("array2Bin -> ".$h." = ".$t[$h]) ;
    //if (($t[$h] > 1) || ($t[$h] = true)){
    //if (($t[$h] = on)){
    if (!empty($t[$h] )){
      //jjd_echo ("|trouv&eacute;: ".$h."|") ;
       $tb[$h] = "1";
    }
   //    $tb[$h] = "0";
    //else {jjd_echo ("|pas trouve: ".$h."|") ;}
      //jjd_echo ("<BR>") ;
  }
  $b = implode("",$tb);
  //jjd_echo ("array2Bin - bin = ".$b."<BR>";) 
  return $b;
}
/*
*/
/*************************************************************************
 transforme un chaine de type "010101010" en tableau de caracteres
 *************************************************************************/
function binStr2Array($binStr, $lgMax = 32){
  $t = array ();
  
  //jjd_echo ("binStr2Array - str = ".$binStr."<BR>") ;
  $binStr = str_pad($binStr, $lgMax, "0", STR_PAD_RIGHT);  
  
  for ($h = 0; $h < $lgMax; $h++){
    if (substr($binStr, $h, 1) == "1") {$t[$h] = 1;} else {$t[$h] = 0;}
  }

  return $t;
}

/************************************************************************
 *Transforme un tableau de numérique représentant des valeur binaire 0 et 1 
 *en un tableau de vvaleur binaire représentés par des caractères. "0" et "1"  
************************************************************************/
function arrayBin2Str($tBin){
  for ($h = 0; $h < count($tBin); $h++) {$tStr[$h] = strval($tBin[$h]);}
  return $tStr;
}
/************************************************************************
 *Transforme un tableau de caracter représentant des valeur binaire "0" et "1"
 *en un tableau de valeur numérique de 0 et de 1 
************************************************************************/
function ArrayStr2Bin($tStr){
  for ($h = 0; $h < count($tStr); $h++) {$tBin[$h] = intval($tStr[$h]);}
  return $tBin;
}

//************************************************************************

/*************************************************************************
 transforme un binaire en chaine de type "010101010"    bin => "010101010"
 *************************************************************************/
function bin2Str($bin, $lgMax = 32, $strTrue= "1", $strFalse = "0"){
  $t = array ();
  
  for ($h = 0; $h < $lgMax; $h++){
    if ((($bin & pow(2, $h)) <> 0 ) )  {$t[$h] = $strTrue;} else {$t[$h] = $strFalse;}
  }
  $binStr = implode ("", $t);
  
  return $binStr;
}
/*************************************************************************
 transforme une chaine de type "010101010"    => "| |1| |3| |5| |7| |"
 transforme une chaine de type "010101010"    => "|1|3|5|7|"
*************************************************************************/
function binStr2Index($binStr, $base = 0, $KeepOnlyTrue = true, $sep = "|", 
                      $strTrue= "1", $strFalse = "0", 
                      $prefixe = "[", $suffixe = "]")
{
  $t = array ();
  
  for ($h = 0; $h < strlen($binStr)-1; $h++){
    if (substr($binStr, $h, 1) == $strTrue){
      $t[] = strval($h+ $base);
    }
    elseif (!$KeepOnlyTrue){
      $lg = len (strval($h));
      $t[] = str_pad("", $lg, " ", STR_PAD_RIGHT); 
    }
  }
   
  $r = implode ($sep, $t);  
  return $prefixe.$r.$suffixe;

}







//****************************************************************
?>
