-- phpMyAdmin SQL Dump
-- version 2.7.0-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 01, 2009 at 04:33 PM
-- Server version: 5.0.18
-- PHP Version: 5.1.1
-- 
-- Database: `apdm`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_ccs`
-- 

DROP TABLE IF EXISTS `apdm_ccs`;
CREATE TABLE IF NOT EXISTS `apdm_ccs` (
  `ccs_id` int(11) NOT NULL auto_increment,
  `ccs_code` char(10) NOT NULL,
  `ccs_description` text NOT NULL,
  `ccs_activate` tinyint(1) NOT NULL default '0',
  `ccs_create` datetime NOT NULL,
  `ccs_create_by` int(11) NOT NULL,
  `ccs_modified` datetime NOT NULL,
  `ccs_modified_by` int(11) NOT NULL,
  `ccs_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ccs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `apdm_ccs`
-- 

INSERT INTO `apdm_ccs` VALUES (1, 'XXX', 'ert dtgdf dfgdf dds sdfsd dsf', 0, '2009-01-11 10:09:54', 76, '2009-01-11 10:09:54', 76, 0);
INSERT INTO `apdm_ccs` VALUES (7, '123', 'test fgfdgfd gfhfghgf', 0, '2009-02-12 16:33:20', 64, '2009-03-01 07:25:42', 62, 1);
INSERT INTO `apdm_ccs` VALUES (5, 'BBB', 'gdf dfgdfg dfgdf dfgdf', 0, '2009-01-11 06:35:11', 76, '2009-01-11 06:35:11', 76, 0);
INSERT INTO `apdm_ccs` VALUES (8, '124', '124 description', 0, '2009-02-09 16:04:20', 64, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `apdm_ccs` VALUES (9, '126', '126 description', 0, '2009-02-09 16:04:32', 64, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `apdm_ccs` VALUES (10, '144', 'dsfsdf', 0, '2009-02-12 16:31:37', 64, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_component`
-- 

DROP TABLE IF EXISTS `apdm_component`;
CREATE TABLE IF NOT EXISTS `apdm_component` (
  `component_id` tinyint(1) NOT NULL auto_increment,
  `component_name` varchar(200) NOT NULL,
  PRIMARY KEY  (`component_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `apdm_component`
-- 

INSERT INTO `apdm_component` VALUES (1, 'Commodity Code');
INSERT INTO `apdm_component` VALUES (2, 'Vendor');
INSERT INTO `apdm_component` VALUES (3, 'Supplier');
INSERT INTO `apdm_component` VALUES (4, 'Manufacture');
INSERT INTO `apdm_component` VALUES (5, 'ECO');
INSERT INTO `apdm_component` VALUES (6, 'Part Number');

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_eco`
-- 

DROP TABLE IF EXISTS `apdm_eco`;
CREATE TABLE IF NOT EXISTS `apdm_eco` (
  `eco_id` int(11) NOT NULL auto_increment,
  `eco_name` varchar(200) NOT NULL,
  `eco_pdf` varchar(255) default NULL,
  `eco_description` text,
  `eco_status` tinyint(1) NOT NULL default '0',
  `eco_create` datetime NOT NULL,
  `eco_create_by` int(11) NOT NULL,
  `eco_modified` datetime NOT NULL,
  `eco_modified_by` int(11) NOT NULL default '0',
  `eco_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`eco_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `apdm_eco`
-- 

INSERT INTO `apdm_eco` VALUES (3, 'eco _name 2', NULL, 'dfgdfg', 0, '2009-02-23 17:31:00', 62, '2009-03-01 08:04:53', 62, 0);
INSERT INTO `apdm_eco` VALUES (6, 'account edit 1', 'accout_edit.pdf', 'Description', 0, '2009-02-25 17:21:32', 62, '2009-03-01 08:04:53', 62, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_manufacture`
-- 

DROP TABLE IF EXISTS `apdm_manufacture`;
CREATE TABLE IF NOT EXISTS `apdm_manufacture` (
  `manufacture_id` int(11) NOT NULL auto_increment,
  `manufacture_name` varchar(200) NOT NULL,
  `manufacture_address` varchar(255) default NULL,
  `manufacture_tel_fax` varchar(100) default NULL,
  `manufacture_website` varchar(255) default NULL,
  `manufacture_contractor` varchar(100) default NULL,
  `manufacture_email` varchar(255) default NULL,
  `manufacture_description` text,
  `manufacture_activate` tinyint(1) NOT NULL default '0',
  `manufacture_create` datetime NOT NULL,
  `manufacture_create_by` int(11) NOT NULL,
  `manufacture_modified` datetime NOT NULL,
  `manufacture_modified_by` int(11) NOT NULL,
  `manufacture_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`manufacture_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `apdm_manufacture`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_pn_cad`
-- 

DROP TABLE IF EXISTS `apdm_pn_cad`;
CREATE TABLE IF NOT EXISTS `apdm_pn_cad` (
  `pns_cad_id` int(11) NOT NULL auto_increment,
  `pns_id` int(11) NOT NULL,
  `cad_file` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `created_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pns_cad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `apdm_pn_cad`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_pns`
-- 

DROP TABLE IF EXISTS `apdm_pns`;
CREATE TABLE IF NOT EXISTS `apdm_pns` (
  `pns_id` int(11) NOT NULL auto_increment,
  `ccs_id` int(11) NOT NULL,
  `pns_code` varchar(13) NOT NULL,
  `pns_revision` varchar(3) NOT NULL,
  `pns_parent` varchar(13) NOT NULL,
  `eco_id` int(11) NOT NULL default '0',
  `pns_type` varchar(50) default NULL,
  `manufacture_id` int(11) NOT NULL default '0',
  `pns_status` tinyint(1) NOT NULL default '0',
  `pns_pdf` varchar(255) default NULL,
  `pns_image` varchar(255) default NULL,
  `pns_description` text,
  `pns_create` datetime NOT NULL,
  `pns_create_by` int(11) NOT NULL default '0',
  `pns_modified` datetime NOT NULL,
  `pns_modified_by` int(11) NOT NULL default '0',
  `pns_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`pns_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `apdm_pns`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_pns_supplier`
-- 

DROP TABLE IF EXISTS `apdm_pns_supplier`;
CREATE TABLE IF NOT EXISTS `apdm_pns_supplier` (
  `pns_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `apdm_pns_supplier`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_pns_vendor`
-- 

DROP TABLE IF EXISTS `apdm_pns_vendor`;
CREATE TABLE IF NOT EXISTS `apdm_pns_vendor` (
  `pns_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `apdm_pns_vendor`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_role`
-- 

DROP TABLE IF EXISTS `apdm_role`;
CREATE TABLE IF NOT EXISTS `apdm_role` (
  `role_id` int(11) NOT NULL auto_increment,
  `role_name` varchar(100) default NULL,
  `role_description` varchar(255) default NULL,
  `role_create` datetime NOT NULL,
  `role_create_by` int(11) NOT NULL default '0',
  `role_modified` datetime NOT NULL,
  `role_modified_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `apdm_role`
-- 

INSERT INTO `apdm_role` VALUES (7, 'role 2', 'This Role have full permission on all component. ', '2009-02-03 15:29:41', 64, '2009-02-03 15:29:41', 64);
INSERT INTO `apdm_role` VALUES (6, 'Role 1', 'Role 1 description', '2009-03-01 08:48:31', 76, '2009-03-01 08:48:31', 76);
INSERT INTO `apdm_role` VALUES (8, 'Role 3', 'This role management on Vendor, SUpplier, Manufacture.', '2009-03-01 08:48:46', 76, '2009-03-01 08:48:46', 76);
INSERT INTO `apdm_role` VALUES (9, 'Role management PNS', 'This role only management PNs', '2009-02-03 15:24:42', 64, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_role_component`
-- 

DROP TABLE IF EXISTS `apdm_role_component`;
CREATE TABLE IF NOT EXISTS `apdm_role_component` (
  `role_id` int(11) NOT NULL,
  `component_id` tinyint(1) NOT NULL,
  `role_value` char(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `apdm_role_component`
-- 

INSERT INTO `apdm_role_component` VALUES (7, 6, 'R');
INSERT INTO `apdm_role_component` VALUES (7, 6, 'D');
INSERT INTO `apdm_role_component` VALUES (7, 6, 'E');
INSERT INTO `apdm_role_component` VALUES (7, 6, 'W');
INSERT INTO `apdm_role_component` VALUES (7, 6, 'V');
INSERT INTO `apdm_role_component` VALUES (7, 5, 'R');
INSERT INTO `apdm_role_component` VALUES (7, 5, 'D');
INSERT INTO `apdm_role_component` VALUES (7, 5, 'E');
INSERT INTO `apdm_role_component` VALUES (7, 5, 'W');
INSERT INTO `apdm_role_component` VALUES (7, 5, 'V');
INSERT INTO `apdm_role_component` VALUES (7, 4, 'R');
INSERT INTO `apdm_role_component` VALUES (7, 4, 'D');
INSERT INTO `apdm_role_component` VALUES (7, 4, 'E');
INSERT INTO `apdm_role_component` VALUES (7, 4, 'W');
INSERT INTO `apdm_role_component` VALUES (7, 4, 'V');
INSERT INTO `apdm_role_component` VALUES (7, 3, 'R');
INSERT INTO `apdm_role_component` VALUES (7, 3, 'D');
INSERT INTO `apdm_role_component` VALUES (7, 3, 'E');
INSERT INTO `apdm_role_component` VALUES (7, 3, 'W');
INSERT INTO `apdm_role_component` VALUES (7, 3, 'V');
INSERT INTO `apdm_role_component` VALUES (7, 2, 'R');
INSERT INTO `apdm_role_component` VALUES (7, 2, 'D');
INSERT INTO `apdm_role_component` VALUES (7, 2, 'E');
INSERT INTO `apdm_role_component` VALUES (7, 2, 'W');
INSERT INTO `apdm_role_component` VALUES (7, 2, 'V');
INSERT INTO `apdm_role_component` VALUES (7, 1, 'R');
INSERT INTO `apdm_role_component` VALUES (7, 1, 'D');
INSERT INTO `apdm_role_component` VALUES (7, 1, 'E');
INSERT INTO `apdm_role_component` VALUES (7, 1, 'W');
INSERT INTO `apdm_role_component` VALUES (7, 1, 'V');
INSERT INTO `apdm_role_component` VALUES (6, 6, 'R');
INSERT INTO `apdm_role_component` VALUES (6, 6, 'D');
INSERT INTO `apdm_role_component` VALUES (6, 6, 'E');
INSERT INTO `apdm_role_component` VALUES (6, 6, 'W');
INSERT INTO `apdm_role_component` VALUES (6, 6, 'V');
INSERT INTO `apdm_role_component` VALUES (6, 5, 'V');
INSERT INTO `apdm_role_component` VALUES (6, 4, '0');
INSERT INTO `apdm_role_component` VALUES (6, 3, '0');
INSERT INTO `apdm_role_component` VALUES (6, 2, '0');
INSERT INTO `apdm_role_component` VALUES (6, 1, 'V');
INSERT INTO `apdm_role_component` VALUES (8, 6, 'V');
INSERT INTO `apdm_role_component` VALUES (8, 5, 'V');
INSERT INTO `apdm_role_component` VALUES (8, 4, 'V');
INSERT INTO `apdm_role_component` VALUES (8, 3, 'V');
INSERT INTO `apdm_role_component` VALUES (8, 2, 'V');
INSERT INTO `apdm_role_component` VALUES (8, 1, 'V');
INSERT INTO `apdm_role_component` VALUES (9, 6, 'V');
INSERT INTO `apdm_role_component` VALUES (9, 6, 'W');
INSERT INTO `apdm_role_component` VALUES (9, 6, 'E');
INSERT INTO `apdm_role_component` VALUES (9, 6, 'D');
INSERT INTO `apdm_role_component` VALUES (9, 6, 'R');

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_role_user`
-- 

DROP TABLE IF EXISTS `apdm_role_user`;
CREATE TABLE IF NOT EXISTS `apdm_role_user` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `apdm_role_user`
-- 

INSERT INTO `apdm_role_user` VALUES (74, 7);
INSERT INTO `apdm_role_user` VALUES (75, 8);

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_supplier`
-- 

DROP TABLE IF EXISTS `apdm_supplier`;
CREATE TABLE IF NOT EXISTS `apdm_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(200) NOT NULL,
  `supplier_address` varchar(200) default NULL,
  `supplier_tel_fax` varchar(100) default NULL,
  `supplier_website` varchar(255) default NULL,
  `supplier_contractor` varchar(100) default NULL,
  `supplier_email` varchar(255) default NULL,
  `supplier_description` text,
  `supplier_activate` tinyint(1) NOT NULL default '0',
  `supplier_create` datetime default NULL,
  `supplier_create_by` int(11) default NULL,
  `supplier_modified` datetime default NULL,
  `supplier_modified_by` int(11) default NULL,
  `supplier_deleted` tinyint(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `apdm_supplier`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_supplier_info`
-- 

DROP TABLE IF EXISTS `apdm_supplier_info`;
CREATE TABLE IF NOT EXISTS `apdm_supplier_info` (
  `info_id` int(11) NOT NULL auto_increment,
  `info_type` tinyint(1) NOT NULL,
  `info_name` varchar(255) NOT NULL,
  `info_address` varchar(255) default NULL,
  `info_telfax` varchar(100) default NULL,
  `info_website` varchar(255) default NULL,
  `info_contactperson` varchar(100) default NULL,
  `info_email` varchar(255) default NULL,
  `info_description` text NOT NULL,
  `info_activate` tinyint(1) NOT NULL default '0',
  `info_deleted` tinyint(1) NOT NULL default '0',
  `info_create` datetime NOT NULL,
  `info_created_by` int(11) NOT NULL default '0',
  `info_modified_by` int(11) NOT NULL default '0',
  `info_modified` datetime NOT NULL,
  PRIMARY KEY  (`info_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `apdm_supplier_info`
-- 

INSERT INTO `apdm_supplier_info` VALUES (1, 2, 'Vendor 1', ' Address ', '456546', 'sdsadsa', 'sdsdsa', 'sdsada', 'sdasdas', 0, 0, '2009-02-19 17:07:21', 62, 62, '2009-02-23 15:38:36');
INSERT INTO `apdm_supplier_info` VALUES (2, 3, 'Supplier 1', 'Address ', '5654bgf', 'df', 'fd', 'sdsada', 'fsdfds', 0, 1, '2009-02-19 17:08:41', 62, 62, '2009-03-01 08:09:24');

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_user_history`
-- 

DROP TABLE IF EXISTS `apdm_user_history`;
CREATE TABLE IF NOT EXISTS `apdm_user_history` (
  `history_id` int(11) NOT NULL auto_increment,
  `history_date` datetime NOT NULL,
  `history_where` varchar(255) default NULL,
  `history_what` text,
  `history_todo_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

-- 
-- Dumping data for table `apdm_user_history`
-- 

INSERT INTO `apdm_user_history` VALUES (1, '2009-01-11 06:13:46', '1', 'W', 1, 76);
INSERT INTO `apdm_user_history` VALUES (2, '2009-01-11 06:23:25', '1', 'W', 2, 76);
INSERT INTO `apdm_user_history` VALUES (3, '2009-01-11 06:25:48', '1', 'W', 3, 76);
INSERT INTO `apdm_user_history` VALUES (8, '2009-01-11 09:05:24', '1', 'E', 2, 76);
INSERT INTO `apdm_user_history` VALUES (7, '2009-01-11 09:04:32', '1', 'D', 1, 76);
INSERT INTO `apdm_user_history` VALUES (6, '2009-01-11 06:35:11', '1', 'E', 5, 76);
INSERT INTO `apdm_user_history` VALUES (9, '2009-01-11 10:04:48', '1', 'R', 1, 76);
INSERT INTO `apdm_user_history` VALUES (10, '2009-01-11 10:08:50', '1', 'D', 1, 76);
INSERT INTO `apdm_user_history` VALUES (11, '2009-01-11 10:08:50', '1', 'D', 2, 76);
INSERT INTO `apdm_user_history` VALUES (12, '2009-01-11 10:09:10', '1', 'R', 1, 76);
INSERT INTO `apdm_user_history` VALUES (13, '2009-01-11 10:09:54', '1', 'E', 1, 76);
INSERT INTO `apdm_user_history` VALUES (14, '2009-02-09 15:55:34', '1', 'W', 6, 64);
INSERT INTO `apdm_user_history` VALUES (15, '2009-02-09 15:58:59', '1', 'E', 6, 64);
INSERT INTO `apdm_user_history` VALUES (16, '2009-02-09 15:59:53', '1', 'D', 6, 64);
INSERT INTO `apdm_user_history` VALUES (17, '2009-02-09 16:01:49', '1', 'W', 7, 64);
INSERT INTO `apdm_user_history` VALUES (18, '2009-02-09 16:04:07', '1', 'E', 7, 64);
INSERT INTO `apdm_user_history` VALUES (19, '2009-02-09 16:04:20', '1', 'W', 8, 64);
INSERT INTO `apdm_user_history` VALUES (20, '2009-02-09 16:04:32', '1', 'W', 9, 64);
INSERT INTO `apdm_user_history` VALUES (21, '2009-02-09 16:13:02', '1', 'E', 7, 64);
INSERT INTO `apdm_user_history` VALUES (22, '2009-02-09 16:13:06', '1', 'E', 7, 64);
INSERT INTO `apdm_user_history` VALUES (23, '2009-02-09 16:13:09', '1', 'E', 8, 64);
INSERT INTO `apdm_user_history` VALUES (24, '2009-02-09 16:13:11', '1', 'E', 8, 64);
INSERT INTO `apdm_user_history` VALUES (25, '2009-02-12 16:31:37', '1', 'W', 10, 64);
INSERT INTO `apdm_user_history` VALUES (26, '2009-02-12 16:32:05', '1', 'E', 7, 64);
INSERT INTO `apdm_user_history` VALUES (27, '2009-02-12 16:33:20', '1', 'E', 7, 64);
INSERT INTO `apdm_user_history` VALUES (28, '2009-02-19 17:07:21', '2', 'W', 1, 62);
INSERT INTO `apdm_user_history` VALUES (29, '2009-02-19 17:08:41', '3', 'W', 2, 62);
INSERT INTO `apdm_user_history` VALUES (30, '2009-02-19 17:45:22', '2', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (31, '2009-02-19 17:45:24', '2', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (32, '2009-02-19 17:45:27', '3', 'E', 2, 62);
INSERT INTO `apdm_user_history` VALUES (33, '2009-02-19 17:45:30', '2', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (34, '2009-02-19 17:45:42', '2', 'D', 1, 62);
INSERT INTO `apdm_user_history` VALUES (35, '2009-02-19 17:52:44', '2', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (36, '2009-02-19 17:52:46', '3', 'E', 2, 62);
INSERT INTO `apdm_user_history` VALUES (37, '2009-02-23 15:33:07', '3', 'E', 2, 62);
INSERT INTO `apdm_user_history` VALUES (38, '2009-02-23 15:38:03', '2', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (39, '2009-02-23 15:38:36', '2', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (40, '2009-02-23 15:38:39', '3', 'E', 2, 62);
INSERT INTO `apdm_user_history` VALUES (41, '2009-02-23 15:39:03', '3', 'W', 3, 62);
INSERT INTO `apdm_user_history` VALUES (42, '2009-02-23 15:39:51', '3', 'D', 3, 62);
INSERT INTO `apdm_user_history` VALUES (43, '2009-02-23 17:28:04', '5', 'W', 1, 62);
INSERT INTO `apdm_user_history` VALUES (44, '2009-02-23 17:30:39', '5', 'W', 2, 62);
INSERT INTO `apdm_user_history` VALUES (45, '2009-02-23 17:31:00', '5', 'W', 3, 62);
INSERT INTO `apdm_user_history` VALUES (46, '2009-02-23 17:32:11', '5', 'W', 4, 62);
INSERT INTO `apdm_user_history` VALUES (47, '2009-02-25 17:19:25', '5', 'W', 5, 62);
INSERT INTO `apdm_user_history` VALUES (48, '2009-02-25 17:20:06', '5', 'W', 6, 62);
INSERT INTO `apdm_user_history` VALUES (49, '2009-02-25 17:20:54', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (50, '2009-02-25 17:21:32', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (51, '2009-02-25 17:45:52', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (52, '2009-02-25 17:45:55', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (53, '2009-02-25 17:45:58', '5', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (54, '2009-02-25 17:46:30', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (55, '2009-02-25 17:48:09', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (56, '2009-02-25 17:48:40', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (57, '2009-02-25 17:49:52', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (58, '2009-02-25 17:50:20', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (59, '2009-02-25 17:50:23', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (60, '2009-02-25 17:50:25', '5', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (61, '2009-02-25 17:50:28', '5', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (62, '2009-02-25 17:50:29', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (63, '2009-02-25 17:52:57', '5', 'D', 2, 62);
INSERT INTO `apdm_user_history` VALUES (64, '2009-02-25 17:52:57', '5', 'D', 3, 62);
INSERT INTO `apdm_user_history` VALUES (65, '2009-02-25 17:53:38', '5', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (66, '2009-02-25 17:53:41', '5', 'E', 6, 62);
INSERT INTO `apdm_user_history` VALUES (67, '2009-02-26 16:58:52', '1', 'E', 7, 75);
INSERT INTO `apdm_user_history` VALUES (68, '2009-02-26 16:58:55', '1', 'E', 7, 75);
INSERT INTO `apdm_user_history` VALUES (69, '2009-03-01 05:02:55', '3', 'D', 2, 62);
INSERT INTO `apdm_user_history` VALUES (70, '2009-03-01 05:03:16', '5', 'D', 4, 62);
INSERT INTO `apdm_user_history` VALUES (71, '2009-03-01 07:25:28', '1', 'R', 6, 62);
INSERT INTO `apdm_user_history` VALUES (72, '2009-03-01 07:25:42', '1', 'D', 6, 62);
INSERT INTO `apdm_user_history` VALUES (73, '2009-03-01 07:25:42', '1', 'D', 7, 62);
INSERT INTO `apdm_user_history` VALUES (74, '2009-03-01 07:41:04', '3', 'R', 2, 62);
INSERT INTO `apdm_user_history` VALUES (75, '2009-03-01 07:41:17', '3', 'R', 2, 62);
INSERT INTO `apdm_user_history` VALUES (76, '2009-03-01 07:41:21', '3', 'R', 3, 62);
INSERT INTO `apdm_user_history` VALUES (77, '2009-03-01 07:41:57', '3', 'R', 2, 62);
INSERT INTO `apdm_user_history` VALUES (78, '2009-03-01 07:44:24', '3', 'R', 2, 62);
INSERT INTO `apdm_user_history` VALUES (79, '2009-03-01 07:51:26', '5', 'D', 1, 62);
INSERT INTO `apdm_user_history` VALUES (80, '2009-03-01 07:56:03', '5', 'D', 6, 62);
INSERT INTO `apdm_user_history` VALUES (81, '2009-03-01 08:04:53', '5', 'R', 6, 62);
INSERT INTO `apdm_user_history` VALUES (82, '2009-03-01 08:04:53', '5', 'R', 1, 62);
INSERT INTO `apdm_user_history` VALUES (83, '2009-03-01 08:04:53', '5', 'R', 2, 62);
INSERT INTO `apdm_user_history` VALUES (84, '2009-03-01 08:04:53', '5', 'R', 3, 62);
INSERT INTO `apdm_user_history` VALUES (85, '2009-03-01 08:05:56', '5', 'E', 1, 62);
INSERT INTO `apdm_user_history` VALUES (86, '2009-03-01 08:06:12', '5', 'E', 2, 62);
INSERT INTO `apdm_user_history` VALUES (87, '2009-03-01 08:06:23', '5', 'D', 1, 62);
INSERT INTO `apdm_user_history` VALUES (88, '2009-03-01 08:06:23', '5', 'D', 2, 62);
INSERT INTO `apdm_user_history` VALUES (89, '2009-03-01 08:09:24', '3', 'D', 2, 62);

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_users`
-- 

DROP TABLE IF EXISTS `apdm_users`;
CREATE TABLE IF NOT EXISTS `apdm_users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(100) NOT NULL,
  `user_lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_title` varchar(255) NOT NULL,
  `user_mobile` varchar(100) NOT NULL,
  `user_telephone` varchar(100) NOT NULL,
  `user_enable` tinyint(1) NOT NULL default '0',
  `user_group` tinyint(1) NOT NULL,
  `user_create` datetime NOT NULL,
  `user_create_by` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `apdm_users`
-- 

INSERT INTO `apdm_users` VALUES (74, 'Test1', '1', 'test@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', 'ttitle 2', '5656', '56765', 0, 23, '2009-01-07 18:21:40', 64);
INSERT INTO `apdm_users` VALUES (75, 'Test 2', '2', 'test2@yahoo.com', 'd41d8cd98f00b204e9800998ecf8427e', 'title 2', '123457', '12344', 0, 23, '2009-01-10 04:20:56', 76);
INSERT INTO `apdm_users` VALUES (76, 'apdm', '1', 'apdm@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', 'This ttitle of user', '4534', '21312', 0, 24, '2009-01-10 08:50:49', 62);
INSERT INTO `apdm_users` VALUES (77, 'Phuc', 'Le', 'phucle@yahoo.com', 'd41d8cd98f00b204e9800998ecf8427e', 'title of user phuc le', '', '', 0, 24, '2009-02-06 15:48:26', 64);

-- --------------------------------------------------------

-- 
-- Table structure for table `apdm_vendor`
-- 

DROP TABLE IF EXISTS `apdm_vendor`;
CREATE TABLE IF NOT EXISTS `apdm_vendor` (
  `vendor_id` int(11) NOT NULL auto_increment,
  `vendor_name` varchar(200) NOT NULL,
  `vendor_activate` tinyint(1) NOT NULL default '0',
  `vendor_address` varchar(255) NOT NULL,
  `vendor_tel_fax` varchar(100) NOT NULL,
  `vendor_website` varchar(255) NOT NULL,
  `vendor_contractor` varchar(100) NOT NULL,
  `vendor_email` varchar(255) NOT NULL,
  `vendor_description` text NOT NULL,
  `vendor_create` datetime NOT NULL,
  `vendor_create_by` int(11) NOT NULL,
  `vendor_modified` datetime NOT NULL,
  `vendor_modified_by` int(11) NOT NULL,
  `vendor_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`vendor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `apdm_vendor`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_banner`
-- 

DROP TABLE IF EXISTS `jos_banner`;
CREATE TABLE IF NOT EXISTS `jos_banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(30) NOT NULL default 'banner',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `custombannercode` text,
  `catid` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `tags` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`),
  KEY `idx_banner_catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_banner`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_bannerclient`
-- 

DROP TABLE IF EXISTS `jos_bannerclient`;
CREATE TABLE IF NOT EXISTS `jos_bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_bannerclient`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_bannertrack`
-- 

DROP TABLE IF EXISTS `jos_bannertrack`;
CREATE TABLE IF NOT EXISTS `jos_bannertrack` (
  `track_date` date NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_bannertrack`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_categories`
-- 

DROP TABLE IF EXISTS `jos_categories`;
CREATE TABLE IF NOT EXISTS `jos_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_categories`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_components`
-- 

DROP TABLE IF EXISTS `jos_components`;
CREATE TABLE IF NOT EXISTS `jos_components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `parent_option` (`parent`,`option`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

-- 
-- Dumping data for table `jos_components`
-- 

INSERT INTO `jos_components` VALUES (1, 'Banners', '', 0, 0, '', 'Banner Management', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, 'track_impressions=0\ntrack_clicks=0\ntag_prefix=\n\n', 1);
INSERT INTO `jos_components` VALUES (2, 'Banners', '', 0, 1, 'option=com_banners', 'Active Banners', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (3, 'Clients', '', 0, 1, 'option=com_banners&c=client', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (4, 'Web Links', 'option=com_weblinks', 0, 0, '', 'Manage Weblinks', 'com_weblinks', 0, 'js/ThemeOffice/component.png', 0, 'show_comp_description=1\ncomp_description=\nshow_link_hits=1\nshow_link_description=1\nshow_other_cats=1\nshow_headings=1\nshow_page_title=1\nlink_target=0\nlink_icons=\n\n', 1);
INSERT INTO `jos_components` VALUES (5, 'Links', '', 0, 4, 'option=com_weblinks', 'View existing weblinks', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (6, 'Categories', '', 0, 4, 'option=com_categories&section=com_weblinks', 'Manage weblink categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (7, 'Contacts', 'option=com_contact', 0, 0, '', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/component.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1);
INSERT INTO `jos_components` VALUES (8, 'Contacts', '', 0, 7, 'option=com_contact', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '', 1);
INSERT INTO `jos_components` VALUES (9, 'Categories', '', 0, 7, 'option=com_categories&section=com_contact_details', 'Manage contact categories', '', 2, 'js/ThemeOffice/categories.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1);
INSERT INTO `jos_components` VALUES (10, 'Polls', 'option=com_poll', 0, 0, 'option=com_poll', 'Manage Polls', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (11, 'News Feeds', 'option=com_newsfeeds', 0, 0, '', 'News Feeds Management', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (12, 'Feeds', '', 0, 11, 'option=com_newsfeeds', 'Manage News Feeds', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, 'show_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n', 1);
INSERT INTO `jos_components` VALUES (13, 'Categories', '', 0, 11, 'option=com_categories&section=com_newsfeeds', 'Manage Categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (14, 'User', 'option=com_user', 0, 0, '', '', 'com_user', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (15, 'Search', 'option=com_search', 0, 0, 'option=com_search', 'Search Statistics', 'com_search', 0, 'js/ThemeOffice/component.png', 1, 'enabled=0\n\n', 1);
INSERT INTO `jos_components` VALUES (16, 'Categories', '', 0, 1, 'option=com_categories&section=com_banner', 'Categories', '', 3, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (17, 'Wrapper', 'option=com_wrapper', 0, 0, '', 'Wrapper', 'com_wrapper', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (18, 'Mail To', '', 0, 0, '', '', 'com_mailto', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (19, 'Media Manager', '', 0, 0, 'option=com_media', 'Media Manager', 'com_media', 0, '', 1, 'upload_extensions=bmp,csv,doc,epg,gif,ico,jpg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,EPG,GIF,ICO,JPG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\nupload_maxsize=10000000\nfile_path=images\nimage_path=images/stories\nrestrict_uploads=1\ncheck_mime=1\nimage_extensions=bmp,gif,jpg,png\nignore_extensions=\nupload_mime=image/jpeg,image/gif,image/png,image/bmp,application/x-shockwave-flash,application/msword,application/excel,application/pdf,application/powerpoint,text/plain,application/x-zip\nupload_mime_illegal=text/html\nenable_flash=0\n\n', 1);
INSERT INTO `jos_components` VALUES (20, 'Articles', 'option=com_content', 0, 0, '', '', 'com_content', 0, '', 1, 'show_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\nfeed_summary=0\n\n', 1);
INSERT INTO `jos_components` VALUES (21, 'Configuration Manager', '', 0, 0, '', 'Configuration', 'com_config', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (22, 'Installation Manager', '', 0, 0, '', 'Installer', 'com_installer', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (23, 'Language Manager', '', 0, 0, '', 'Languages', 'com_languages', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (24, 'Mass mail', '', 0, 0, '', 'Mass Mail', 'com_massmail', 0, '', 1, 'mailSubjectPrefix=\nmailBodySuffix=\n\n', 1);
INSERT INTO `jos_components` VALUES (25, 'Menu Editor', '', 0, 0, '', 'Menu Editor', 'com_menus', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (27, 'Messaging', '', 0, 0, '', 'Messages', 'com_messages', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (28, 'Modules Manager', '', 0, 0, '', 'Modules', 'com_modules', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (29, 'Plugin Manager', '', 0, 0, '', 'Plugins', 'com_plugins', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (30, 'Template Manager', '', 0, 0, '', 'Templates', 'com_templates', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (31, 'User Manager', '', 0, 0, '', 'Users', 'com_users', 0, '', 1, 'allowUserRegistration=1\nnew_usertype=Registered\nuseractivation=1\nfrontend_userparams=1\n\n', 1);
INSERT INTO `jos_components` VALUES (32, 'Cache Manager', '', 0, 0, '', 'Cache', 'com_cache', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (33, 'Control Panel', '', 0, 0, '', 'Control Panel', 'com_cpanel', 0, '', 1, '', 1);
INSERT INTO `jos_components` VALUES (34, 'APDM Users Management', 'option=com_apdmusers', 0, 0, 'option=com_apdmusers', 'APDM Users Management', 'com_apdmusers', 0, 'user.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (41, 'APDM Information Supplier Management', 'option=com_apdmsuppliers', 0, 0, 'option=com_apdmsuppliers', 'APDM Information Supplier Management', 'com_apdmsuppliers', 0, 'component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (40, 'APDM Commodity Code Management', 'option=com_apdmccs', 0, 0, 'option=com_apdmccs', 'APDM Commodity Code Management', 'com_apdmccs', 0, 'component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (37, 'APDM Role Management', 'option=com_roles', 0, 0, 'option=com_roles', 'APDM Role Management', 'com_roles', 0, 'config.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (42, 'APDM ECO Management', 'option=com_apdmeco', 0, 0, 'option=com_apdmeco', 'APDM ECO Management', 'com_apdmeco', 0, 'component.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (43, 'APDM Recyle Bin Management', 'option=com_apdmrecylebin', 0, 0, 'option=com_apdmrecylebin', 'APDM ECO Management', 'com_apdmrecylebin', 0, 'trash.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (44, 'Commodity Code', '', 0, 43, 'option=com_apdmrecylebin&task=ccs', 'Commodity Code', 'com_apdmrecylebin', 0, 'trash.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (45, 'Info VD/SP/MF', '', 0, 43, 'option=com_apdmrecylebin&task=info', 'Info VD/SP/MF', 'com_apdmrecylebin', 1, 'trash.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (46, 'ECO', '', 0, 43, 'option=com_apdmrecylebin&task=eco', 'ECO', 'com_apdmrecylebin', 2, 'trash.png', 0, '', 1);
INSERT INTO `jos_components` VALUES (47, 'Part Number', '', 0, 43, 'option=com_apdmrecylebin&task=pns', 'Part Number', 'com_apdmrecylebin', 3, 'trash.png', 0, '', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_contact_details`
-- 

DROP TABLE IF EXISTS `jos_contact_details`;
CREATE TABLE IF NOT EXISTS `jos_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `con_position` varchar(255) default NULL,
  `address` text,
  `suburb` varchar(100) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) default NULL,
  `postcode` varchar(100) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `misc` mediumtext,
  `image` varchar(255) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(255) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `mobile` varchar(255) NOT NULL default '',
  `webpage` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_contact_details`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_content`
-- 

DROP TABLE IF EXISTS `jos_content`;
CREATE TABLE IF NOT EXISTS `jos_content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `title_alias` varchar(255) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `metadata` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_content`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_content_frontpage`
-- 

DROP TABLE IF EXISTS `jos_content_frontpage`;
CREATE TABLE IF NOT EXISTS `jos_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_content_frontpage`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_content_rating`
-- 

DROP TABLE IF EXISTS `jos_content_rating`;
CREATE TABLE IF NOT EXISTS `jos_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_content_rating`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_aro`
-- 

DROP TABLE IF EXISTS `jos_core_acl_aro`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro` (
  `id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `jos_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `jos_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- 
-- Dumping data for table `jos_core_acl_aro`
-- 

INSERT INTO `jos_core_acl_aro` VALUES (10, 'users', '62', 0, 'Administrator', 0);
INSERT INTO `jos_core_acl_aro` VALUES (11, 'users', '63', 0, 'manager', 0);
INSERT INTO `jos_core_acl_aro` VALUES (12, 'users', '64', 0, 'administrator', 0);
INSERT INTO `jos_core_acl_aro` VALUES (23, 'users', '75', 0, 'Test 2 2', 0);
INSERT INTO `jos_core_acl_aro` VALUES (22, 'users', '74', 0, 'Test1 1', 0);
INSERT INTO `jos_core_acl_aro` VALUES (24, 'users', '76', 0, 'apdm 1', 0);
INSERT INTO `jos_core_acl_aro` VALUES (25, 'users', '77', 0, 'Phuc Le', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_aro_groups`
-- 

DROP TABLE IF EXISTS `jos_core_acl_aro_groups`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_groups` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `jos_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- 
-- Dumping data for table `jos_core_acl_aro_groups`
-- 

INSERT INTO `jos_core_acl_aro_groups` VALUES (17, 0, 'ROOT', 1, 22, 'ROOT');
INSERT INTO `jos_core_acl_aro_groups` VALUES (28, 17, 'USERS', 2, 21, 'USERS');
INSERT INTO `jos_core_acl_aro_groups` VALUES (29, 28, 'Public Frontend', 3, 12, 'Public Frontend');
INSERT INTO `jos_core_acl_aro_groups` VALUES (18, 29, 'Registered', 4, 11, 'Registered');
INSERT INTO `jos_core_acl_aro_groups` VALUES (19, 18, 'Author', 5, 10, 'Author');
INSERT INTO `jos_core_acl_aro_groups` VALUES (20, 19, 'Editor', 6, 9, 'Editor');
INSERT INTO `jos_core_acl_aro_groups` VALUES (21, 20, 'Publisher', 7, 8, 'Publisher');
INSERT INTO `jos_core_acl_aro_groups` VALUES (30, 28, 'Public Backend', 13, 20, 'Public Backend');
INSERT INTO `jos_core_acl_aro_groups` VALUES (23, 30, 'Manager', 14, 19, 'Manager');
INSERT INTO `jos_core_acl_aro_groups` VALUES (24, 23, 'Administrator', 15, 18, 'Administrator');
INSERT INTO `jos_core_acl_aro_groups` VALUES (25, 24, 'Super Administrator', 16, 17, 'Super Administrator');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_aro_map`
-- 

DROP TABLE IF EXISTS `jos_core_acl_aro_map`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_map` (
  `acl_id` int(11) NOT NULL default '0',
  `section_value` varchar(230) NOT NULL default '0',
  `value` varchar(100) NOT NULL,
  PRIMARY KEY  (`acl_id`,`section_value`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_core_acl_aro_map`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_aro_sections`
-- 

DROP TABLE IF EXISTS `jos_core_acl_aro_sections`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_sections` (
  `id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `jos_gacl_value_aro_sections` (`value`),
  KEY `jos_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `jos_core_acl_aro_sections`
-- 

INSERT INTO `jos_core_acl_aro_sections` VALUES (10, 'users', 1, 'Users', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_acl_groups_aro_map`
-- 

DROP TABLE IF EXISTS `jos_core_acl_groups_aro_map`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_core_acl_groups_aro_map`
-- 

INSERT INTO `jos_core_acl_groups_aro_map` VALUES (23, '', 11);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (23, '', 18);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (23, '', 19);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (23, '', 22);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (23, '', 23);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (24, '', 12);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (24, '', 24);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (24, '', 25);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (25, '', 10);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_log_items`
-- 

DROP TABLE IF EXISTS `jos_core_log_items`;
CREATE TABLE IF NOT EXISTS `jos_core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_core_log_items`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_core_log_searches`
-- 

DROP TABLE IF EXISTS `jos_core_log_searches`;
CREATE TABLE IF NOT EXISTS `jos_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_core_log_searches`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_groups`
-- 

DROP TABLE IF EXISTS `jos_groups`;
CREATE TABLE IF NOT EXISTS `jos_groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_groups`
-- 

INSERT INTO `jos_groups` VALUES (0, 'Public');
INSERT INTO `jos_groups` VALUES (1, 'Registered');
INSERT INTO `jos_groups` VALUES (2, 'Special');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_menu`
-- 

DROP TABLE IF EXISTS `jos_menu`;
CREATE TABLE IF NOT EXISTS `jos_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(75) default NULL,
  `name` varchar(255) default NULL,
  `alias` varchar(255) NOT NULL default '',
  `link` text,
  `type` varchar(50) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL default '0',
  `rgt` int(11) unsigned NOT NULL default '0',
  `home` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jos_menu`
-- 

INSERT INTO `jos_menu` VALUES (1, 'mainmenu', 'Home', 'home', 'index.php?option=com_content&view=frontpage', 'component', 1, 0, 20, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'num_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\norderby_pri=\norderby_sec=front\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_menu_types`
-- 

DROP TABLE IF EXISTS `jos_menu_types`;
CREATE TABLE IF NOT EXISTS `jos_menu_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `menutype` varchar(75) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `menutype` (`menutype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jos_menu_types`
-- 

INSERT INTO `jos_menu_types` VALUES (1, 'mainmenu', 'Main Menu', 'The main menu for the site');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_messages`
-- 

DROP TABLE IF EXISTS `jos_messages`;
CREATE TABLE IF NOT EXISTS `jos_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_messages`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_messages_cfg`
-- 

DROP TABLE IF EXISTS `jos_messages_cfg`;
CREATE TABLE IF NOT EXISTS `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_messages_cfg`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_migration_backlinks`
-- 

DROP TABLE IF EXISTS `jos_migration_backlinks`;
CREATE TABLE IF NOT EXISTS `jos_migration_backlinks` (
  `itemid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `sefurl` text NOT NULL,
  `newurl` text NOT NULL,
  PRIMARY KEY  (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_migration_backlinks`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_modules`
-- 

DROP TABLE IF EXISTS `jos_modules`;
CREATE TABLE IF NOT EXISTS `jos_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(50) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  `control` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `jos_modules`
-- 

INSERT INTO `jos_modules` VALUES (1, 'Main Menu', '', 1, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu\nmoduleclass_sfx=_menu\n', 1, 0, '');
INSERT INTO `jos_modules` VALUES (2, 'Login', '', 1, 'login', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (3, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 0, 'mod_popular', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (4, 'Recent added Articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 0, 'mod_latest', 0, 2, 1, 'ordering=c_dsc\nuser_id=0\ncache=0\n\n', 0, 1, '');
INSERT INTO `jos_modules` VALUES (5, 'Menu Stats', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 0, 'mod_stats', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (6, 'Unread Messages', '', 1, 'header', 0, '0000-00-00 00:00:00', 0, 'mod_unread', 0, 2, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (7, 'Online Users', '', 2, 'header', 0, '0000-00-00 00:00:00', 0, 'mod_online', 0, 2, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (8, 'Toolbar', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 2, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (9, 'Quick Icons', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 2, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (10, 'Logged in Users', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (11, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1, '');
INSERT INTO `jos_modules` VALUES (12, 'Admin Menu', '', 1, 'menu', 0, '0000-00-00 00:00:00', 1, 'mod_menu', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (13, 'Admin SubMenu', '', 1, 'submenu', 0, '0000-00-00 00:00:00', 1, 'mod_submenu', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (14, 'User Status', '', 1, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_status', 0, 2, 1, '', 0, 1, '');
INSERT INTO `jos_modules` VALUES (15, 'Title', '', 1, 'title', 0, '0000-00-00 00:00:00', 1, 'mod_title', 0, 2, 1, '', 0, 1, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_modules_menu`
-- 

DROP TABLE IF EXISTS `jos_modules_menu`;
CREATE TABLE IF NOT EXISTS `jos_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_modules_menu`
-- 

INSERT INTO `jos_modules_menu` VALUES (1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_newsfeeds`
-- 

DROP TABLE IF EXISTS `jos_newsfeeds`;
CREATE TABLE IF NOT EXISTS `jos_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_newsfeeds`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_plugins`
-- 

DROP TABLE IF EXISTS `jos_plugins`;
CREATE TABLE IF NOT EXISTS `jos_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- 
-- Dumping data for table `jos_plugins`
-- 

INSERT INTO `jos_plugins` VALUES (1, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (2, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', 'host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n');
INSERT INTO `jos_plugins` VALUES (3, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (4, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (5, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'autoregister=1\n\n');
INSERT INTO `jos_plugins` VALUES (6, 'Search - Content', 'content', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n');
INSERT INTO `jos_plugins` VALUES (7, 'Search - Contacts', 'contacts', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n');
INSERT INTO `jos_plugins` VALUES (8, 'Search - Categories', 'categories', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n');
INSERT INTO `jos_plugins` VALUES (9, 'Search - Sections', 'sections', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n');
INSERT INTO `jos_plugins` VALUES (10, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n');
INSERT INTO `jos_plugins` VALUES (11, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n');
INSERT INTO `jos_plugins` VALUES (12, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', 'enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n');
INSERT INTO `jos_plugins` VALUES (13, 'Content - Rating', 'vote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (14, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'mode=1\n\n');
INSERT INTO `jos_plugins` VALUES (15, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (16, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'enabled=1\nstyle=0\n\n');
INSERT INTO `jos_plugins` VALUES (17, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'position=1\n\n');
INSERT INTO `jos_plugins` VALUES (18, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (19, 'Editor - TinyMCE 2.0', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced\ncleanup=1\ncleanup_startup=0\nautosave=0\ncompressed=0\nrelative_urls=1\ntext_direction=ltr\nlang_mode=0\nlang_code=en\ninvalid_elements=applet\ncontent_css=1\ncontent_css_custom=\nnewlines=0\ntoolbar=top\nhr=1\nsmilies=1\ntable=1\nstyle=1\nlayer=1\nxhtmlxtras=0\ntemplate=0\ndirectionality=1\nfullscreen=1\nhtml_height=550\nhtml_width=750\npreview=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\n\n');
INSERT INTO `jos_plugins` VALUES (20, 'Editor - XStandard Lite 2.0', 'xstandard', 'editors', 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (21, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (22, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (23, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (24, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (25, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', 'catid=1\nsectionid=0\n\n');
INSERT INTO `jos_plugins` VALUES (27, 'System - SEF', 'sef', 'system', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (28, 'System - Debug', 'debug', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', 'queries=1\nmemory=1\nlangauge=1\n\n');
INSERT INTO `jos_plugins` VALUES (29, 'System - Legacy', 'legacy', 'system', 0, 3, 0, 1, 0, 0, '0000-00-00 00:00:00', 'route=0\n\n');
INSERT INTO `jos_plugins` VALUES (30, 'System - Cache', 'cache', 'system', 0, 4, 0, 1, 0, 0, '0000-00-00 00:00:00', 'browsercache=0\ncachetime=15\n\n');
INSERT INTO `jos_plugins` VALUES (31, 'System - Log', 'log', 'system', 0, 5, 0, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (32, 'System - Remember Me', 'remember', 'system', 0, 6, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_plugins` VALUES (33, 'System - Backlink', 'backlink', 'system', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_poll_data`
-- 

DROP TABLE IF EXISTS `jos_poll_data`;
CREATE TABLE IF NOT EXISTS `jos_poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_poll_data`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_poll_date`
-- 

DROP TABLE IF EXISTS `jos_poll_date`;
CREATE TABLE IF NOT EXISTS `jos_poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_poll_date`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_poll_menu`
-- 

DROP TABLE IF EXISTS `jos_poll_menu`;
CREATE TABLE IF NOT EXISTS `jos_poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_poll_menu`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_polls`
-- 

DROP TABLE IF EXISTS `jos_polls`;
CREATE TABLE IF NOT EXISTS `jos_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_polls`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_sections`
-- 

DROP TABLE IF EXISTS `jos_sections`;
CREATE TABLE IF NOT EXISTS `jos_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` text NOT NULL,
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `jos_sections`
-- 

INSERT INTO `jos_sections` VALUES (1, 'Test 1', '', 'test-1', '', 'content', 'left', '', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_session`
-- 

DROP TABLE IF EXISTS `jos_session`;
CREATE TABLE IF NOT EXISTS `jos_session` (
  `username` varchar(150) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `data` longtext,
  PRIMARY KEY  (`session_id`(64)),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_session`
-- 

INSERT INTO `jos_session` VALUES ('admin', '1235896674', '76fdbd6b003614c768480218dbb8c4d9', 0, 62, 'Super Administrator', 25, 1, '__default|a:8:{s:22:"session.client.browser";s:90:"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.6) Gecko/2009011913 Firefox/3.0.6";s:15:"session.counter";i:179;s:8:"registry";O:9:"JRegistry":3:{s:17:"_defaultNameSpace";s:7:"session";s:9:"_registry";a:8:{s:7:"session";a:1:{s:4:"data";O:8:"stdClass":0:{}}s:11:"application";a:1:{s:4:"data";O:8:"stdClass":1:{s:4:"lang";s:0:"";}}s:22:"com_apdmccs&task=trash";a:1:{s:4:"data";O:8:"stdClass":5:{s:12:"filter_order";s:10:"c.ccs_code";s:16:"filter_order_Dir";s:0:"";s:17:"filter_created_by";i:0;s:6:"search";s:0:"";s:10:"limitstart";i:0;}}s:6:"global";a:1:{s:4:"data";O:8:"stdClass":1:{s:4:"list";O:8:"stdClass":1:{s:5:"limit";s:2:"20";}}}s:26:"com_apdmrecylebin&task=ccs";a:1:{s:4:"data";O:8:"stdClass":5:{s:12:"filter_order";s:10:"c.ccs_code";s:16:"filter_order_Dir";s:3:"asc";s:17:"filter_created_by";i:0;s:6:"search";s:0:"";s:10:"limitstart";i:0;}}s:17:"com_apdmrecylebin";a:1:{s:4:"data";O:8:"stdClass":9:{s:12:"filter_order";s:11:"s.info_name";s:16:"filter_order_Dir";s:3:"asc";s:15:"filter_activate";s:1:"0";s:20:"filter_date_modified";s:0:"";s:19:"filter_date_created";s:0:"";s:17:"filter_created_by";i:0;s:18:"filter_modified_by";i:0;s:6:"search";s:0:"";s:10:"limitstart";i:0;}}s:11:"com_apdmeco";a:1:{s:4:"data";O:8:"stdClass":9:{s:12:"filter_order";s:10:"e.eco_name";s:16:"filter_order_Dir";s:0:"";s:15:"filter_activate";s:0:"";s:20:"filter_date_modified";s:0:"";s:19:"filter_date_created";s:0:"";s:17:"filter_created_by";i:0;s:18:"filter_modified_by";i:0;s:6:"search";s:0:"";s:10:"limitstart";i:0;}}s:26:"com_apdmrecylebin&task=eco";a:1:{s:4:"data";O:8:"stdClass":4:{s:12:"filter_order";s:10:"e.eco_name";s:16:"filter_order_Dir";s:0:"";s:6:"search";s:0:"";s:10:"limitstart";i:0;}}}s:7:"_errors";a:0:{}}s:4:"user";O:5:"JUser":19:{s:2:"id";s:2:"62";s:4:"name";s:13:"Administrator";s:8:"username";s:5:"admin";s:5:"email";s:20:"lediemphuc@gmail.com";s:8:"password";s:65:"b1e0e11880677c342883e79b78f707e3:SXDN6oVrRNMLYv00adJi05dZiRtw4Abc";s:14:"password_clear";s:0:"";s:8:"usertype";s:19:"Super Administrator";s:5:"block";s:1:"0";s:9:"sendEmail";s:1:"1";s:3:"gid";s:2:"25";s:12:"registerDate";s:19:"2008-11-19 00:02:33";s:13:"lastvisitDate";s:19:"2009-03-01 04:16:12";s:10:"activation";s:0:"";s:6:"params";s:0:"";s:3:"aid";i:2;s:5:"guest";i:0;s:7:"_params";O:10:"JParameter":7:{s:4:"_raw";s:0:"";s:4:"_xml";N;s:9:"_elements";a:0:{}s:12:"_elementPath";a:1:{i:0;s:78:"C:\\Program Files\\xampp\\htdocs\\www\\adpm\\libraries\\joomla\\html\\parameter\\element";}s:17:"_defaultNameSpace";s:8:"_default";s:9:"_registry";a:1:{s:8:"_default";a:1:{s:4:"data";O:8:"stdClass":0:{}}}s:7:"_errors";a:0:{}}s:9:"_errorMsg";N;s:7:"_errors";a:0:{}}s:13:"session.token";s:32:"d74d9453d9b018d7a8680ccd91289675";s:19:"session.timer.start";i:1235891243;s:18:"session.timer.last";i:1235895833;s:17:"session.timer.now";i:1235896674;}');
INSERT INTO `jos_session` VALUES ('apdm@yahoo.com', '1235899699', '7af21b2201af5f1dde14a0c9c1af77b7', 0, 76, 'Administrator', 24, 1, '__default|a:8:{s:15:"session.counter";i:8;s:19:"session.timer.start";i:1235898368;s:18:"session.timer.last";i:1235899698;s:17:"session.timer.now";i:1235899699;s:22:"session.client.browser";s:56:"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; GTB5)";s:8:"registry";O:9:"JRegistry":3:{s:17:"_defaultNameSpace";s:7:"session";s:9:"_registry";a:2:{s:7:"session";a:1:{s:4:"data";O:8:"stdClass":0:{}}s:11:"application";a:1:{s:4:"data";O:8:"stdClass":1:{s:4:"lang";s:0:"";}}}s:7:"_errors";a:0:{}}s:4:"user";O:5:"JUser":19:{s:2:"id";s:2:"76";s:4:"name";s:6:"apdm 1";s:8:"username";s:14:"apdm@yahoo.com";s:5:"email";s:14:"apdm@yahoo.com";s:8:"password";s:65:"3cf9bddb260d3d8e89f0f49b17fa7c5a:bmG8Z7CGTUJGYZKu7YlghK9duxIyW2V7";s:14:"password_clear";s:0:"";s:8:"usertype";s:13:"Administrator";s:5:"block";s:1:"0";s:9:"sendEmail";s:1:"0";s:3:"gid";s:2:"24";s:12:"registerDate";s:19:"2009-01-10 08:50:49";s:13:"lastvisitDate";s:19:"2009-03-01 09:05:09";s:10:"activation";s:0:"";s:6:"params";s:1:"\n";s:3:"aid";i:2;s:5:"guest";i:0;s:7:"_params";O:10:"JParameter":7:{s:4:"_raw";s:0:"";s:4:"_xml";N;s:9:"_elements";a:0:{}s:12:"_elementPath";a:1:{i:0;s:78:"C:\\Program Files\\xampp\\htdocs\\www\\adpm\\libraries\\joomla\\html\\parameter\\element";}s:17:"_defaultNameSpace";s:8:"_default";s:9:"_registry";a:1:{s:8:"_default";a:1:{s:4:"data";O:8:"stdClass":0:{}}}s:7:"_errors";a:0:{}}s:9:"_errorMsg";N;s:7:"_errors";a:0:{}}s:13:"session.token";s:32:"0a1a9f7da8def752035d1e893f1c0172";}');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_stats_agents`
-- 

DROP TABLE IF EXISTS `jos_stats_agents`;
CREATE TABLE IF NOT EXISTS `jos_stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_stats_agents`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jos_templates_menu`
-- 

DROP TABLE IF EXISTS `jos_templates_menu`;
CREATE TABLE IF NOT EXISTS `jos_templates_menu` (
  `template` varchar(255) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`menuid`,`client_id`,`template`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `jos_templates_menu`
-- 

INSERT INTO `jos_templates_menu` VALUES ('rhuk_milkyway', 0, 0);
INSERT INTO `jos_templates_menu` VALUES ('khepri', 0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_users`
-- 

DROP TABLE IF EXISTS `jos_users`;
CREATE TABLE IF NOT EXISTS `jos_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

-- 
-- Dumping data for table `jos_users`
-- 

INSERT INTO `jos_users` VALUES (62, 'Administrator', 'admin', 'lediemphuc@gmail.com', 'b1e0e11880677c342883e79b78f707e3:SXDN6oVrRNMLYv00adJi05dZiRtw4Abc', 'Super Administrator', 0, 1, 25, '2008-11-19 00:02:33', '2009-03-01 07:07:23', '', '');
INSERT INTO `jos_users` VALUES (63, 'manager', 'manager', 'manager@yahoo.com', '7b1ec2687656c6cce8f74b456d838a86:DaTB8yC1pccYlkDq1Y8XJvEX9d4Vk3tG', 'Manager', 0, 0, 23, '2008-12-11 15:01:33', '2008-12-11 15:02:34', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');
INSERT INTO `jos_users` VALUES (64, 'administrator', 'administrator', 'administrator@yahoo.com', 'e6ecc578e38d25d443cff4a8ec784bf6:WBZDwhykMmwZjpIYfrER41NPRDf1t8wr', 'Administrator', 0, 0, 24, '2008-12-11 15:02:12', '2009-02-27 16:27:55', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');
INSERT INTO `jos_users` VALUES (74, 'Test1 1', 'test@yahoo.com', 'test@yahoo.com', '931734675de4add33aa4cfd6b4e723cd:Qk4sxy8QUA2QXdZLbn6DvppSqJMRs4pd', 'Manager', 0, 0, 23, '2009-01-07 18:21:40', '0000-00-00 00:00:00', '', '\n');
INSERT INTO `jos_users` VALUES (75, 'Test 2 2', 'test2@yahoo.com', 'test2@yahoo.com', '5f7a5b80114b245c088ed11087a5cf75:p6Q4355dP5ls58uPaVJ2mIJaB4vu8Qg5', 'Manager', 0, 0, 23, '2009-01-10 04:20:56', '2009-03-01 09:06:08', '', '\n');
INSERT INTO `jos_users` VALUES (76, 'apdm 1', 'apdm@yahoo.com', 'apdm@yahoo.com', '3cf9bddb260d3d8e89f0f49b17fa7c5a:bmG8Z7CGTUJGYZKu7YlghK9duxIyW2V7', 'Administrator', 0, 0, 24, '2009-01-10 08:50:49', '2009-03-01 09:06:13', '', '\n');
INSERT INTO `jos_users` VALUES (77, 'Phuc Le', 'phucle@yahoo.com', 'phucle@yahoo.com', '0f8707e629a73061ae23f18fbc4e8a85:c5dvbUrpxFraYqFHys01myOLlhqHyqiM', 'Administrator', 0, 0, 24, '2009-02-06 15:48:26', '2009-02-06 15:50:55', '', '\n');

-- --------------------------------------------------------

-- 
-- Table structure for table `jos_weblinks`
-- 

DROP TABLE IF EXISTS `jos_weblinks`;
CREATE TABLE IF NOT EXISTS `jos_weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jos_weblinks`
-- 

