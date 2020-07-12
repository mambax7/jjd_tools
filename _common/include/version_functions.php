<?php
//  ------------------------------------------------------------------------ //
//  ------------------------------------------------------------------------ //
/******************************************************************************

******************************************************************************/


// General settings
//include_once ("header.php");
global $xoopsModule;




/**********************************************************************
 *
 **********************************************************************/ 
//function xoops_module_update_xoopshack(&$module) {
function update_module (&$module) {
global $xoopsModuleConfig, $xoopsDB;
  
  //echo "<hr>xoops_module_update_jjd_tools -> creation de la table version<hr>";

  $moduleName = $module->getVar('dirname');
  $folder = XOOPS_ROOT_PATH."/modules/{$moduleName}/versions/";
  
  echo "<hr>Mise a jour du module : {$moduleName}<br>";
  //echo "dossier : {$folder}<br>";  
  
  
  //_JJD_ROOT_PATH."versions/";
  $files = getListPatch($folder);
  
  reset ($files);
  echo '<table>';
  foreach ($files as $fileName) {
  //for ($h = 0; $h < count($files); $h++) { 
   
    $fullName = $folder.$fileName;  
    //echo "mise à jour : {$fullName}<br>";    

    if (!is_readable($fullName)){ return'';}
    include_Once ($fullName);
    //$langFile = getLanguageFile($fulName);
    $tf = explode('/', $fullName);
    $tt = explode('.', $tf[count($tf)-1]);
    $nomClasse = 'cls_'.$tt[0];
    
    $options = array();
    $ob = new $nomClasse($options);    
    
    //echo "{$tt[0]} - {$ob->version} - {$ob->description}<br>";
    echo "<tr><td>{$tt[0]}</td><td>{$ob->version}</td><td>{$ob->description}</td></tr>";
    
    $r = $ob->updateModule($module);   
    if ($r){
      addPatch ($moduleName,$fileName, $ob->version, $ob->dateVersion, $ob->description);    
    }


   }
  
  echo '</table>';  
  //echo "nom de la classe : {$nomClasse}<hr>";  
  //$ob = new $nomClasse(array('lang' => $langFile, 'jjd' => 'J°J°D'), $mode);
  
  //echo 'nom de la classe : '.get_class($ob).'<hr>';    




    echo "<br>fin des mises à jour des tables du module : {$moduleName}<hr>";

  return true;  
  

}

/**********************************************************************
 *
 **********************************************************************/
function getListPatch($sFolder){
global $xoopsModuleConfig, $xoopsDB;  
  
  //echo"<hr>{$sFolder}<br>";
  
  $sql = "SELECT code,version FROM ".$xoopsDB->prefix('jjd_versions')
        ." ORDER BY version";
  $sqlquery = $xoopsDB->queryF ($sql);   
  
  $t = array();     
  while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
    $t[$sqlfetch['code']] = $sqlfetch;  
  }
  //----------------------------------------------------------
  $tPatch = array();
  $files = glob($sFolder."*.php");
  
  foreach ($files as $filename) {
    $p = basename ($filename);
    //echo "Fichier - >{$p} => {$filename}<br>";
    if (! isset($t[$p])){
      $tPatch[] = $p;  
      //echo "patch = > $p<br>";        
    }
    


  
  } 
  
  //echo"<hr>";
  return $tPatch;


}// getListpatch

/*************************************************************************
 *
 *************************************************************************/
function addPatch($moduleName,$fileName, $version, $dateVersion, $libelle){
global $xoopsModuleConfig, $xoopsDB;

  //$dateVersion = date("Y-m-d h:m:s");
  //$dateVersion = date("Y-m-d h:m:s");
  $libelle = str_replace("'", "''", $libelle);
  
    
  $sql = "INSERT INTO ".$xoopsDB->prefix('jjd_versions')
       ."(module, code,version,dateVersion,libelle)"
        ." VALUES ("
        ."'{$moduleName}','{$fileName}','{$version}','{$dateVersion}','{$libelle}'"
        .")";  
  $xoopsDB->queryF ($sql);
    
  //------------------------------------------- 
  return true;   
   
}//fin updateContentTable
 
 
/*************************************************************************
 *
 *************************************************************************/
function kill_Module(&$module){
global $xoopsModuleConfig, $xoopsDB;

  $moduleName = $module->getVar('dirname');
     
  $sql = "DELETE FROM ".$xoopsDB->prefix('jjd_versions')
       ." WHERE module = '{$moduleName}'";  
  $xoopsDB->queryF ($sql);
    
  //------------------------------------------- 
  return true;   
   
}//fin updateContentTable
 
/*************************************************************************
 *
 *************************************************************************/
function compareVersion($versionModule, $versionPatch){
  $tvm = explode('.', $versionModule.'.0.0.0');
  $tvp = explode('.', $versionPatch.'.0.0.0');  
  
  for ($h = 0; $h < 3; $h++){
    if ($tvm[$h] > $tvp[$h] ){
      return +1;
    }elseif($tvm[$h] < $tvp[$h] ){
      return -1;
    }
  
  }
  return 0;
  //---------------------------------------------------
}

?>

