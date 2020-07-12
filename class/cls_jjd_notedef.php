<?php

//  ------------------------------------------------------------------------ //
/******************************************************************************
******************************************************************************/
include_once (XOOPS_ROOT_PATH . "/modules/jjd_tools/_common/class/cls_jjd_ado.php");

class cls_JJD_NOTEDEF extends cls_jjd_ado {  

/************************************************************
 * declaration des variables membre:
 ************************************************************/

      
/*============================================================
 * Constructucteur:
 =============================================================*/
//function  cls_hermes_texte($table, $colNameId, $becho = 0){
function  cls_JJD_NOTEDEF($becho = 0){
  cls_jjd_ado::cls_jjd_ado(_JJD_TFN_NOTEDEF, "idNotedef", $becho); 
  
  return true;
  
}

/*============================================================
 * methodes:
 =============================================================*/
  
/******************************************************
 *
 ******************************************************/
function getArray ($id, $colList = '*', $becho = 0){
	global  $xoopsDB;

  if ($id == 0) {
      $p = array ('idNotedef'        => 0, 
                  'name'             => '',      
                  'description'      => '',      
                  'noteMin'          => 0,
                  'noteMax'          => 9,                  
                  'fontImg'          => '',
                  'curseurImg'       => '',                  
                  'curseurIndexImg0' => 0,
                  'curseurIndexImg1' => 1);

  }
  else {
    $sqlQuery = $this->getRow($id,$colList,$becho);
    $p = $xoopsDB->fetchArray($sqlQuery);
    
    $p['description']   = sql2string ($p['description']);
    
  }
  return $p;
}

/****************************************************************
 *
 ****************************************************************/

function newRow ($t) {
	
    return newEmptyRow () ;	


}
/****************************************************************
 *
 ****************************************************************/

function newEmptyRow () {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	$sql = "INSERT INTO {$this->table}"
	      ." (name,description,noteMin,noteMax,fontImg,curseurImg,curseurIndexImg0,curseurIndexImg1) "
	      ." VALUES ('???','???',0,0,'','',0,0)";
	
    $xoopsDB->query($sql);	
    $newId = $xoopsDB->getInsertId() ;
    return $newId;
  
}

/*******************************************************************
 *
 *******************************************************************/
function saveRequest ($t) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	   $myts =& MyTextSanitizer::getInstance();
	   // $name = $myts->makeTboxData4Show();	

  //------------------------------------
  
  $idNotedef = $t['idNotedef'];
  //-----------------------------------------------------------
  //-----------------------------------------------------------
   //$t['txtTexte'] = string2sql($t['txtTexte']);
   $txt = $t['txtdescription'];
   $description = $myts->makeTareaData4Save($txt);   
    
  if ($idNotedef == 0){
   






      $sql = "INSERT INTO {$this->table} "
            ." (name,description,noteMin,noteMax,"
            ." fontImg,curseurImg,curseurIndexImg0,curseurIndexImg1) "
            ."VALUES (" 
            ."'{$t['txtname']}'," 
            ."'{$description}',"
            ."{$t['txtnoteMin']},"
            ."{$t['txtnoteMax']},"            
            ."'{$t['txtfontImg']}',"  
            ."'{$t['txtcurseurImg']}',"            
            ."{$t['txtcurseurIndexImg0']},"
            ."{$t['txtcurseurIndexImg1']}"       
            .")";
   
  }else{
      $sql = "UPDATE {$this->table} SET "
           ."name              = '{$t['txtname']}',"
           ."description       = '{$description}',"
           ."noteMin           = {$t['txtnoteMin']},"           
           ."noteMax           = {$t['txtnoteMax']},"           
           ."fontImg           = '{$t['txtfontImg']}',"
           ."curseurImg        = '{$t['txtcurseurImg']}',"
           ."curseurIndexImg0  = {$t['txtcurseurIndexImg0']},"
           ."curseurIndexImg1  = {$t['txtcurseurIndexImg1']} " 
           ." WHERE idNotedef  = ".$idNotedef;
          
            
  }

  $xoopsDB->queryF($sql);           
//echo "<hr>{$sql}<hr>";
//exit;
}
//==============================================================================
} // fin de la classe

?>



