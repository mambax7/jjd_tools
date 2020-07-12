

CREATE TABLE `jjd_versions` (
  `idVersion` bigint(20) NOT NULL auto_increment,
  `module` varchar(50) default NULL,
  `code` varchar(50) default NULL,
  `version` varchar(12) default NULL,
  `dateVersion` datetime default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`idVersion`)
) TYPE=MyISAM ;

INSERT INTO `jjd_versions` ( `module`, `code`, `version`, `dateVersion`, `libelle`) 
VALUES('jjd_tools', 'jjd_2_10.php', '2.10', '2008-02-08 12:12:12', 'creation de la table version en vue des mise a jour');

INSERT INTO `jjd_versions` ( `module`, `code`, `version`, `dateVersion`, `libelle`) 
VALUES('jjd_tools', 'jjd_2_20.php', '1.00', '2008-12-02 12:12:12', 'creation des tables pour les objets notations');


CREATE TABLE `jjd_notedef` (
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
) TYPE=MyISAM;


CREATE TABLE `jjd_notation` (
        `idNotation` bigint(12) unsigned NOT NULL auto_increment,
        `idModule` bigint(20) NOT NULL default '0',        
        `name` varchar(30) NOT NULL,  
        `idParent` bigint(12) unsigned NOT NULL default '0',  
        `idChild`  bigint(12) unsigned NOT NULL default '0',          
        `noteCount` int(10) unsigned default '0',
        `noteSum` int(10) unsigned default '0',
        `noteAverage` float default '0',
  PRIMARY KEY  (`idNotation`)
) TYPE=MyISAM;

CREATE TABLE `jjd_glink` (
  `idGlink` bigint(12) unsigned NOT NULL auto_increment,
  `idModule` bigint(20) NOT NULL default '0',          
  `idGroup` bigint(20) NOT NULL default '0',
  `idSource` bigint(20) default NULL,
  `name` varchar(30) default NULL,  
  `value` TINYINT NOT NULL DEFAULT '0',      
   PRIMARY KEY  (`idGlink`)
) TYPE=MyISAM;
