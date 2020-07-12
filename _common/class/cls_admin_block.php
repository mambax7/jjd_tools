<?php
//  ------------------------------------------------------------------------ //
//  ------------------------------------------------------------------------ //
/******************************************************************************
******************************************************************************/

class cls_admin_block {

var $mid;


/***********************************************************************

 ***********************************************************************/
function cls_admin_block($idModule) {
global $xoopsConfig;	

  $this->mid = $idModule;
  $f = XOOPS_ROOT_PATH."/modules/jjd_tools/language/{$xoopsConfig['language']}/admin.php";
  include_once($f);
 

}
/***********************************************************************

 ***********************************************************************/
function listBlock ($title, $description) {
global $xoopsModule, $xoopsConfig, $xoopsDB;
 
    $query = $this->getBlocks();    
    $tPosition = explode('|', _AD_JJD_BLOCK_SIDE);
    $tYesNo = array(_AD_JJD_NO,_AD_JJD_YES);
          
  echo _JJD_JSI_TOOLS;
  echo _JJD_JSI_SPIN;  
  
  	$myts =& MyTextSanitizer::getInstance();
  	$line = buildHR(1, '696969',11);

    OpenTable();
    //**********************************************************************************    
    //echo "<b>"._AD_JJD_TEXTES."</b><br>";    

/***************************
 bid        mediumint(8)  	 	UNSIGNED  	Non  	 	auto_increment  	  Affiche les valeurs distinctes   	  Modifier   	  Supprimer   	  Primaire   	  Unique   	  Index   	 Texte entier
mid        smallint(5) 		UNSIGNED 	Non 	0 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
func_num   tinyint(3) 		UNSIGNED 	Non 	0 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
options    varchar(255) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
name       varchar(150) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
title      varchar(255) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
content    text 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
side       tinyint(1) 		UNSIGNED 	Non 	0 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
weight     smallint(5) 		UNSIGNED 	Non 	0 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
visible    tinyint(1) 		UNSIGNED 	Non 	0 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
block_type char(1) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
c_type     char(1) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
isactive   tinyint(1) 		UNSIGNED 	Non 	0 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
dirname    varchar(50) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
func_file  varchar(50) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
show_func  varchar(50) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
edit_func  varchar(50) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
template   varchar(50) 	latin1_swedish_ci 		Non 			Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
bcachetime int(10) 		UNSIGNED 	Non 	0 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
last_modified 

 ***************************/
    $sqlquery = $this->getBlocks ();
    echo "<FORM ACTION='admin_block.php?op=save' METHOD=POST>\n";

    echo "<table>";
    echo buildTitleOption4($title, $description,11,'000000', false, true);
    echo "</table>";


    //displayArray($sqlquery,"----- db_getBlocks -----");
    echo "<table>";  
    



    //echo "</tr>";    

    //-titre des lolones
    echo "<tr>";
    echo "<td align='right'>#</td>";
    echo "<td>"._AD_JJD_NAME."</td>";    
    echo "<td>"._AD_JJD_TITLE."</td>";    
    echo "<td>"._AD_JJD_SIDE."</td>";    
    echo "<td>"._AD_JJD_WEIGHT."</td>";
    echo "<td>"._AD_JJD_VISIBLE."</td>";    
    echo "<td>"._AD_JJD_BLOCK_TYPE."</td>";  
    echo "<td>"._AD_JJD_ACTIF."</td>";    
    echo "<td>".""."</td>";    
          
    echo "</tr>";
  
    $numLine = 0;
    $side = 0;
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      
      if($side <> $sqlfetch['side']){
        echo $line;
        $side = $sqlfetch['side'];
      }
      
      $idBlock = $sqlfetch['bid'];    
      
      //--------------------------------------------------------      
      
      echo '<tr>';
      
     echo "<TD align='center'  >"
         ."<INPUT TYPE=\"hidden\" "
         ." NAME='txtBlock[{$idBlock}][bid]'  size='1%'  " 
         ." VALUE='{$idBlock}'>"
         ."{$sqlfetch['bid']}</td>";
      
      echo "<td>{$sqlfetch['name']}</td>";

 //     $nom = $myts->makeTboxData4Show($sqlfetch['title'], "1", "1", "1");
 //     echo "<td>{$nom}</td>";
//."NAME='txtBlock[{$bid}][visible]' size='5%' "

    echo "<TD align='left' ><INPUT TYPE=\"text\" NAME='txtBlock[{$idBlock}][title]' VALUE='{$sqlfetch['title']}'></TD>\n";
      
      //$position = $tPosition[];     
      //echo "<td>{$tPosition[$sqlfetch['side']]}</td>";
      $pos = buildHtmlList ("txtBlock[{$idBlock}][side]", $tPosition, $sqlfetch['side'], 0,
                        0, '', '');
      echo "<td>{$pos}</td>";                        
                        
     //---poids
     echo "<TD align='center'  >";
     $lwSpin=5;
     echo htmlSpin ("","txtBlock[{$idBlock}][weight]", $sqlfetch['weight'], 9999, 0, 10, $lwSpin , '', 1);      
     echo "</TD>\n";
     // echo "<td>{$sqlfetch['weight']}</td>";
      
      
      //---Visible
      $c = ($sqlfetch['visible']==1)?"checked":"";
      echo "<TD align='center'  ><input type='checkbox' "
           ."NAME='txtBlock[{$idBlock}][visible]' size='5%' "
           ."value='1' ".$c.">"
           ."</td>\n";
      
      
      
      
      
      echo "<td>{$sqlfetch['block_type']}</td>";      


      //--- actif
      $c = ($sqlfetch['isactive']==1)?"checked":"";
      echo "<TD align='center'  ><input type='checkbox' "
           ."NAME='txtBlock[{$idBlock}][isactive]' size='5%' "
           ."value='1' ".$c.">"
           ."</td>\n";


      
          //echo htmlSpin ("","txtStrOrdre_{$numLine}", ($numLine+1)*10, 365, 1, 1, $lwSpin , '', 1);      

      
      
      echo '</tr>';       
    }
    
    //---------------------------------------------------    
    echo $line;      
    
    echo "</table>";      


    //**********************************************************************************
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CLOSE."' onclick='".buildUrlJava("index.php",false)."'></td>
    <td align='left' width='200'></td>

    
    <td align='right'>
    <input type='submit' name='cancel' value='"._AD_JJD_CANCEL."' onclick='".buildUrlJava("admin_block.php?op=cancel",false)."'>    
    </td>

    <td align='right'>
    <input type='submit' name='update' value='"._AD_JJD_UPDATE."' onclick='".buildUrlJava("admin_block.php?op=save",false)."'>    
    </td>

  </tr></table>
  </form>";

  
  CloseTable();
}




/*******************************************************************
 *
 *******************************************************************/
function saveBlocks ($tBlocks) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	   $myts =& MyTextSanitizer::getInstance();
	   // $name = $myts->makeTboxData4Show();	

    //displayArray($t, "----------saveBlocks--------------");


    while(list($key,$item) = each($tBlocks)){
      $idBlock = $item['bid'];
      if (!isset($item['visible']))  $item['visible'] = 0;
      if (!isset($item['isactive'])) $item['isactive'] = 0;
            
      $sql = "UPDATE ".$xoopsDB->prefix('newblocks')." SET "
            ."title            = '{$item['title']}',"
            ."side             =  {$item['side']},"            
            ."weight           =  {$item['weight']},"  
            ."visible          =  {$item['visible']},"   
            ."isactive         =  {$item['isactive']}"            
            ." WHERE bid = ".$idBlock;
    
      $xoopsDB->query($sql);    
      //echo "<hr>{$sql}<hr>"; 

    }

 //exit;
}


/*****************************************************************
*
******************************************************************/
function getBlocks(){
global $xoopsDB,$xoopsModuleConfig, $xoopsModule;
  
  
  $sql = "SELECT * FROM ".$xoopsDB->prefix('newblocks')
       . " WHERE mid = {$this->mid}"
       . " ORDER BY side,weight,name";
  $query = $xoopsDB->query ($sql);       

  return $query;
  
}

 

 
//---------------------------------------------------------------------
    
} //fin class
?>
