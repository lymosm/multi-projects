/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80023
 Source Host           : localhost:3306
 Source Schema         : video

 Target Server Type    : MySQL
 Target Server Version : 80023
 File Encoding         : 65001

 Date: 03/04/2022 17:39:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for v_user
-- ----------------------------
DROP TABLE IF EXISTS `v_user`;
CREATE TABLE `v_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account` varchar(60) NOT NULL DEFAULT '',
  `pwd` varchar(60) NOT NULL DEFAULT '',
  `added_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=create database video default character set utf8mb4 collate utf8mb4_unicode_ci; COMMENT='用户表';

-- ----------------------------
-- Records of v_user
-- ----------------------------
BEGIN;
INSERT INTO `v_user` VALUES (2, 'tb710741910', '8c36d86a9142342f9a8b58e4eb3fe3d8', '2021-05-28 12:12:12', NULL);
COMMIT;

-- ----------------------------
-- Table structure for v_video_list
-- ----------------------------
DROP TABLE IF EXISTS `v_video_list`;
CREATE TABLE `v_video_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `origin_video_uri` varchar(60) NOT NULL DEFAULT '',
  `video_uri` varchar(60) NOT NULL DEFAULT '',
  `qrcode_uri` varchar(60) NOT NULL DEFAULT '',
  `qrcode_text` varchar(60) NOT NULL DEFAULT '',
  `detail_uri` varchar(60) NOT NULL DEFAULT '',
  `added_by` int NOT NULL DEFAULT '0',
  `added_date` datetime DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT '0',
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=create database video default character set utf8mb4 collate utf8mb4_unicode_ci; COMMENT='视频表';

-- ----------------------------
-- Records of v_video_list
-- ----------------------------
BEGIN;
INSERT INTO `v_video_list` VALUES (1, '测试视频', '', '/v-encode/20220402/6247c151ce020.mov', '6247c151ce020', '', '', 2, '2022-04-02 22:10:22', 0, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
