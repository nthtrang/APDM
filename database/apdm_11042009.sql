-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2009 at 09:39 AM
-- Server version: 5.1.30
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `apdm`
--

-- --------------------------------------------------------

--
-- Table structure for table `apdm_ccs`
--

DROP TABLE IF EXISTS `apdm_ccs`;
CREATE TABLE IF NOT EXISTS `apdm_ccs` (
  `ccs_id` int(11) NOT NULL AUTO_INCREMENT,
  `ccs_code` char(10) NOT NULL,
  `ccs_description` text NOT NULL,
  `ccs_activate` tinyint(1) NOT NULL DEFAULT '0',
  `ccs_create` datetime NOT NULL,
  `ccs_create_by` int(11) NOT NULL,
  `ccs_modified` datetime NOT NULL,
  `ccs_modified_by` int(11) NOT NULL,
  `ccs_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ccs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `apdm_ccs`
--

INSERT INTO `apdm_ccs` (`ccs_id`, `ccs_code`, `ccs_description`, `ccs_activate`, `ccs_create`, `ccs_create_by`, `ccs_modified`, `ccs_modified_by`, `ccs_deleted`) VALUES
(1, 'XXX', 'ert dtgdf dfgdf dds sdfsd dsf', 0, '2009-01-11 10:09:54', 76, '2009-01-11 10:09:54', 76, 0),
(7, '123', 'test fgfdgfd gfhfghgf', 0, '2009-02-12 16:33:20', 64, '2009-03-01 07:25:42', 62, 1),
(5, 'BBB', 'gdf dfgdfg dfgdf dfgdf', 0, '2009-01-11 06:35:11', 76, '2009-01-11 06:35:11', 76, 0),
(8, '124', '124 description', 0, '2009-02-09 16:04:20', 64, '0000-00-00 00:00:00', 0, 0),
(9, '126', '126 description', 0, '2009-02-09 16:04:32', 64, '0000-00-00 00:00:00', 0, 0),
(10, '144', 'dsfsdf', 0, '2009-02-12 16:31:37', 64, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `apdm_component`
--

DROP TABLE IF EXISTS `apdm_component`;
CREATE TABLE IF NOT EXISTS `apdm_component` (
  `component_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `component_name` varchar(200) NOT NULL,
  PRIMARY KEY (`component_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `apdm_component`
--

INSERT INTO `apdm_component` (`component_id`, `component_name`) VALUES
(1, 'Commodity Code'),
(2, 'Vendor'),
(3, 'Supplier'),
(4, 'Manufacture'),
(5, 'ECO'),
(6, 'Part Number');

-- --------------------------------------------------------

--
-- Table structure for table `apdm_eco`
--

DROP TABLE IF EXISTS `apdm_eco`;
CREATE TABLE IF NOT EXISTS `apdm_eco` (
  `eco_id` int(11) NOT NULL AUTO_INCREMENT,
  `eco_name` varchar(200) NOT NULL,
  `eco_pdf` varchar(255) DEFAULT NULL,
  `eco_description` text,
  `eco_status` tinyint(1) NOT NULL DEFAULT '0',
  `eco_create` datetime NOT NULL,
  `eco_create_by` int(11) NOT NULL,
  `eco_modified` datetime NOT NULL,
  `eco_modified_by` int(11) NOT NULL DEFAULT '0',
  `eco_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `apdm_eco`
--

INSERT INTO `apdm_eco` (`eco_id`, `eco_name`, `eco_pdf`, `eco_description`, `eco_status`, `eco_create`, `eco_create_by`, `eco_modified`, `eco_modified_by`, `eco_deleted`) VALUES
(3, 'eco _name 2', NULL, 'dfgdfg', 0, '2009-02-23 17:31:00', 62, '2009-03-01 08:04:53', 62, 0),
(6, 'account edit 1', 'accout_edit.pdf', 'Description', 0, '2009-02-25 17:21:32', 62, '2009-03-01 08:04:53', 62, 0);

-- --------------------------------------------------------

--
-- Table structure for table `apdm_pns`
--

DROP TABLE IF EXISTS `apdm_pns`;
CREATE TABLE IF NOT EXISTS `apdm_pns` (
  `pns_id` int(11) NOT NULL AUTO_INCREMENT,
  `ccs_id` int(11) NOT NULL,
  `pns_code` varchar(13) NOT NULL,
  `pns_revision` varchar(3) NOT NULL,
  `eco_id` int(11) NOT NULL DEFAULT '0',
  `pns_type` varchar(50) DEFAULT NULL,
  `pns_status` varchar(20) NOT NULL DEFAULT '0',
  `pns_pdf` varchar(255) DEFAULT NULL,
  `pns_image` varchar(255) DEFAULT NULL,
  `pns_description` text,
  `pns_create` datetime NOT NULL,
  `pns_create_by` int(11) NOT NULL DEFAULT '0',
  `pns_modified` datetime NOT NULL,
  `pns_modified_by` int(11) NOT NULL DEFAULT '0',
  `pns_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pns_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `apdm_pns`
--

INSERT INTO `apdm_pns` (`pns_id`, `ccs_id`, `pns_code`, `pns_revision`, `eco_id`, `pns_type`, `pns_status`, `pns_pdf`, `pns_image`, `pns_description`, `pns_create`, `pns_create_by`, `pns_modified`, `pns_modified_by`, `pns_deleted`) VALUES
(1, 8, ' AADE24-00', '', 0, 'Making', 'Approval', NULL, NULL, NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 1),
(2, 10, 'AMSU89-00', '', 3, 'Buying', 'Cbsolete', '144_AMSU89_00.pdf', '144_AMSU89_00.jpg', '', '2009-03-09 16:17:33', 62, '2009-04-06 15:41:27', 62, 0),
(3, 8, '0XCUAD-00', '12', 6, 'Making', 'Pending', '', '', '', '2009-03-09 16:21:31', 62, '2009-04-06 15:37:42', 62, 1),
(4, 8, '000qqq-00', '', 6, 'Reference', 'Approval', '124_000qqq_00.jpg', '124_000qqq_00.jpg', '', '2009-03-09 16:46:01', 62, '2009-04-11 01:36:34', 64, 0),
(5, 8, 'DHJNPS-00', 'DDD', 6, 'Buying', 'Pending', '', '', NULL, '2009-03-09 16:55:47', 62, '0000-00-00 00:00:00', 0, 0),
(6, 8, '000qqq-00', 'XXX', 6, 'Reference', 'Approval', '124_000qqq_00_XXX.jpg', '124_000qqq_00_XXX.jpg', 'Description goes here...', '2009-03-18 17:18:47', 62, '2009-04-11 01:32:58', 64, 0),
(7, 8, '000qqq-00', 'XX1', 6, 'Reference', 'Approval', '124_000qqq_00_XX1.pdf', '124_000qqq_00_XX1.jpg', 'test description', '2009-03-18 17:21:06', 62, '2009-03-31 16:38:47', 62, 0),
(8, 8, '000qqq-00', '222', 6, 'Reference', 'Approval', '124_000qqq_00_222.jpg', '124_000qqq_00_222.jpg', '', '2009-03-26 16:54:32', 62, '2009-04-06 09:32:43', 62, 1),
(9, 8, '000qqq-00', '221', 3, 'Reference', 'Approval', '124_000qqq_00_221.jpg', '124_000qqq_00_221.jpg', '', '2009-03-26 17:21:54', 62, '2009-04-06 10:04:10', 62, 1),
(10, 8, '000qqq-00', 'ttt', 6, 'Reference', 'Approval', '', '124_000qqq_00_ttt.jpg', '', '2009-03-26 17:38:40', 62, '2009-03-26 17:49:53', 62, 1),
(11, 8, '0XCUAD-00', '121', 6, 'Making', 'Pending', NULL, NULL, '', '2009-04-06 15:37:48', 62, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `apdm_pns_parents`
--

DROP TABLE IF EXISTS `apdm_pns_parents`;
CREATE TABLE IF NOT EXISTS `apdm_pns_parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pns_id` int(11) NOT NULL,
  `pns_parent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `apdm_pns_parents`
--

INSERT INTO `apdm_pns_parents` (`id`, `pns_id`, `pns_parent`) VALUES
(1, 5, 1),
(2, 5, 4),
(3, 5, 3),
(96, 4, 2),
(90, 11, 0),
(91, 2, 0),
(81, 7, 2),
(93, 6, 5),
(82, 8, 9),
(89, 3, 0),
(88, 9, 6),
(75, 10, 2),
(74, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `apdm_pns_supplier`
--

DROP TABLE IF EXISTS `apdm_pns_supplier`;
CREATE TABLE IF NOT EXISTS `apdm_pns_supplier` (
  `pns_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `supplier_info` varchar(255) DEFAULT NULL,
  `type_id` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `apdm_pns_supplier`
--

INSERT INTO `apdm_pns_supplier` (`pns_id`, `id`, `supplier_id`, `supplier_info`, `type_id`) VALUES
(1, 1, 1, 'value vendor 1', 2),
(2, 2, 1, 'value vendor 1', 2),
(2, 3, 4, 'value vendor 2', 2),
(2, 4, 5, 'value vendor 3', 2),
(4, 6, 4, 'value vendor 2 edit', 2),
(4, 8, 6, 'value supplier1 edit1', 3),
(4, 9, 7, 'value supplier2 edit 2', 3),
(4, 10, 8, 'value supplier3 edit 3', 3),
(4, 12, 10, 'Vlaue 1 edit 1', 4),
(4, 13, 11, 'Vlaue 2 edit 2', 4),
(8, 79, 7, 'value supplier2 edit 2', 3),
(8, 78, 6, 'value supplier1 edit1', 3),
(7, 77, 12, 'qqqqq', 4),
(7, 76, 10, 'Vlaue 1 edit 1', 4),
(7, 75, 11, 'Vlaue 2 edit 2', 4),
(7, 74, 9, 'qqqq', 3),
(7, 73, 6, 'value supplier1 edit1', 3),
(7, 72, 7, 'value supplier2 edit 2', 3),
(7, 71, 8, 'value supplier3 edit 3', 3),
(7, 70, 1, 'qqq', 2),
(6, 69, 11, 'Vlaue 2 edit 2', 4),
(6, 68, 10, 'Vlaue 1 edit 1', 4),
(6, 67, 8, 'value supplier3 edit 3', 3),
(6, 66, 7, 'value supplier2 edit 2', 3),
(6, 65, 6, 'value supplier1 edit1', 3),
(8, 80, 8, 'value supplier3 edit 3', 3),
(8, 81, 10, 'Vlaue 1 edit 1', 4),
(8, 82, 11, 'Vlaue 2 edit 2', 4),
(9, 83, 6, 'value supplier1 edit1', 3),
(9, 84, 7, 'value supplier2 edit 2', 3),
(9, 85, 8, 'value supplier3 edit 3', 3),
(9, 86, 10, 'Vlaue 1 edit 1', 4),
(9, 87, 11, 'Vlaue 2 edit 2', 4),
(10, 88, 6, 'value supplier1 edit1', 3),
(10, 89, 7, 'value supplier2 edit 2', 3),
(10, 90, 8, 'value supplier3 edit 3', 3),
(10, 91, 10, 'Vlaue 1 edit 1', 4),
(10, 92, 11, 'Vlaue 2 edit 2', 4);

-- --------------------------------------------------------

--
-- Table structure for table `apdm_pn_cad`
--

DROP TABLE IF EXISTS `apdm_pn_cad`;
CREATE TABLE IF NOT EXISTS `apdm_pn_cad` (
  `pns_cad_id` int(11) NOT NULL AUTO_INCREMENT,
  `pns_id` int(11) NOT NULL,
  `cad_file` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pns_cad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `apdm_pn_cad`
--

INSERT INTO `apdm_pn_cad` (`pns_cad_id`, `pns_id`, `cad_file`, `date_create`, `created_by`) VALUES
(26, 8, '100_1498.jpg', '2009-03-26 16:54:32', 62),
(25, 8, '100_1492.jpg', '2009-03-26 16:54:32', 62),
(24, 8, '100_1493.jpg', '2009-03-26 16:54:32', 62),
(23, 8, '100_1494.jpg', '2009-03-26 16:54:32', 62),
(22, 8, '1.jpg', '2009-03-26 16:54:32', 62),
(44, 6, '100_1693.jpg', '2009-04-11 01:32:15', 64),
(31, 4, '100_0818.jpg', '2009-03-26 17:38:30', 62),
(32, 4, '100_0819.jpg', '2009-03-26 17:38:30', 62),
(33, 4, '100_0827.jpg', '2009-03-26 17:38:30', 62),
(34, 4, '100_0828.jpg', '2009-03-26 17:38:30', 62),
(45, 6, '100_1654.jpg', '2009-04-11 01:32:15', 64),
(43, 6, '100_1662.jpg', '2009-04-11 01:32:15', 64),
(42, 6, '100_1674.jpg', '2009-04-11 01:32:15', 64);

-- --------------------------------------------------------

--
-- Table structure for table `apdm_role`
--

DROP TABLE IF EXISTS `apdm_role`;
CREATE TABLE IF NOT EXISTS `apdm_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) DEFAULT NULL,
  `role_description` varchar(255) DEFAULT NULL,
  `role_create` datetime NOT NULL,
  `role_create_by` int(11) NOT NULL DEFAULT '0',
  `role_modified` datetime NOT NULL,
  `role_modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `apdm_role`
--

INSERT INTO `apdm_role` (`role_id`, `role_name`, `role_description`, `role_create`, `role_create_by`, `role_modified`, `role_modified_by`) VALUES
(7, 'role 2', 'This Role have full permission on all component. ', '2009-02-03 15:29:41', 64, '2009-02-03 15:29:41', 64),
(6, 'Role 1', 'Role 1 description', '2009-03-01 08:48:31', 76, '2009-03-01 08:48:31', 76),
(8, 'Role 3', 'This role management on Vendor, SUpplier, Manufacture.', '2009-03-01 08:48:46', 76, '2009-03-01 08:48:46', 76),
(9, 'Role management PNS', 'This role only management PNs', '2009-02-03 15:24:42', 64, '0000-00-00 00:00:00', 0);

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

INSERT INTO `apdm_role_component` (`role_id`, `component_id`, `role_value`) VALUES
(7, 6, 'R'),
(7, 6, 'D'),
(7, 6, 'E'),
(7, 6, 'W'),
(7, 6, 'V'),
(7, 5, 'R'),
(7, 5, 'D'),
(7, 5, 'E'),
(7, 5, 'W'),
(7, 5, 'V'),
(7, 4, 'R'),
(7, 4, 'D'),
(7, 4, 'E'),
(7, 4, 'W'),
(7, 4, 'V'),
(7, 3, 'R'),
(7, 3, 'D'),
(7, 3, 'E'),
(7, 3, 'W'),
(7, 3, 'V'),
(7, 2, 'R'),
(7, 2, 'D'),
(7, 2, 'E'),
(7, 2, 'W'),
(7, 2, 'V'),
(7, 1, 'R'),
(7, 1, 'D'),
(7, 1, 'E'),
(7, 1, 'W'),
(7, 1, 'V'),
(6, 6, 'R'),
(6, 6, 'D'),
(6, 6, 'E'),
(6, 6, 'W'),
(6, 6, 'V'),
(6, 5, 'V'),
(6, 4, '0'),
(6, 3, '0'),
(6, 2, '0'),
(6, 1, 'V'),
(8, 6, 'V'),
(8, 5, 'V'),
(8, 4, 'V'),
(8, 3, 'V'),
(8, 2, 'V'),
(8, 1, 'V'),
(9, 6, 'V'),
(9, 6, 'W'),
(9, 6, 'E'),
(9, 6, 'D'),
(9, 6, 'R');

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

INSERT INTO `apdm_role_user` (`user_id`, `role_id`) VALUES
(74, 7),
(75, 8);

-- --------------------------------------------------------

--
-- Table structure for table `apdm_supplier_info`
--

DROP TABLE IF EXISTS `apdm_supplier_info`;
CREATE TABLE IF NOT EXISTS `apdm_supplier_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `info_type` tinyint(1) NOT NULL,
  `info_name` varchar(255) NOT NULL,
  `info_address` varchar(255) DEFAULT NULL,
  `info_telfax` varchar(100) DEFAULT NULL,
  `info_website` varchar(255) DEFAULT NULL,
  `info_contactperson` varchar(100) DEFAULT NULL,
  `info_email` varchar(255) DEFAULT NULL,
  `info_description` text NOT NULL,
  `info_activate` tinyint(1) NOT NULL DEFAULT '0',
  `info_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `info_create` datetime NOT NULL,
  `info_created_by` int(11) NOT NULL DEFAULT '0',
  `info_modified_by` int(11) NOT NULL DEFAULT '0',
  `info_modified` datetime NOT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `apdm_supplier_info`
--

INSERT INTO `apdm_supplier_info` (`info_id`, `info_type`, `info_name`, `info_address`, `info_telfax`, `info_website`, `info_contactperson`, `info_email`, `info_description`, `info_activate`, `info_deleted`, `info_create`, `info_created_by`, `info_modified_by`, `info_modified`) VALUES
(1, 2, 'Vendor 1', ' Address ', '456546', 'sdsadsa', 'sdsdsa', 'sdsada', 'sdasdas', 0, 0, '2009-02-19 17:07:21', 62, 62, '2009-02-23 15:38:36'),
(2, 3, 'Supplier 1', 'Address ', '5654bgf', 'df', 'fd', 'sdsada', 'fsdfds', 0, 1, '2009-02-19 17:08:41', 62, 62, '2009-03-01 08:09:24'),
(4, 2, 'Vendor 2', ' Address ', '456546', 'sdsadsa', 'sdsdsa', 'sdsada', 'fsf dfgdf', 0, 0, '2009-03-03 17:48:03', 62, 62, '2009-03-03 17:48:13'),
(5, 2, 'Vendor 3', 'Vendor 3', 'Vendor 3', 'Vendor 3', 'Vendor 3', 'Vendor 3', 'Vendor 3', 0, 0, '2009-03-03 17:48:40', 62, 0, '0000-00-00 00:00:00'),
(6, 3, 'Supplier 1', ' Address ', '456546', 'Vendor 3', 'sdsdsa', 'sdsada', 'fdh fghfgh', 0, 0, '2009-03-09 16:26:21', 62, 0, '0000-00-00 00:00:00'),
(7, 3, 'Supplier 2', 'Supplier 2', '456456', 'Supplier 2', 'Supplier 2', 'Supplier 2', 'Supplier 2', 0, 0, '2009-03-09 16:26:41', 62, 0, '0000-00-00 00:00:00'),
(8, 3, 'Supplier 3', 'Supplier 3', 'Supplier 3', 'Supplier 3', 'Supplier 3', 'Supplier 3', 'Supplier 3', 0, 0, '2009-03-09 16:26:58', 62, 0, '0000-00-00 00:00:00'),
(9, 3, 'Supplier 4', 'Supplier 4', 'Supplier 4', 'Supplier 4', 'Supplier 4', 'Supplier 4', 'Supplier 4', 0, 0, '2009-03-09 16:27:11', 62, 0, '0000-00-00 00:00:00'),
(10, 4, 'Manufacture 1', 'Manufacture 1', 'Manufacture 1', 'Manufacture 1', 'Manufacture 1', 'Manufacture 1', 'Manufacture 1', 0, 0, '2009-03-09 16:27:32', 62, 0, '0000-00-00 00:00:00'),
(11, 4, 'Manufacture 2', 'Manufacture 2', 'Manufacture 2', 'Manufacture 2', 'Manufacture 2', 'Manufacture 2', 'Manufacture 2', 0, 0, '2009-03-09 16:27:43', 62, 0, '0000-00-00 00:00:00'),
(12, 4, 'Manufacture 3', 'Manufacture 3', 'Manufacture 3', 'Manufacture 3', 'Manufacture 3', 'Manufacture 3', 'Manufacture 3', 0, 0, '2009-03-09 16:27:54', 62, 0, '0000-00-00 00:00:00'),
(13, 4, 'Manufacture 4', 'Manufacture 4', 'Manufacture 4', 'Manufacture 4', 'Manufacture 4', 'Manufacture 4', 'Manufacture 4', 0, 0, '2009-03-09 16:28:09', 62, 0, '0000-00-00 00:00:00');

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
  `user_enable` tinyint(1) NOT NULL DEFAULT '0',
  `user_group` tinyint(1) NOT NULL,
  `user_create` datetime NOT NULL,
  `user_create_by` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `apdm_users`
--

INSERT INTO `apdm_users` (`user_id`, `user_firstname`, `user_lastname`, `username`, `user_password`, `user_title`, `user_mobile`, `user_telephone`, `user_enable`, `user_group`, `user_create`, `user_create_by`) VALUES
(74, 'Test1', '1', 'test@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', 'ttitle 2', '5656', '56765', 0, 23, '2009-01-07 18:21:40', 64),
(75, 'Test 2', '2', 'test2@yahoo.com', 'd41d8cd98f00b204e9800998ecf8427e', 'title 2', '123457', '12344', 0, 23, '2009-01-10 04:20:56', 76),
(76, 'apdm', '1', 'apdm@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', 'This ttitle of user', '4534', '21312', 0, 24, '2009-01-10 08:50:49', 62),
(77, 'Phuc', 'Le', 'phucle@yahoo.com', 'd41d8cd98f00b204e9800998ecf8427e', 'title of user phuc le', '', '', 0, 24, '2009-02-06 15:48:26', 64);

-- --------------------------------------------------------

--
-- Table structure for table `apdm_user_history`
--

DROP TABLE IF EXISTS `apdm_user_history`;
CREATE TABLE IF NOT EXISTS `apdm_user_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `history_date` datetime NOT NULL,
  `history_where` varchar(255) DEFAULT NULL,
  `history_what` text,
  `history_todo_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

--
-- Dumping data for table `apdm_user_history`
--

INSERT INTO `apdm_user_history` (`history_id`, `history_date`, `history_where`, `history_what`, `history_todo_id`, `user_id`) VALUES
(1, '2009-01-11 06:13:46', '1', 'W', 1, 76),
(2, '2009-01-11 06:23:25', '1', 'W', 2, 76),
(3, '2009-01-11 06:25:48', '1', 'W', 3, 76),
(8, '2009-01-11 09:05:24', '1', 'E', 2, 76),
(7, '2009-01-11 09:04:32', '1', 'D', 1, 76),
(6, '2009-01-11 06:35:11', '1', 'E', 5, 76),
(9, '2009-01-11 10:04:48', '1', 'R', 1, 76),
(10, '2009-01-11 10:08:50', '1', 'D', 1, 76),
(11, '2009-01-11 10:08:50', '1', 'D', 2, 76),
(12, '2009-01-11 10:09:10', '1', 'R', 1, 76),
(13, '2009-01-11 10:09:54', '1', 'E', 1, 76),
(14, '2009-02-09 15:55:34', '1', 'W', 6, 64),
(15, '2009-02-09 15:58:59', '1', 'E', 6, 64),
(16, '2009-02-09 15:59:53', '1', 'D', 6, 64),
(17, '2009-02-09 16:01:49', '1', 'W', 7, 64),
(18, '2009-02-09 16:04:07', '1', 'E', 7, 64),
(19, '2009-02-09 16:04:20', '1', 'W', 8, 64),
(20, '2009-02-09 16:04:32', '1', 'W', 9, 64),
(21, '2009-02-09 16:13:02', '1', 'E', 7, 64),
(22, '2009-02-09 16:13:06', '1', 'E', 7, 64),
(23, '2009-02-09 16:13:09', '1', 'E', 8, 64),
(24, '2009-02-09 16:13:11', '1', 'E', 8, 64),
(25, '2009-02-12 16:31:37', '1', 'W', 10, 64),
(26, '2009-02-12 16:32:05', '1', 'E', 7, 64),
(27, '2009-02-12 16:33:20', '1', 'E', 7, 64),
(28, '2009-02-19 17:07:21', '2', 'W', 1, 62),
(29, '2009-02-19 17:08:41', '3', 'W', 2, 62),
(30, '2009-02-19 17:45:22', '2', 'E', 1, 62),
(31, '2009-02-19 17:45:24', '2', 'E', 1, 62),
(32, '2009-02-19 17:45:27', '3', 'E', 2, 62),
(33, '2009-02-19 17:45:30', '2', 'E', 1, 62),
(34, '2009-02-19 17:45:42', '2', 'D', 1, 62),
(35, '2009-02-19 17:52:44', '2', 'E', 1, 62),
(36, '2009-02-19 17:52:46', '3', 'E', 2, 62),
(37, '2009-02-23 15:33:07', '3', 'E', 2, 62),
(38, '2009-02-23 15:38:03', '2', 'E', 1, 62),
(39, '2009-02-23 15:38:36', '2', 'E', 1, 62),
(40, '2009-02-23 15:38:39', '3', 'E', 2, 62),
(41, '2009-02-23 15:39:03', '3', 'W', 3, 62),
(42, '2009-02-23 15:39:51', '3', 'D', 3, 62),
(43, '2009-02-23 17:28:04', '5', 'W', 1, 62),
(44, '2009-02-23 17:30:39', '5', 'W', 2, 62),
(45, '2009-02-23 17:31:00', '5', 'W', 3, 62),
(46, '2009-02-23 17:32:11', '5', 'W', 4, 62),
(47, '2009-02-25 17:19:25', '5', 'W', 5, 62),
(48, '2009-02-25 17:20:06', '5', 'W', 6, 62),
(49, '2009-02-25 17:20:54', '5', 'E', 6, 62),
(50, '2009-02-25 17:21:32', '5', 'E', 6, 62),
(51, '2009-02-25 17:45:52', '5', 'E', 6, 62),
(52, '2009-02-25 17:45:55', '5', 'E', 6, 62),
(53, '2009-02-25 17:45:58', '5', 'E', 1, 62),
(54, '2009-02-25 17:46:30', '5', 'E', 6, 62),
(55, '2009-02-25 17:48:09', '5', 'E', 6, 62),
(56, '2009-02-25 17:48:40', '5', 'E', 6, 62),
(57, '2009-02-25 17:49:52', '5', 'E', 6, 62),
(58, '2009-02-25 17:50:20', '5', 'E', 6, 62),
(59, '2009-02-25 17:50:23', '5', 'E', 6, 62),
(60, '2009-02-25 17:50:25', '5', 'E', 1, 62),
(61, '2009-02-25 17:50:28', '5', 'E', 1, 62),
(62, '2009-02-25 17:50:29', '5', 'E', 6, 62),
(63, '2009-02-25 17:52:57', '5', 'D', 2, 62),
(64, '2009-02-25 17:52:57', '5', 'D', 3, 62),
(65, '2009-02-25 17:53:38', '5', 'E', 1, 62),
(66, '2009-02-25 17:53:41', '5', 'E', 6, 62),
(67, '2009-02-26 16:58:52', '1', 'E', 7, 75),
(68, '2009-02-26 16:58:55', '1', 'E', 7, 75),
(69, '2009-03-01 05:02:55', '3', 'D', 2, 62),
(70, '2009-03-01 05:03:16', '5', 'D', 4, 62),
(71, '2009-03-01 07:25:28', '1', 'R', 6, 62),
(72, '2009-03-01 07:25:42', '1', 'D', 6, 62),
(73, '2009-03-01 07:25:42', '1', 'D', 7, 62),
(74, '2009-03-01 07:41:04', '3', 'R', 2, 62),
(75, '2009-03-01 07:41:17', '3', 'R', 2, 62),
(76, '2009-03-01 07:41:21', '3', 'R', 3, 62),
(77, '2009-03-01 07:41:57', '3', 'R', 2, 62),
(78, '2009-03-01 07:44:24', '3', 'R', 2, 62),
(79, '2009-03-01 07:51:26', '5', 'D', 1, 62),
(80, '2009-03-01 07:56:03', '5', 'D', 6, 62),
(81, '2009-03-01 08:04:53', '5', 'R', 6, 62),
(82, '2009-03-01 08:04:53', '5', 'R', 1, 62),
(83, '2009-03-01 08:04:53', '5', 'R', 2, 62),
(84, '2009-03-01 08:04:53', '5', 'R', 3, 62),
(85, '2009-03-01 08:05:56', '5', 'E', 1, 62),
(86, '2009-03-01 08:06:12', '5', 'E', 2, 62),
(87, '2009-03-01 08:06:23', '5', 'D', 1, 62),
(88, '2009-03-01 08:06:23', '5', 'D', 2, 62),
(89, '2009-03-01 08:09:24', '3', 'D', 2, 62),
(90, '2009-03-03 17:48:03', '2', 'W', 4, 62),
(91, '2009-03-03 17:48:13', '2', 'E', 4, 62),
(92, '2009-03-03 17:48:40', '2', 'W', 5, 62),
(93, '2009-03-03 18:08:50', '1', 'W', 11, 62),
(94, '2009-03-09 16:26:21', '3', 'W', 6, 62),
(95, '2009-03-09 16:26:41', '3', 'W', 7, 62),
(96, '2009-03-09 16:26:58', '3', 'W', 8, 62),
(97, '2009-03-09 16:27:11', '3', 'W', 9, 62),
(98, '2009-03-09 16:27:32', '4', 'W', 10, 62),
(99, '2009-03-09 16:27:43', '4', 'W', 11, 62),
(100, '2009-03-09 16:27:54', '4', 'W', 12, 62),
(101, '2009-03-09 16:28:09', '4', 'W', 13, 62),
(102, '2009-03-26 18:00:32', '6', 'D', 10, 62),
(103, '2009-03-29 16:13:07', '6', 'E', 4, 62),
(104, '2009-03-30 16:29:39', '6', 'E', 9, 62),
(105, '2009-03-30 17:19:16', '6', 'D', 1, 62),
(106, '2009-03-30 17:20:13', '6', 'D', 1, 62),
(107, '2009-03-30 18:37:08', '6', 'E', 6, 62),
(108, '2009-03-31 16:38:47', '6', 'E', 7, 62),
(109, '2009-04-06 09:32:43', '6', 'E', 8, 62),
(110, '2009-04-06 09:50:36', '6', 'E', 6, 62),
(111, '2009-04-06 09:50:42', '6', 'E', 6, 62),
(112, '2009-04-06 09:51:15', '6', 'E', 6, 62),
(113, '2009-04-06 09:51:54', '6', 'E', 9, 62),
(114, '2009-04-06 10:04:10', '6', 'E', 9, 62),
(115, '2009-04-06 10:50:18', '6', 'D', 8, 62),
(116, '2009-04-06 10:51:18', '6', 'D', 9, 62),
(117, '2009-04-06 15:37:42', '6', 'E', 3, 62),
(118, '2009-04-06 15:37:48', '6', 'W', 11, 62),
(119, '2009-04-06 15:41:27', '6', 'E', 2, 62),
(120, '2009-04-11 01:32:15', '6', 'E', 6, 64),
(121, '2009-04-11 01:32:58', '6', 'E', 6, 64),
(122, '2009-04-11 01:34:59', '6', 'D', 3, 64),
(123, '2009-04-11 01:35:59', '6', 'E', 4, 64),
(124, '2009-04-11 01:36:34', '6', 'E', 4, 64);

-- --------------------------------------------------------

--
-- Table structure for table `jos_banner`
--

DROP TABLE IF EXISTS `jos_banner`;
CREATE TABLE IF NOT EXISTS `jos_banner` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT 'banner',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `imageurl` varchar(100) NOT NULL DEFAULT '',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  `showBanner` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `custombannercode` text,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tags` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`bid`),
  KEY `viewbanner` (`showBanner`),
  KEY `idx_banner_catid` (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jos_banner`
--

INSERT INTO `jos_banner` (`bid`, `cid`, `type`, `name`, `alias`, `imptotal`, `impmade`, `clicks`, `imageurl`, `clickurl`, `date`, `showBanner`, `checked_out`, `checked_out_time`, `editor`, `custombannercode`, `catid`, `description`, `sticky`, `ordering`, `publish_up`, `publish_down`, `tags`, `params`) VALUES
(1, 1, '', 'banner1', 'banner1', 0, 0, 0, 'osmbanner1.png', '', '2009-03-10 16:13:34', 1, 0, '0000-00-00 00:00:00', '', '', 1, '', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'width=100\nheight=100');

-- --------------------------------------------------------

--
-- Table structure for table `jos_bannerclient`
--

DROP TABLE IF EXISTS `jos_bannerclient`;
CREATE TABLE IF NOT EXISTS `jos_bannerclient` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` time DEFAULT NULL,
  `editor` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jos_bannerclient`
--

INSERT INTO `jos_bannerclient` (`cid`, `name`, `contact`, `email`, `extrainfo`, `checked_out`, `checked_out_time`, `editor`) VALUES
(1, 'Client 1', 'Client 1', 'a12@a.com', 'Client 1', 0, '00:00:00', '');

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `section` varchar(50) NOT NULL DEFAULT '',
  `image_position` varchar(30) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jos_categories`
--

INSERT INTO `jos_categories` (`id`, `parent_id`, `title`, `name`, `alias`, `image`, `section`, `image_position`, `description`, `published`, `checked_out`, `checked_out_time`, `editor`, `ordering`, `access`, `count`, `params`) VALUES
(1, 0, 'Cate 1', '', 'cate-1', '', 'com_banner', 'left', 'Cate 1', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `jos_components`
--

DROP TABLE IF EXISTS `jos_components`;
CREATE TABLE IF NOT EXISTS `jos_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `menuid` int(11) unsigned NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `admin_menu_link` varchar(255) NOT NULL DEFAULT '',
  `admin_menu_alt` varchar(255) NOT NULL DEFAULT '',
  `option` varchar(50) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `admin_menu_img` varchar(255) NOT NULL DEFAULT '',
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent_option` (`parent`,`option`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `jos_components`
--

INSERT INTO `jos_components` (`id`, `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
(1, 'Banners', '', 0, 0, '', 'Banner Management', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, 'track_impressions=0\ntrack_clicks=0\ntag_prefix=\n\n', 1),
(2, 'Banners', '', 0, 1, 'option=com_banners', 'Active Banners', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '', 1),
(3, 'Clients', '', 0, 1, 'option=com_banners&c=client', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(4, 'Web Links', 'option=com_weblinks', 0, 0, '', 'Manage Weblinks', 'com_weblinks', 0, 'js/ThemeOffice/component.png', 0, 'show_comp_description=1\ncomp_description=\nshow_link_hits=1\nshow_link_description=1\nshow_other_cats=1\nshow_headings=1\nshow_page_title=1\nlink_target=0\nlink_icons=\n\n', 1),
(5, 'Links', '', 0, 4, 'option=com_weblinks', 'View existing weblinks', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '', 1),
(6, 'Categories', '', 0, 4, 'option=com_categories&section=com_weblinks', 'Manage weblink categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(7, 'Contacts', 'option=com_contact', 0, 0, '', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/component.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1),
(8, 'Contacts', '', 0, 7, 'option=com_contact', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '', 1),
(9, 'Categories', '', 0, 7, 'option=com_categories&section=com_contact_details', 'Manage contact categories', '', 2, 'js/ThemeOffice/categories.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1),
(10, 'Polls', 'option=com_poll', 0, 0, 'option=com_poll', 'Manage Polls', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(11, 'News Feeds', 'option=com_newsfeeds', 0, 0, '', 'News Feeds Management', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(12, 'Feeds', '', 0, 11, 'option=com_newsfeeds', 'Manage News Feeds', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, 'show_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n', 1),
(13, 'Categories', '', 0, 11, 'option=com_categories&section=com_newsfeeds', 'Manage Categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(14, 'User', 'option=com_user', 0, 0, '', '', 'com_user', 0, '', 1, '', 1),
(15, 'Search', 'option=com_search', 0, 0, 'option=com_search', 'Search Statistics', 'com_search', 0, 'js/ThemeOffice/component.png', 1, 'enabled=0\n\n', 1),
(16, 'Categories', '', 0, 1, 'option=com_categories&section=com_banner', 'Categories', '', 3, '', 1, '', 1),
(17, 'Wrapper', 'option=com_wrapper', 0, 0, '', 'Wrapper', 'com_wrapper', 0, '', 1, '', 1),
(18, 'Mail To', '', 0, 0, '', '', 'com_mailto', 0, '', 1, '', 1),
(19, 'Media Manager', '', 0, 0, 'option=com_media', 'Media Manager', 'com_media', 0, '', 1, 'upload_extensions=bmp,csv,doc,epg,gif,ico,jpg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,EPG,GIF,ICO,JPG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\nupload_maxsize=10000000\nfile_path=images\nimage_path=images/stories\nrestrict_uploads=1\ncheck_mime=1\nimage_extensions=bmp,gif,jpg,png\nignore_extensions=\nupload_mime=image/jpeg,image/gif,image/png,image/bmp,application/x-shockwave-flash,application/msword,application/excel,application/pdf,application/powerpoint,text/plain,application/x-zip\nupload_mime_illegal=text/html\nenable_flash=0\n\n', 1),
(20, 'Articles', 'option=com_content', 0, 0, '', '', 'com_content', 0, '', 1, 'show_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\nfeed_summary=0\n\n', 1),
(21, 'Configuration Manager', '', 0, 0, '', 'Configuration', 'com_config', 0, '', 1, '', 1),
(22, 'Installation Manager', '', 0, 0, '', 'Installer', 'com_installer', 0, '', 1, '', 1),
(23, 'Language Manager', '', 0, 0, '', 'Languages', 'com_languages', 0, '', 1, '', 1),
(24, 'Mass mail', '', 0, 0, '', 'Mass Mail', 'com_massmail', 0, '', 1, 'mailSubjectPrefix=\nmailBodySuffix=\n\n', 1),
(25, 'Menu Editor', '', 0, 0, '', 'Menu Editor', 'com_menus', 0, '', 1, '', 1),
(27, 'Messaging', '', 0, 0, '', 'Messages', 'com_messages', 0, '', 1, '', 1),
(28, 'Modules Manager', '', 0, 0, '', 'Modules', 'com_modules', 0, '', 1, '', 1),
(29, 'Plugin Manager', '', 0, 0, '', 'Plugins', 'com_plugins', 0, '', 1, '', 1),
(30, 'Template Manager', '', 0, 0, '', 'Templates', 'com_templates', 0, '', 1, '', 1),
(31, 'User Manager', '', 0, 0, '', 'Users', 'com_users', 0, '', 1, 'allowUserRegistration=1\nnew_usertype=Registered\nuseractivation=1\nfrontend_userparams=1\n\n', 1),
(32, 'Cache Manager', '', 0, 0, '', 'Cache', 'com_cache', 0, '', 1, '', 1),
(33, 'Control Panel', '', 0, 0, '', 'Control Panel', 'com_cpanel', 0, '', 1, '', 1),
(34, 'APDM Users Management', 'option=com_apdmusers', 0, 0, 'option=com_apdmusers', 'APDM Users Management', 'com_apdmusers', 0, 'user.png', 0, '', 1),
(41, 'APDM Information Supplier Management', 'option=com_apdmsuppliers', 0, 0, 'option=com_apdmsuppliers', 'APDM Information Supplier Management', 'com_apdmsuppliers', 0, 'component.png', 0, '', 1),
(40, 'APDM Commodity Code Management', 'option=com_apdmccs', 0, 0, 'option=com_apdmccs', 'APDM Commodity Code Management', 'com_apdmccs', 0, 'component.png', 0, '', 1),
(37, 'APDM Role Management', 'option=com_roles', 0, 0, 'option=com_roles', 'APDM Role Management', 'com_roles', 0, 'config.png', 0, '', 1),
(42, 'APDM ECO Management', 'option=com_apdmeco', 0, 0, 'option=com_apdmeco', 'APDM ECO Management', 'com_apdmeco', 0, 'component.png', 0, '', 1),
(43, 'APDM Recyle Bin Management', 'option=com_apdmrecylebin', 0, 0, 'option=com_apdmrecylebin', 'APDM ECO Management', 'com_apdmrecylebin', 0, 'trash.png', 0, '', 1),
(44, 'Commodity Code', '', 0, 43, 'option=com_apdmrecylebin&task=ccs', 'Commodity Code', 'com_apdmrecylebin', 0, 'trash.png', 0, '', 1),
(45, 'Info VD/SP/MF', '', 0, 43, 'option=com_apdmrecylebin&task=info', 'Info VD/SP/MF', 'com_apdmrecylebin', 1, 'trash.png', 0, '', 1),
(46, 'ECO', '', 0, 43, 'option=com_apdmrecylebin&task=eco', 'ECO', 'com_apdmrecylebin', 2, 'trash.png', 0, '', 1),
(47, 'Part Number', '', 0, 43, 'option=com_apdmrecylebin&task=pns', 'Part Number', 'com_apdmrecylebin', 3, 'trash.png', 0, '', 1),
(48, 'APDM PNs Management', 'option=com_apdmpns', 0, 0, 'option=com_apdmpns', 'APDM PNs Management', 'com_apdmpns', 0, 'pns.png', 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jos_contact_details`
--

DROP TABLE IF EXISTS `jos_contact_details`;
CREATE TABLE IF NOT EXISTS `jos_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `con_position` varchar(255) DEFAULT NULL,
  `address` text,
  `suburb` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `misc` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `imagepos` varchar(20) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `webpage` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title_alias` varchar(255) NOT NULL DEFAULT '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `sectionid` int(11) unsigned NOT NULL DEFAULT '0',
  `mask` int(11) unsigned NOT NULL DEFAULT '0',
  `catid` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL DEFAULT '1',
  `parentid` int(11) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  PRIMARY KEY (`id`),
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
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
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
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(11) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(11) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_value` varchar(240) NOT NULL DEFAULT '0',
  `value` varchar(240) NOT NULL DEFAULT '',
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `jos_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `jos_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `jos_core_acl_aro`
--

INSERT INTO `jos_core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(11, 'users', '63', 0, 'manager', 0),
(12, 'users', '64', 0, 'administrator', 0),
(23, 'users', '75', 0, 'Test 2 2', 0),
(22, 'users', '74', 0, 'Test1 1', 0),
(24, 'users', '76', 0, 'apdm 1', 0),
(25, 'users', '77', 0, 'Phuc Le', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jos_core_acl_aro_groups`
--

DROP TABLE IF EXISTS `jos_core_acl_aro_groups`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `jos_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `jos_core_acl_aro_groups`
--

INSERT INTO `jos_core_acl_aro_groups` (`id`, `parent_id`, `name`, `lft`, `rgt`, `value`) VALUES
(17, 0, 'ROOT', 1, 22, 'ROOT'),
(28, 17, 'USERS', 2, 21, 'USERS'),
(29, 28, 'Public Frontend', 3, 12, 'Public Frontend'),
(18, 29, 'Registered', 4, 11, 'Registered'),
(19, 18, 'Author', 5, 10, 'Author'),
(20, 19, 'Editor', 6, 9, 'Editor'),
(21, 20, 'Publisher', 7, 8, 'Publisher'),
(30, 28, 'Public Backend', 13, 20, 'Public Backend'),
(23, 30, 'Manager', 14, 19, 'Manager'),
(24, 23, 'Administrator', 15, 18, 'Administrator'),
(25, 24, 'Super Administrator', 16, 17, 'Super Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `jos_core_acl_aro_map`
--

DROP TABLE IF EXISTS `jos_core_acl_aro_map`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_map` (
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(230) NOT NULL DEFAULT '0',
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`acl_id`,`section_value`,`value`)
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(230) NOT NULL DEFAULT '',
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(230) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `jos_gacl_value_aro_sections` (`value`),
  KEY `jos_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `jos_core_acl_aro_sections`
--

INSERT INTO `jos_core_acl_aro_sections` (`id`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', 1, 'Users', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jos_core_acl_groups_aro_map`
--

DROP TABLE IF EXISTS `jos_core_acl_groups_aro_map`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(240) NOT NULL DEFAULT '',
  `aro_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jos_core_acl_groups_aro_map`
--

INSERT INTO `jos_core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(23, '', 11),
(23, '', 18),
(23, '', 19),
(23, '', 22),
(23, '', 23),
(24, '', 12),
(24, '', 24),
(24, '', 25),
(25, '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `jos_core_log_items`
--

DROP TABLE IF EXISTS `jos_core_log_items`;
CREATE TABLE IF NOT EXISTS `jos_core_log_items` (
  `time_stamp` date NOT NULL DEFAULT '0000-00-00',
  `item_table` varchar(50) NOT NULL DEFAULT '',
  `item_id` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0'
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
  `search_term` varchar(128) NOT NULL DEFAULT '',
  `hits` int(11) unsigned NOT NULL DEFAULT '0'
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
  `id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jos_groups`
--

INSERT INTO `jos_groups` (`id`, `name`) VALUES
(0, 'Public'),
(1, 'Registered'),
(2, 'Special');

-- --------------------------------------------------------

--
-- Table structure for table `jos_menu`
--

DROP TABLE IF EXISTS `jos_menu`;
CREATE TABLE IF NOT EXISTS `jos_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(75) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `link` text,
  `type` varchar(50) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `componentid` int(11) unsigned NOT NULL DEFAULT '0',
  `sublevel` int(11) DEFAULT '0',
  `ordering` int(11) DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL DEFAULT '0',
  `browserNav` tinyint(4) DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `utaccess` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL DEFAULT '0',
  `rgt` int(11) unsigned NOT NULL DEFAULT '0',
  `home` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jos_menu`
--

INSERT INTO `jos_menu` (`id`, `menutype`, `name`, `alias`, `link`, `type`, `published`, `parent`, `componentid`, `sublevel`, `ordering`, `checked_out`, `checked_out_time`, `pollid`, `browserNav`, `access`, `utaccess`, `params`, `lft`, `rgt`, `home`) VALUES
(1, 'mainmenu', 'Home', 'home', 'index.php?option=com_content&view=frontpage', 'component', 1, 0, 20, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'num_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\norderby_pri=\norderby_sec=front\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jos_menu_types`
--

DROP TABLE IF EXISTS `jos_menu_types`;
CREATE TABLE IF NOT EXISTS `jos_menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menutype` varchar(75) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jos_menu_types`
--

INSERT INTO `jos_menu_types` (`id`, `menutype`, `title`, `description`) VALUES
(1, 'mainmenu', 'Main Menu', 'The main menu for the site');

-- --------------------------------------------------------

--
-- Table structure for table `jos_messages`
--

DROP TABLE IF EXISTS `jos_messages`;
CREATE TABLE IF NOT EXISTS `jos_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` int(11) NOT NULL DEFAULT '0',
  `priority` int(1) unsigned NOT NULL DEFAULT '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`),
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
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) NOT NULL DEFAULT '',
  `cfg_value` varchar(255) NOT NULL DEFAULT '',
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
  PRIMARY KEY (`itemid`)
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) DEFAULT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `numnews` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `control` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `jos_modules`
--

INSERT INTO `jos_modules` (`id`, `title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`, `control`) VALUES
(1, 'Main Menu', '', 1, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu\nmoduleclass_sfx=_menu\n', 1, 0, ''),
(2, 'Login', '', 1, 'login', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 1, ''),
(3, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 0, 'mod_popular', 0, 2, 1, '', 0, 1, ''),
(4, 'Recent added Articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 0, 'mod_latest', 0, 2, 1, 'ordering=c_dsc\nuser_id=0\ncache=0\n\n', 0, 1, ''),
(5, 'Menu Stats', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 0, 'mod_stats', 0, 2, 1, '', 0, 1, ''),
(6, 'Unread Messages', '', 1, 'header', 0, '0000-00-00 00:00:00', 0, 'mod_unread', 0, 2, 1, '', 1, 1, ''),
(7, 'Online Users', '', 2, 'header', 0, '0000-00-00 00:00:00', 0, 'mod_online', 0, 2, 1, '', 1, 1, ''),
(8, 'Toolbar', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 2, 1, '', 1, 1, ''),
(9, 'Quick Icons', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 2, 1, '', 1, 1, ''),
(10, 'Logged in Users', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 2, 1, '', 0, 1, ''),
(11, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1, ''),
(12, 'Admin Menu', '', 1, 'menu', 0, '0000-00-00 00:00:00', 1, 'mod_menu', 0, 2, 1, '', 0, 1, ''),
(13, 'Admin SubMenu', '', 1, 'submenu', 0, '0000-00-00 00:00:00', 1, 'mod_submenu', 0, 2, 1, '', 0, 1, ''),
(14, 'User Status', '', 1, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_status', 0, 2, 1, '', 0, 1, ''),
(15, 'Title', '', 1, 'title', 0, '0000-00-00 00:00:00', 1, 'mod_title', 0, 2, 1, '', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `jos_modules_menu`
--

DROP TABLE IF EXISTS `jos_modules_menu`;
CREATE TABLE IF NOT EXISTS `jos_modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jos_modules_menu`
--

INSERT INTO `jos_modules_menu` (`moduleid`, `menuid`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jos_newsfeeds`
--

DROP TABLE IF EXISTS `jos_newsfeeds`;
CREATE TABLE IF NOT EXISTS `jos_newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `link` text NOT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(11) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(11) unsigned NOT NULL DEFAULT '3600',
  `checked_out` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rtl` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `element` varchar(100) NOT NULL DEFAULT '',
  `folder` varchar(100) NOT NULL DEFAULT '',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `iscore` tinyint(3) NOT NULL DEFAULT '0',
  `client_id` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `jos_plugins`
--

INSERT INTO `jos_plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', 'host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n'),
(3, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'autoregister=1\n\n'),
(6, 'Search - Content', 'content', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n'),
(7, 'Search - Contacts', 'contacts', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(8, 'Search - Categories', 'categories', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(9, 'Search - Sections', 'sections', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(10, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(11, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(12, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', 'enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n'),
(13, 'Content - Rating', 'vote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'mode=1\n\n'),
(15, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'enabled=1\nstyle=0\n\n'),
(17, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'position=1\n\n'),
(18, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Editor - TinyMCE 2.0', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced\ncleanup=1\ncleanup_startup=0\nautosave=0\ncompressed=0\nrelative_urls=1\ntext_direction=ltr\nlang_mode=0\nlang_code=en\ninvalid_elements=applet\ncontent_css=1\ncontent_css_custom=\nnewlines=0\ntoolbar=top\nhr=1\nsmilies=1\ntable=1\nstyle=1\nlayer=1\nxhtmlxtras=0\ntemplate=0\ndirectionality=1\nfullscreen=1\nhtml_height=550\nhtml_width=750\npreview=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\n\n'),
(20, 'Editor - XStandard Lite 2.0', 'xstandard', 'editors', 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(21, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(22, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(23, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(24, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(25, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', 'catid=1\nsectionid=0\n\n'),
(27, 'System - SEF', 'sef', 'system', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(28, 'System - Debug', 'debug', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', 'queries=1\nmemory=1\nlangauge=1\n\n'),
(29, 'System - Legacy', 'legacy', 'system', 0, 3, 0, 1, 0, 0, '0000-00-00 00:00:00', 'route=0\n\n'),
(30, 'System - Cache', 'cache', 'system', 0, 4, 0, 1, 0, 0, '0000-00-00 00:00:00', 'browsercache=0\ncachetime=15\n\n'),
(31, 'System - Log', 'log', 'system', 0, 5, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(32, 'System - Remember Me', 'remember', 'system', 0, 6, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(33, 'System - Backlink', 'backlink', 'system', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `jos_polls`
--

DROP TABLE IF EXISTS `jos_polls`;
CREATE TABLE IF NOT EXISTS `jos_polls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `voters` int(9) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `lag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `jos_polls`
--


-- --------------------------------------------------------

--
-- Table structure for table `jos_poll_data`
--

DROP TABLE IF EXISTS `jos_poll_data`;
CREATE TABLE IF NOT EXISTS `jos_poll_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL DEFAULT '0',
  `poll_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
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
  `pollid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jos_poll_menu`
--


-- --------------------------------------------------------

--
-- Table structure for table `jos_sections`
--

DROP TABLE IF EXISTS `jos_sections`;
CREATE TABLE IF NOT EXISTS `jos_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` text NOT NULL,
  `scope` varchar(50) NOT NULL DEFAULT '',
  `image_position` varchar(30) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jos_sections`
--

INSERT INTO `jos_sections` (`id`, `title`, `name`, `alias`, `image`, `scope`, `image_position`, `description`, `published`, `checked_out`, `checked_out_time`, `ordering`, `access`, `count`, `params`) VALUES
(1, 'Test 1', '', 'test-1', '', 'content', 'left', '', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `jos_session`
--

DROP TABLE IF EXISTS `jos_session`;
CREATE TABLE IF NOT EXISTS `jos_session` (
  `username` varchar(150) DEFAULT '',
  `time` varchar(14) DEFAULT '',
  `session_id` varchar(200) NOT NULL DEFAULT '0',
  `guest` tinyint(4) DEFAULT '1',
  `userid` int(11) DEFAULT '0',
  `usertype` varchar(50) DEFAULT '',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `data` longtext,
  PRIMARY KEY (`session_id`(64)),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jos_session`
--

INSERT INTO `jos_session` (`username`, `time`, `session_id`, `guest`, `userid`, `usertype`, `gid`, `client_id`, `data`) VALUES
('administrator', '1239413909', '3a5c842736825cce6d30d25453a78392', 0, 64, 'Administrator', 24, 1, '__default|a:8:{s:15:"session.counter";i:81;s:19:"session.timer.start";i:1239413406;s:18:"session.timer.last";i:1239413909;s:17:"session.timer.now";i:1239413909;s:22:"session.client.browser";s:90:"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8";s:8:"registry";O:9:"JRegistry":3:{s:17:"_defaultNameSpace";s:7:"session";s:9:"_registry";a:4:{s:7:"session";a:1:{s:4:"data";O:8:"stdClass":0:{}}s:11:"application";a:1:{s:4:"data";O:8:"stdClass":1:{s:4:"lang";s:0:"";}}s:11:"com_apdmpns";a:1:{s:4:"data";O:8:"stdClass":9:{s:12:"filter_order";s:8:"p.pns_id";s:16:"filter_order_Dir";s:4:"desc";s:13:"filter_status";s:0:"";s:11:"filter_type";s:0:"";s:17:"filter_created_by";i:0;s:18:"filter_modified_by";i:0;s:11:"text_search";s:0:"";s:11:"type_filter";i:0;s:10:"limitstart";i:0;}}s:6:"global";a:1:{s:4:"data";O:8:"stdClass":1:{s:4:"list";O:8:"stdClass":1:{s:5:"limit";s:2:"20";}}}}s:7:"_errors";a:0:{}}s:4:"user";O:5:"JUser":19:{s:2:"id";s:2:"64";s:4:"name";s:13:"administrator";s:8:"username";s:13:"administrator";s:5:"email";s:23:"administrator@yahoo.com";s:8:"password";s:65:"e6ecc578e38d25d443cff4a8ec784bf6:WBZDwhykMmwZjpIYfrER41NPRDf1t8wr";s:14:"password_clear";s:0:"";s:8:"usertype";s:13:"Administrator";s:5:"block";s:1:"0";s:9:"sendEmail";s:1:"0";s:3:"gid";s:2:"24";s:12:"registerDate";s:19:"2008-12-11 15:02:12";s:13:"lastvisitDate";s:19:"2009-03-02 16:06:29";s:10:"activation";s:0:"";s:6:"params";s:56:"admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n";s:3:"aid";i:2;s:5:"guest";i:0;s:7:"_params";O:10:"JParameter":7:{s:4:"_raw";s:0:"";s:4:"_xml";N;s:9:"_elements";a:0:{}s:12:"_elementPath";a:1:{i:0;s:78:"C:\\Program Files\\xampp\\htdocs\\www\\adpm\\libraries\\joomla\\html\\parameter\\element";}s:17:"_defaultNameSpace";s:8:"_default";s:9:"_registry";a:1:{s:8:"_default";a:1:{s:4:"data";O:8:"stdClass":5:{s:14:"admin_language";s:0:"";s:8:"language";s:0:"";s:6:"editor";s:0:"";s:8:"helpsite";s:0:"";s:8:"timezone";s:1:"0";}}}s:7:"_errors";a:0:{}}s:9:"_errorMsg";N;s:7:"_errors";a:0:{}}s:13:"session.token";s:32:"110376b77a936cb26c85c9d7c0c81a06";}');

-- --------------------------------------------------------

--
-- Table structure for table `jos_stats_agents`
--

DROP TABLE IF EXISTS `jos_stats_agents`;
CREATE TABLE IF NOT EXISTS `jos_stats_agents` (
  `agent` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '1'
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
  `template` varchar(255) NOT NULL DEFAULT '',
  `menuid` int(11) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menuid`,`client_id`,`template`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jos_templates_menu`
--

INSERT INTO `jos_templates_menu` (`template`, `menuid`, `client_id`) VALUES
('rhuk_milkyway', 0, 0),
('khepri', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jos_users`
--

DROP TABLE IF EXISTS `jos_users`;
CREATE TABLE IF NOT EXISTS `jos_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `jos_users`
--

INSERT INTO `jos_users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'lediemphuc@gmail.com', 'b1e0e11880677c342883e79b78f707e3:SXDN6oVrRNMLYv00adJi05dZiRtw4Abc', 'Super Administrator', 0, 1, 25, '2008-11-19 00:02:33', '2009-04-09 15:48:25', '', ''),
(63, 'manager', 'manager', 'manager@yahoo.com', '7b1ec2687656c6cce8f74b456d838a86:DaTB8yC1pccYlkDq1Y8XJvEX9d4Vk3tG', 'Manager', 0, 0, 23, '2008-12-11 15:01:33', '2008-12-11 15:02:34', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(64, 'administrator', 'administrator', 'administrator@yahoo.com', 'e6ecc578e38d25d443cff4a8ec784bf6:WBZDwhykMmwZjpIYfrER41NPRDf1t8wr', 'Administrator', 0, 0, 24, '2008-12-11 15:02:12', '2009-04-11 01:30:17', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(74, 'Test1 1', 'test@yahoo.com', 'test@yahoo.com', '931734675de4add33aa4cfd6b4e723cd:Qk4sxy8QUA2QXdZLbn6DvppSqJMRs4pd', 'Manager', 0, 0, 23, '2009-01-07 18:21:40', '0000-00-00 00:00:00', '', '\n'),
(75, 'Test 2 2', 'test2@yahoo.com', 'test2@yahoo.com', '5f7a5b80114b245c088ed11087a5cf75:p6Q4355dP5ls58uPaVJ2mIJaB4vu8Qg5', 'Manager', 0, 0, 23, '2009-01-10 04:20:56', '2009-03-01 09:06:08', '', '\n'),
(76, 'apdm 1', 'apdm@yahoo.com', 'apdm@yahoo.com', '3cf9bddb260d3d8e89f0f49b17fa7c5a:bmG8Z7CGTUJGYZKu7YlghK9duxIyW2V7', 'Administrator', 0, 0, 24, '2009-01-10 08:50:49', '2009-04-09 15:54:24', '', '\n'),
(77, 'Phuc Le', 'phucle@yahoo.com', 'phucle@yahoo.com', '0f8707e629a73061ae23f18fbc4e8a85:c5dvbUrpxFraYqFHys01myOLlhqHyqiM', 'Administrator', 0, 0, 24, '2009-02-06 15:48:26', '2009-02-06 15:50:55', '', '\n');

-- --------------------------------------------------------

--
-- Table structure for table `jos_weblinks`
--

DROP TABLE IF EXISTS `jos_weblinks`;
CREATE TABLE IF NOT EXISTS `jos_weblinks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `jos_weblinks`
--

