-- -------------------------------------------
SET AUTOCOMMIT=0;
START TRANSACTION;
SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------
-- -------------------------------------------
-- START BACKUP
-- -------------------------------------------
-- -------------------------------------------
-- TABLE `_sequence`
-- -------------------------------------------
DROP TABLE IF EXISTS `_sequence`;
CREATE TABLE IF NOT EXISTS `_sequence` (
  `seq_name` varchar(50) NOT NULL,
  `seq_type` enum('I','O') NOT NULL,
  `seq_group` varchar(5) NOT NULL,
  `seq_year` varchar(2) NOT NULL,
  `seq_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`seq_name`,`seq_type`,`seq_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_application_email`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_application_email`;
CREATE TABLE IF NOT EXISTS `appform_application_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_form_id` int(11) NOT NULL,
  `application_step_id` int(11) NOT NULL,
  `email_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_appform_application_email_appform_application_form1_idx` (`application_form_id`),
  KEY `fk_appform_application_email_appform_application_step1_idx` (`application_step_id`),
  CONSTRAINT `fk_appform_application_email_appform_application_form1` FOREIGN KEY (`application_form_id`) REFERENCES `appform_application_form` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_application_email_appform_application_step1` FOREIGN KEY (`application_step_id`) REFERENCES `appform_application_step` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_application_form`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_application_form`;
CREATE TABLE IF NOT EXISTS `appform_application_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_type_id` int(11) NOT NULL,
  `inc_document_id` int(11) NOT NULL,
  `investor_region_id` int(11) NOT NULL,
  `contact_email` varchar(60) NOT NULL,
  `application_step_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inc_document_id_UNIQUE` (`inc_document_id`),
  KEY `fk_application_form_application_type1_idx` (`application_type_id`),
  KEY `fk_appform_application_form_appform_investor_region1_idx` (`investor_region_id`),
  KEY `fk_appform_application_form_appform_application_step1_idx` (`application_step_id`),
  CONSTRAINT `fk_appform_application_form_appform_application_step1` FOREIGN KEY (`application_step_id`) REFERENCES `appform_application_step` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_application_form_appform_investor_region1` FOREIGN KEY (`investor_region_id`) REFERENCES `appform_investor_region` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_application_form_application_type1` FOREIGN KEY (`application_type_id`) REFERENCES `appform_application_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=374 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_application_form_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_application_form_history`;
CREATE TABLE IF NOT EXISTS `appform_application_form_history` (
  `id` int(11) NOT NULL,
  `application_type_id` int(11) NOT NULL,
  `inc_document_id` int(11) NOT NULL,
  `investor_region_id` int(11) NOT NULL,
  `contact_email` varchar(60) NOT NULL,
  `application_step_id` int(11) NOT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  KEY `index1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_application_step`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_application_step`;
CREATE TABLE IF NOT EXISTS `appform_application_step` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step_description` varchar(100) NOT NULL,
  `email_notify` tinyint(4) NOT NULL COMMENT '1 notify, 0 not notify',
  `email_content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_application_type`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_application_type`;
CREATE TABLE IF NOT EXISTS `appform_application_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_business_sector`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_business_sector`;
CREATE TABLE IF NOT EXISTS `appform_business_sector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_district`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_district`;
CREATE TABLE IF NOT EXISTS `appform_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province_id` int(11) NOT NULL,
  `district_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_district_province1_idx` (`province_id`),
  KEY `in_district_name` (`district_name`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_id`) REFERENCES `appform_province` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_electric`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_electric`;
CREATE TABLE IF NOT EXISTS `appform_electric` (
  `application_form_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `mou` enum('0','1') NOT NULL DEFAULT '0',
  `develop_contract` enum('0','1') NOT NULL DEFAULT '0',
  `consession_contract` enum('0','1') NOT NULL DEFAULT '0',
  `province_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`application_form_id`),
  KEY `fk_appform_electric_appform_province1_idx` (`province_id`),
  KEY `fk_appform_electric_appform_district1_idx` (`district_id`),
  KEY `fk_appform_electric_appform_village1_idx` (`village_id`),
  CONSTRAINT `fk_appform_electric_appform_application_form1` FOREIGN KEY (`application_form_id`) REFERENCES `appform_application_form` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_electric_appform_district1` FOREIGN KEY (`district_id`) REFERENCES `appform_district` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appform_electric_appform_province1` FOREIGN KEY (`province_id`) REFERENCES `appform_province` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appform_electric_appform_village1` FOREIGN KEY (`village_id`) REFERENCES `appform_village` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_electric_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_electric_history`;
CREATE TABLE IF NOT EXISTS `appform_electric_history` (
  `application_form_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `mou` enum('0','1') NOT NULL DEFAULT '0',
  `develop_contract` enum('0','1') NOT NULL DEFAULT '0',
  `consession_contract` enum('0','1') NOT NULL DEFAULT '0',
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime DEFAULT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  KEY `index1` (`application_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_electric_project_site`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_electric_project_site`;
CREATE TABLE IF NOT EXISTS `appform_electric_project_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `electric_application_form_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_appform_electric_project_site_appform_province1_idx` (`province_id`),
  KEY `fk_appform_electric_project_site_appform_district1_idx` (`district_id`),
  KEY `fk_appform_electric_project_site_appform_electric1_idx` (`electric_application_form_id`),
  CONSTRAINT `fk_appform_electric_project_site_appform_district1` FOREIGN KEY (`district_id`) REFERENCES `appform_district` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_electric_project_site_appform_electric1` FOREIGN KEY (`electric_application_form_id`) REFERENCES `appform_electric` (`application_form_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_electric_project_site_appform_province1` FOREIGN KEY (`province_id`) REFERENCES `appform_province` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_electric_project_site_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_electric_project_site_history`;
CREATE TABLE IF NOT EXISTS `appform_electric_project_site_history` (
  `id` int(11) NOT NULL,
  `electric_application_form_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  KEY `index1` (`id`),
  KEY `index2` (`electric_application_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_general`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_general`;
CREATE TABLE IF NOT EXISTS `appform_general` (
  `application_form_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `mou` enum('0','1') NOT NULL DEFAULT '0',
  `develop_contract` enum('0','1') NOT NULL DEFAULT '0',
  `consession_contract` enum('0','1') NOT NULL DEFAULT '0',
  `business_sector_id` int(11) NOT NULL,
  `province_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`application_form_id`),
  KEY `fk_appform_general_appform_application_form1_idx` (`application_form_id`),
  KEY `fk_appform_general_appform_business_sector1_idx` (`business_sector_id`),
  KEY `fk_appform_general_appform_province1_idx` (`province_id`),
  KEY `fk_appform_general_appform_district1_idx` (`district_id`),
  KEY `fk_appform_general_appform_village1_idx` (`village_id`),
  CONSTRAINT `fk_appform_general_appform_application_form1` FOREIGN KEY (`application_form_id`) REFERENCES `appform_application_form` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_general_appform_business_sector1` FOREIGN KEY (`business_sector_id`) REFERENCES `appform_business_sector` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_general_appform_district1` FOREIGN KEY (`district_id`) REFERENCES `appform_district` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appform_general_appform_province1` FOREIGN KEY (`province_id`) REFERENCES `appform_province` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appform_general_appform_village1` FOREIGN KEY (`village_id`) REFERENCES `appform_village` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_general_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_general_history`;
CREATE TABLE IF NOT EXISTS `appform_general_history` (
  `application_form_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `mou` enum('0','1') NOT NULL DEFAULT '0',
  `develop_contract` enum('0','1') NOT NULL DEFAULT '0',
  `consession_contract` enum('0','1') NOT NULL DEFAULT '0',
  `business_sector_id` int(11) NOT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  `province_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  KEY `index1` (`application_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_general_project_site`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_general_project_site`;
CREATE TABLE IF NOT EXISTS `appform_general_project_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `general_application_form_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_appform_general_project_site_appform_province1_idx` (`province_id`),
  KEY `fk_appform_general_project_site_appform_district1_idx` (`district_id`),
  KEY `fk_appform_general_project_site_appform_general1_idx` (`general_application_form_id`),
  CONSTRAINT `fk_appform_general_project_site_appform_district1` FOREIGN KEY (`district_id`) REFERENCES `appform_district` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_general_project_site_appform_general1` FOREIGN KEY (`general_application_form_id`) REFERENCES `appform_general` (`application_form_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_general_project_site_appform_province1` FOREIGN KEY (`province_id`) REFERENCES `appform_province` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_general_project_site_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_general_project_site_history`;
CREATE TABLE IF NOT EXISTS `appform_general_project_site_history` (
  `id` int(11) NOT NULL,
  `general_application_form_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  KEY `index1` (`id`),
  KEY `index2` (`general_application_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_invest_company`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_invest_company`;
CREATE TABLE IF NOT EXISTS `appform_invest_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_form_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `register_place` varchar(255) NOT NULL,
  `register_date` date NOT NULL,
  `total_capital` int(11) NOT NULL,
  `capital` int(11) NOT NULL,
  `president_first_name` varchar(255) NOT NULL,
  `president_last_name` varchar(255) NOT NULL,
  `president_nationality` varchar(255) NOT NULL,
  `president_position` varchar(255) NOT NULL,
  `headquarter_address` varchar(255) NOT NULL,
  `business_sector_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index2` (`company_name`),
  KEY `fk_appform_invest_company_appform_application_form1_idx` (`application_form_id`),
  KEY `fk_appform_invest_company_appform_business_sector1_idx` (`business_sector_id`),
  CONSTRAINT `fk_appform_invest_company_appform_application_form1` FOREIGN KEY (`application_form_id`) REFERENCES `appform_application_form` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_invest_company_appform_business_sector1` FOREIGN KEY (`business_sector_id`) REFERENCES `appform_business_sector` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_invest_company_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_invest_company_history`;
CREATE TABLE IF NOT EXISTS `appform_invest_company_history` (
  `id` int(11) NOT NULL,
  `application_form_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `register_place` varchar(255) NOT NULL,
  `register_date` date NOT NULL,
  `total_capital` int(11) NOT NULL,
  `capital` int(11) NOT NULL,
  `president_first_name` varchar(255) NOT NULL,
  `president_last_name` varchar(255) NOT NULL,
  `president_nationality` varchar(255) NOT NULL,
  `president_position` varchar(255) NOT NULL,
  `headquarter_address` varchar(255) NOT NULL,
  `business_sector_id` int(11) NOT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  KEY `index1` (`id`),
  KEY `index2` (`application_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_investor_region`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_investor_region`;
CREATE TABLE IF NOT EXISTS `appform_investor_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_mining`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_mining`;
CREATE TABLE IF NOT EXISTS `appform_mining` (
  `application_form_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `objective` varchar(255) NOT NULL,
  `total_capital` int(11) NOT NULL,
  `capital` int(11) NOT NULL,
  `fixed_asset` int(11) NOT NULL,
  `current_asset` int(11) NOT NULL,
  `province_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`application_form_id`),
  KEY `fk_appform_mining_appform_application_form1_idx` (`application_form_id`),
  KEY `fk_appform_mining_appform_province1_idx` (`province_id`),
  KEY `fk_appform_mining_appform_district1_idx` (`district_id`),
  KEY `fk_appform_mining_appform_village1_idx` (`village_id`),
  CONSTRAINT `fk_appform_mining_appform_application_form1` FOREIGN KEY (`application_form_id`) REFERENCES `appform_application_form` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_mining_appform_district1` FOREIGN KEY (`district_id`) REFERENCES `appform_district` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appform_mining_appform_province1` FOREIGN KEY (`province_id`) REFERENCES `appform_province` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appform_mining_appform_village1` FOREIGN KEY (`village_id`) REFERENCES `appform_village` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_mining_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_mining_history`;
CREATE TABLE IF NOT EXISTS `appform_mining_history` (
  `application_form_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `objective` varchar(255) NOT NULL,
  `total_capital` int(11) NOT NULL,
  `capital` int(11) NOT NULL,
  `fixed_asset` int(11) NOT NULL,
  `current_asset` int(11) NOT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  `province_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  KEY `index1` (`application_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_mining_project_site`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_mining_project_site`;
CREATE TABLE IF NOT EXISTS `appform_mining_project_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mining_application_form_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_appform_mining_project_site_appform_province1_idx` (`province_id`),
  KEY `fk_appform_mining_project_site_appform_district1_idx` (`district_id`),
  KEY `fk_appform_mining_project_site_appform_mining1_idx` (`mining_application_form_id`),
  CONSTRAINT `fk_appform_mining_project_site_appform_district1` FOREIGN KEY (`district_id`) REFERENCES `appform_district` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_mining_project_site_appform_mining1` FOREIGN KEY (`mining_application_form_id`) REFERENCES `appform_mining` (`application_form_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appform_mining_project_site_appform_province1` FOREIGN KEY (`province_id`) REFERENCES `appform_province` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_mining_project_site_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_mining_project_site_history`;
CREATE TABLE IF NOT EXISTS `appform_mining_project_site_history` (
  `id` int(11) NOT NULL,
  `mining_application_form_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  KEY `index1` (`id`),
  KEY `index2` (`mining_application_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_nationality`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_nationality`;
CREATE TABLE IF NOT EXISTS `appform_nationality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nationality_description` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nationality_description_UNIQUE` (`nationality_description`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_province`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_province`;
CREATE TABLE IF NOT EXISTS `appform_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `province_name_UNIQUE` (`province_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_rep_office`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_rep_office`;
CREATE TABLE IF NOT EXISTS `appform_rep_office` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_form_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `parent_company` varchar(255) NOT NULL,
  `register_place` varchar(255) NOT NULL,
  `business` text NOT NULL,
  `objective` text NOT NULL,
  `house_no` varchar(45) DEFAULT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `capital` int(11) NOT NULL,
  `fixed_asset` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `application_form_id_UNIQUE` (`application_form_id`),
  KEY `fk_representative_province1_idx` (`province_id`),
  KEY `fk_representative_district1_idx` (`district_id`),
  KEY `fk_rep_office_village1_idx` (`village_id`),
  KEY `fk_rep_office_application_form1_idx` (`application_form_id`),
  KEY `fk_appform_rep_office_appform_nationality1_idx` (`nationality_id`),
  CONSTRAINT `fk_appform_rep_office_appform_nationality1` FOREIGN KEY (`nationality_id`) REFERENCES `appform_nationality` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_representative_district1` FOREIGN KEY (`district_id`) REFERENCES `appform_district` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_representative_province1` FOREIGN KEY (`province_id`) REFERENCES `appform_province` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rep_office_application_form1` FOREIGN KEY (`application_form_id`) REFERENCES `appform_application_form` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rep_office_village1` FOREIGN KEY (`village_id`) REFERENCES `appform_village` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_rep_office_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_rep_office_history`;
CREATE TABLE IF NOT EXISTS `appform_rep_office_history` (
  `id` int(11) NOT NULL,
  `application_form_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `parent_company` varchar(255) NOT NULL,
  `register_place` varchar(255) NOT NULL,
  `business` text NOT NULL,
  `objective` text NOT NULL,
  `house_no` varchar(45) DEFAULT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `capital` int(11) NOT NULL,
  `fixed_asset` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  KEY `index1` (`id`),
  KEY `index2` (`application_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `appform_village`
-- -------------------------------------------
DROP TABLE IF EXISTS `appform_village`;
CREATE TABLE IF NOT EXISTS `appform_village` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `district_id` int(11) NOT NULL,
  `village_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_village_district1_idx` (`district_id`),
  KEY `in_village_name` (`village_name`),
  CONSTRAINT `fk_village_district1` FOREIGN KEY (`district_id`) REFERENCES `appform_district` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16449 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `assign`
-- -------------------------------------------
DROP TABLE IF EXISTS `assign`;
CREATE TABLE IF NOT EXISTS `assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inc_document_document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userdoc_UNIQUE` (`inc_document_document_id`,`user_id`),
  KEY `fk_assign_inc_document1_idx` (`inc_document_document_id`),
  KEY `fk_assign_user1_idx` (`user_id`),
  CONSTRAINT `fk_assign_inc_document1` FOREIGN KEY (`inc_document_document_id`) REFERENCES `inc_document` (`document_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_assign_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20451 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `assignments`
-- -------------------------------------------
DROP TABLE IF EXISTS `assignments`;
CREATE TABLE IF NOT EXISTS `assignments` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `attach_file`
-- -------------------------------------------
DROP TABLE IF EXISTS `attach_file`;
CREATE TABLE IF NOT EXISTS `attach_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `file_name` varchar(60) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_name_UNIQUE` (`file_name`),
  KEY `fk_attach_files_document1_idx` (`document_id`),
  CONSTRAINT `fk_attach_files_document1` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `caisse`
-- -------------------------------------------
DROP TABLE IF EXISTS `caisse`;
CREATE TABLE IF NOT EXISTS `caisse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inc_document_id` int(11) NOT NULL,
  `amount_to_budget` int(11) NOT NULL DEFAULT '0',
  `amount_to_department` int(11) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_status` tinyint(4) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inc_document_id_UNIQUE` (`inc_document_id`),
  KEY `fk_caisse_inc_document1_idx` (`inc_document_id`),
  KEY `fk_caisse_user1_idx` (`user_id`),
  CONSTRAINT `fk_caisse_inc_document1` FOREIGN KEY (`inc_document_id`) REFERENCES `inc_document` (`document_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_caisse_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `comment`
-- -------------------------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_detail` text NOT NULL,
  `comment_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comment_document1_idx` (`document_id`),
  KEY `fk_comment_user1_idx` (`user_id`),
  CONSTRAINT `fk_comment_document1` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2414 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `comment_to_user`
-- -------------------------------------------
DROP TABLE IF EXISTS `comment_to_user`;
CREATE TABLE IF NOT EXISTS `comment_to_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('Unread','Read') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comment_to_user_comment1_idx` (`comment_id`),
  KEY `fk_comment_to_user_user1_idx` (`user_id`),
  CONSTRAINT `fk_comment_to_user_comment1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_to_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `doc_multi_relate`
-- -------------------------------------------
DROP TABLE IF EXISTS `doc_multi_relate`;
CREATE TABLE IF NOT EXISTS `doc_multi_relate` (
  `doc_id` int(11) NOT NULL,
  `doc_related_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `document`
-- -------------------------------------------
DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `in_or_out` enum('INC','OUT') NOT NULL,
  `document_date` date NOT NULL,
  `document_title` text NOT NULL,
  `related_document_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_modified` datetime NOT NULL,
  `last_modified_id` int(11) NOT NULL,
  `detail` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_unique` (`id`,`in_or_out`),
  KEY `fk_document_user1_idx` (`created_by`),
  KEY `fk_document_document_type1_idx` (`document_type_id`),
  KEY `in_relate_id` (`related_document_id`),
  KEY `fk_document_user2_idx` (`last_modified_id`),
  CONSTRAINT `fk_document_document_type1` FOREIGN KEY (`document_type_id`) REFERENCES `document_type` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_document_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_document_user2` FOREIGN KEY (`last_modified_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=71606 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `document_receiver`
-- -------------------------------------------
DROP TABLE IF EXISTS `document_receiver`;
CREATE TABLE IF NOT EXISTS `document_receiver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `out_document_id` int(11) NOT NULL,
  `to_organization_id` int(11) NOT NULL,
  `document_status_id` int(11) NOT NULL,
  `status_date` datetime NOT NULL,
  `receiver_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_out_document_has_organization_organization1_idx` (`to_organization_id`),
  KEY `fk_out_document_has_organization_out_document1_idx` (`out_document_id`),
  KEY `fk_document_receiver_document_status1_idx` (`document_status_id`),
  CONSTRAINT `fk_organization_idx` FOREIGN KEY (`to_organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_out_document_has_organization_out_document1` FOREIGN KEY (`out_document_id`) REFERENCES `out_document` (`document_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_status_idx` FOREIGN KEY (`document_status_id`) REFERENCES `document_status` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29539 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `document_receiver_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `document_receiver_history`;
CREATE TABLE IF NOT EXISTS `document_receiver_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `out_document_id` int(11) NOT NULL,
  `to_organization_id` int(11) NOT NULL,
  `document_status_id` int(11) NOT NULL,
  `status_date` datetime NOT NULL,
  `receiver_name` varchar(255) DEFAULT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `in_out_document` (`out_document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=502 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `document_status`
-- -------------------------------------------
DROP TABLE IF EXISTS `document_status`;
CREATE TABLE IF NOT EXISTS `document_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_description` varchar(255) NOT NULL,
  `status_type` enum('INC','OUT') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_unique` (`status_type`,`status_description`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `document_type`
-- -------------------------------------------
DROP TABLE IF EXISTS `document_type`;
CREATE TABLE IF NOT EXISTS `document_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `type_level_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_document_type_type_level1_idx` (`type_level_id`),
  CONSTRAINT `fk_document_type_type_level1` FOREIGN KEY (`type_level_id`) REFERENCES `type_level` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `fee`
-- -------------------------------------------
DROP TABLE IF EXISTS `fee`;
CREATE TABLE IF NOT EXISTS `fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_description` varchar(45) DEFAULT NULL,
  `amount_to_budget` int(11) NOT NULL DEFAULT '0',
  `amount_to_department` int(11) NOT NULL DEFAULT '0',
  `fee_type` enum('ກີບ','ໂດລາ') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `from_to`
-- -------------------------------------------
DROP TABLE IF EXISTS `from_to`;
CREATE TABLE IF NOT EXISTS `from_to` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_organization_id` int(11) NOT NULL,
  `to_organization_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `from_to_unique` (`from_organization_id`,`to_organization_id`),
  KEY `fk_from_to_organization1_idx` (`from_organization_id`),
  KEY `fk_from_to_organization2_idx` (`to_organization_id`),
  CONSTRAINT `fk_from_to_organization1` FOREIGN KEY (`from_organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_from_to_organization2` FOREIGN KEY (`to_organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `fulltext_document`
-- -------------------------------------------
DROP TABLE IF EXISTS `fulltext_document`;
CREATE TABLE IF NOT EXISTS `fulltext_document` (
  `id` int(11) NOT NULL,
  `document_title` text NOT NULL,
  FULLTEXT KEY `text_index` (`document_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `inc_document`
-- -------------------------------------------
DROP TABLE IF EXISTS `inc_document`;
CREATE TABLE IF NOT EXISTS `inc_document` (
  `document_id` int(11) NOT NULL,
  `inc_document_no` char(17) NOT NULL,
  `is_application` enum('No','Yes') NOT NULL DEFAULT 'No',
  `sender` varchar(255) DEFAULT NULL,
  `sender_ref` varchar(60) DEFAULT NULL,
  `document_status_id` int(11) NOT NULL,
  `status_date` date NOT NULL,
  `from_organization_id` int(11) NOT NULL COMMENT 'Organization of sender',
  `to_organization_id` int(11) NOT NULL,
  `sender_contact` varchar(255) DEFAULT NULL,
  `fee_id` int(11) DEFAULT NULL,
  `office_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  UNIQUE KEY `inc_document_no_UNIQUE` (`inc_document_no`),
  KEY `fk_inc_document_document_status1_idx` (`document_status_id`),
  KEY `fk_inc_document_organization1_idx` (`from_organization_id`),
  KEY `fk_inc_document_organization2_idx` (`to_organization_id`),
  KEY `fk_inc_document_fee1_idx` (`fee_id`),
  CONSTRAINT `fk_inc_document_document1` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_inc_document_document_status1` FOREIGN KEY (`document_status_id`) REFERENCES `document_status` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_inc_document_fee1` FOREIGN KEY (`fee_id`) REFERENCES `fee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inc_document_organization1` FOREIGN KEY (`from_organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_inc_document_organization2` FOREIGN KEY (`to_organization_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `inc_document_history`
-- -------------------------------------------
DROP TABLE IF EXISTS `inc_document_history`;
CREATE TABLE IF NOT EXISTS `inc_document_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `inc_document_no` char(17) NOT NULL,
  `document_date` date NOT NULL,
  `document_title` text NOT NULL,
  `related_document_id` int(11) DEFAULT NULL,
  `from_organization_id` int(11) NOT NULL,
  `to_organization_id` int(11) NOT NULL,
  `document_status_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `application_type_id` int(11) DEFAULT NULL,
  `is_application` enum('No','Yest') NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `sender_ref` varchar(60) DEFAULT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_modified` datetime NOT NULL,
  `last_modified_id` int(11) NOT NULL,
  `user_action_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `in_document_id` (`document_id`),
  KEY `in_inc_document_no` (`inc_document_no`)
) ENGINE=InnoDB AUTO_INCREMENT=22968 DEFAULT CHARSET=utf8;

