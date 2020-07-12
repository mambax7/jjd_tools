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
/******************************************************************************
 
******************************************************************************/
function buildCheckedListHA ($list, 
                           $title = '',
                           $prefixe = "chk", 
                           $firstIndex = 0, 
                           $cols = 2, 
                           $keyLib = 'name',
                           $keyVal = 'val',
                           $keyId = 'id',
                           $keyOnclick = 'onclick'){
  
	$tselected = array ();
  if ($title <> ""){$tselected []= $title."<br>";} 
  
  $tselected []= addBaliseBV ("TABLE", "", 1, 0, true);
  $i = 0; //pour compter les colonnes
//    displayArray($tList,'getCheckedH----------------------');

  while ($item = current($list)) {
      //  echo "{$item['id']} : {$item['name']} - {$item['value']}";      
      //-------------------------------------------------
      if ($keyId ==''){
        $v = $h;
      }else{
        $v = $item[$keyId];      
      } 
      //-------------------------------------------------
      
        if ($item[$keyVal] == 1){$value = 'checked';} else {$value = 'unchecked';}
        
        if (isset($item[$keyOnclick])) {
            $oc = " onclick='{$item[$keyOnclick]}' ";
        } else {
            $oc = '';        
        }
        
        $line =  "<input type='checkbox' name='{$prefixe}[{$v}][value]' {$oc} {$value}>&nbsp;{$item[$keyLib]}";
        $line .= "<INPUT TYPE=\"hidden\" name='{$prefixe}[{$v}][id]'  size='1%'"." VALUE='".$v."'>";
        //------------------------------------------------------------
        if ($cols > 1){
          addBalise ("TD", $line, 1, 1, true);
          if ($i == 0) { 
              addBalise ("TR", $line, 1, 0, true);
              $j=1;
          }
          $i++;
          if ($i >= $cols) { 
            $i = 0;
            $j = 0;
            addBalise ("TR", $line, 0, 1, true);
          }
        }
        else {
        
            addBalise ("TD", $line, 1, 1, true);
            addBalise ("TR", $line, 1, 1, true);            
        }

        $tselected []= $line;
        //$tselected []= "<tr><td>".$line."</td></tr>";
      next ($list);
    }
  
 
  
  //displayArray($tselected,'Liste de case a cocher');
  $line = "";
  if ($i > 0) {$tselected [] = addBaliseBV ("TR", "", 0, 1);}
  $tselected [] = addBaliseBV ("TABLE", "", 0, 1);
   //------------------------------------------------------------  	 
  $obHtml = implode (_br, $tselected);
  //$obHtml = balise2Str($obHtml);
  return $obHtml;
 

}



/******************************************************************************
 
******************************************************************************/
function buildCheckedListH ($list, 
                           $title = '',
                           $prefixe = "chk", 
                           $firstIndex = 0, 
                           $cols = 2, 
                           $keyLib = 'name',
                           $keyVal = 'val',
                           $keyId = 'id',
                           $keyOnclick = 'onclick'){
  
	$tselected = array ();
  if ($title <> ""){$tselected []= $title."<br>";} 
  
  $tselected []= addBaliseBV ("TABLE", "", 1, 0, true);
  $i = 0; //pour compter les colonnes
//    displayArray($tList,'getCheckedH----------------------');

  while ($item = current($list)) {
      //  echo "{$item['id']} : {$item['name']} - {$item['value']}";      
      //-------------------------------------------------
      if ($keyId ==''){
        $v = $h;
      }else{
        $v = $item[$keyId];      
      } 
      //-------------------------------------------------
      
        if ($item[$keyVal] == 1){$value = 'checked';} else {$value = 'unchecked';}
        
        if (isset($item[$keyOnclick])) {
            $oc = " onclick='{$item[$keyOnclick]}' ";
        } else {
            $oc = '';        
        }
        
        $line =  "<input type='checkbox' name='{$prefixe}_{$v}'{$oc} {$value}>&nbsp;{$item[$keyLib]}";
        //------------------------------------------------------------
        if ($cols > 1){
          addBalise ("TD", $line, 1, 1, true);
          if ($i == 0) { 
              addBalise ("TR", $line, 1, 0, true);
              $j=1;
          }
          $i++;
          if ($i >= $cols) { 
            $i = 0;
            $j = 0;
            addBalise ("TR", $line, 0, 1, true);
          }
        }
        else {
        
            addBalise ("TD", $line, 1, 1, true);
            addBalise ("TR", $line, 1, 1, true);            
        }

        $tselected []= $line;
        //$tselected []= "<tr><td>".$line."</td></tr>";
      next ($list);
    }
  
 
  
  //displayArray($tselected,'Liste de case a cocher');
  $line = "";
  if ($i > 0) {$tselected [] = addBaliseBV ("TR", "", 0, 1);}
  $tselected [] = addBaliseBV ("TABLE", "", 0, 1);
   //------------------------------------------------------------  	 
  $obHtml = implode (_br, $tselected);
  //$obHtml = balise2Str($obHtml);
  return $obHtml;
 

}




function buildCheckedListH2 ($list, 
                           $title = '',
                           $prefixe = "chk", 
                           $firstIndex = 0, 
                           $cols = 2, 
                           $keyLib = 'name',
                           $keyVal = 'val',
                           $keyId = 'id',
                           $keyOnclick = 'onclick'){
  
	$tselected = array ();
  if ($title <> ""){$tselected []= $title."<br>";} 
  
  $tselected []= addBaliseBV ("TABLE", "", 1, 0, true);
  $i = 0; //pour compter les colonnes
//    displayArray($tList,'getCheckedH----------------------');
  
  for ($h = 0; $h < count($list); $h++){
      $item = $list[$h];
        echo "{$item['id']} : {$item['name']} - {$item['value']}";      
      //-------------------------------------------------
      if ($keyId ==''){
        $v = $h;
      }else{
        $v = $item[$keyId];      
      } 
      //-------------------------------------------------
      
        if ($item[$keyVal] == 1){$value = 'checked';} else {$value = 'unchecked';}
        
        if (isset($item[$keyOnclick])) {
            $oc = " onclick='{$item[$keyOnclick]}' ";
        } else {
            $oc = '';        
        }
        
        $line =  "<input type='checkbox' name='{$prefixe}_{$v}'{$oc} {$value}>&nbsp;{$item[$keyLib]}";
        //------------------------------------------------------------
        if ($cols > 1){
          addBalise ("TD", $line, 1, 1, true);
          if ($i == 0) { 
              addBalise ("TR", $line, 1, 0, true);
              $j=1;
          }
          $i++;
          if ($i >= $cols) { 
            $i = 0;
            $j = 0;
            addBalise ("TR", $line, 0, 1, true);
          }
        }
        else {
        
            addBalise ("TD", $line, 1, 1, true);
            addBalise ("TR", $line, 1, 1, true);            
        }

        $tselected []= $line;
        //$tselected []= "<tr><td>".$line."</td></tr>";
  }
  
  //displayArray($tselected,'Liste de case a cocher');
  $line = "";
  if ($i > 0) {$tselected [] = addBaliseBV ("TR", "", 0, 1);}
  $tselected [] = addBaliseBV ("TABLE", "", 0, 1);
   //------------------------------------------------------------  	 
  $obHtml = implode (_br, $tselected);
  //$obHtml = balise2Str($obHtml);
  return $obHtml;
 

}

/********************************************************************
*********************************************************************/
function buildCheckedListV ($list, 
                           $title = '',
                           $prefixe = "chk", 
                           $firstIndex = 0, 
                           $cols = 2, 
                           $keyLib = 'name',
                           $keyVal = 'val',
                           $keyId = 'id'){

  
	$tselected = array ();
  if ($title <> ""){$tselected []= $title."<br>";} 
//    displayArray($tList,'getCheckedV----------------------');  
  $tselected []= addBaliseBV ("TABLE", "", 1, 0, true);
  $i = 0; //pour compter les colonnes

  $nbRows  = floor (count($tList) / $cols) ;
  $tselected []= addBaliseBV ("TR", "", 1, 0, true);
  
  
  for ($h = 0; $h < count($list); $h++){
      $item = $list[$h];
      //-------------------------------------------------
      if ($keyId ==''){
        $v = $h;
      }else{
        $v = $item[$keyId];      
      } 
      //-------------------------------------------------
      
        if ($item[$keyVal] == 1){$value = 'checked';} else {$value = 'unchecked';}
        $line =  "<p><input type='checkbox' name='{$prefixe}_{$v}' {$value}>&nbsp;{$item[$keyLib]}</p>";
       //---------------------------------------------------
 
        if ($cols > 1){
          if ($i == 0) { 
              addBalise ("TD", $line, 1, 0, true);
          }
          $i++;
          if ($i >= $nbRows) { 
            $i = 0;
            addBalise ("TD", $line, 0, 1, true);
          }
          else {
              $line .= "<br>";
          }
        }
        else {
          //$tselected []= $line;
        }
        
          $tselected []= $line;

  }
  //$tselected []= "</table>";
    $tselected []= addBaliseBV ("TR", "", 0, 1, true);
  $line = "";
  if ($i > 0) {$tselected [] = addBaliseBV ("TD", "", 0, 1);}
  $tselected [] = addBaliseBV ("TABLE", "", 0, 1);
   //------------------------------------------------------------  	 
  $obHtml = implode (_br , $tselected);
  $obHtml = balise2Str($obHtml);
  return $obHtml;
 

}



/*******************************************************************
 *
 * fonction g‚n‚rique de gestion de balise html
 *   
 *******************************************************************/
 
 
/*****************************************************************
 *
 *****************************************************************/
 function addBaliseBV ($balise, $line, $baliseOpen = 1 , $baliseClose = 1){
$suffixe = "";
$prefixe = "";

  if ($baliseOpen > 0)  {$prefixe = "<".$balise.">";}
  if ($baliseClose > 0) {$suffixe = "</".$balise.">";}
  
  $newLine = $prefixe.$line.$suffixe;
  return $newLine;
}
function balise2Str ($Line) {

  $Line = str_replace ("<", "&lt;", $Line);
  $Line = str_replace (">", "&gt;", $Line);
  
  return $Line;
}

/*****************************************************************
 *
 *****************************************************************/
function addBalise ($balise, &$line, $baliseOpen = 1 , $baliseClose = 1, $byRef = false){
$suffixe = "";
$prefixe = "";


  if ($baliseOpen > 0)  {$prefixe = "<".$balise.">";}
  if ($baliseClose > 0) {$suffixe = "</".$balise.">";}
  
  $newLine = $prefixe.$line.$suffixe;
  if ($byRef) {$line = $newLine;}
  return $newLine;
}

/*****************************************************************
 *
 *****************************************************************/
 function htmlArrayOnPrefix($p, $tPrefix, $sep = '_'){
$tb = array ();
$tb = array_pad ($tb, 100, array());
  
  if (is_string($tPrefix)){$tPrefix = explode(';',$tPrefix);}
  $key = array_keys($p);  
  $j = 0;
  
  //balayage tu tableau dobjet renvoyer par le submit
  for ($h = 0; $h < count($key); $h++){
    //decoupage du noom pour isoler la racine des identifiants
    $t = explode("_", $key[$h]);
    
    //echo "prefixe = {$t[0]}";
    //balayage des prifixe
    for ($i = 0; $i < count($tPrefix); $i++){
      //prefixe trouve  ???
      if ($t[0] == $tPrefix [$i]){
        $tb[$t[1]][$tPrefix [$i]]= $p[$key[$h]];
        if ($j < $t[1]) {$j = $t[1];}

      }
    }
  }
  $tb = array_slice ($tb, 0, $j+1);
  
  
  //isplayArray($p, 'post');  
  //displayArray($tb, 'r‚sultat de du form');
  return $tb;
}




/***********************************************************************
 * construit la ligne de titre de la section d'option du lexique
 ***********************************************************************/
function buildTitleOption($title, $description){
  
    $t = array();
    //-------------------------------------------
    $t[] = "<TR>";
    $t[] = "<TD align='left'><B><font color='#0000FF'>{$title}</font></B></TD>";    
    $t[] = "<TD align='left'><i><font color='#0000FF'>{$description}</font></i></TD>";    
    $t[] = "</TR>";
    $t[] = "<TR><td colspan='2'><hr></td></TR>"._br;
    //-------------------------------------------
    return implode(_br, $t)._br;

}

/***********************************************************************
 * construit la ligne de titre secondaire de la section d'option du lexique
 ***********************************************************************/
function buildTitleOption2($title, $description, $nbCol = 2, 
                           $fontColor = 'FFFFFF', 
                           $hrBefore = true, $hrAfter = false){
  
    $hrb = (($hrBefore) ? buildHR(1,'696969',$nbCol) : '');
    $hra = (($hrAfter)  ? buildHR(1,'696969',$nbCol) : '');    
    $t = array();
    //-------------------------------------------
    $t[] = "<TR><td colspan='{$nbCol}'>{$hrb}</td></TR>"._br;    
    $t[] = "<TR>";
    $t[] = "<TD align='left'><B><font color='#{$fontColor}'>{$title}</font></B></TD>";    
    $t[] = "<TD align='left' colspan='{$nbCol}'><i><font color='#{$fontColor}'>{$description}</font></i>{$hra}</TD>";    
    $t[] = "</TR>";

    //-------------------------------------------
    return implode(_br, $t)._br;

}
/***********************************************************************
 * construit la ligne de titre secondaire de la section d'option du lexique
 ***********************************************************************/
function buildTitleOption4($title, $description = '', $nbCol = 2, 
                           $fontColor = 'FFFFFF', 
                           $hrBefore = true, $hrAfter = false){
  
    $t = array();
    //-------------------------------------------
    if ($hrBefore){
      //$t[] = "<TR><td colspan='{$nbCol}'>{$hrb}</td></TR>\n";   
      $t[] = buildHR(1,'839d2d', $nbCol); 
    }
    $t[] = "<TR>";
    $t[] = "<TD align='left' colspan='{$nbCol}'><B><font color='#{$fontColor}'>{$title}</font></B>";
        
    if ($description <> ""){  
    $t[] = "<br><i><font color='#{$fontColor}'>{$description}</font></i>";    
    } 
    
    $t[] = "</TR></TD>";
    
    if ($hrAfter){
      //$t[] = "<TR><td colspan='{$nbCol}'>{$hrb}</td></TR>\n";   
      $t[] = buildHR(1,'839d2d', $nbCol);       
    }
    
    //-------------------------------------------
    return implode(_br, $t)._br;

}

/***********************************************************************
 * construit la ligne de titre secondaire de la section d'option du lexique
 ***********************************************************************/
function buildTitleOption3($description){
  
    $t = array();
    $hr = buildHR(1);
    //-------------------------------------------
    $t[] = "<TR><td colspan='2'>{$hr}<br>";
    $t[] = "<i><B><font color='#000000'>{$description}</B></i>";
    $t[] = "</TD></td></TR>"._br;    

    //-------------------------------------------
    return implode(_br, $t)._br;

}

/***********************************************************************
 * construit une ligne avec une zone de saisie
 ***********************************************************************/
function buildInput($title, $description, $name, 
                    $default, $size, 
                    $defautHidden = '', $fin = '', 
                    $colorDisabled = ''){
    
    //$style = "style='background-color: #F2F2F2; border-style: solid; border-width: 1'";
    $style = "style='background-color: {$colorDisabled};'";    
    $attribDisabled = (($colorDisabled <> '') ? "{$style} disabled " : '');
    $t = array();
    
    $t[] = "<TR>";
    
    $t[] = "<TD align='left' >";
    if ($defautHidden<>''){
      $t[] = "<INPUT TYPE=\"hidden\" id='hidden{$name}'  NAME='hidden{$name}'  size='1%'  VALUE='{$defautHidden}'>";    
    }
    
    $t[] = "<B>{$title}</B></TD>";    
    $t[] = "<TD align='left' ><INPUT TYPE='text' id='{$name}'  "
          ."NAME='{$name}'  size='{$size}' VALUE='{$default}' {$attribDisabled}></TD>";    
    $t[] = "</TR>";
    
    if ($description <> ''){$t[] = buildDescription($description);}    
    if ($fin         <> ''){$t[] = $fin;}
    
    
    //echo "<hr>INPUT TYPE='text' id='{$name}'  "
    //     ."NAME='{$name}'  size='{$size}' VALUE='{$default}' {$attribDisabled}<hr>";    
      
    //-------------------------------------
    return  _br.implode(_br, $t)._br; 

}

/***********************************************************************
 * construit une ligne avec une zone de saisie
 ***********************************************************************/
function buildLibInfo($title, $description, $name, $fin = ''){
    
    $t = array();
    
    $t[] = "<TR>";
    $t[] = "<TD align='left' ><B>{$title}</B></TD>";    
    $t[] = "<TD align='left' >{$name}</TD>";    
    $t[] = "</TR>";
    
    if ($description <> ''){$t[] = buildDescription($description);}    
    if ($fin         <> ''){$t[] = $fin;}
      
    //-------------------------------------
    return  _br.implode(_br, $t)._br; 

}

/***********************************************************************
 * construit une ligne avec une liste de selection
 ***********************************************************************/
  
function buildList($title, $description, $name, $list, $default, $fin = '', $nbRows=0,
                   $onChange = ''){
    
    //todo               
    if ($onChange <> ''){$oc = "onchange='{$onChange}'" ;}else{$oc='';}
    if ($nbRows > 1)    {$size = " size='{$nbRows}' ";}   else{$size = '';}  
    //-----------------------------------------------------------------------
    $t = array();
    $selected = getlistSearch ($name, $list, 0, $default, $nbRows);
    //$tselected [] = "<SELECT NAME='{$name}' NAME='{$name}' {$size} {$oc} >";

    $t[] = "<TR>";
    $t[] = "<TD align='left' ><B>".$title."</B></TD>";    
    $t[] = "<TD align='left'>".$selected."</TD>";    
    $t[] = "</TR>";
    
    if ($description <> ''){$t[] = buildDescription($description);}    
    if ($fin         <> ''){$t[] = $fin;}
    
    //-------------------------------------
    return  _br.implode(_br, $t)._br; 

}

/***********************************************************************
 * construit une ligne avec une liste de selection
 ***********************************************************************/
function buildList2($title, $description, $name, $list, $default, $fin = ''){
    
    $t = array();
    $selected = getlistSearch ($name, $list, 0, $default);
    
    $t[] = "<TR>";
    $t[] = "<TD align='left' ><B>".$title."</B></TD>";    
    $t[] = "<TD align='left'>".$selected."</TD>";    
    $t[] = "</TR>";
    
    if ($description <> ''){$t[] = buildDescription($description);}    
    if ($fin         <> ''){$t[] = $fin;}
    
    //-------------------------------------
    return  _br.implode(_br, $t)._br; 

}

/***********************************************************************
 * construit une ligne avec une liste de selection d‚j… construite
 ***********************************************************************/
function buildSelecteur($title, $description, $selected, $fin = ''){
    
    $t = array(); 
    
    $t[] = "<TR>";
    $t[] = "<TD align='left' ><B>".$title."</B></TD>";    
    $t[] = "<TD align='left'>".$selected."</TD>";    
    $t[] = "</TR>";
   
    if ($description <> ''){$t[] = buildDescription($description);}    
    if ($fin         <> ''){$t[] = $fin;}
    
    //-------------------------------------
    return  _br.implode(_br, $t)._br; 

}






/***************************************************************************
 *
 ***************************************************************************/
function buildHtmlList ($name, $list, $defaut = 0, $firstIndex = 0, 
                        $nbRows = 0, $onChange = '', $ondblclick = ''){
  
  $tselected = array();
  
  if ($onChange <> ''){$oc = "onchange='{$onChange}'" ;}else{$oc='';}
  if ($ondblclick <> ''){$od = "ondblclick='{$ondblclick}'" ;}else{$od='';}  
  if ($nbRows > 1)    {$size = " size='{$nbRows}' ";}   else{$size = '';}  
  
  $tselected [] = "<SELECT NAME='{$name}' NAME='{$name}' {$size} {$oc} {$od}>";
  
  for ($h = 0; $h < count($list); $h++){
    $i = $firstIndex + $h;
    if ($defaut == $i ) {	$itemSelected = " selected";} else {$itemSelected = "";}
    
    $tselected [] = "<OPTION VALUE='{$i}' {$itemSelected}>{$list[$h]}";
  }
  $tselected [] = "</SELECT>";
  
  $obList = implode ("", $tselected);
  return $obList;
}




/***********************************************************************
 * construit une ligne avec un spinButton
 ***********************************************************************/
function buildColorSelecteur($title, $description, $name, $colorDefaut){

    $t = array();
    $t[] = "<TR>";
    $t[] = "<TD align='left' ><B>".$title."</B></TD>";
  
    

    $selColor =  html_colorSelecteur($name, $colorDefaut) ;
    $t[] = "<TD align='left' >{$selColor}</TD>"._br; 
    $t[] = "</TR>";    
    
    if ($description <> ''){$t[] = buildDescription($description);}
    //if ($fin         <> ''){$t[] = $fin;}    
    //-------------------------------------
    return  _br.implode(_br, $t)._br; 

}

/***********************************************************************
 *  construit un sélecteur de coleur sous forme de liste déroulante
 ***********************************************************************/
function html_colorSelecteur($name, $colorDefaut = '#FFFFFF', $onChange = ""){
		
		$colorarray = array("00", "33", "66", "99", "CC", "FF");	
    $xxx = "";
    	
    $event = ($onChange == '')?'':" onchange='{$onChange};'";
		$ret = "<select id='{$name}' name='{$name}' {$event}>\n";
		$ret .= "<option value='COLOR'>".$xxx."</option>\n";
		
		if (substr($colorDefaut,0,1) == "#") {$colorDefaut = substr($colorDefaut,1); }
		$selected = '';
		
		foreach ( $colorarray as $color1 ) {
			foreach ( $colorarray as $color2 ) {
				foreach ( $colorarray as $color3 ) {
				  $color = "{$color1}{$color2}{$color3}";
				  
          $selected = ($color == $colorDefaut)?' selected ':'';
          /*
				  if ($color == $colorDefaut){ 
              $selected = ' selected';
				  //echo "--> {$color}---{$colorDefaut}<br>";          
          }

          */
					$ret .= "<option value='{$color}' {$selected}  style='background-color:#{$color};color:#{$color};'>#{$color}</option>\n";
				}
			}
		}
		
		$ret .= "</select><br />\n";

  return $ret;
}

/***********************************************************************
 *  construit un sélecteur de coleur sous forme de liste déroulante
 ***********************************************************************/
function html_getColorCode($lisIndex){
		
		$colorarray = array("00", "33", "66", "99", "CC", "FF");	
    $h = 0;    	
		
    foreach ( $colorarray as $color1 ) {
			foreach ( $colorarray as $color2 ) {
				foreach ( $colorarray as $color3 ) {
				  if ($h == $lisIndex){
  					$ret = "#{$color1}{$color2}{$color3}";   
            break;       
          }else{
            $h++;
          }

				}
			}
		}
	echo "couleur : {$ret}<br>";
  return $ret;
}

/***********************************************************************
 *  construit un sélecteur de de répertoire
 ***********************************************************************/
function html_buildFolderlist($folder, $name, $default, $oc = ''){

    //---Feuille de style   
    $folder = str_replace ('//','/', $folder."/*");
    $tf = glob($folder, GLOB_ONLYDIR);
    $tr = array();
    

    
    //displayArray($tf, "----- html_buildFolderlist -----");
    $lg = strlen($folder) -1;


    $i = 0;
    for ($h = 0; $h < count($tf); $h++){
      $tf[$h] = substr($tf[$h], $lg);
      //$tf[] =  "<INPUT TYPE=\"hidden\" id='{$name}'  NAME='{$name}'  size='1%'"." VALUE='{$tf[$h]}'>";
      if ($tf[$h] ==  $default) $i = $h; 
    }

/*    
*/
    array_unshift ( $tf, '');    
    

    return buildHtmlListString ($name, $tf, $default, false, $oc);
    //$tselected [] = "<SELECT NAME='{$name}' NAME='{$name}' {$size} {$oc} >";


    
}

/***********************************************************************
 *  construit un sélecteur de de répertoire
 ***********************************************************************/
function html_buildFolderlist2($folder, $name, $default, $title, $description =''){

    //---Feuille de style   
    $folder = str_replace ('//','/', $folder."/*");
    $tf = glob($folder, GLOB_ONLYDIR);
    $tr = array();
    

    
    //displayArray($tf, "----- html_buildFolderlist -----");
    $lg = strlen($folder) -1;


    $i = 0;
    for ($h = 0; $h < count($tf); $h++){
      $tf[$h] = substr($tf[$h], $lg);
      //$tf[] =  "<INPUT TYPE=\"hidden\" id='{$name}'  NAME='{$name}'  size='1%'"." VALUE='{$tf[$h]}'>";
      if ($tf[$h] ==  $default) $i = $h; 
    }

/*    
*/
    array_unshift ( $tf, '');    
    
    
    
    
    
    
    
//    return buildList($caption, $description, $name, $tf, $default);  //
//    function buildHtmlListString ($name, $list, $defaut = '', $onChange = '', $sep = ";"){

//****************************************************************


    $t = array();
    $selected =  buildHtmlListString ($name, $tf, $default);
    //$tselected [] = "<SELECT NAME='{$name}' NAME='{$name}' {$size} {$oc} >";

    $t[] = "<TR>";
    $t[] = "<TD align='left' ><B>".$title."</B></TD>";    
    $t[] = "<TD align='left'>".$selected."</TD>";    
    $t[] = "</TR>";
    
    if ($description <> ''){$t[] = buildDescription($description);}    
    if ($fin         <> ''){$t[] = $fin;}
    
    //-------------------------------------
    return  _br.implode(_br, $t)._br; 

    
}
/**************************************************************************
 *
 **************************************************************************/
 function build_icoOption($link, $icone, $alt, $texteBefore='', $textAfter='', $style = ''){
    //$alt = str_replace("'","\'",$alt);
    $ico = "<TD {$style} align='center'>{$texteBefore}"
           ."<A href='{$link}'><img src='{$icone}' border=0 "
           ."Alt=\"{$alt}\" title=\"{$alt}\" width='20' height='20' ALIGN='absmiddle'></A>"
           ."{$textAfter}</td>";            
  return $ico;
 }
/**************************************************************************
 *
 **************************************************************************/
 function build_icoSubmit($name, $icone, $alt, $texteBefore='', $textAfter='', $style){
    //$alt = str_replace("'","\'",$alt);


    
    $ico = "<TD {$style} align='center'>{$texteBefore}"
          ."<input type='image' src=".$icone." border='0' name='{$name}' "
          ." title='{$alt}' width='20' height='20' Alt='{$alt}'>"    
          ."{$textAfter}</td>";    

            
  return $ico;
 }
/****************************************************************
 *
 ****************************************************************/

function buildListFromFolder($title, 
                             $description, 
                             $default,  
                             $name,
                             $folder, 
                             $suffixeFilter, 
                             $mode = 0,
                             $AddBlanck = true,
                             $nbRows=1,
                             $onChange = ''){

//if (!isset($onChange))  $onChange = '';
//if (!isset($nbRows))    $nbRows = 1;
//if (!isset($AddBlanck)) $AddBlanck = true;


    if ($onChange <> ''){$oc = "onchange='{$onChange}'" ;}else{$oc='';}
    if ($nbRows > 1)    {$size = " size='{$nbRows}' ";}   else{$size = '';}  
    //-----------------------------------------------------------------------
    $bTbl = ($title<>'');
    
    $lstCSS = getFileListH($folder, $suffixeFilter, 5);
    if ($AddBlanck) array_unshift ( $lstCSS, '');    
    $lg = strlen($folder);
    //displayArray8($lstCSS,"-----  -----");
    $t = array();
    //-------------------------------
    if ($bTbl) {
      $t[] = "<TR>";
      $t[] = "<TD align='left' ><B>{$title}</B></TD>";    
      $t[] = "<TD align='left'>";    
    }
    //---------------------------------------------------------------
    $t [] = "<select name='{$name}' size='{$nbRows}' {$oc}>";
    
    $i = 0;
    for ($h = 0; $h < count($lstCSS); $h++){
      switch($mode){
      case 1:
        $item = substr(dirname($lstCSS[$h]), $lg);      
        break;
      default:
        $item = substr($lstCSS[$h], $lg);      
      }
      
      
      $selected = (($item == $default) ? 'selected' : '');
      $t[] = "<option value='{$item}' {$selected}>{$item}</option>";
    }
    
    $t [] = "</select>";
    //---------------------------------------------------------------    
    if ($bTbl) {    
      $t[] = "</TD>";    
      $t[] = "</TR>";
      if ($description <> ''){
          $t[] = "<TR>";
          $t[] = "<TD align='left' colspan='2'>";
          $t[] = "<i>{$description}</i>";    
          $t[] = "</TD></tr>";    
      
      }
    }

    //----------------------------------------------------
    $list = implode("\n", $t);
    return $list;      


 //   echo buildList(_AD_FUN_STYLE_SHEET, _AD_FUN_STYLE_SHEET_DSC, 'txtFeuilleDeStyle', $lstCSS, $i);  //
}

?>
