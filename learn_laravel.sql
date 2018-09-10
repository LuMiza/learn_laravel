/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : learn_laravel

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-09-10 18:02:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `a_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `a_username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `a_password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `a_is_disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否禁用,0启用  1禁用',
  `a_add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('3', 'admin', '555555', '0', '2018-03-18 10:59:45');
INSERT INTO `admin` VALUES ('4', 'demo', '111111', '0', '2018-03-19 22:36:07');
INSERT INTO `admin` VALUES ('5', '普通管理员', '555555', '1', '2018-07-06 15:16:46');

-- ----------------------------
-- Table structure for `admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `ar_aid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'admin表的主键id',
  `ar_role_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色表主键id',
  PRIMARY KEY (`ar_aid`),
  KEY `ar_role_id` (`ar_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色映射表';

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES ('3', '1');
INSERT INTO `admin_role` VALUES ('4', '4');
INSERT INTO `admin_role` VALUES ('5', '4');

-- ----------------------------
-- Table structure for `privilege`
-- ----------------------------
DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
  `p_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `p_name` varchar(100) NOT NULL DEFAULT '' COMMENT '权限名称',
  `module_name` varchar(100) NOT NULL DEFAULT '' COMMENT '模块名称',
  `route_name` varchar(600) NOT NULL DEFAULT '' COMMENT '路由别名',
  `action_name` varchar(600) NOT NULL DEFAULT '' COMMENT '路由方法名 【App\\Http\\Controllers\\Admin\\PowerController@rule】',
  `style_name` varchar(100) NOT NULL DEFAULT '' COMMENT '样式名称css的类名',
  `p_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父亲id',
  `p_paths` varchar(600) NOT NULL DEFAULT '' COMMENT '各级父id',
  `p_add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `p_is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除 1删除  0不删除',
  PRIMARY KEY (`p_id`),
  KEY `p_pid` (`p_pid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of privilege
-- ----------------------------
INSERT INTO `privilege` VALUES ('1', '管理员管理', 'admin', '', '', 'fa-user-o', '0', '0', '2018-09-10 16:05:02', '0');
INSERT INTO `privilege` VALUES ('2', '管理员列表', 'admin', 'admin::Admin.Power.index', 'App\\Http\\Controllers\\Admin\\PowerController@index', '', '1', '0,1', '2018-09-10 16:48:40', '0');
INSERT INTO `privilege` VALUES ('3', '添加管理员', 'admin', 'admin::Admin.Power.addAdmin', 'App\\Http\\Controllers\\Admin\\PowerController@addAdmin', '', '2', '0,1,2', '2018-09-10 16:51:04', '0');
INSERT INTO `privilege` VALUES ('4', '修改管理员', 'admin', 'admin::Admin.Power.editAdmin', 'App\\Http\\Controllers\\Admin\\PowerController@editAdmin', '', '2', '0,1,2', '2018-09-10 16:53:08', '0');
INSERT INTO `privilege` VALUES ('5', '权限列表', 'admin', 'admin::Admin.Power.rule', 'App\\Http\\Controllers\\Admin\\PowerController@rule', '', '1', '0,1', '2018-09-10 17:53:48', '0');
INSERT INTO `privilege` VALUES ('6', '添加权限', 'admin', 'admin::Admin.Power.addRule', 'App\\Http\\Controllers\\Admin\\PowerController@addRule', '', '5', '0,1,5', '2018-09-10 17:55:34', '0');

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色主键id',
  `role_name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  `role_description` varchar(600) NOT NULL DEFAULT '' COMMENT '角色描述',
  `role_add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `role_is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除 1删除  0不删除',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '超级管理员', '', '2018-03-16 13:57:32', '0');
INSERT INTO `role` VALUES ('2', '业务经理', '', '2018-03-16 13:57:51', '0');
INSERT INTO `role` VALUES ('3', '业务员', '', '2018-03-16 13:57:57', '0');
INSERT INTO `role` VALUES ('4', '业务助理', '', '2018-03-16 13:58:05', '0');
INSERT INTO `role` VALUES ('5', '行政助理', '这个是我的权限系统', '2018-03-16 13:58:16', '0');
INSERT INTO `role` VALUES ('6', 'ddds', 'dsdfdf', '2018-07-06 10:35:23', '1');
INSERT INTO `role` VALUES ('7', '呀呢', 'dsdfdf', '2018-07-06 10:36:35', '0');
INSERT INTO `role` VALUES ('8', '哦呢', 'dsdfdf', '2018-07-06 10:36:56', '0');
INSERT INTO `role` VALUES ('9', '昨天', '昨天', '2018-07-06 10:38:04', '0');

-- ----------------------------
-- Table structure for `role_privilege`
-- ----------------------------
DROP TABLE IF EXISTS `role_privilege`;
CREATE TABLE `role_privilege` (
  `rp_role_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'role角色表的主键id',
  `rp_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'privilege表的主键id',
  KEY `rp_role_id` (`rp_role_id`),
  KEY `rp_pid` (`rp_pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限映射表';

-- ----------------------------
-- Records of role_privilege
-- ----------------------------
INSERT INTO `role_privilege` VALUES ('1', '14');
INSERT INTO `role_privilege` VALUES ('1', '9');
INSERT INTO `role_privilege` VALUES ('1', '12');
INSERT INTO `role_privilege` VALUES ('1', '11');
INSERT INTO `role_privilege` VALUES ('1', '10');
INSERT INTO `role_privilege` VALUES ('1', '5');
INSERT INTO `role_privilege` VALUES ('1', '13');
INSERT INTO `role_privilege` VALUES ('1', '8');
INSERT INTO `role_privilege` VALUES ('1', '7');
INSERT INTO `role_privilege` VALUES ('1', '6');
INSERT INTO `role_privilege` VALUES ('1', '1');
INSERT INTO `role_privilege` VALUES ('1', '4');
INSERT INTO `role_privilege` VALUES ('1', '3');
INSERT INTO `role_privilege` VALUES ('1', '2');
