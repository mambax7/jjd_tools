<?php
//  ------------------------------------------------------------------------ //
//       JJD -          //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

******************************************************************************/


class cls_jjd_ado {  

/************************************************************
 * declaration des variables membre:
 ************************************************************/
  var $table       = 'table';
  var $colNameId   = 'idTable';
  var $becho       = 0;      
/************************************************************
 * Constructucteur:
 ************************************************************/
function  cls_jjd_ado($table, $colNameId, $becho = 0){

  //if (is_readable($options['lang'])) include_once($options['lang']);
  
  $this->init($table, $colNameId, $becho);                                              
  
  return true;
  
}
/************************************************************
 * 
 ************************************************************/
function  setEcho($newValue){
  $this->becho = $newValue;
}
/************************************************************
 * 
 ************************************************************/
function  getEcho(){
  return $this->becho;
}
  
/************************************************************
 * initialisation de la classe:
 ************************************************************/
function  init($table, $colNameId, $becho = 0){


  $this->table           = $table;
  $this->colNameId       = $colNameId;  
  $this->becho           = $becho;
  return true;
  
}
/************************************************************
 * initialisation de la classe:
 ************************************************************/
function  setBecho($newVal){


  $this->becho = $newVal;

  
}

/*************************************************************************
 *
 *************************************************************************/
function getRow($id, $colList = '*', $becho = 0){
	global $xoopsDB;
	
    if ($colList == '') $colList = '*';
    $sql = "SELECT {$colList} FROM {$this->table}"
          ." WHERE {$this->colNameId} = {$id}";
          
    $this->showSql ($sql, 'getRow', $becho);          
    $sqlquery = $xoopsDB->query ($sql); 
    
     
    return $sqlquery;

}
 /****************************************************************************
 *
 ****************************************************************************/
 function getRows($orderBy = '', $filter = '', $colList = '*'){
	global $xoopsModuleConfig, $xoopsDB;
	

    $sql = "SELECT {$colList} FROM {$this->table}"
          .(($filter <> '')?" WHERE {$filter}":'')
          .(($orderBy == "" )?'':" ORDER BY {$orderBy}");
          
    //echo "<hr>getRows<br>{$sql}<hr>";          
    $sqlquery = $xoopsDB->query ($sql);  
    
    

    return $sqlquery;
                
      
 }
 /****************************************************************************
 *
 ****************************************************************************/
 function getArrays($orderBy = 'nom', $filter = '', $colList = '*'){
	global $xoopsModuleConfig, $xoopsDB;
	 
	 $t = array();
   $sqlquery = $this->getRows($orderBy, $filter);

   while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $sqlfetch['id'] =  $sqlfetch[$this->colNameId];
      $t[] = $sqlfetch;
    }
    
  return $t;
 }

/*************************************************************************
 *
 *************************************************************************/
function delete($clauseWhere = '', $becho = 0){

    $sql = "DELETE FROM {$this->table}"
          .($clauseWhere == '') ? ''   : " WHERE {$clauseWhere}";
    
    $this->showSql ($sql, 'delete', $becho);      
    $sqlquery = $xoopsDB->query ($sql);  
    return 1;
          
}  

/*************************************************************************
 *
 *************************************************************************/
function deleteId ($id, $children = '', $sep = ";") {
	Global $xoopsDB;
	
	$sql = "DELETE FROM {$this->table} "
	      ." WHERE {$this->colNameId} = ".$id;
	
       $xoopsDB->query($sql);	

	//------------------------------------------
	//suppression dans les tables enfants passer en paametre
	//supose que le nom du champ dans la table enfant est le meme que dans la table parent
	//------------------------------------------
	if ($children <> ''){
    $t = explode ($sep, $children);
    for ($h = 0; $h < count($t); $h++){
    	 $sql = "DELETE FROM {$t[$h]} "
    	      ." WHERE {$this->colNameId} = ".$id;
       $xoopsDB->query($sql);    
    }
  }
}
 /****************************************************************************
 *
 ****************************************************************************/
 function getChildren($childTable = '', $id, $orderBy = ''){
	global $xoopsModuleConfig, $xoopsDB;
	

    $sql = "SELECT * FROM {$childTable}"
          ." WHERE {$this->colNameId} = {$id}"
          .(($orderBy == "" )?'':" ORDER BY {$orderBy}");
          
    //echo "<hr>getChildren<br>{$sql}<hr>";          
    $sqlquery = $xoopsDB->query ($sql);  

    return $sqlquery;
      
 }
 /****************************************************************************
 *
 ****************************************************************************/
 function getChildrenArray($childTable = '', $id, $orderBy = '', 
                           $nbEmpty2add = 0, $tDefault = ''){
	global $xoopsModuleConfig, $xoopsDB;
	
  $sqlquery = $this->getChildren($childTable,$id,$orderBy);
  $t = array();
    
   while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $t[] = $sqlfetch;
    }

  if ($nbEmpty2add > 0){
    for ($h = 0; $h < $nbEmpty2add; $h++){
      $t[] = $tDefault;    
    }
  }

  //-----------------------------------------------------
  return $t;
      
}
 /****************************************************************************
 *
 ****************************************************************************/
 function getSql2Array($sql){
	global $xoopsDB;
	
  $sqlquery = $xoopsDB->query ($sql);
  $t = array();
    
   while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $t[] = $sqlfetch;
    }
/*

  if ($nbEmpty2add > 0){
    for ($h = 0; $h < $nbEmpty2add; $h++){
      $t[] = $tDefault;    
    }
  }
*/
  //-----------------------------------------------------
  return $t;
      
}

/*************************************************************************
 *
 *************************************************************************/
function countRows($clauseWhere = '', $becho = 0){
	global $xoopsDB;
	

    $sql = "SELECT count({$this->colNameId}) AS nbEnr FROM {$this->table} "
          .(($clauseWhere == '') ? ''   : " WHERE {$clauseWhere}");

    //$this->showSql ($sql, 'countRows', $becho);      
    $sqlquery = $xoopsDB->query ($sql); 
     
    list ($nbEnr) = $xoopsDB->fetchRow($sqlquery);
    return $nbEnr;

}

/*************************************************************************
 *
 *************************************************************************/
function exist($id, $zeroCanExist = false){
	global $xoopsDB;
	  
    //echo "<hr>exist->{$id}<hr>";
    if (!$zeroCanExist & ($id == 0)) return false;
    //----------------------------------------------
    $sql = "SELECT count({$this->colNameId}) AS nbEnr FROM {$this->table} "
          ." WHERE {$this->colNameId} = {$id}";

    //$this->showSql ($sql, 'exist', false);      
    $sqlquery = $xoopsDB->query ($sql); 
     
    list ($nbEnr) = $xoopsDB->fetchRow($sqlquery);
    return ($nbEnr > 0);

}

/*************************************************************************
 *
 *************************************************************************/
function existInTable($table, $id, $colNameId, $zeroCanExist = false){
	global $xoopsDB;
	  
    //echo "<hr>exist->{$id}<hr>";
    if (!$zeroCanExist & ($id == 0)) return false;
    //----------------------------------------------
    $sql = "SELECT count({$colNameId}) AS nbEnr FROM {$table} "
          ." WHERE {$colNameId} = {$id}";

    //$this->showSql ($sql, 'exist', true);      
    $sqlquery = $xoopsDB->query ($sql); 
     
    list ($nbEnr) = $xoopsDB->fetchRow($sqlquery);
    return ($nbEnr > 0);

}

/******************************************************
 *
 ******************************************************/
function getArray ($id, $colList = '*', $becho = 0){
	global  $xoopsDB;

    $sqlquery = $this->getRow($id,  $colList, $becho);
    $p = $xoopsDB->fetchArray($sqlquery);

    return $p;
}


/******************************************************
 *
 ******************************************************/
function clean ($filter = ''){
	global  $xoopsDB;
	
	    if ($filter == ''){	    
	     return false;
      }elseif ($filter == '*'){
        $sql = "DELETE  FROM {$this->table}";      
      }else{
        $sql = "DELETE  FROM {$this->table} WHERE {$filter} ";      
      }

      $xoopsDB->queryF($sql);            
      //echo "<hr>{$sql}<hr>";

    //$sqlquery = $this->getRow($id,  $colList, $becho);
    //$p = $xoopsDB->fetchArray($sqlquery);

    //return $p;
}

/*************************************************************************
 *
 *************************************************************************/
function showSql($sql, $source , $becho = 1){
  
  if ($becho <> 0) {$b = $becho;} 
  else if ($this->becho <> 0) {$b = $this->becho;}
  else {$b = 0;}
  //---------------------------------------------------------
  switch ($b){
  case 1:
    if ($becho) echo "<hr>{$source}<br>$sql<hr>";  
    break;
  
  case 2:
    //a prevoir log dans fichier
    break;
  }

}


/****************************************************************
 *
 ****************************************************************/

function getValue($id, $colName){
	Global $xoopsDB, $xoopsConfig, $xoopsModule;
	
  $sql = "SELECT {$colName} AS sqlValue "
        ." FROM ".$this->table
        ." WHERE {$this->colNameId} = {$id}"; 

  $sqlquery = $xoopsDB->query ($sql);  
  list($r) = $xoopsDB->fetchRow($sqlquery);  
  return $r;
}

/****************************************************************
 *
 ****************************************************************/
function getScalaire($col2count, $filter, $op = 'count', $table = '', $debug = false){
	Global $xoopsDB, $xoopsConfig, $xoopsModule;
	
	if ($table == '') $table = $this->table;
  $sql = "SELECT {$op}({$col2count}) AS nbEnr "
        ." FROM {$table} "
        .(($filter == '') ? '' : " WHERE {$filter}"); 

  $sqlquery = $xoopsDB->query ($sql);  
  if ($xoopsDB->getRowsNum($sqlquery) == 0){
    $r = 0;
  }else{
    //$sqlfetch = $xoopsDB->fetchArray($sqlquery);
    //$r = $sqlfetch['nbEnr'] ;
    list($r) = $xoopsDB->fetchRow($sqlquery);
  }
  
  if ($debug) echo "<hr>countArchives<br>$sql<hr>";
  //displayArray($t,"----- countArchives -----");
  return $r;
}
function buildActions ($id) {
//echo build_icoOption($link, _JJDICO_EDIT, _AD_HER_EDIT, '', '', $bg);
  return '';
  
}


/****************************************************************
 *
 ****************************************************************/
function getColsArray($table = '', $cols2eclude, $sep = ','){
global $xoopsDB;
  
  if ($table == '') $table = $this->table;
  $fields = mysql_list_fields(XOOPS_DB_NAME ,  $table);
  $columns = mysql_num_fields($fields);
  
  
  $t = explode($sep, $cols2eclude);
  $tCol2Exclude = array_flip($t);
  
  $t = array();  
  for ($i = 0; $i < $columns; $i++) {
      $name = mysql_field_name($fields, $i);
      //echo $name."\n";
      if(!isset($tCol2Exclude[$name])){
        $t[] = $name;        
      }
  } 

  return $t;
}

/****************************************************************
 *
 ****************************************************************/

function getColsStr($table, $cols2eclude, $sep = ','){
  
  $t = $this->getColsArray($table, $cols2eclude, $sep);
  $cols = implode($sep, $t);
  return $cols;

}
/****************************************************************
 *
 ****************************************************************/
function newClone($id, $returnArray = false, $name2AddCopy = ''){
global $xoopsDB;
  
  $tCols = $this->getColsArray($this->table, $this->colNameId, $sep = ',');
  $cols1 = implode (',', $tCols);
  //----------------------------------------------------------------
  if ($name2AddCopy <> ''){
      $copy = "concat({$name2AddCopy}, ' - copy of #', {$this->colNameId}) AS {$name2AddCopy}";
      $t = array_flip($tCols);
      $i = $t[$name2AddCopy];
      $tCols[$i] = $copy;  
  }
  //----------------------------------------------------------------
  $cols2 = implode (',', $tCols);  
  //displayArray($t2,'--------------------------');
  //-----------------------------------------------------------
  $sql = "INSERT INTO {$this->table} ({$cols1}) "
       . " SELECT {$cols2} FROM {$this->table} WHERE {$this->colNameId}={$id}";
  //displaySql($sql);
  //echo "<hr>newClone->sql<br>{$sql}<hr>";
  //echo "<hr>newClone->".XOOPS_DB_NAME."-{$this->table}<br>{$cols}<hr>";  
  $xoopsDB->queryF ($sql);
  $newId = $xoopsDB->getInsertId() ;

  //--------------------------------------------------------
  if ($returnArray) {
    return $this->getArray($newId);
  }else{
    return $this->fetchRow($newId);  
  }

}
/****************************************************************
 *
 ****************************************************************/
function newCloneChild($oldId, $newId, 
                       $childTable, 
                       $childColNamaId, 
                       $parentColNameId,
                       $returnArray = false){
global $xoopsDB;

  
  //$tCols = $this->getColsArray(_HER_TFN_DECOPP, 'idDecopp');
  $tCols = cls_jjd_ado::getColsArray($childTable, $childColNamaId);  
  $cols1 = implode (',', $tCols);
  //----------------------------------------------------------------

      $t = array_flip($tCols);
      $i = $t[$parentColNameId];
      $tCols[$i] = "{$newId} AS {$parentColNameId}";  

  //----------------------------------------------------------------
  $cols2 = implode (',', $tCols);  

  $sql = "INSERT INTO {$childTable} ({$cols1}) "
       . " SELECT {$cols2} FROM {$childTable} WHERE {$parentColNameId}={$oldId}";
  $xoopsDB->queryF ($sql);

 if ($returnArray){
   $sql = " SELECT * FROM {$childTable} WHERE {$parentColNameId}={$newId}"; 
   $t = cls_jjd_ado::getSql2Array($sql);
   return $t;
 }else{
  return true;
  }

}
//-------------------------------------------

} // fin de la classe
?>



