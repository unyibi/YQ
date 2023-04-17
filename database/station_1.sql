/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50734
 Source Host           : localhost:3306
 Source Schema         : station_1

 Target Server Type    : MySQL
 Target Server Version : 50734
 File Encoding         : 65001

 Date: 17/04/2023 10:49:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for station_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `station_admin_roles`;
CREATE TABLE `station_admin_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '账号uuid',
  `role_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色uuid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校账号角色关联表';

-- ----------------------------
-- Records of station_admin_roles
-- ----------------------------
BEGIN;
INSERT INTO `station_admin_roles` (`id`, `admin_uuid`, `role_uuid`) VALUES (2, '42bbc870-3e6a-4f9d-8837-02406c83e6c6', '83a45411-7f81-4bda-bd4e-09b3a1413170');
INSERT INTO `station_admin_roles` (`id`, `admin_uuid`, `role_uuid`) VALUES (3, '432547e0-1c7d-4ab3-bf26-cf152ccba865', '83a45411-7f81-4bda-bd4e-09b3a1413170');
COMMIT;

-- ----------------------------
-- Table structure for station_admins
-- ----------------------------
DROP TABLE IF EXISTS `station_admins`;
CREATE TABLE `station_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'uuid唯一标识',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '账号',
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `login_time` datetime DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录ip',
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '头像',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0关闭 1使用',
  `is_super` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是超级管理员：0否 1是',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`uuid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员表';

-- ----------------------------
-- Records of station_admins
-- ----------------------------
BEGIN;
INSERT INTO `station_admins` (`id`, `uuid`, `name`, `nickname`, `password`, `login_time`, `login_ip`, `avatar`, `status`, `is_super`, `create_time`, `update_time`) VALUES (1, '55787dae-5799-4a9d-8f60-4671ceb33184', 'admin', '懒羊羊', '$2y$10$UdqE4X0j3mhGqJi1MN.68ell0hhDYUWgF9fcvUJxc435b6hB48TuC', NULL, NULL, '/uploads/1/images/1.png', 1, 1, '2023-04-14 18:31:35', '2023-04-14 18:31:55');
INSERT INTO `station_admins` (`id`, `uuid`, `name`, `nickname`, `password`, `login_time`, `login_ip`, `avatar`, `status`, `is_super`, `create_time`, `update_time`) VALUES (3, 'e8378d22-db2d-4fe6-a3d8-f3678d4642da', 'kefu', '美羊羊1', '$2y$10$9t9QHNEaHwxnGpaOentupOy/gE/mRSq749mhO9E7PrrpI2SqLRBRu', NULL, NULL, '/uploads/1/images/2.png', 1, 0, '2023-04-15 09:05:49', '2023-04-15 09:30:57');
INSERT INTO `station_admins` (`id`, `uuid`, `name`, `nickname`, `password`, `login_time`, `login_ip`, `avatar`, `status`, `is_super`, `create_time`, `update_time`) VALUES (4, '127b4840-5e1c-4b07-abf1-d524896e85c1', 'kefu1', '美羊羊', '$2y$10$kYMIOZPYSVPVHQHUP3t2IOia26XTjFNA.Da6GZaQ4s3asLTcl2Ge6', NULL, NULL, '/uploads/1/images/2.png', 1, 0, '2023-04-15 09:56:03', '2023-04-15 09:56:03');
INSERT INTO `station_admins` (`id`, `uuid`, `name`, `nickname`, `password`, `login_time`, `login_ip`, `avatar`, `status`, `is_super`, `create_time`, `update_time`) VALUES (5, '42bbc870-3e6a-4f9d-8837-02406c83e6c6', 'kefu2', '美羊羊', '$2y$10$AKMqjEexxoiGEwVOLQQet.l6EThgp7ZiWUyi2MEp0v.nE2jBKC91.', NULL, NULL, '/uploads/1/images/2.png', 1, 0, '2023-04-15 09:57:34', '2023-04-15 09:57:34');
INSERT INTO `station_admins` (`id`, `uuid`, `name`, `nickname`, `password`, `login_time`, `login_ip`, `avatar`, `status`, `is_super`, `create_time`, `update_time`) VALUES (6, 'ad1f28c9-9028-4a92-9b6e-f23c16efa786', 'kefu3', '美羊羊', '$2y$10$oV6kTL1thZ04MY1Pe84NDu/x8Byw1YQ3.Jfcih6Y0MAfN7GQ7u0oW', NULL, NULL, '/uploads/1/images/2.png', 1, 0, '2023-04-15 11:04:35', '2023-04-15 11:04:35');
INSERT INTO `station_admins` (`id`, `uuid`, `name`, `nickname`, `password`, `login_time`, `login_ip`, `avatar`, `status`, `is_super`, `create_time`, `update_time`) VALUES (7, '79145399-eedf-4416-b4bc-af57a00211b6', 'kefu4', '美羊羊', '$2y$10$aJXRbn6PhXAdwMCEg/CAXuirg/RUTf/PN8bMqrkpJUlGLdH84tLIW', NULL, NULL, '/uploads/1/images/2.png', 1, 0, '2023-04-15 11:06:49', '2023-04-15 11:06:49');
INSERT INTO `station_admins` (`id`, `uuid`, `name`, `nickname`, `password`, `login_time`, `login_ip`, `avatar`, `status`, `is_super`, `create_time`, `update_time`) VALUES (8, '432547e0-1c7d-4ab3-bf26-cf152ccba865', 'kefu5', '美羊羊', '$2y$10$N5K1w12FMiyvnZAeDAuefemtjT53N0OaBFfHZQ5phMT2fj/WcUiR2', NULL, NULL, '/uploads/1/images/2.png', 1, 0, '2023-04-15 11:07:41', '2023-04-15 11:07:41');
COMMIT;

-- ----------------------------
-- Table structure for station_articles
-- ----------------------------
DROP TABLE IF EXISTS `station_articles`;
CREATE TABLE `station_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'uuid唯一标识',
  `school_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校id',
  `column_uuid` json DEFAULT NULL COMMENT '所属栏目',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `sub_title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '副标题',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图url',
  `content` longblob COMMENT '文章内容',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶:1是 0否',
  `sort` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除:1删除 0正常',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `url_md5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '爬虫加密链接',
  `jump_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '跳转外部链接类型：0不跳转 1网页 2文档',
  `jump_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转地址',
  `views_num` int(10) unsigned DEFAULT '0' COMMENT '浏览量',
  `show_app` json DEFAULT NULL COMMENT '展示端：8官网 9微信 10支付宝 11抖音 12百度 13QQ',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否展示：0否 1是',
  `is_draft` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否设为草稿：0否 1是',
  `timing_send` timestamp NULL DEFAULT NULL COMMENT '定时发送',
  `release_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  PRIMARY KEY (`id`,`uuid`) USING BTREE,
  UNIQUE KEY `url_md5` (`url_md5`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章表';

-- ----------------------------
-- Records of station_articles
-- ----------------------------
BEGIN;
INSERT INTO `station_articles` (`id`, `uuid`, `school_id`, `column_uuid`, `title`, `sub_title`, `image_url`, `content`, `is_top`, `sort`, `is_del`, `create_time`, `update_time`, `url_md5`, `jump_type`, `jump_url`, `views_num`, `show_app`, `is_show`, `is_draft`, `timing_send`, `release_time`) VALUES (7, '629542a7-55fa-4e45-9468-50f05b0050d1', 1, '[\"d651a008-9209-4306-9360-a45afdf25000\"]', '标题', '副标题', '', 0xE58685E5AEB9E58685E5AEB9E58685E5AEB9E58685E5AEB9, 0, 1, 0, '2023-04-13 11:38:03', '2023-04-13 16:09:32', NULL, 0, '', 0, '[8, 9, 10, 11, 12, 13]', 1, 0, NULL, '2023-04-13 12:12:12');
INSERT INTO `station_articles` (`id`, `uuid`, `school_id`, `column_uuid`, `title`, `sub_title`, `image_url`, `content`, `is_top`, `sort`, `is_del`, `create_time`, `update_time`, `url_md5`, `jump_type`, `jump_url`, `views_num`, `show_app`, `is_show`, `is_draft`, `timing_send`, `release_time`) VALUES (8, '1d0096ca-b549-4698-b978-b05dfbad2023', 1, '[\"d651a008-9209-4306-9360-a45afdf25000\"]', '标题', '副标题', '', 0xE58685E5AEB9E58685E5AEB9E58685E5AEB9E58685E5AEB9, 0, 1, 0, '2023-04-13 12:04:35', '2023-04-13 16:09:36', NULL, 0, '', 0, '[8, 9, 10, 11, 12, 13]', 1, 0, NULL, '2023-04-13 12:12:12');
INSERT INTO `station_articles` (`id`, `uuid`, `school_id`, `column_uuid`, `title`, `sub_title`, `image_url`, `content`, `is_top`, `sort`, `is_del`, `create_time`, `update_time`, `url_md5`, `jump_type`, `jump_url`, `views_num`, `show_app`, `is_show`, `is_draft`, `timing_send`, `release_time`) VALUES (9, '6efd39fc-297a-4809-bd93-dd04295a4c15', 1, '[\"d651a008-9209-4306-9360-a45afdf25000\"]', '标题', '副标题', '', 0xE58685E5AEB9E58685E5AEB9E58685E5AEB9E58685E5AEB9, 0, 1, 0, '2023-04-13 14:14:23', '2023-04-13 16:09:39', NULL, 0, '', 0, '[8, 9, 10, 11, 12, 13]', 1, 0, NULL, '2023-04-13 12:12:12');
INSERT INTO `station_articles` (`id`, `uuid`, `school_id`, `column_uuid`, `title`, `sub_title`, `image_url`, `content`, `is_top`, `sort`, `is_del`, `create_time`, `update_time`, `url_md5`, `jump_type`, `jump_url`, `views_num`, `show_app`, `is_show`, `is_draft`, `timing_send`, `release_time`) VALUES (10, '5b5c8474-7529-4c6e-95dd-4fc3ba7f0006', 1, '[\"d651a008-9209-4306-9360-a45afdf25000\"]', '标题1', '副标题', '', 0xE58685E5AEB9E58685E5AEB9E58685E5AEB9E58685E5AEB9, 1, 2, 1, '2023-04-13 15:09:38', '2023-04-14 09:16:05', NULL, 0, '', 0, '[8, 9, 10, 11, 12, 13]', 1, 0, NULL, '2023-04-13 12:12:12');
INSERT INTO `station_articles` (`id`, `uuid`, `school_id`, `column_uuid`, `title`, `sub_title`, `image_url`, `content`, `is_top`, `sort`, `is_del`, `create_time`, `update_time`, `url_md5`, `jump_type`, `jump_url`, `views_num`, `show_app`, `is_show`, `is_draft`, `timing_send`, `release_time`) VALUES (11, 'fe20d044-c11b-4860-a34b-6cec0a03bea1', 1, '[\"d651a008-9209-4306-9360-a45afdf25000\"]', '标题', '副标题', '', 0xE58685E5AEB9E58685E5AEB9E58685E5AEB9E58685E5AEB9, 0, 1, 0, '2023-04-13 16:07:19', '2023-04-13 16:09:45', NULL, 0, '', 0, '[8, 9, 10, 11, 12, 13]', 1, 0, NULL, '2023-04-13 12:12:12');
COMMIT;

-- ----------------------------
-- Table structure for station_columns
-- ----------------------------
DROP TABLE IF EXISTS `station_columns`;
CREATE TABLE `station_columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'uuid唯一标识',
  `school_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '栏目名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `show_create_time` tinyint(1) NOT NULL DEFAULT '1' COMMENT '展示发布时间： 0不展示 1展示',
  `type` json DEFAULT NULL COMMENT '栏目类型：1院校 2招生 3就业（支持多选）',
  `show_app` json DEFAULT NULL COMMENT '展示端：8官网 9微信 10支付宝 11抖音 12百度 13QQ',
  `property` tinyint(1) NOT NULL DEFAULT '1' COMMENT '栏目属性：1文章 2图片 3视频',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章栏目表';

-- ----------------------------
-- Records of station_columns
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for station_permissions
-- ----------------------------
DROP TABLE IF EXISTS `station_permissions`;
CREATE TABLE `station_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'uuid唯一标识',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '组件名称',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1显示 0隐藏（隐藏直接过滤）',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '路径',
  `navigation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '导航前端是否显示：0否 1是',
  PRIMARY KEY (`id`,`uuid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='菜单权限表';

-- ----------------------------
-- Records of station_permissions
-- ----------------------------
BEGIN;
INSERT INTO `station_permissions` (`id`, `uuid`, `pid`, `title`, `name`, `is_show`, `sort`, `url`, `navigation`) VALUES (1, 'feb696cf-086b-4b62-85b8-6f77f23e3f28', 0, '站群监控', 'MonitoringPage', 1, 1, '/log', 1);
INSERT INTO `station_permissions` (`id`, `uuid`, `pid`, `title`, `name`, `is_show`, `sort`, `url`, `navigation`) VALUES (2, '1645253e-6b81-435c-9dd5-6a98cc8f6918', 0, '站群管理', 'WebsitePage', 1, 1, '/website', 1);
INSERT INTO `station_permissions` (`id`, `uuid`, `pid`, `title`, `name`, `is_show`, `sort`, `url`, `navigation`) VALUES (3, '9265cad7-4b3b-4881-acf8-7769c6279733', 0, '内容管理', 'ContentPage', 1, 1, '/content', 1);
INSERT INTO `station_permissions` (`id`, `uuid`, `pid`, `title`, `name`, `is_show`, `sort`, `url`, `navigation`) VALUES (4, '43b4288b-ee27-4ca8-a4d1-2f556ce37feb', 0, '权限管理', 'RolePage', 1, 1, '/role', 1);
COMMIT;

-- ----------------------------
-- Table structure for station_pictures
-- ----------------------------
DROP TABLE IF EXISTS `station_pictures`;
CREATE TABLE `station_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'uuid唯一标识',
  `school_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校id',
  `column_uuid` json DEFAULT NULL COMMENT '所属栏目',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片url',
  `sort` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `views_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `intro` text COLLATE utf8mb4_unicode_ci COMMENT '介绍',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='图片表';

-- ----------------------------
-- Records of station_pictures
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for station_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `station_role_permissions`;
CREATE TABLE `station_role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色uuid',
  `permission_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限uuid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校账号角色关联表';

-- ----------------------------
-- Records of station_role_permissions
-- ----------------------------
BEGIN;
INSERT INTO `station_role_permissions` (`id`, `role_uuid`, `permission_uuid`) VALUES (1, '', '');
INSERT INTO `station_role_permissions` (`id`, `role_uuid`, `permission_uuid`) VALUES (2, '58a7038a-4a56-422b-a30c-b24334683703', 'feb696cf-086b-4b62-85b8-6f77f23e3f28');
INSERT INTO `station_role_permissions` (`id`, `role_uuid`, `permission_uuid`) VALUES (3, '58a7038a-4a56-422b-a30c-b24334683703', '1645253e-6b81-435c-9dd5-6a98cc8f6918');
INSERT INTO `station_role_permissions` (`id`, `role_uuid`, `permission_uuid`) VALUES (4, '58a7038a-4a56-422b-a30c-b24334683703', '9265cad7-4b3b-4881-acf8-7769c6279733');
COMMIT;

-- ----------------------------
-- Table structure for station_roles
-- ----------------------------
DROP TABLE IF EXISTS `station_roles`;
CREATE TABLE `station_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'uuid唯一标识',
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色',
  `desc` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1开启 0关闭',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '申请时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`uuid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色表';

-- ----------------------------
-- Records of station_roles
-- ----------------------------
BEGIN;
INSERT INTO `station_roles` (`id`, `uuid`, `role`, `desc`, `status`, `create_time`, `update_time`) VALUES (1, '83a45411-7f81-4bda-bd4e-09b3a1413170', '客服', '管理学校信息', 1, '2023-04-15 09:35:07', '2023-04-15 10:56:08');
INSERT INTO `station_roles` (`id`, `uuid`, `role`, `desc`, `status`, `create_time`, `update_time`) VALUES (2, '58a7038a-4a56-422b-a30c-b24334683703', '客服1', '管理学校信息', 1, '2023-04-17 09:00:36', '2023-04-17 09:00:36');
COMMIT;

-- ----------------------------
-- Table structure for station_videos
-- ----------------------------
DROP TABLE IF EXISTS `station_videos`;
CREATE TABLE `station_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'uuid唯一标识',
  `school_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校id',
  `column_uuid` json DEFAULT NULL COMMENT '所属栏目',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '封面url',
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '视频url',
  `sort` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `views_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `intro` text COLLATE utf8mb4_unicode_ci COMMENT '介绍',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='视频表';

-- ----------------------------
-- Records of station_videos
-- ----------------------------
BEGIN;
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
