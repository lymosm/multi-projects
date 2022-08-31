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

 Date: 30/08/2022 16:49:32
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
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_cart' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_cart
-- ----------------------------
INSERT INTO `s_cart` VALUES (8, 'e879f421cbafe263a4d1010de61e622b', 0, '{\"product_list\":[{\"product_id\":\"1\",\"uri\":\"product1\",\"product_name\":\"product1\",\"qty\":1,\"price\":\"66\",\"item_price\":66}],\"price_obj\":{\"total_price\":66,\"need_payment\":true,\"payment_type\":\"paypal\"}}', '2022-07-19 17:59:08', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'product cate' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_cate
-- ----------------------------
INSERT INTO `s_cate` VALUES (2, 'sui55', 'uwiw', '', '2222', 1, '2022-08-30 16:47:43', 1, '2022-08-30 16:47:54');

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'cate relation' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_cate_rela
-- ----------------------------
INSERT INTO `s_cate_rela` VALUES (10, 2, 0);

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
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_order
-- ----------------------------
INSERT INTO `s_order` VALUES (1, '62d67020e52c7', NULL, '', 0, '2022-07-19 16:49:36', 0, NULL);
INSERT INTO `s_order` VALUES (2, '62d670666b9f9', NULL, '', 0, '2022-07-19 16:50:46', 0, NULL);
INSERT INTO `s_order` VALUES (3, '62d67460edf64', NULL, '', 0, '2022-07-19 17:07:44', 0, NULL);
INSERT INTO `s_order` VALUES (4, '62d67652018d6', NULL, '', 0, '2022-07-19 17:16:02', 0, NULL);
INSERT INTO `s_order` VALUES (5, '62d6778383af1', NULL, '', 0, '2022-07-19 17:21:07', 0, NULL);
INSERT INTO `s_order` VALUES (6, '62d678a9a8cc3', NULL, '', 0, '2022-07-19 17:26:01', 0, NULL);
INSERT INTO `s_order` VALUES (7, '62d679082f23c', NULL, '', 0, '2022-07-19 17:27:36', 0, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_price' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_order_price
-- ----------------------------
INSERT INTO `s_order_price` VALUES (1, 1, '', '66');
INSERT INTO `s_order_price` VALUES (2, 2, '', '66');
INSERT INTO `s_order_price` VALUES (3, 3, '', '66');
INSERT INTO `s_order_price` VALUES (4, 4, '', '66');
INSERT INTO `s_order_price` VALUES (5, 5, '', '66');
INSERT INTO `s_order_price` VALUES (6, 6, '', '66');
INSERT INTO `s_order_price` VALUES (7, 7, '', '66');

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
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_product' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_order_product
-- ----------------------------
INSERT INTO `s_order_product` VALUES (1, 1, 1, 'product1', '66', 1, '66');
INSERT INTO `s_order_product` VALUES (2, 2, 1, 'product1', '66', 1, '66');
INSERT INTO `s_order_product` VALUES (3, 3, 1, 'product1', '66', 1, '66');
INSERT INTO `s_order_product` VALUES (4, 4, 1, 'product1', '66', 1, '66');
INSERT INTO `s_order_product` VALUES (5, 5, 1, 'product1', '66', 1, '66');
INSERT INTO `s_order_product` VALUES (6, 6, 1, 'product1', '66', 1, '66');
INSERT INTO `s_order_product` VALUES (7, 7, 1, 'product1', '66', 1, '66');

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
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_user' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_order_user
-- ----------------------------
INSERT INTO `s_order_user` VALUES (1, 1, 0, 'e879f421cbafe263a4d1010de61e622b', '', '', '', 'suoiw', 'dddd', 'yuanming.liang@esr-case.net', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (2, 2, 0, 'e879f421cbafe263a4d1010de61e622b', '', '', '', 'suoiw', 'dddd', 'yuanming.liang@esr-case.net', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (3, 3, 0, 'e879f421cbafe263a4d1010de61e622b', '', '', '', 'suoiw', 'dddd', 'yuanming.liang@esr-case.net', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (4, 4, 0, 'e879f421cbafe263a4d1010de61e622b', '', '', '', '666', '6666', 'yuanming.liang@esr.com', '66666', '6666');
INSERT INTO `s_order_user` VALUES (5, 5, 0, 'e879f421cbafe263a4d1010de61e622b', '', '', '', 'suoiw', 'dddd', 'yuanming.liang@esr-case.net', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (6, 6, 0, 'e879f421cbafe263a4d1010de61e622b', '', '', '', '666', '6666', 'yuanming.liang@esr.com', '66666', '6666');
INSERT INTO `s_order_user` VALUES (7, 7, 0, 'e879f421cbafe263a4d1010de61e622b', '', '', '', 'suoiw', 'dddd', 'yuanming.liang@esr-case.net', '12345, 9999658588', '888888');

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
