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

/****************************************************************
 *
 ****************************************************************/

function getScalaire($table, $col2count, $filter, $op = 'count', $debug = false){
	Global $xoopsDB, $xoopsConfig, $xoopsModule;
	
  $sql = "SELECT {$op}({$col2count}) AS nbEnr "
        ." FROM ".$xoopsDB->prefix($table)
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
/****************************************************************
 *
 ****************************************************************/

function getValueById($table, $id, $colNameId, $colNameValue){
	Global $xoopsDB;
	
  $sql = "SELECT {$colNameValue} AS sqlValue "
        ." FROM ".$table
        ." WHERE {$colNameId} = {$id}"; 

  $sqlquery = $xoopsDB->query ($sql);  
  list($r) = $xoopsDB->fetchRow($sqlquery);  
  return $r;
}

/**********************************************************************
 *
 **********************************************************************/
function get_tables($prefixe){
global $xoopsDB;


  $sqlquery = mysql_list_tables(XOOPS_DB_NAME );
  $t = array();
  //$prefixe = $xoopsDB->prefix().'_'.$prefixe;
  $prefixe = $xoopsDB->prefix($prefixe);  
  //echo "<hr>get_tables->".XOOPS_DB_NAME."-{$prefixe}<hr>";  
  
  //echo "<hr>{$prefixe}<hr>";
  $lg = strlen($prefixe); 
  
   while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
    
      list($key, $name)= each($sqlfetch);
      //echo "get_tables-{$key}-{$name}<br>";
      if (substr($name, 0, $lg) == $prefixe) {
          $t[] =array($name, substr($name, $lg)) ;
      };
      //her_displayArray($sqlfetch,"----- build_const_table -----");
    }
    
    //displayArray($t,"----- build_const_table -----");
  //exit;
  return $t;
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
function newClone($id, $table, $colNameId, $name2AddCopy = ''){
global $xoopsDB;
  
  $tCols = getColsArray($table, $colNameId);
  $cols1 = implode (',', $tCols);
  //----------------------------------------------------------------
  if ($name2AddCopy <> ''){
      $copy = "concat({$name2AddCopy}, ' - copy of #', {$colNameId}) AS {$name2AddCopy}";
      $t = array_flip($tCols);
      $i = $t[$name2AddCopy];
      $tCols[$i] = $copy;  
  }
  //----------------------------------------------------------------
  $cols2 = implode (',', $tCols);  
  //displayArray($t2,'--------------------------');
  //-----------------------------------------------------------
  $sql = "INSERT INTO {$table} ({$cols1}) "
       . " SELECT {$cols2} FROM {$table} WHERE {$colNameId}={$id}";
  //displaySql($sql);
  //echo "<hr>newClone->sql<br>{$sql}<hr>";
  //echo "<hr>newClone->".XOOPS_DB_NAME."-{$this->table}<br>{$cols}<hr>";  
  $xoopsDB->queryF ($sql);
  $newId = $xoopsDB->getInsertId() ;
  return $newId;
  //--------------------------------------------------------

}

/****************************************************************
 *
 ****************************************************************/
function newCloneChild($oldId, $newId, 
                       $childTable, 
                       $childColNameId, 
                       $parentColNameId){
global $xoopsDB;

  
  //$tCols = $this->getColsArray(_HER_TFN_DECOPP, 'idDecopp');
  $tCols = getColsArray($childTable, $childColNameId);  
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

  return true;

}

?>
