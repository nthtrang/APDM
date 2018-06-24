DROP TABLE IF EXISTS `apdm_pns_rev`;
CREATE TABLE `apdm_pns_rev` (
  `pns_rev_id` double NOT NULL AUTO_INCREMENT,
  `pns_id` double DEFAULT NULL,
  `ccs_code` varchar(9) DEFAULT NULL,
  `pns_code` varchar(39) DEFAULT NULL,
  `pns_revision` varchar(9) DEFAULT NULL,
  `eco_id` double DEFAULT NULL,
  `pns_modified` datetime DEFAULT NULL,
  `pns_modified_by` double DEFAULT NULL,
  `pns_life_cycle` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`pns_rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


alter table `apdm_pns` add column `pns_ref_des` varchar (100)  NULL  after `pns_qty_used`, add column `pns_find_number` int (11)  NULL  after `pns_ref_des`;

alter table `apdm_eco` add column `eco_lifecycle` varchar (255) DEFAULT 'create' NOT NULL  after `eco_deleted`
insert into apdm_pns_rev(pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle) select pns_id,ccs_code,pns_code,pns_revision,eco_id,pns_life_cycle from apdm_pns;


DROP TABLE IF EXISTS `apdm_eco_routes`;
CREATE TABLE `apdm_eco_routes`(
  `id` double NOT NULL AUTO_INCREMENT,
  `eco_id` double DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(9) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `owner` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

alter table `apdm_eco_routes` add column `deleted` double  DEFAULT '0' NULL  after `owner`;

alter table `apdm_eco_status` add column `routes_id` int (11)  NULL  after `note`, add column `title` varchar (100) CHARSET utf8  COLLATE utf8_general_ci   NULL  after `routes_id`,change `note` `note` text  CHARACTER SET utf8   NOT NULL ;

alter table `apdm_eco` add column `eco_routes_id` int (11)  NULL  after `eco_lifecycle`;
alter table `apdm_eco_status` change `eco_id` `eco_id` int (11)  NOT NULL , change `username` `username` varchar (100) CHARACTER SET utf8  COLLATE utf8_general_ci   NOT NULL , change `user_id` `user_id` int (11)  NOT NULL , change `routes_id` `routes_id` int (11)  NOT NULL ,drop primary key,  add primary key(`id`, `eco_id`, `username`, `routes_id` );


DROP TABLE IF EXISTS `apdm_pns_initial`;
CREATE TABLE `apdm_pns_initial` (
  `init_id` double NOT NULL AUTO_INCREMENT,
  `pns_id` double DEFAULT NULL,
  `init_plant_status` varchar(9) DEFAULT NULL,
  `init_make_buy` varchar(39) DEFAULT NULL,
  `init_leadtime` datetime DEFAULT NULL,
  `init_buyer` varchar(100) DEFAULT NULL,
  `init_supplier` int(11) DEFAULT NULL,
  `init_cost` double DEFAULT NULL,
  `init_modified` datetime DEFAULT NULL,
  `init_modified_by` double DEFAULT NULL,
  PRIMARY KEY (`init_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


alter table `apdm_eco` add column `eco_record_number` varchar (255)  NULL  after `eco_routes_id`;


//22/06
insert into `jos_components`(`id`,`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)values(NULL,'Customers PN Management','option=com_apdmcpns','0','0','option=com_apdmcpns','Customers PNs Management','com_apdmcpns','2','pns.png','0','track=0','1')


//24/06
alter table `adpm1`.`apdm_pns` add column `pns_cpn` int (11) DEFAULT '0' NULL  after `pns_find_number`;