/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100803
 Source Host           : localhost:3306
 Source Schema         : shop

 Target Server Type    : MariaDB
 Target Server Version : 100803
 File Encoding         : 65001

 Date: 05/07/2022 13:21:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for s_attachment
-- ----------------------------
DROP TABLE IF EXISTS `s_attachment`;
CREATE TABLE `s_attachment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'image' COMMENT 'image/pdf/doc...',
  `added_by` int(11) NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_product_img' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for s_cart
-- ----------------------------
DROP TABLE IF EXISTS `s_cart`;
CREATE TABLE `s_cart`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `cart_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_date` datetime NULL DEFAULT NULL,
  `expired_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_cart' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_cart
-- ----------------------------

-- ----------------------------
-- Table structure for s_cate
-- ----------------------------
DROP TABLE IF EXISTS `s_cate`;
CREATE TABLE `s_cate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `img_uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `desc` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `added_by` int(11) NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uri`(`uri`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'product cate' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_cate
-- ----------------------------

-- ----------------------------
-- Table structure for s_cate_rela
-- ----------------------------
DROP TABLE IF EXISTS `s_cate_rela`;
CREATE TABLE `s_cate_rela`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL DEFAULT 0,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cate_id`(`cate_id`, `parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'cate relation' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_cate_rela
-- ----------------------------
INSERT INTO `s_cate_rela` VALUES (1, 1, 0);
INSERT INTO `s_cate_rela` VALUES (2, 2, 0);
INSERT INTO `s_cate_rela` VALUES (3, 3, 0);
INSERT INTO `s_cate_rela` VALUES (4, 4, 2);
INSERT INTO `s_cate_rela` VALUES (5, 5, 2);
INSERT INTO `s_cate_rela` VALUES (6, 6, 3);
INSERT INTO `s_cate_rela` VALUES (7, 7, 3);
INSERT INTO `s_cate_rela` VALUES (8, 8, 6);

-- ----------------------------
-- Table structure for s_loop_banner
-- ----------------------------
DROP TABLE IF EXISTS `s_loop_banner`;
CREATE TABLE `s_loop_banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `img_uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `text` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `btn` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `btn_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `order` int(11) NOT NULL DEFAULT 0 COMMENT 'sort index',
  `added_by` int(11) NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'loop banner' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_loop_banner
-- ----------------------------
INSERT INTO `s_loop_banner` VALUES (1, '777', '/storage/images/20220418/1.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);
INSERT INTO `s_loop_banner` VALUES (2, '777', '/storage/images/20220418/2.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);
INSERT INTO `s_loop_banner` VALUES (3, '777', '/storage/images/20220418/3.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);

-- ----------------------------
-- Table structure for s_order
-- ----------------------------
DROP TABLE IF EXISTS `s_order`;
CREATE TABLE `s_order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_num` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `paid_date` datetime NULL DEFAULT NULL,
  `paid_type` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'wechatpay | alipay | paypal',
  `added_by` int(11) NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_order
-- ----------------------------

-- ----------------------------
-- Table structure for s_order_price
-- ----------------------------
DROP TABLE IF EXISTS `s_order_price`;
CREATE TABLE `s_order_price`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `discount_price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `total_price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_price' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_order_price
-- ----------------------------

-- ----------------------------
-- Table structure for s_order_product
-- ----------------------------
DROP TABLE IF EXISTS `s_order_product`;
CREATE TABLE `s_order_product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `qty` int(11) NOT NULL DEFAULT 0,
  `item_price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_product' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_order_product
-- ----------------------------

-- ----------------------------
-- Table structure for s_order_user
-- ----------------------------
DROP TABLE IF EXISTS `s_order_user`;
CREATE TABLE `s_order_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `session_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `country` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `state` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `city` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `first_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `last_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_user' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_order_user
-- ----------------------------

-- ----------------------------
-- Table structure for s_product
-- ----------------------------
DROP TABLE IF EXISTS `s_product`;
CREATE TABLE `s_product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `added_by` int(11) NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'product' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_product
-- ----------------------------
INSERT INTO `s_product` VALUES (1, 'product1', 'product1', 0, NULL, 0, NULL);

-- ----------------------------
-- Table structure for s_product_cate_rela
-- ----------------------------
DROP TABLE IF EXISTS `s_product_cate_rela`;
CREATE TABLE `s_product_cate_rela`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `cate_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `product_id`(`product_id`, `cate_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'product cate relation' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_product_cate_rela
-- ----------------------------
INSERT INTO `s_product_cate_rela` VALUES (1, 1, 1);

-- ----------------------------
-- Table structure for s_product_detail
-- ----------------------------
DROP TABLE IF EXISTS `s_product_detail`;
CREATE TABLE `s_product_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `price` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `short_desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `long_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_product_detail' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_product_detail
-- ----------------------------
INSERT INTO `s_product_detail` VALUES (1, 1, '66', '6666666', 'dddddddddd');

-- ----------------------------
-- Table structure for s_product_img
-- ----------------------------
DROP TABLE IF EXISTS `s_product_img`;
CREATE TABLE `s_product_img`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `attachment_id` int(11) NOT NULL DEFAULT 0,
  `sort` tinyint(1) NOT NULL DEFAULT 0,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_product_img' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_product_img
-- ----------------------------

-- ----------------------------
-- Table structure for s_user
-- ----------------------------
DROP TABLE IF EXISTS `s_user`;
CREATE TABLE `s_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `pwd` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `added_date` datetime NULL DEFAULT NULL,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account`(`account`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_user
-- ----------------------------
INSERT INTO `s_user` VALUES (1, 'admin', '2fc6535054e083ee8adf0b255e740372', '2021-05-28 12:12:12', NULL);

SET FOREIGN_KEY_CHECKS = 1;
