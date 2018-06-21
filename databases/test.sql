/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2018-06-21 16:27:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_users
-- ----------------------------
DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tb_users
-- ----------------------------
INSERT INTO `tb_users` VALUES ('4', 'Ngô Ngọc Huấn', 'ngochuan2212@gmail.com', '$2y$10$4eSwTTBGPqfNk45vk26hgOHwSSR0f5D.eutrXEbVbEnUY.hNOeWEC', null, '0988478266', 'bach mai', '2016-04-19 03:16:38');
INSERT INTO `tb_users` VALUES ('5', 'Huấn', 'huannn.ptit@gmail.com', '$2y$10$CGXI/cJ6dHvE/8J2q6o.cufPOxM/eA.JP7ntac0yA7VBsTqRug74e', '$2y$10$AOw.jh0Qo.90oVbIdz2tReArGOXsNb2mElV2PyC7aCQzMKW15h30m', '0988478266', 'bach mai', '2016-04-19 03:18:32');
