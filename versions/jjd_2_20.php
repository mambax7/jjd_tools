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
class cls_jjd_2_20{  

/************************************************************
 * declaration des varaibles membre:
 ************************************************************/
  var $version      = '1.00';  
  var $dateVersion  = '2008-12-02 12:12:12'; //date("Y-m-d h:m:s");
  var $description  = 'creation des tables pour les objets notations';

/************************************************************
 * Constructucteur:
 ************************************************************/
  function  cls_jjd_2_20($options){
 
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
    
    $this->create_notedef();
    $this->create_notation();    
    $this->create_glink();
                      
    return true;
} // fin updtateModule

/*************************************************************************
 *
 *************************************************************************/
function create_notedef(){
global $xoopsModuleConfig, $xoopsDB;

  $table = $xoopsDB->prefix('jjd_notedef');
  echo "Creation de la table : {$table}<br>";
  
  $sql = " CREATE TABLE {$table} (
        `idNotedef` bigint(12) unsigned NOT NULL auto_increment,
        `name` varchar(30) NOT NULL,
        `description`  varchar(120) NOT NULL,
        `noteMin` int(10) unsigned default '0',
        `noteMax` int(10) unsigned default '0',
        `fontImg` varchar(120) default NULL,
        `curseurImg` varchar(120) NOT NULL,
        `curseurIndexImg0` Tinyint default 0,
        `curseurIndexImg1` Tinyint default 1,   
        PRIMARY KEY  (`idNotedef`)
      ) TYPE=MyISAM;";


  
  //echo "<hr>createNewTables<br>$sql<hr>";  
  $xoopsDB->queryF ($sql);

  //---------------------------------------------------  
  
  return true;   

   
} // fin 

/*************************************************************************
 *
 *************************************************************************/
function create_notation(){
global $xoopsModuleConfig, $xoopsDB;

  $table = $xoopsDB->prefix('jjd_notation');
  echo "Creation de la table : {$table}<br>";
  
  $sql = " CREATE TABLE {$table} (
        `idNotation` bigint(12) unsigned NOT NULL auto_increment,
        `idModule` bigint(20) NOT NULL default '0',        
        `name` varchar(30) NOT NULL,  
        `idParent` bigint(12) unsigned NOT NULL default '0',  
        `idChild`  bigint(12) unsigned NOT NULL default '0',          
        `noteCount` int(10) unsigned default '0',
        `noteSum` int(10) unsigned default '0',
        `noteAverage` float default '0',
        PRIMARY KEY  (`idNotation`)
      ) TYPE=MyISAM;";


  
  //echo "<hr>createNewTables<br>$sql<hr>";  
  $xoopsDB->queryF ($sql);

  //---------------------------------------------------  
  
  return true;   

   
} // fin 


/**************************************************************************
 *
 *************************************************************************/
function create_glink(){
global $xoopsModuleConfig, $xoopsDB;

  $table = $xoopsDB->prefix('jjd_glink');
  echo "Creation de la table : {$table}<br>";
  
  $sql = " CREATE TABLE {$table} (
        `idGlink` bigint(12) unsigned NOT NULL auto_increment,
        `idModule` bigint(20) NOT NULL default '0',          
        `idGroup` bigint(20) NOT NULL default '0',
        `idSource` bigint(20) default NULL,
        `name` varchar(30) default NULL,  
        `value` TINYINT NOT NULL DEFAULT '0',      
         PRIMARY KEY  (`idGlink`)
      ) TYPE=MyISAM;";


  
  //echo "<hr>createNewTables<br>$sql<hr>";  
  $xoopsDB->queryF ($sql);

  //---------------------------------------------------  
  
  return true;   

   
} // fin 


//-----------------------------------------------------------

} // fin de la classe

?>
 