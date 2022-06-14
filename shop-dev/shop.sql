/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80027
 Source Host           : localhost:3306
 Source Schema         : shop

 Target Server Type    : MySQL
 Target Server Version : 80027
 File Encoding         : 65001

 Date: 14/06/2022 17:55:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for s_cate
-- ----------------------------
DROP TABLE IF EXISTS `s_cate`;
CREATE TABLE `s_cate`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `img_uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `desc` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uri`(`uri` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = 'product cate' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_cate
-- ----------------------------
INSERT INTO `s_cate` VALUES (1, 'aa77', '999977', '', '999999888', 0, '2022-04-19 15:40:35', 1, '2022-06-14 17:55:05');
INSERT INTO `s_cate` VALUES (3, '666', '666', '', '6666', 1, '2022-06-14 17:34:14', 0, NULL);
INSERT INTO `s_cate` VALUES (5, '66688', '66655', '', '6666', 1, '2022-06-14 17:39:33', 0, NULL);
INSERT INTO `s_cate` VALUES (6, '6668844', '6665544', '', '6666444', 1, '2022-06-14 17:40:13', 0, NULL);
INSERT INTO `s_cate` VALUES (7, '66644', '44', '', '44', 1, '2022-06-14 17:41:52', 0, NULL);
INSERT INTO `s_cate` VALUES (8, '5555', '555', '', '555', 1, '2022-06-14 17:44:42', 0, NULL);

-- ----------------------------
-- Table structure for s_cate_rela
-- ----------------------------
DROP TABLE IF EXISTS `s_cate_rela`;
CREATE TABLE `s_cate_rela`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `cate_id` int NOT NULL DEFAULT 0,
  `parent_id` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cate_id`(`cate_id` ASC, `parent_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = 'cate relation' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_cate_rela
-- ----------------------------
INSERT INTO `s_cate_rela` VALUES (1, 1, 0);
INSERT INTO `s_cate_rela` VALUES (2, 2, 0);
INSERT INTO `s_cate_rela` VALUES (3, 3, 0);
INSERT INTO `s_cate_rela` VALUES (4, 4, 2);
INSERT INTO `s_cate_rela` VALUES (9, 5, 0);
INSERT INTO `s_cate_rela` VALUES (5, 5, 2);
INSERT INTO `s_cate_rela` VALUES (10, 6, 0);
INSERT INTO `s_cate_rela` VALUES (6, 6, 3);
INSERT INTO `s_cate_rela` VALUES (7, 7, 3);
INSERT INTO `s_cate_rela` VALUES (11, 7, 5);
INSERT INTO `s_cate_rela` VALUES (12, 8, 0);
INSERT INTO `s_cate_rela` VALUES (8, 8, 6);

-- ----------------------------
-- Table structure for s_loop_banner
-- ----------------------------
DROP TABLE IF EXISTS `s_loop_banner`;
CREATE TABLE `s_loop_banner`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `img_uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `text` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `btn` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `btn_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `order` int NOT NULL DEFAULT 0 COMMENT 'sort index',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = 'loop banner' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_loop_banner
-- ----------------------------
INSERT INTO `s_loop_banner` VALUES (1, '777', '/storage/images/20220418/1.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);
INSERT INTO `s_loop_banner` VALUES (2, '777', '/storage/images/20220418/2.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);
INSERT INTO `s_loop_banner` VALUES (3, '777', '/storage/images/20220418/3.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);

-- ----------------------------
-- Table structure for s_user
-- ----------------------------
DROP TABLE IF EXISTS `s_user`;
CREATE TABLE `s_user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `account` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `pwd` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `added_date` datetime NULL DEFAULT NULL,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account`(`account` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '用户表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_user
-- ----------------------------
INSERT INTO `s_user` VALUES (1, 'admin', '2fc6535054e083ee8adf0b255e740372', '2021-05-28 12:12:12', NULL);

SET FOREIGN_KEY_CHECKS = 1;
