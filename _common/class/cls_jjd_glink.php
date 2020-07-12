<?php
//  ------------------------------------------------------------------------ //
//       JJD -          //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

******************************************************************************/

$f = XOOPS_ROOT_PATH."/modules/jjd_tools/include/jjd_constantes.php";
//echo "<hr>->{$f}<hr>";
include_once(XOOPS_ROOT_PATH."/modules/jjd_tools/include/jjd_constantes.php");
            
class cls_jjd_glink {  

/************************************************************
 * declaration des variables membre:
 ************************************************************/
  var $idModule    = 0;

/************************************************************
 * Constructucteur:
 ************************************************************/
function  cls_jjd_glink($idModule = 0){

  //if (is_readable($options['lang'])) include_once($options['lang']);
  $this->idModule = $idModule;
  //$this->init($table, $colNameId, $becho);                                              
  echo "<hr>cls_jjd_glinks : idModule={$idModule}<hr>";
  return true;
  
}
/************************************************************
 * 
 ************************************************************/
function  getIdModule(){
  return $this->idModule ;
}
/************************************************************
 * 
 ************************************************************/
function  setIdmodule($idModule){
  return $this->idModule = $idModule;
}
  
//-------------------------------------------
/****************************************************************************
 * retoutne un tableau constitué uniquement les groupes d'utilisateurs ayant l'acces
 ****************************************************************************/
function getGlinksOk($idModule, $idSource, $name = ''){
global $xoopsModuleConfig, $xoopsDB;
	
  $sql = "SELECT * FROM "._JJD_TFN_GLINK
        ." WHERE idModule = {$idModule}"
        . " AND idSource = {$idSource}"
        . " AND name = '{$name}'"
        . " AND value > 0";
    $sqlquery = $xoopsDB->queryF ($sql);
    //echo "<hr>getGlinks2<br>{$sql}<hr>";
    $groups = array();
    
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
        $k = "k-{$sqlfetch['idGroup']}";
        $groups[$k]['value'] = 1;
        $groups[$k]['idGroup'] = $sqlfetch['idGroup'] ;      
    }
    
    return $groups;
}

/****************************************************************************
 * retoutne un tableau constitué uniquement les groupes d'utilisateurs ayant l'acces
 ****************************************************************************/
function getUsersForMail($idModule, $idSource, $name = ''){
global $xoopsModuleConfig, $xoopsDB;
    
  $tu = $xoopsDB->prefix('users');	
  $tl = $xoopsDB->prefix('groups_users_link');
  
  $sql = "SELECT tu.* FROM "._JJD_TFN_GLINK." AS tg, {$tu} AS tu, {$tl} AS tl "
        ." WHERE tu.uid = tl.uid "
        ."   AND tl.groupid = tg.idGroup"
        ."   AND tg.idModule = {$idModule}"
        ."   AND tg.idSource = {$idSource}"
        ."   AND tg.name = '{$name}'"
        ."   AND tg.value > 0 "
        ."   AND tu.user_mailok = 1";
    $sqlquery = $xoopsDB->queryF ($sql);
    //echo "<hr>getGlinks2<br>{$sql}<hr>";
    $tr = array();
    
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
        $k = "k-{$sqlfetch['uid']}";
        $tr[$k] = $sqlfetch;
           
    }

    //displayArray($tr, "---getUsersForMail--module={$idModule}---------------------");    
    return $tr;
}


/****************************************************************************
 * retoutne tous les groupes d'utilisateurs avec et les acces
 ****************************************************************************/
function loadGlinks($idModule, $idSource, $name = ''){
global $xoopsModuleConfig, $xoopsDB;
	
  $groups = cls_jjd_glink::getListGroupes();
  
  $t = cls_jjd_glink::getGlinksOk($idModule, $idSource, $name);
  while (list($key, $item) = each ($t)){
       $groups["k-{$item['idGroup']}"]['value'] = 1;
    }

    return $groups;
}

/****************************************************************************
 * sauvegarde tous les groupes d'utilisateurs avec et les acces
 ****************************************************************************/
function saveGlinks($idModule, $idSource, $name = '', $tGroups){
global $xoopsModuleConfig, $xoopsDB;

 $sql = "DELETE FROM "._JJD_TFN_GLINK
         ." WHERE idModule = {$idModule}"
         ." AND $idSource = {$idSource}"
         ." AND name = '{$name}'";
  $xoopsDB->query($sql);         
  
  if (count($tGroups) > 0){
    while (list($key, $t) = each($tGroups)){
        if (isset($t['value'])){
          $sql = "INSERT INTO "._JJD_TFN_GLINK
               ." (idModule, idSource, name, idGroup, value)"
               ." VALUES ({$idModule},{$idSource},'{$name}',{$t['id']},1)";
      $xoopsDB->query($sql);
        } 
    }
  }  
  //-------------------------------------------------------
  // fin enregistrement des groupes
  //-------------------------------------------------------  

}


/****************************************************************************
 * getListGroupes
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


/****************************************************************************
 *
 ****************************************************************************/
function getListGroupesID($idModule){
global $xoopsModule;
//global XoopsModule;
include_once (XOOPS_ROOT_PATH."/class/xoopsmodule.php");

//$module_handler =& xoops_gethandler('module');
//$module =& $module_handler->getByDirname($modversion['dirname']);
	$module = XoopsModule::get($idModule);
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






} // fin de la classe
?>



