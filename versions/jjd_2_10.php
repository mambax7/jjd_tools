<?php
//  ------------------------------------------------------------------------ //
//       HERMES - Module de gestion de lettre de diffusion pour XOOPS        //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

Module HERMES version 1.1.1pour XOOPS- Gestion de lettre de diffusion 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique Générale GNU publiée par la Free Software Foundation (version 2 ou bien toute autre version ultérieure choisie par vous). 

Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU pour plus de détails. 

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

Créeation juin 2007
Dernière modification : septembre 2007 
******************************************************************************/

//rappel le nom de la classe doit porter le nom du fichier
class cls_jjd_2_10{  

/************************************************************
 * declaration des varaibles membre:
 ************************************************************/
  var $version      = '2.10';  
  var $dateVersion  = '2008-02-08 12:12:12'; //date("Y-m-d h:m:s");
  var $description  = 'creation de la table version en vue des mise a jour';

/************************************************************
 * Constructucteur:
 ************************************************************/
  function  cls_jjd_2_10($options){
 
  }
  
/*************************************************************************
 *
 *************************************************************************/
function getVersion()     {return $this->version;}
function getDateVersion() {return $this->dateVersion;}
function getDescription() {return $this->description;}


/*************************************************************************
 *
 *************************************************************************/

function updateModule(&$module){
    
    $this->createNewTables();
    $this->updateContentTables();    
                  
    return true;
} // fin updtateModule

/*************************************************************************
 *
 *************************************************************************/
function createNewTables(){
global $xoopsModuleConfig, $xoopsDB;

  $table = $xoopsDB->prefix('jjd_versions');
  echo "Creation de la table : {$table}<br>";
  
  $sql = "
CREATE TABLE {$table} (
  idVersion BIGINT NOT NULL AUTO_INCREMENT,
  module VARCHAR(50) NULL,
  code VARCHAR(50) NULL,
  version VARCHAR(12) NULL,
  dateVersion DATETIME NULL,
  libelle VARCHAR(255) NULL,
  PRIMARY KEY(idVersion)
  ) ENGINE=MyISAM ;";
  
  
  echo "<hr>createNewTables<br>$sql<hr>";  
  $xoopsDB->queryF ($sql);

  //---------------------------------------------------  
  
  return true;   

   
} // fin createNewTables

/*************************************************************************
 *
 *************************************************************************/
function updateContentTables(){
global $xoopsModuleConfig, $xoopsDB;


/*

  $dateVersion= date("Y-m-d h:m:s");

  $sql = "INSERT INTO ".$xoopsDB->prefix('jjd_versions')
       ."(module,code,version,dateVersion,libelle)"
        ." VALUES ("
        ."'jjd_tools','her_2.10.php','2.10','{$dateVersion}','Création de la table version'"
        .")";  
  $xoopsDB->queryF ($sql);
*/    
  //------------------------------------------- 
  return true;   
   
}//fin updateContentTable
//-----------------------------------------------------------

} // fin de la classe

?>
