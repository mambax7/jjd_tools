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






include_once ("constantes.php");
include_once ("sysfile_functions.php");
include_once ("database_functions.php");
include_once ("debugTools.php");
include_once ("html_functions.php");

//include_once ( XOOPS_ROOT_PATH."/class/xoopseditor/editor_functions.php");
//echo XOOPS_ROOT_PATH."/include/editor_functions.php<hr>";
include_once ( "editor_functions.php");

/***************************************************************************
*
*****************************************************************************/

function testFile($filename){

if (file_exists($filename)) {
    print "Le fichier $filename existe";
} else {
    print "Le fichier $filename n'existe pas";
}


}

/***************************************************************************
JJD - 15/07/2006
Petite modif juste pour dire que c'est JJD qu'a foutu un peu le bordel
****************************************************************************/

function getCopyright() {
global $xoopsModule;

    $module_handler = &xoops_gethandler('module');
    $versioninfo = &$module_handler->get($xoopsModule->getVar('mid'));
    $v = $versioninfo->getInfo('version');
    $i = $versioninfo->getInfo('initiales');
    $n = $versioninfo->getInfo('name');
/*
    
  $cr = "<a href='http://www.wakasensei.fr' target='_new'><B>{$n}</B> "
        ._MD_LEX_VERSION." {$v} "
        ._MD_LEX_BY." <B>{$i}</B></a>";
*/        

  $cr = "<a href='http://www.wakasensei.fr' target='_new'><B>{$n}</B> "
        .'Version'." {$v} "
        .'Author'." <B>{$i}</B></a>";
 
	return ($cr);
}
/***************************************************************************
JJD - 15/07/2006
Petite modif juste pour dire que c'est JJD qu'a foutu un peu le bordel
****************************************************************************/

function getCopyright2($moduleName, $site, $signature='') {
global $xoopsModule;

		$module = XoopsModule::getByDirname($moduleName);
    $n = $module->vars['name']['value'];    
    $v = number_format($module->vars['version']['value'] / 100, 2, '.', ' ');
    $i = $signature;
    //$n = $versioninfo->getInfo('name');
		
		
		/*

		echo "<preg>";
    print_r($module);
		echo "</preg>";		
		$copyright= $module->vars['mid'];//getcopyRight();
		echo "<hr>info->{$copyright}<hr>";
		displayArray($module->vars,"----------------");
    */		
  $cr = "<a href='http://{$site}' target='_new'><B>{$n}</B> "
        .'Version'." {$v} "
        .'Author'." <B>{$i}</B></a>";
  $cr = "{$n}-{$v}-{$i}";
 
	return ($cr);
}

//-----------------------------------------------------------------------
/******************************************************************
 calcul un valeur defini par des bornes. 
 si la valeur passee; est plus petite que le minimum, renvoie la borne inferieure
 si la valeur est plus grande que le maximum, renvoie la borne superieure
 renvoie la meme valeur dans les autres cas.
 les option de configuration ne permette pas de controle de valeur (du moins je n'ai pas trouve)
 cela permet de faire le controle a posteriori. 
 par exemple, le nombre de ligne du selecteur alphabetique, ne doit pas etre
 inferieure a 1 et superieure a 3. 
 si l'utilisateur a saisie une valeur hors borne, cela limite les degats
 si config est une chaine recupere la valeur a bornee dans moduleCongig
 sinon considere que ce'est ne valeur et l'utilise directement
 ******************************************************************/
function getValeurBornee($source, $min = 0, $max = 255) {
	Global $xoopsDB, $xoopsModuleConfig, $info;

	if (is_numeric($source)){
    $vb = $source;	
  }else{
    $vb =  @$info[$source];    
  }
	//------------------------------------------------------

  if ($vb < $min ){$vb = $min;}
  elseif ($vb > $max ){$vb = $max;}  
  
  return ($vb);
  
}


function getValeurBornee2($source, $min = 0, $max = 255) {
	Global $xoopsDB, $xoopsModuleConfig;

    $vb = $source;	
	//------------------------------------------------------

  if ($vb < $min ){$vb = $min;}
  elseif ($vb > $max ){$vb = $max;}  
  
  return ($vb);
  
}

/***********************************************************************
 ***********************************************************************/
function import2db($text) {
	return preg_replace(array("/'/i"), array("\'"), $text);
}


//---------------------------------------------------------------------------


/***************************************************************************
JJD - 25/07/2006
****************************************************************************/
function isBitOk($bit, $val){
  $b = pow(2, $bit);
  $v = (($val &  $b) <> 0 )?1:0;
  return $v;


}


function zzz($s){
  echo $s;
}








/***************************************************************************
JJD - 25/07/2006
construit une liste de sTlection a partir d'une liste de nom et de valeur
paramFtrTs: 
$name : valeur de l'attribut 'name'
$list : tableau de valeur affich&eacute; dans la liste
$firstIndex: index affect&eacute; au premier &eacute;l&eacute;ment (normalement 0 ou 1). 
             les autres sont incr&eacute;ment&eacute; de 1
$defaut: item a selectionner par d&eacute;faut. se ref&egrave;re au num&eacute; de position 
         dans la liste en fonction du premier index.
         ex si $firstIndex=0 et que defaut = 2, l'item s&eacute;lection&eacute; est le 3eme 
$width = "50": largeur de la liste,. mais la il y a un probleme, car apprament
         on ne peut pas sp&eacute;cifier la largeur d'une liste. 
         elle prend la largeur de l'item le plus grand, a v&eacute;rifier a l'ocasion.
****************************************************************************/
function getlistSearch ($name, $list, $firstIndex = 0, $defaut = 0, $nbRows = 0,
                        $colId = 'id', $colLib = 'lib', $colBgColor = 'bgColor',
                        $onChange = '',  $idSelected = 0){
//$ret .= "<option value='{$color}' {$selected}  style='background-color:#{$color};color:#{$color};'>#{$color}</option>\n";           
  
  if ($nbRows > 1)    {$size = " size='{$nbRows}' ";}   else{$size = '';}  
  $tselected = array();
  $oc = ($onChange == '')?'':"onchange='$onChange;'";
  $tselected [] = "<SELECT NAME='{$name}' {$size} {$oc}>";
  $style = '';
  
  if (count($list) == 0) {
    return '';
  }
  
  if ($defaut == 0){$defaut = $list[0][$colId];}
  
  for ($h = 0; $h < count($list); $h++){
    if (is_array($list[$h])) {
      $i = $firstIndex + $list[$h][$colId];   
      $lib =  $list[$h][$colLib];
      if (isset($list[$h][$colBgColor])){
        $bg = $list[$h][$colBgColor];
        $style = " style='background-color:#{$bg}' ";

      }else{$style = '';}
    }else{
      $i = $firstIndex + $h;
      $lib =  $list[$h];          
    }

    if ($defaut == $i ) {	
        $itemSelected = " selected";
        $idSelected = $list[$h][$colId]; 
    } else {$itemSelected = "";}
    
    $tselected [] = "<OPTION VALUE='{$i}'{$itemSelected} {$style}>{$lib}";

  }
  $tselected [] = "</SELECT>";
  
  $obList = implode ("", $tselected);
  return $obList;
}
//------------------------------------------------------------------------------
/***************************************************************************
 *
 ***************************************************************************/
function buildHtmlAList ($name, $list, $onChange = '', $width = "50"){
  
  $tselected = array();
  $defaut = 0; //pas utile de l'avoir en parametre pur le menu
  
  if ($onChange <> ''){$oc = "onchange='{$onChange}'" ;}else{$oc='';}
  $tselected [] = "<SELECT NAME='{$name}' {$oc}>";
  
  for ($h = 0; $h < count($list); $h++){
    $i = $list[$h]['id'];
    $v = $list[$h]['value'];
    if ($defaut == $i ) {	$itemSelected = ' selected';} else {$itemSelected = '';}
    
    $tselected [] = "<OPTION VALUE='{$i}' {$itemSelected}>{$v}";
  }
  $tselected [] = "</SELECT>";
  
  $obList = implode ("", $tselected);
  return $obList;
}

/***************************************************************************
 *
 ***************************************************************************/
function buildHtmlListVal ($name, $firstVal, $nbVals, $defaut = 0, $sens = 0, $onChange = ''){
  
  $tselected = array();

  
  if ($onChange <> ''){$oc = "onchange='{$onChange}'" ;}else{$oc='';}
  $tselected [] = "<SELECT NAME='{$name}' {$oc}>";
  
  if ($sens == 0){
      for ($h = $firstVal; $h < ($firstVal + $nbVals  ) ; $h++){
        if ($defaut == $h ) {	$itemSelected = ' selected';} else {$itemSelected = '';}
        $tselected [] = "<OPTION VALUE='{$h}' {$itemSelected}>{$h}";
      }
  
  }else{
      for ($h = ($firstVal + $nbVals  -1); $h >= $firstVal ; $h--){

        if ($defaut == $h ) {	$itemSelected = ' selected';} else {$itemSelected = '';}
        //echo "{$defaut} - {$itemSelected}<br>";        
        $tselected [] = "<OPTION VALUE='{$h}' {$itemSelected}>{$h}";
      }
  
  }
  $tselected [] = "</SELECT>";
  
  $obList = implode ("", $tselected);
  return $obList;
}

/***************************************************************************
 *
 ***************************************************************************/
function buildHtmlListString ($name, $list, $defaut = '', 
                              $addBlanck = false, 
                              $onChange = '', 
                              $sep = ";"){
  if (!is_array($list)){
    $list = explode($sep, $list);
  }else{
  
  }
  
  $tselected = array();
  
  if ($onChange <> ''){$oc = "onchange='{$onChange}'" ;}else{$oc='';}
  $tselected [] = "<SELECT NAME='{$name}' {$oc}>";
  if ($addBlanck){
    $tselected [] = "<OPTION VALUE='' >";  
  }

    
  for ($h = 0; $h < count($list); $h++){
    $item = $list[$h];
    
    if ($defaut == $item ) {	$itemSelected = " selected";} else {$itemSelected = "";}
    
    $tselected [] = "<OPTION VALUE='{$item}' {$itemSelected}>{$list[$h]}";
  }
  $tselected [] = "</SELECT>";
  
  $obList = implode ("", $tselected);
  return $obList;
}

/*************************************************************************
 *utilis&eacute; notamment aves $_POST & $_GET pour r&eacute;cup&eacute;rer l'ensemble des objets
 d'un page qui commence par le meme prefixe et termine par un index unique.
 par exempl supposons que nous ayont consteruit une page avec 8 case a cocher
 nomm&eacute;es: chk_1, chk_2, chk_3, ... chk_8 et que l'on ai coch&eacute; les 2,3 et 7eme case
 cette fonction construit un tableau comme suit
 $t(0) = ""
 $t(1) = ""
 $t(2) = "on"
 $t(3) = "on"
 $t(4) = ""
 $t(5) = ""
 $t(6) = ""
 $t(7) = "on"
 comme cette fonction est destin‚e … fonctionner avec n'importe 
 quel type d'objet HTML, il n'y a pas de transformation des valeurs
 elle sont restitu&es tel que.  
 Il y a une autre foncion charg‚ede cette transformation (array_2Bin je ce crois)
*************************************************************************/
function getArrayOnPrefix ($ta, $prefix, $max = 32){

  $lg = strlen($prefix);
  $tKeys = array_keys ($ta);
  
  //prepare le tableau de reception car apparament il ya un petit bug dans PHP
  // a suivre de pret des fois que cela soit corrige; dans les version a venir
  //for ($h = 0; $h < 32; $h++) {$tr[$h] = "";}
  $tr = array();
  $tr = array_pad ($tr, $max, "");
  
  //on baaye les clT du tablebleu $_POST
  for ($h = 0; $h < count($tKeys); $h++){
    if (substr($tKeys[$h], 0, $lg) == $prefix) {
        $index = intval(substr($tKeys[$h], $lg));
        for ($i = 0; $i<=$index; $i++){
        if ($i==$index){$tr[$i] = $ta [$tKeys[$h]] ; }
        }
   //jjd_echo ( "getArrayOnPrefix - > ".$index." > ".$tKeys[$h]." = ".$ta [$tKeys[$h]]." - ".$ta [$h]."<BR>");
    }
  }
  
  return  $tr;
}
/***************************************************************************
 *
 ***************************************************************************/
function getArrayKeyOnPrefix ($ta, $prefix){

  $lg = strlen($prefix);
  $tKeys = array_keys ($ta);
  
  //prepare le tableau de reception car apparament il ya un petit bug dans PHP
  // a suivre de pret des fois que cela soit corrige; dans les version a venir
  //for ($h = 0; $h < 32; $h++) {$tr[$h] = "";}
  $tr = array();

  
  //on baaye les clT du tablebleu $_POST
  for ($h = 0; $h < count($tKeys); $h++){
    if (substr($tKeys[$h], 0, $lg) == $prefix) {
        $name = substr($tKeys[$h], $lg);
        $tr [$name] = $ta [$tKeys[$h]];

   //jjd_echo ( "getArrayOnPrefix - > ".$index." > ".$tKeys[$h]." = ".$ta [$tKeys[$h]]." - ".$ta [$h]."<BR>");
    }
  }  
  
  //displayArray($tr);
  return  $tr;
}


/****************************************************************************
 *
 ****************************************************************************/
function getArrayOnPrefix2 ($ta, $prefix, $sepPrefixe = ";"){


  $tKeys = array_keys ($ta);

  //prepare le tableau de reception car apparament il ya un petit bug dans PHP
  // a suivre de pret des fois que cela soit corrige; dans les version a venir
  //for ($h = 0; $h < 32; $h++) {$tr[$h] = "";}
  $tr = array();
  $tr = array_pad ($tr, 32, "");
  
  $tPrefix = explode($sepPrefixe,$prefix);  
  
  //on balaye les cles du tablebleu $_POST  
  if (count($tPrefix) == 1){
      $lg = strlen($prefix);
      for ($h = 0; $h < count($tKeys); $h++){
        if (substr($tKeys[$h], 0, $lg) == $prefix) {
            $index = intval(substr($tKeys[$h], $lg));
            for ($i = 0; $i<=$index; $i++){
            if ($i==$index){$tr[$i] = $ta [$tKeys[$h]] ; }
            }
       //jjd_echo ( "getArrayOnPrefix - > ".$index." > ".$tKeys[$h]." = ".$ta [$tKeys[$h]]." - ".$ta [$h]."<BR>");
        }
      }
  
  }else{
      //Calul de la longueur des prefixe pour extraire en suite les valeur
      $tLg = array();
      $tLg = array_pad ($tr, 32, "");
      $nbPrefixes = count($tPrefix);
      $max = 0; 
      
      for ($h = 0; $h < $nbPrefixes; $h++){   
          $tLg[$h] =  strlen($tPrefix[$h]);
          //echo $tPrefix[$h]." - lg = ".$tLg[$h]."<br>";
      } 
      //echo "888888888888888888888888888888888888888<br>";
      //----------------------------------------------------------
 //displayArray($tKeys,"zzzzzzzzzzzzzzzzzzzzzz");
      for ($h = 0; $h < count($tKeys); $h++){
      
      
          //si on trouve une cle qui commence par un des prefixe, on traite
          for ($i = 0; $i < $nbPrefixes; $i++){
          //echo $tKeys[$h]." = ".$ta [$tKeys[$h]]."<br>";          
 //echo "wwww-".substr($tKeys[$h], 0, $tLg[$i])." == ".$tPrefix[$i]."<br>";          
            if (substr($tKeys[$h], 0, $tLg[$i]) == $tPrefix[$i]) {
                $index = intval(substr($tKeys[$h], $tLg[$i]));
                if ($max < $index){$max = $index;}          

                $tr[$index][$tPrefix[$i]] = $ta [$tKeys[$h]] ; 
              }    
                //echo $tPrefix[$i]." -> ".$tKeys[$h]."-->".$ta [$tKeys[$h]]."<br>";            
                /*

                for ($i = 0; $i<=$index; $i++){
                if ($i==$index){$tr[$i] = $ta [$tKeys[$h]] ; }
                }
                */                
                
           //jjd_echo ( "getArrayOnPrefix - > ".$index." > ".$tKeys[$h]." = ".$ta [$tKeys[$h]]." - ".$ta [$h]."<BR>");
            }
          }
          
      }    
        
        
  echo "max = ".$max."<br>";
  return  array_slice ($tr, 0, $max+1);
}


/****************************************************************************
 *
 ****************************************************************************/
function getArrayOnPrefixArray ($p, $lstPrefixe, $sepPrefixe = ";", $sepElement = "_"){


  $tKeys = array_keys ($p);
  
  //prepare le tableau de reception car apparament il ya un petit bug dans PHP
  // a suivre de pret des fois que cela soit corrige; dans les version a venir
  //for ($h = 0; $h < 32; $h++) {$tr[$h] = "";}
  $tValue = array();
  $tPrefixe = explode($sepPrefixe, $lstPrefixe);  



      while (list($k, $item) = each($p)) {
     // while ($item = current($p)) {
     //   $k = key($p);
//     echo $k." => ".$item.'<br>';   
        $elements = explode ($sepElement, $k); 
        for ($i = 0; $i < count($tPrefixe); $i++){
          if ( $tPrefixe[$i] == $elements[0]) {
            $j = $elements[1];
           
            $tValue [$j][$tPrefixe[$i]] = $item;
          }
        
        }      

 
            
      }  
   
   return $tValue;
  
}

/****************************************************************************
 *
 ****************************************************************************/
function sqlInsertOnPrefix ($p, $lstPrefix, $sType, $table,
                            $underscore = true, $sepPrefixe = ";"){
//$mode = 0 - insert  $mode = 0 ,
//$mode = 1- update
  
  
  //-------------------------------------------------------------
  $tPrefix = explode($sepPrefixe, $lstPrefix);  
  $tField = array();
  $tValue = array() ;  
  $us = ($underscore)?'_':'';
  //-------------------------------------------------------------  
  for ($h = 0; $h < count($tPrefix);$h++){
    $prefix = $tPrefix[$h].$us;
    $lg = strlen($prefix);
    reset ($p);
      
      $ok = false;
      while ($item = current($p)) {
        $k = key($p);
        if ( $prefix == substr($k, 0, $lg)) {
            $tField []= $tPrefix[$h];
            $tValue []= $item ;  
            $ok = true ;
            break;
        }
        next ($p);
      
      }
      if (!$ok) {
            $tField []= $tPrefix[$h];
            $tValue []= '' ;  
      
      };
  }  
  $fields = implode(',', $tField);
  $values = implode(',', $tValue); 
  $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";      
  
  echo $sql."<br>";
  return  $sql;

}

/****************************************************************
 *
 ****************************************************************/

function buildArrayOnPrefix ($p, $lstPrefix, $sType, $table,
                            $colId, $id, 
                            $underscore = true, $sepPrefixe = ";"){
//$mode = 0 - insert  $mode = 0 ,
//$mode = 1- update
  
  $lstPrefix = str_replace ( $sepPrefixe, ',', $lstPrefix);
  //-------------------------------------------------------------
  $tPrefix = explode(',', $lstPrefix);  
  $tField = array();
  $nbFields = count($tPrefix);
  $tValue = array() ;  
  $us = ($underscore)?'_':'';
  //-------------------------------------------------------------  
  for ($h = 0; $h < count($tPrefix);$h++){
    $prefix = $tPrefix[$h].$us;
    $lg = strlen($prefix);
    reset ($p);
      
      $ok = false;
      //$tValue [$j] = array_pad ( array (), $nbFields, '');


      while (list($k, $item) = each($p)) {
     // while ($item = current($p)) {
     //   $k = key($p);        

        //echo "{$k} = {$item} <br>";        

        if ( $prefix == substr($k, 0, $lg)) {
            $t = explode ('_', $k);
            $j = $t[count($t)-1];
        if (!isset($tValue [$j])){
          $tValue [$j] = array_pad (array()  , $nbFields, '');        
        }
            
            //$tField [$j][] = $tPrefix[$h];
            
            $tValue [$j][$h] = $item ;  
            $ok = true ;
            //break;
        }
        //next ($p);
      
      }
      if (!$ok) {
            //$tField []= $tPrefix[$h];
            //$tValue []= '' ;  
      
      };
            
  }  
  
  //displayArray($tValue,$lstPrefix.'++++++++++$tValue+++++++++++++++++++++++++++++');  
  //------------------------------------------------------- 
  for ($h = 0; $h < count($tValue);$h++){
      for ($j = 0; $j < count($tValue[$h]);$j++){  
        switch (substr($sType.'nnnnnnnnnnnnnn',$j,1)){
        case 's':
          //$tValue[$h][$j] = "'".$tValue[$h][$j]."'";
          $tValue[$h][$j] = string2sql ($tValue[$h][$j], true);          
            break;
        case 'b':
          if ( strtoupper($tValue[$h][$j]) == 'ON' OR $tValue[$h][$j] == 1){
            $tValue[$h][$j] = 1;
          }else{
            $tValue[$h][$j] = 0;          
          }
           
            break;
        case 'n':
            break;
            
        }
      }
      
  }
 
  //-------------------------------------------------------  
  //displayArray($tValue, "------buildArrayOnPrefix------");
  return $tValue;

}

/****************************************************************
 *
 ****************************************************************/

function sqlInsertArrayOnPrefix ($p, $lstPrefix, $sType, $table,
                            $colId, $id, 
                            $underscore = true, $sepPrefixe = ";"){
//$mode = 0 - insert  $mode = 0 ,
//$mode = 1- update
  $lstPrefix = str_replace ( $sepPrefixe, ',', $lstPrefix);  
  $tValue = buildArrayOnPrefix ($p,$lstPrefix,$sType,$table,$colId,$id,$underscore,$sepPrefixe);
  
  //-------------------------------------------------------  
  
  
  //displayArray($tValue,'********************************');
  //-------------------------------------------------------
  $tv = array();  
  for ($h = 0; $h < count($tValue); $h++){
    $tValue [$h] = array_pad (  $tValue [$h]  , $nbFields, 'zzzzz');
    $tv [$h] = "({$id},".implode(',',  $tValue [$h] ).')';
  }
  //displayArray($tv,'********************************');  
  //$v =  implode(','.chr(13).chr(10),  $tv );
  $v =  implode(','._br,  $tv );  
  //-------------------------------------------------------
  //$fields = implode(',', $tField);
  //$values = implode(',', $tValue); 
  $sql = "INSERT INTO {$table} ({$colId},{$lstPrefix}) VALUES {$v};";      
  
  echo $sql."<br>";
  return  $sql;

}

/****************************************************************
 *
 ****************************************************************/
function buildSqlInsert ($t , $lstFields, $table,
                            $colIdParent, $idParent){

  $tPrefix = explode(',', $lstFields);  
  $tFields = array_slice($tPrefix, 1);
  $sFields = implode(',', $tFields);
  
  $t = array_slice ($t, 1);
  //displayArray($t, 'slice.............................');
  $f = implode(',', $tFields);
  
   $v = "{$idParent},".implode(',', $t);
   //$v = string2sql($v);   
   $sql = "INSERT INTO {$table} ({$colIdParent},{$f}) VALUES ({$v});";      
  
//$sql ='aaaaaaaaaaaaaa';
  return  $sql;


}
/****************************************************************
 *
 ****************************************************************/
 
/****************************************************************
 *
 ****************************************************************/
function buildSqlUpdate ($t, $lstFields, $table,
                            $colIdParent, $idParent){
global $xoopsDB;
   $tPrefix = explode(',', $lstFields);  
    $v = array();
    $v [] = "{$colIdParent} = {$idParent}";    
    
    for ($h = 1; $h < count($t); $h++){
      //$t[$h] = string2sql($t[$h]);
      $v [] = "{$tPrefix[$h]} = {$t[$h]}"; 
    }
    
    $sql = "UPDATE {$table} SET ".implode(',',$v)." WHERE {$tPrefix[0]} = {$t[0]}";
    return $sql;

}
 
 
/****************************************************************
 *
 ****************************************************************/

function sqlArrayOnPrefix ($p, $lstPrefix, $sType, $table,
                            $colIdParent, $idParent, 
                            $underscore = true, $sepPrefixe = ";"){
//$mode = 0 - insert  $mode = 0 ,
//$mode = 1- update
  
  $lstPrefix = str_replace ( $sepPrefixe, ',', $lstPrefix);
  $tValue = buildArrayOnPrefix ($p,$lstPrefix,$sType,$table,
                                $colIdParent,$idParent,
                                $underscore,$sepPrefixe);
  //-------------------------------------------------------------
  //$tPrefix = explode(',', $lstPrefix);  
  //$tFields = array_slice($tPrefix, 1);
  //$lstFields = implode(',', $tFields);
 // $nbFields = count($tPrefix);
  
  $us = ($underscore)?'_':'';
  //-------------------------------------------------------------  
  //displayArray($p,'*************$p**************************');  
  //displayArray($tValue,'++++++++++$tValue+++++++++++++++++++++++++++++');
  //-------------------------------------------------------
  $tSql = array();  
  for ($h = 0; $h < count($tValue); $h++){
    if ($tValue [$h][1] == '' or $tValue [$h][1] == "''") continue;
    if ($tValue [$h][1] <> '') {
        if ($tValue [$h][0] == 0){
            $tSql [] = buildSqlInsert ($tValue[$h] , $lstPrefix, $table, $colIdParent, $idParent);
        }else{
            $tSql [] = buildSqlUpdate ($tValue[$h] , $lstPrefix, $table, $colIdParent, $idParent);    
            
        } 
    
    }    
    
   } 
    
    
    
  
  //displayArray($tSql,'********************************');  
  

  return  $tSql;

}
/***************************************************************************
 *suprime tout cracter incompatble avec de la liste passe en parametre
 *a utiliser pour le nom des ficiers 
 ***************************************************************************/
 function sanitizeNameFile ($name, $car2relace = "\"\',;:!/*", $byCar = "_"){
    //echo "<hr>sanitizeNameFile = $name<hr>";//exit;  
    $name = str_replace ("\'" ,$byCar, $name);    
    
    for ($h = 0; $h < strlen($car2relace); $h++){
      $name = str_replace (substr($car2relace,$h,1) ,$byCar, $name);
    
    }
    //echo "<hr>sanitizeNameFile = $name<hr>";//exit;    
    return $name;

 }

/***************************************************************************
 *construit un clause like apartir des elements en parametre
 ***************************************************************************/
 function buildClauseLike ($colName, $exp2Search, $mode = 0, 
                           $delimiteur = " -.;:()"){
    	
    	
    	if ($exp2Search == ''){return '';}
      switch ($mode) {
      case 1:
        $r = " ".$colName." LIKE '".$exp2Search."%' ";
        break;
        
      case 2:
        $r = " ".$colName." LIKE '%".$exp2Search."' ";
        break;

      case 3:
        $r = " ".$colName." LIKE '%".$exp2Search."%' ";
        break;
        
      case 4:
        $tDelim = array ();
        $cote = '"';
        for ($h=0; $h< strlen($delimiteur); $h++){
          $tdelim [] = $cote.substr($delimiteur, $h, 1).$cote; 
        }
        
        //$sDelim = implode (",", $tdelim);
        //$sDelim = "[".$sDelim."]";
/*
        $sDelim = '^[ -()]';
        $r  = " (";
        $r .=   " ".$colName." LIKE '".$exp2Search."' ";
        $r .= "OR ".$colName." REGEXP '".$sDelim.$exp2Search.$sDelim."' ";
        $r .= ") ";
*/        
        
        //$sDelim = '[ -()<>:!.,\"\']';
        $sDelim = '[[:punct:],[:space:],[()<>]';
        $r  = " (";
        $r .=   " ".$colName." LIKE '".$exp2Search."' ";
        $r .= "OR ".$colName." REGEXP '".$sDelim.$exp2Search.$sDelim."' ";
        $r .= "OR ".$colName." REGEXP '"."^".$exp2Search.$sDelim."' ";
        $r .= "OR ".$colName." REGEXP '".$sDelim.$exp2Search."^' ";
        $r .= ") ";
        
/*
        $sDelim = implode (",", $tdelim);
        $sDelim = "[".$sDelim."]";
        $sDelim = '[ -()]'
        $r  = " (";
        $r .=   " ".$colName." LIKE '".$exp2Search."' ";
        $r .= "OR ".$colName." REGEXP '".$exp2Search.$sDelim."%' ";
        $r .= "OR ".$colName." LIKE '%".$sDelim.$exp2Search."' ";
        $r .= "OR ".$colName." LIKE '%".$sDelim.$exp2Search.$sDelim."%' ";
        $r .= ") ";

*/        
/*
        $r  = " (";
        $r .=   " ".$colName." LIKE '".$exp2Search."' ";
        $r .= "OR ".$colName." LIKE '".$exp2Search." %' ";
        $r .= "OR ".$colName." LIKE '% ".$exp2Search."' ";
        $r .= "OR ".$colName." LIKE '% ".$exp2Search." %' ";
        $r .= ") ";
*/        
        break;

      case 0:
      default:
        $r = " ".$colName." LIKE '".$exp2Search."' ";
        break;
    }
  
  //jjd_echo ("sql search : ".$r);
  return $r;
       
 }



/******************************************************************
 * Ajout le mot cl‚ a la clause pass‚ en paramettre si il n'existe pas d‚j…
 ******************************************************************/
function addClause($keyWord, $sqlClause){
	global $xoopsModuleConfig, $xoopsDB;
	
  $sqlClause = ltrim ($sqlClause);
  $uKeyWord = strtoupper ($keyWord);
  if ($sqlClause  <> "" and strtoupper(substr($sqlClause, 0, strlen($keyWord)))  <> strtoupper($keyWord))  {
      $sqlClause    = $keyWord." ".$sqlClause;
  }

  return $sqlClause;
}

/*********************************************************************
test l'existance d'un id dans une liste d'id avec separateur
Renvoi vrai si il existe
**********************************************************************/
function isIdInList ($id, $sList, $sep = "/"){
  $tId = explode ($sep, $sList);
  $tFind = array_keys ($tId ,$id);
  //$b =  (count ( $tFind ) <> 0)?"oui":"non";
  //echo "isIdInList -> ".$id." - ".$sList." - "."count=".count ( $tId ).$sep.count ( $tFind )." - ".$b."<br>";
  return (count ( $tFind ) <> 0);

}

/************************************************************

function replaceSeparator($textSource, $sep = "/"){

  $text=  str_replace( ":", $sep, $textSource);
  $text=  str_replace( ",", $sep, $text);
  $text=  str_replace( ";", $sep, $text);
  $text=  str_replace( "|", $sep, $text);
  $text=  str_replace( "/", $sep, $text);
  //$text=  str_replace( "n\", "/", $text);
  
  return $text;
}
*************************************************************/


/************************************************************
 *
*************************************************************/
function replaceSeparator($textSource, $newSep = '/', $sep2replace = ':,;|/'){
  
  for ($h=0; $h < strlen($sep2replace); $h++){
    $textSource =  str_replace( substr($sep2replace, $h, 1), $newSep, $textSource);  
  }
  
  return $textSource;
}

/************************************************************
 *
*************************************************************/
function addQuoteInArray($tList){
  
  for ($h=0; $h < count($tList)-1; $h++){
    $tList [$h] = "'".trim($tList [$h])."'";  
  }
  
  return $tList;
}

/************************************************************
 *
*************************************************************/
function addQuoteInList($list, $sep = ","){
  
  $tList = explode ($list, $sep);
  $tList = addQuoteInArray ($tList);
  
  $list = implode ($tList, $sep);
  
  
  return $list;
}


/******************************************************************************
 *
 *****************************************************************************/
function addDelimitor ($expression, 
                       $color = "#FF0000", 
                       $delimiteurs = "[]",
                       $colorAll = false){


  $trans = get_html_translation_table(HTML_ENTITIES);
  $trans = array_flip($trans);
  $delimiteurs = strtr($delimiteurs, $trans);
  
                       
  if (substr ($color,0,1)<>"#") {$color = "#".$color;}
//$delimiteurs = "[]";  
  switch (strlen($delimiteurs)){
  case 0:
    $delimiteurOuvrant = "";
    $delimiteurFermant = "";
    break;
    
  case 1:
    $delimiteurOuvrant = $delimiteurs;
    $delimiteurFermant = $delimiteurs;
    break;
    
  default:
    $delimiteurOuvrant = substr($delimiteurs, 0, 1);
    $delimiteurFermant = substr($delimiteurs, 1, 1);
    break;
  }
  
  $fontDeb = "<font color='".$color."'>";
  $fontFin = "</font>";
  //------------------------------------------------------------------
  
  if ($colorAll){
    $ltrlib = $fontDeb.$delimiteurOuvrant.$expression.$delimiteurFermant.$fontFin ;  
  }else{
    $ltrlib = $fontDeb.$delimiteurOuvrant.$fontFin.$expression.$fontDeb.$delimiteurFermant.$fontFin ;  
  }
  
  

  return $ltrlib;
}


/***************************************************************************
JJD - 25/07/2006
construit une liste de selection a partir d'une liste de nom et de valeur
paramFtres: 
$name : valeur de l'attribut 'name'
$list : tableau de valeur affiche; dans la liste
$firstIndex: index affect&eacute; au premier &eacute;l&eacute;ment (normalement 0 ou 1). 
             les autres sont incr&eacute;ment&eacute; de 1
$defaut: item a selectionner par d&eacute;faut. se ref&egrave;re au num&eacute; de position 
         dans la liste en fonction du premier index.
         ex si $firstIndex=0 et que defaut = 2, l'item s&eacute;lection&eacute; est le 3eme 
$width = "50": largeur de la liste,. mais la il y a un probleme, car apprament
         on ne peut pas sp&eacute;cifier la largeur d'une liste. 
         elle prend la largeur de l'item le plus grand, a v&eacute;rifier a l'ocasion.
****************************************************************************/
function buildHtmlListFromTable ($name, 
                                 $table, 
                                 $colName, 
                                 $colId, 
                                 $colOrder, 
                                 & $defaut , 
                                 $onClick = "",
                                 $clauseWhere = '',
                                 $width = "150",
                                 $fCallBack = '',
                                 $addNone = false){
                                 
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	
 
	  $clauseWhere = addClause("WHERE",$clauseWhere);	
    $sql = "SELECT DISTINCT {$colId},{$colName} FROM ".$xoopsDB->prefix($table)
           ." {$clauseWhere} ORDER BY {$colOrder}";
    $sqlquery=$xoopsDB->query($sql);
//echo "<hr>buildHtmlListFromTable<br>{$sql}<hr>";
    //------------------------------------------------    
    $tselected = array();
    if ($onClick <> ""){$oc = "onchange='".$onClick."'" ;}else{$oc="";}
    $tselected [] = "<SELECT NAME='".$name."' ".$oc." width='".$width."'>";
    $id = 0;
    $firstId = 0;
        
    if ($addNone){
      $v = ($colName==$colId) ? '': 0;
      if ($defaut == $id ) {	$itemSelected = " selected";} else {$itemSelected = "";}      
      $tselected [] = "<OPTION VALUE='{$v}' {$itemSelected}> ";    
    }
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $id   = $sqlfetch[$colId];
      $name = $sqlfetch[$colName];
      if ($firstId == 0) $firstId = $id;
  //cho "<hr>buildHtmlListFromTable<br>defaut = {$defaut}<br>firstId = {$firstId}<hr>";      
      if ($fCallBack <> ''){
        $ok = $fCallBack($id);
      }else {$ok = 1;}
      //$ok = 1;
      //--------------------------------
      if ($ok == 1) {
          if ($defaut == $id ) {	$itemSelected = " selected";} else {$itemSelected = "";}      
          $tselected [] = "<OPTION VALUE='{$id}' {$itemSelected}>{$name}";    
          //$firstId = 0;  
      }
    }
  
  $tselected [] = "</SELECT>";

  $obList = implode ("", $tselected);
  //if ($firstId <> 0 ) $defaut = $firstId;  
  if ($defaut == 0 ) $defaut = $firstId;  
  
  //echo "<hr>buildHtmlListFromTable<br>defaut = {$defaut}<br>firstId = {$firstId}<hr>";
  //$defaut = $firstId;  
  
  return $obList;
}

/***************************************************************************
JJD - 25/07/2006
construit une liste de selection a partir d'une liste distinc de valeur
****************************************************************************/
function buildHtmlListFromTable2 ($name, 
                                 $table, 
                                 $colName, 
                                 & $defaut , 
                                 $onClick = "",
                                 $clauseWhere = '',
                                 $width = "150",
                                 $fCallBack = '',
                                 $addNone = false){
                                 
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	
 
	  $clauseWhere = addClause("WHERE",$clauseWhere);	
    $sql = "SELECT {$colId},{$colName} FROM ".$xoopsDB->prefix($table)
           ." {$clauseWhere} ORDER BY {$colOrder}";
    $sqlquery=$xoopsDB->query($sql);
//echo "<hr>buildHtmlListFromTable<br>{$sql}<hr>";
    //------------------------------------------------    
    $tselected = array();
    if ($onClick <> ""){$oc = "onchange='".$onClick."'" ;}else{$oc="";}
    $tselected [] = "<SELECT NAME='".$name."' ".$oc." width='".$width."'>";
    $id = 0;
    $firstId = 0;
        
    if ($addNone){
          if ($defaut == $id ) {	$itemSelected = " selected";} else {$itemSelected = "";}      
          $tselected [] = "<OPTION VALUE='0' {$itemSelected}> ";    
    }
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $id   = $sqlfetch[$colId];
      $name = $sqlfetch[$colName];
      if ($firstId == 0) $firstId = $id;
  //cho "<hr>buildHtmlListFromTable<br>defaut = {$defaut}<br>firstId = {$firstId}<hr>";      
      if ($fCallBack <> ''){
        $ok = $fCallBack($id);
      }else {$ok = 1;}
      //$ok = 1;
      //--------------------------------
      if ($ok == 1) {
          if ($defaut == $id ) {	$itemSelected = " selected";} else {$itemSelected = "";}      
          $tselected [] = "<OPTION VALUE='{$id}' {$itemSelected}>{$name}";    
          //$firstId = 0;  
      }
    }
  
  $tselected [] = "</SELECT>";

  $obList = implode ("", $tselected);
  //if ($firstId <> 0 ) $defaut = $firstId;  
  if ($defaut == 0 ) $defaut = $firstId;  
  
  //echo "<hr>buildHtmlListFromTable<br>defaut = {$defaut}<br>firstId = {$firstId}<hr>";
  //$defaut = $firstId;  
  
  return $obList;
}

/***************************************************************************
JJD - 25/07/2006
construit une liste de selection a partir d'une liste de nom et de valeur
paramFtres: 
$name : valeur de l'attribut 'name'
$list : tableau de valeur affiche; dans la liste
$firstIndex: index affect&eacute; au premier &eacute;l&eacute;ment (normalement 0 ou 1). 
             les autres sont incr&eacute;ment&eacute; de 1
$defaut: item a selectionner par d&eacute;faut. se ref&egrave;re au num&eacute; de position 
         dans la liste en fonction du premier index.
         ex si $firstIndex=0 et que defaut = 2, l'item s&eacute;lection&eacute; est le 3eme 
$width = "50": largeur de la liste,. mais la il y a un probleme, car apprament
         on ne peut pas sp&eacute;cifier la largeur d'une liste. 
         elle prend la largeur de l'item le plus grand, a v&eacute;rifier a l'ocasion.
/*

function buildHtmlListFromList  ($name, 
                                 $ListItem, 
                                 $FistInde
                                 $colName, 
                                 $colId, 
                                 $colOrder, 
                                 $defaut = 2, 
                                 $onClick = "",
                                 $width = "150"){
                                 
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	 
	  // $col = implode (",", array(,,,);	
    $sql = "SELECT ".$colId.",".$colName." FROM ".$xoopsDB->prefix($table)
           ." ORDER BY ".$colOrder;
    $sqlquery=$xoopsDB->query($sql);

    //------------------------------------------------    
    $tselected = array();
    if ($onClick <> ""){$oc = "onchange='".$onClick."'" ;}else{$oc="";}
    $tselected [] = "<SELECT NAME='".$name."' ".$oc." width='".$width."'>";
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $id   = $sqlfetch[$colId];
      $name = $sqlfetch[$colName];
      //--------------------------------
      if ($defaut == $id ) {	$itemSelected = " selected";} else {$itemSelected = "";}      
      $tselected [] = "<OPTION VALUE='".$id."'".$itemSelected.">".$name."";      
    }
  
  $tselected [] = "</SELECT>";
  
  $obList = implode ("", $tselected);
  return $obList;
}
*/

//--------------------------------------------------------------
function buildUrlJava($url, $addRoot = true){
  
  $link = "gotoURL2(\"".(($addRoot)?XOOPS_URL:"").$url."\");";
  //if ($addRoot){$link = XOOPS_URL.$link;}
  return $link;
  
}

function buildUrlJava2($url, $addRoot = true){
  
  $link = "javascript:window.navigate(\"".(($addRoot)?XOOPS_URL:"").$url."\");";
  
  //if ($addRoot){$link = XOOPS_URL.$link;}
  return $link;
  
}



/****************************************************************
 *echo fonction
 ****************************************************************/
 function displaySql ($sql, $title ='' , $lineBefore =false, $lineAfter = false){
 $bShow = true;
  
  if (!$bShow){return '';}
  
  if ($lineBefore){echo "<hr>";}
  if ($title <> ""){echo $title."<br>";}
  
//  echo $sql."<br>";
  
  if ($lineAfter){echo "<hr>";}
 }

/************************************************************
 *
*************************************************************/


function displayAll(){
  global $info, $modversion, $xoopsModuleConfig ,$xoopsUserGroups , 
         $xoopsConfig, $xoopsOption ,$xoopsModuleVersion;
  
  displayArray(get_defined_vars (), 'liste des variables');
 
  displayArray($GLOBALS,              'liste des variables ==> $GLOBALS');
  displayArray($_ENV,                 'liste des variables ==> $_ENV');  
  displayArray($HTTP_ENV_VARS,        'liste des variables ==> $HTTP_ENV_VARS');
  displayArray($argv,                 'liste des variables ==> $argv');  
  displayArray($_POST,                'liste des variables ==> $_POST');
  displayArray($HTTP_POST_VARS,       'liste des variables ==> $HTTP_POST_VARS');  
  displayArray($_GET,                 'liste des variables ==> $_GET');
  displayArray($HTTP_GET_VARS,        'liste des variables ==> $HTTP_GET_VARS');  
  displayArray($_COOKIE,              'liste des variables ==> $_COOKIE');
  displayArray($HTTP_COOKIE_VARS,     'liste des variables ==>$HTTP_COOKIE_VARS ');  
  displayArray($_SERVER,              'liste des variables ==>$_SERVER ');
  displayArray($HTTP_SERVER_VARS,     'liste des variables ==>$HTTP_SERVER_VARS ');  
  displayArray($_FILES,               'liste des variables ==> $_FILES');
  displayArray($HTTP_POST_FILES,      'liste des variables ==> $HTTP_POST_FILES');  
  displayArray($_REQUEST,             'liste des variables ==> $_REQUEST');
  displayArray($xoopsConfig,          'liste des variables ==> $xoopsConfig');  
  displayArray($xoopsOption,          'liste des variables ==> $xoopsOption');
  displayArray($HTTP_SESSION_VARS,    'liste des variables ==> $HTTP_SESSION_VARS');  
  displayArray($_SESSION,             'liste des variables ==> $_SESSION');
  displayArray($xoopsUserGroups,      'liste des variables ==> $xoopsUserGroups');  
  displayArray($XOOPS_TOKEN_SESSION,  'liste des variables ==> $XOOPS_TOKEN_SESSION');
  displayArray($xoopsModuleConfig,    'liste des variables ==>$xoopsModuleConfig ');  
  displayArray($modversion,           'liste des variables ==>$modversion ');
  displayArray($info,                 'liste des variables ==> $info');  
}






/********************************************************************
 *
*********************************************************************/
function htmlAddAttribut($attribut, $value, $default = ''){

  if ($value == ''){$value = $default;}
  
  if ($value <> ""){
    if (substr($value,0,strlen($attribut)) <> $attribut){
      $r ="{$attribut}=\"{$value}\""; 
    }
  }else{
    $r = '';
  }
  
  return $r;

}


/********************************************************************
 *
*********************************************************************/
function htmlStyle($attributs){
  
  $key = array_keys ($attributs);
  $t = array ();
  
  for ($h = 0; $h < count($key); $h++){
    $a = '';
    $t[] = "{$key[h]}: {$attributs[$key[h]]};" ;
  }
  
  return 'style="'.implode(' ', $t).'"';


}

/********************************************************************
 *
*********************************************************************/
function versionJS(){
  
  $t = array();
  
  $t[] = "<script language='JavaScript'>var _version = 1.0;</script>";
  $t[] = "<script language='JavaScript1.1'>var _version = 1.1;</script>";
  $t[] = "<script language='JavaScript1.2'>var _version = 1.2;</script>";
  $t[] = "<script language='JavaScript1.3'>var _version = 1.3;</script>";
  $t[] = "<script language='JavaScript1.4'>var _version = 1.4;</script>";
  $t[] = "<script language='JavaScript1.5'>var _version = 1.5;</script>";
      
        
  $t[] = "<script language='JavaScript'>";
  $t[] = "document.write('<hr><h1>Version JavaScript: ' + _version);";  
  $t[] = "</script>";

  return _br.implode(_br,$t)._br;
}

/********************************************************************
 *rvoi la liste des delimiteur ou l'item
 *$index <0 renvoi la liste composer avec le 2eme parametre
 *$index >=0 renvoi l'item du tableau  
*********************************************************************/
function getDelimitor($index, $exemple = ''){
  $r = $exemple;
  $list = array ( $r ,"({$r})","[{$r}]","{{$r}}","|{$r}|","<{$r}>");
  
  if ($index < 0){
    return $list;
  }else{
    return $list [$index]; 
  }
}

/************************************************************
 *
*************************************************************/
function getNewId ($idParent, $table, $colIdParent, $colIdChild) {
Global $xoopsDB;
	
  $sql = "SELECT max({$colIdChild}) as lastId FROM ".$xoopsDB->prefix($table)." "
        ."WHERE {$colIdParent} = {$idParent}" ;	
  
	$result = $xoopsDB->query($sql);
	list ($newId) = $xoopsDB->fetchRow($result) ;
  $newId ++;
  
  return $newId;
  
}


/***********************************************************************
 * construit une ligne avec un spinButton
 ***********************************************************************/
function buildDescription($description, $colSpan = 2, 
                          $hrBefore = false, $hrAfter=false){

    if ($description <> ''){
      //$style= "<hr style="height: 2px; color: #839D2D; background-color: #839D2D; width: 50%; border: none;">";    
      //$hr = "<hr style='height: 1px; color: #839D2D; background-color: #839D2D; border: none;'>";
      $hr = buildHR(1, '839D2D');
      
      $hrb = (($hrBefore) ? $hr:'');
      $hra = (($hrAfter)  ? $hr:'');      
      $r = "<TR>"    
          ."<td colspan='{$colSpan}'>{$hrb}<i><font size='2' color='#808080'>"
          ."{$description}</font></i>{$hra}</TD>"    
          ."</TR>";    
    
    }else{
      $r = '';
    }    
  //-----------------------------
  
  return $r;
}
/***********************************************************************
 * construit une ligne de separation
 
 ***********************************************************************/
function buildHR($size = 1, $color = '839D2D', $colSpan = 0){
          //."<td colspan='{$colSpan}'>{$hrb}<i><font size='2' color='#808080'>"  
      $hr = "<hr style='height: {$size}px; color: #{$color}; background-color: #{$color}; border: none;'>";
      if ($colSpan > 0 ){
        $r = "<tr><td colspan='{$colSpan}'>{$hr}</td></tr>";
      }else{
        $r = $hr;
      }
  //-----------------------------
  
  return $r;
}



/***************************************************************************
 *
 ***************************************************************************/
function buildActionMenu ($lButton = 255){
//function getButtonBar($lButton = 255, $idTerme = 0, $idLexique = 0){

  $link = "doAction(\"menuAction\");";
  $t = array();
  //------------------------------------------------
  //titre du menu
  $t[] = array ('value' => _MD_LEX_ACTION_MENU,   'id' => 0);  
  //------------------------------------------------  
  if (($lButton &  _LEXBTN_SEARCH) <> 0 ){
    $t[] = array ('value' => _SEARCH,   'id' => 1);
  }  
  //------------------------------------------------  
  if (($lButton &  _LEXBTN_ASKDEF) <> 0 ){
    $t[] = array ('value' => _MD_LEX_ASK_DEF,   'id' => 2);  
  }
  //------------------------------------------------
  if (($lButton &  _LEXBTN_NEW) <> 0 ){
    $t[] = array ('value' => _ADD,   'id' => 3);  
  }
  //------------------------------------------------                


                
  $menuList =  buildHtmlAList ('menuAction', $t, $link);
  return $menuList;
  
  


}



/****************************************************************************
 *
 ****************************************************************************/
/*

function getFolderList($rootFolder, $extention = ""){

Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info,$libelle;
//$folder = _LEXCST_DIR_MODULEROOT."language/{$xoopsConfig['language']}/doc/";	
  
  $t = array();
  if (is_dir($rootFolder)) {
      if ($dh = opendir($rootFolder)) {
          while (($file = readdir($dh)) !== false) {
              if ($file = '.' OR $file = '..') continue;
              $f = $rootFolder.'/'.$file;
              if is_dir($f) $t[] = $f;
              //echo "fichier : $file : type: " . filetype($dir . $file) . "\n";
          }
          closedir($dh);
      }
  }


//  displayArray($t,"**********liste des plugin****************") ;  
  return $t ; 
}
*/


/****************************************************************************
 *
 ****************************************************************************/
function editDoc($doc){
Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;

    $f = _LEXCST_DIR_MODULEROOT."language/{$xoopsConfig['language']}/doc/{$doc}-{$xoopsConfig['language']}.html";	
    //if (!is_readable($f)){return;}
    if (!file_exists($f)){
      redirect_header("index.php",1,_AD_LEX_ADDOK);
      return;
    }    

    //------------------------------------------------  
    $ligneDeSeparation = buildHR(1, _JJD_HR_COLOR1, 2);

	  //xoops_cp_header();
    OpenTable();    
    //------------------------------------------------    
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_DOCUMENTATION."</B><br>";
    
 		echo "<FORM ACTION='index.php' METHOD=POST>"._br;
    readfile ($f);

    CloseTable(); 

	
  echo "<br>";
  OpenTable();

$linkCancel = buildUrlJava ("index.php",  false);  
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CANCEL."' onclick='".$linkCancel."'></td>
    <td align='left' width='10'></td>


    <td align='right'>
    <input type='submit' name='submit' value='"._AD_LEX_VALIDER."' )'>    
    </td>    
  </tr>
  </table>";

  CloseTable();
  
echo  "</form>";    
	CloseTable();
	xoops_cp_footer();



}


/****************************************************************************
 *
 ****************************************************************************/

function BuildLink($table, $colId, $colLibelle, 
                   $link, $orderBy = '', $sep = _LEX_SEP_LINK2, $id = 0,
                   $titleName = '', $titleLink = '', $titleSep = _LEX_SEP_LINK1 ){

Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info,$libelle;
   
  $sql = "SELECT * FROM ".$xoopsDB->prefix($table)
       ." WHERE {$colId} > 0 "  
       .(($id == 0)?'':" AND {$colId} = {$id} ")
       ." ORDER BY ".(($orderBy == '')?$colLibelle:$orderBy);
   //echo $sql."<br>"; 
   	
   $sqlquery = $xoopsDB->query($sql);
	 $t = array();
   
    
         
   while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
     //$link = "admin_lexique.php?op=edit&idLexique=".$idLexique;
     //$link = "admin_lexique.php?op=edit&idLexique=%0%";  
     $url = str_replace("%0%", $sqlfetch[$colId], $link);
     $lib = $sqlfetch[$colLibelle];
     //$newLink = "<TD align='left'><A href='{$url}'>{$lib}</A></TD>";
     $newLink = "<A href='{$url}'>{$lib}</A>";  
       
     //	echo $newLink."<br>";
      $t[] =  $newLink; 
        
   }


    //jjd_echo ("-<".$tcat[$h]."-".$$n.">-", _LEXJJD_DEBUG_VAR);
    
    $r = $sep.implode ($sep, $t).$sep; 
/*
    a revoir et peut être virer les parametres en trop
    if ($titleName <> ''){
      $r = "<p>-&nbsp;<A HREF='{$titleLink}'>{$titleName}</A>{$titleSep}{$r}</p>";
    }
*/
    return $r ; 
}



/**********************************************************************
 *renvoi un tableau avec comme cl‚ le nom du groupe et comme valeur son identifiant
 **********************************************************************/
function arrayCombine ($key, $value){
  
  $t = array();
  
  for ($h = 0; $h < count($key); $h++){
    if ($h > count($value)){
        $t[$key[$h]] = '';    
    }else{
        $t[$key[$h]] = $value[$h];    
    }

  }
  
  return $t;
}


/**********************************************************************
 * equivalentde chiose premier index = 0renvoi un tableau avec comme cl‚ le nom du groupe et comme valeur son identifiant
 **********************************************************************/
function choose ($index, $list, $default = ''){
  
  if ($index >= 0 AND $index < count($list)){
    return $list[$index];  
  }else{
    return $default;  
  }

}

/**********************************************************************
 * 
 **********************************************************************/
function formatDate ($sDAte, $format){
  
  $tm = strtotime ($sDAte);
  return date($tm);

}



/***************************************************************************
 *
*************************************************************/
function getConstanteValide ($name) {
Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info, $libelle;

  $lib = substr($name, 4); 
  $prefixe = array ( "_MI_", "_MD_", "_AD_"); 
  $newLib  = '';
     
      for ($i = 0; $i < count($prefixe); $i++){
        $v = $prefixe[$i].$lib;        
        if (defined($v)) {
             $newLib = constant($v);
             break;
        }        
      
    }
      
   return $newLib ; 
}



//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

/****************************************************************************
 * Fonction SQL - formatage, conversion, ...
 ***************************************************************************/
/****************************************************************
 *
 ****************************************************************/
function fetch2array($sqlquery, $tUrlParams = '', $sepLib = " - ", $sepParam = ";"){
//function fetch2array($sqlquery, $url = '', $colLibelle, $pName1 = '', $colParam1 = ''){
//exemple:
// $t = fetch2array($sqlquery, array('key'=>'link','key'=>'url','pName1'=>,'pColName1'=>'', 'pColLib1'=>'')
//key-url-colLib-colParam


	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;  
	
  $t=array();
  
  if (is_array($tUrlParams)){
    $sepParam1 = (stristr($tUrlParams['url'], "?") === false) ? "?": "&";
    if (($sepParam1) == substr($url,-1)) $sepParam1 = '';


     while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
        $tColName = explode($sepParam, $tUrlParams['colParam']);
        $tParam = array();  
        for ($h = 0; $h < count($tColName); $h++) {
          $val = $sqlfetch[$tColName [$h]];    
          $tParam [] = "{$tColName[$h]}={$val}";              
        }
             
        $tColLib = explode($sepParam, $tUrlParams['colLib']);
        $tLib = array();  
        for ($h = 0; $h < count($tColLib); $h++) {
          $tLib [] = $sqlfetch[$tColLib [$h]];    
        }
             
             
             
             
                     
        $params = implode("&", $tParam);
        $lib    = implode($sepLib, $tLib); 
        if ($tUrlParams['img'] <> ''){
          $img = "<img src='{$tUrlParams['img']}' border=0 Alt='{$tUrlParams['alt']}' width='20' height='20' ALIGN='absmiddle'>";        
        }else{$img='';}
       
        $link = "<A href='{$tUrlParams['url']}{$sepParam1}{$params}'>{$img}{$lib}</A>";        
 
 /*
       
        if (isSet($tUrlParams['pName1'])){
          $val = $sqlfetch[$tUrlParams  ['pName1']];

          $param = "{$sepParam1}{$tUrlParams['pName1']}={$val}";
          $link = "<A href='{$tUrlParams['url']}{$param}'>{$lib}</A>";
          
        }
 */        
 
          $key = (isset($tUrlParams['key'])) ? $tUrlParams['key'] : 'link';
          $sqlfetch[$key] = $link;        

        $t [] = $sqlfetch;
      }
  
  }else{
     while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
        $t [] = $sqlfetch;
      }
  
  }
  
  //displayArray($t, "----- fetch2array -----");
  return $t;

}


/****************************************************************
 *
 ****************************************************************/
function addLink2Array(&$t, $key, $url, $colParam, $colLib, $imgSouce = '', $alt ='',
                       $sepLib = " - ", $sepParam = ";"){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;

  
	
    $sepParam1 = (stristr($url, "?") === false) ? "?": "&";
    if (($sepParam1) == substr($url,-1)) $sepParam1 = '';

    for ($j=0; $j < count($t); $j++){
        $tColName = explode($sepParam, $colParam);
        $tParam = array();  
        for ($h = 0; $h < count($tColName); $h++) {
          $val = $t[$j][$tColName [$h]];    
          $tParam [] = "{$tColName[$h]}={$val}";              
        }
        //---------------------------------------------------
        $tColLib = explode($sepParam, $colLib);
        $tLib = array();  
        for ($h = 0; $h < count($tColLib); $h++) {
          $tLib [] = $t[$j][$tColLib [$h]];
        }
        
        $params = implode("&", $tParam);
        $lib    = implode($sepLib, $tLib);
        $lib='';  
        if ($imgSouce <> ''){
          $img = "<img src='{$imgSouce}' border=0 Alt='{$alt}' width='20' height='20' ALIGN='absmiddle'>";        
        }else{$img='';}
                
        $link = "<A href='{$url}{$sepParam1}{$params}'>{$img}{$lib}</A>";        
        //echo "===>{$link}<br>";
        //$key = (isset($key)) ? $key : 'link';
        $t[$j][$key] = $link;        
    
    }
    
    

  //-----------------------------------------------------  
  //displayArray($t, "----- addLink2Array -----");
  return count($t);

}

//----------------------------------------------------------------------

/****************************************************************
 *function pour SQL
 ****************************************************************/
function string2sql($line, $addQuote = false){

  //$line = str_replace("\'", "''", $line);  
  $line = str_replace("\'", "\*", $line);  
  $line = str_replace("'", "''", $line);  
  $line = str_replace("\*", "''", $line);  
  //$line = str_replace("'", "''", $line);
  
  if ($addQuote){
    return "'".$line."'";  
  }else{
    return $line;  
  }
}  
/****************************************************************
 *function pour SQL
 ****************************************************************/

function sql2string($line){

  //$line = str_replace("'", "\'", $line);  
  //$line = str_replace("'", "''", $line);
    return $line;  
  
  }
  
/****************************************************************
 *function pour SQL
 ****************************************************************/

function sqlQuoteString($exp, $addDelimiteurs = true, $addComma = false){
Global $xoopsDB;

  $exp = str_replace ("'", "''", $exp);
  if ($addDelimiteurs) $exp = "'".$exp."'";
  if ($addComma)       $exp = $exp.",";
  /*
  if ($addDelimiteurs) {
    //$exp = "'".$xoopsDB->quoteString($exp)."'" ; 
    $exp = $xoopsDB->quoteString($exp);    
  }else{
    $exp = $xoopsDB->quoteString($exp);  
  }
  */
  
  return $exp;

}




////////////////////////////////////////////////////////////////////////
//gestoin des groupes et des utilisateurs
////////////////////////////////////////////////////////////////////////


/****************************************************************************
 * retourne une entier qui represente les autorisation d'acces de lutilisateur
 * pour tous les groupes auquel uil appartient 
 ****************************************************************************/
 function isByteOk($byte, $binValue){
  
  $b = (($binValue & ( pow(2, $byte))) == 0)?0:1;
  return $b;
	//global $xoopsModuleConfig, $xoopsDB;
}

/****************************************************************************
 *
 ****************************************************************************/
function getListGroupesID($moduleName){
global $xoopsModule;
//global XoopsModule;
include_once (XOOPS_ROOT_PATH."/class/xoopsmodule.php");

//$module_handler =& xoops_gethandler('module');
//$module =& $module_handler->getByDirname($modversion['dirname']);
	  $module = XoopsModule::getByDirname($moduleName);
	  //$module = XoopsModule::getByDirname($xoopsModule->getVar('dirname'));	$moduleName  
	  //$module =$xoopsModule->getVar('dirname');	  
    $groups = array();
    if ($module) {
        global $xoopsUser;
        if (is_object($xoopsUser)) {
            $groups = $xoopsUser->getGroups();
        } else {
            $groups = array(XOOPS_GROUP_ANONYMOUS);
            //echo "group = {$groups}<br>";
        }
        /*
        $gperm_handler =& xoops_gethandler('groupperm');
        if ($gperm_handler->checkRight("news_submit", 0, $groups, $module->getVar('mid'))) {
              $cansubmit = 1;
        }
        
        */
    }
    
    //displayArray2($groups ,'********groupes*****************') ;
    return implode($groups, ',');   
}


/**********************************************************************
 *selon $mode renvoi un tableau avec 
 * 0  :  clé => k-idGroupe        valeur => Array(name,id,value)
 * 1 :  clé => le nom du groupe  valeur => identifiant 
 * 2 : clé = nom valeur = id 
 * 3 : idem 2 mais tout en minuscule
 * 4 : idem 2 mais tout en majuscule  
 **********************************************************************/
function getListGroupes($mode = 0){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;	
	
    $sql = "SELECT * FROM ".$xoopsDB->prefix("groups")." ORDER BY groupid";
    $sqlquery=$xoopsDB->query($sql);

    //------------------------------------------------        
    $t = array();
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      //$t[$sqlfetch['name']] = $sqlfetch['groupid'];
      
      switch ($mode){
      case 1:
        $t[] = array ('name' =>  $sqlfetch['name'], 
                      'id' => $sqlfetch['groupid']);      
        break;      

      case 2:
        $t[$sqlfetch['name']] = $sqlfetch['groupid'];      
        break;

      case 3:
        $t[strtolower($sqlfetch['name'])] = $sqlfetch['groupid'];      
        break;
        
      case 4:
        $t[strtoupper($sqlfetch['name'])] = $sqlfetch['groupid'];      
        break;
        
      default:
        $t["k-{$sqlfetch['groupid']}"] = array ('name'  =>  $sqlfetch['name'], 
                                                'id'    => $sqlfetch['groupid'], 
                                                'value' => 0);     
      
      }

/*
      
        if ($mode == 0){
          $t["k-{$sqlfetch['groupid']}"] = array ('name'  =>  $sqlfetch['name'], 
                                                  'id'    => $sqlfetch['groupid'], 
                                                  'value' => 0);     
      
      }else{
        $t[] = array ('name' =>  $sqlfetch['name'], 
                      'id' => $sqlfetch['groupid']);      
      }
*/                    
 
    }  
    
    return $t;
}

/**********************************************************************
 **********************************************************************/
function getGroupeID($Groupe){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;	
	
    $sql = "SELECT * FROM ".$xoopsDB->prefix("groups")
          ." WHERE name = '{$Groupe}'";
    $sqlquery = $xoopsDB->query($sql);

    //------------------------------------------------
            
    $t = $xoopsDB->fetchArray($sqlquery);
    return $t['groupid'];
}

/**********************************************************************
 *renvoi un tableau avec comme cl‚ le nom du groupe et comme valeur son identifiant
 **********************************************************************/
function isAdmin(){
  global $xoopsUser;
  
  $ok = false;
  
  if ( $xoopsUser ) {
	   $xoopsModule = XoopsModule::getByDirname(_LEXCST_DIR_NAME);
	   if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
		    $ok = true;
      exit();
	   }
  } 
  return $ok;
}




/**********************************************************************
 * 
 **********************************************************************/
function createNewGroup ($name, $description, $group_type = 'Anonymous'){
	global $xoopsModuleConfig, $xoopsDB,$xoopsGroup;
	
/*
  $sql = "INSERT INTO ".$xoopsDB->prefix(_HERCST_TBL_LETTRE)
       ."(name,description,group_type)"
       .VALUES ('{}','{description}','{$group_type}');
       
       
 
      $xoopsDB->query($sql);
      $groupid = $xoopsDB->getInsertId() ;


*/
	

include_once(XOOPS_ROOT_PATH."/include/functions.php")  ;
  //$xg = new XoopsGroupHandler('rr');
    
    
    $xg = xoops_gethandler('group');  
    $g = $xg->create(true);
    $g->name        = $name;
    $g->description = $description;
    $g->group_type  = $group_type;
    
    $groupid = $xg->insert($g);
    //$groupid = $g->groupid;

    return $groupid;
    

    


    

}
/***************************************************************************
 
 ***************************************************************************/
/*
 
 function grp_getAccess_old($id, colId, table, moduleName){
	global $xoopsModuleConfig, $xoopsDB;
	
    $groupe = getListGroupesID(_TBA_DIR_NAME);
    $sql = "SELECT {$test} isDefine, buttonAccess, readAccessList, readPropertyList FROM "
          .$xoopsDB->prefix(_LEX_TBL_ACCESS)
          ." WHERE idLexique = {$idLexique}"
          ."   AND idGroup in ({$groupe})";
    $sqlquery = $xoopsDB->queryF($sql);  

    $readAccessList    = 0;
    $readPropertyList  = 0;
    $buttonAccess  = 0;
    $isDefine      = 0;
               
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $isDefine     = $isDefine     | $sqlfetch ['isDefine'];
      $buttonAccess = $buttonAccess | $sqlfetch ['buttonAccess'];      
      $readAccessList   = $readAccessList   | $sqlfetch ['readAccessList'];
      $readPropertyList = $readPropertyList | $sqlfetch ['readPropertyList'];   
//      echo "read lexique: {$idLexique} - groupes: ({$groupe})=> {$isDefine} : {$buttonAccess} : {$readAccessList} : {$readPropertyList}<br>";       
    }
    
    //si aucune autorisation on donne toutes les autorisation 
    //foncionnement par defaut adopt‚ car sera souvent le cas
    //ou aucune autorisation ne sera defini
    if ($isDefine == 0) {
      $buttonAccess = _LEX_BYTE_DEFAULT_BUTTON;    
      $readAccessList   = _LEX_BYTE_DEFAULT_READLIST;
      $readPropertyList = _LEX_BYTE_DEFAULT_PROPERTYLIST;    
      $isDefine = 1 ;
    }
      
 }
*/ 
 
/***************************************************************************
 
 ***************************************************************************/

 function grp_getAccess($moduleName, $table , $id, $colId, $colAccess,$colIdGroup = 'idGroup'){
	global $xoopsModuleConfig, $xoopsDB;
	
    $groupe = getListGroupesID($moduleName);
    $sql = "SELECT $colAccess FROM ".$table
          ." WHERE $colId = {$id}"
          ."   AND {$colIdGroup} in ({$groupe})";
    $sqlquery = $xoopsDB->queryF($sql);  

    $binAccess = 0;
               
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $binAccess = $binAccess | $sqlfetch [$colAccess];      
    }
    
    return $binAccess;     
 }
 
 
/***************************************************************************
 
 ***************************************************************************/

function findItemInList($name, $list, $sep = ";"){
	
	if (!is_array($list)){
  	$list = explode($sep, $list);
  }
	
	$tk= array_flip($list);
	if (isset($tk[$name])){
    $r = $tk[$name];
  }else{
    $r = -1;  
  }
	
	
  return $r;     

}
 
/***************************************************************************
 
 ***************************************************************************/
function findConstante($name, $ModulePrefix){
   
    $filePrefixe = array ('MI','MD','AD','MB');
    //echo "<hr>" ;
         
    for ($i = 0; $i < count($filePrefixe); $i++){
      $v = "_{$filePrefixe[$i]}_{$ModulePrefix}_{$name}" ;    
      //echo "{$v}<br>" ;   
      if (defined($v)) {
           $r = constant($v);
          //echo "{$r}<br>" ;           
           return $r ;
      }        
    }
    
    return $name;
}
 

/****************************************************************************
 * transforme une liste de checkbox en valeur numerique binaire
 ****************************************************************************/
function checkBoxToBin($p, $name, &$list, $value = 'on'){
  //-----------------------------------------------------------
  //calcul de la valeur binaire de l'état des boutons
  $list = htmlArrayOnPrefix($p, array($name), '_');
  //displayArray2($list, "******{$name}*********************");
  $b = 0; //initialisation de da valeur binaire
  if (is_array($list)){
    for ($h = 0; $h < count($list); $h++){
      if (isset($list[$h][$name])){
        if ($list[$h][$name] ==  $value) $b += pow(2,$h);
      
      }
    }
  
  }
  //-----------------------------------------------------------  
  return $b;

}

/****************************************************************************
 * 
 ****************************************************************************/
function buildStrGraphique($exp, $img){
/*

  //-----------------------------------------------------------
//<iframe   style="border:0; width:135px; height:32px; background: url('file:///D:/notation/band/fire-vert=27x32.gif') no-repeat -189px 0px ; " >
  $t = explode("=", $img);
  $t = explode(".", $t[1]);  
  $size = explode("x", $t[0]);
  $nbImgMax = 10; //nombre d'image par image 
  
  $lw = $size[0] * $total;
  $ll = ($nbImgMax - $note) * - $size[0];
  $f = _JJD_NOTATION_S_URL.$img;
  echo "<hr>{$note} | {$total} | {$img}<br>ll:{$ll} | lw:{$lw} | mw1:{$size[1]}<hr>";  
  //-----------------------------------------------------
 
  $link = "<iframe   style=\"border:0;"
        ."width:{$lw}px; "
        ."height:{$size[1]}px; "
        ."background: url('{$f}') no-repeat {$ll}px 0px ;\" >"
        ."</iframe>";
  
  //-----------------------------------------------------------  
  return $link;
  
  
  $r = '';
  $t= array();


    $mask = XOOPS_URL.$lexInfo['noteImg'];
    $tImg = array();
$req = $_SERVER['QUERY_STRING'];
    for ($h = $lexInfo['noteMin']; $h <= $lexInfo['noteMax']; $h++){
        $img = str_replace("?", $h, $mask);
        $tImg[] = "<A HREF='admin/lex_action.php?op=addNote2lexique&idLexique={$lexInfo['idLexique']}&note={$h}&{$req}'>"
                 ."<img src='{$img}' border=0 Alt='"
                 .$h."' ALIGN='absmiddle'></A>" ; 
    }
    $a = round($lexInfo['noteAverage'],1);
    $r = " - "._MD_LEX_NOTE_NUMBER. ": {$lexInfo['noteCount']} - "._MD_LEX_NOTE_AVERAGE.": {$a} / {$lexInfo['noteMax']} ";
    $r = ' '._MD_LEX_NOTE_THIS_LEXIQUE.' '.implode('', $tImg).$r;        
  }
*/  
}


/*********************************************************************
 *
 *********************************************************************/
 function getTblStyle(){
    return " style='marge:0;' cellspadding=\'0\' cellspacing=\'0\' "; 
 }

/*********************************************************************
 *
 *********************************************************************/
 function getRowStyle(&$row, $align = '', $borderWidth = '0px', $base = 2){
    if (isset($row)) {
      $row = ($row + 1) % $base;    
    }else{
      $row = 0;    
    } 
    
    //$b = '';// bgcolor=\'#'.constant('_HER_TR_bgColor_'.$row).'\' ' ;   
    
    $bgc = constant('_JJD_TR_bgColor_'.$row) ;   
    $t = array();
    $t[] = "text-align: {$align}";
    $t[] = "background-color: #{$bgc}";  
    //$t[] = "color: #0000FF";
    //$t[] = "color: #{$bgc}";    
    $t[] = "border-style: solid";  
    $t[] = "border-width: {$borderWidth}";
    
    $style = " style='".implode (';', $t).";'";  
    return $style;
   
}


 
?>
