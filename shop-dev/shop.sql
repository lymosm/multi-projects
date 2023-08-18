/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100612
 Source Host           : localhost:3306
 Source Schema         : shop

 Target Server Type    : MySQL
 Target Server Version : 100612
 File Encoding         : 65001

 Date: 16/08/2023 19:20:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for s_attachment
-- ----------------------------
DROP TABLE IF EXISTS `s_attachment`;
CREATE TABLE `s_attachment`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `uri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'image' COMMENT 'image/pdf/doc...',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_product_img' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_attachment
-- ----------------------------
INSERT INTO `s_attachment` VALUES (1, 'product/20220906/ef71543907a8ba07a8d72c2593a69969.jpg', 'product/product/20220906/ef71543907a8ba07a8d72c2593a69969.jpg', 'doc', 1, '2022-09-06 16:53:13', 0, NULL);
INSERT INTO `s_attachment` VALUES (2, 'product/20220908/a4e19935dc2e11056a09c967f5966077.jpg', 'product/product/20220908/a4e19935dc2e11056a09c967f5966077.jpg', 'doc', 1, '2022-09-08 15:09:24', 0, NULL);
INSERT INTO `s_attachment` VALUES (3, 'product/20220908/5bd7dca73db16fab5d914a965a24fa0b.jpg', 'product/product/20220908/5bd7dca73db16fab5d914a965a24fa0b.jpg', 'doc', 1, '2022-09-08 15:10:35', 0, NULL);
INSERT INTO `s_attachment` VALUES (4, 'product/20220908/b2a9860c896f2679515f309a490ddc38.jpg', 'product/product/20220908/b2a9860c896f2679515f309a490ddc38.jpg', 'doc', 1, '2022-09-08 15:13:29', 0, NULL);
INSERT INTO `s_attachment` VALUES (5, 'product/20220908/ed2c8e6e3b8d634da4dde51f27245176.jpg', 'product/product/20220908/ed2c8e6e3b8d634da4dde51f27245176.jpg', 'doc', 1, '2022-09-08 15:15:12', 0, NULL);
INSERT INTO `s_attachment` VALUES (6, 'product/20220908/2e684b03a8c4a6a1dd12c6e9b8b442b6.jpg', 'product/20220908/2e684b03a8c4a6a1dd12c6e9b8b442b6.jpg', 'doc', 1, '2022-09-08 15:17:01', 0, NULL);
INSERT INTO `s_attachment` VALUES (7, 'product/20220908/b47c5e5b3940c8d2b86cb4ebbb23259f.jpg', 'product/20220908/b47c5e5b3940c8d2b86cb4ebbb23259f.jpg', 'doc', 1, '2022-09-08 15:17:01', 0, NULL);
INSERT INTO `s_attachment` VALUES (8, 'product/20220913/b842ec3e0c01ff7244799a744fbc46df.jpg', 'product/20220913/b842ec3e0c01ff7244799a744fbc46df.jpg', 'doc', 1, '2022-09-13 16:21:45', 0, NULL);
INSERT INTO `s_attachment` VALUES (9, 'product/20220913/5664ec648e3509781440c2b6f89bba30.jpg', 'product/20220913/5664ec648e3509781440c2b6f89bba30.jpg', 'doc', 1, '2022-09-13 16:22:53', 0, NULL);
INSERT INTO `s_attachment` VALUES (10, 'product/20220913/20711bebe6f30cb8e13632e7da9d494c.jpg', 'product/20220913/20711bebe6f30cb8e13632e7da9d494c.jpg', 'doc', 1, '2022-09-13 16:22:54', 0, NULL);
INSERT INTO `s_attachment` VALUES (11, 'product/20220913/af885b83872590d8ced1929a90dd57e9.jpg', 'product/20220913/af885b83872590d8ced1929a90dd57e9.jpg', 'doc', 1, '2022-09-13 16:34:23', 0, NULL);
INSERT INTO `s_attachment` VALUES (12, 'product/20220913/e9581606dfb7e4a3d6c103155e0387c6.jpg', 'product/20220913/e9581606dfb7e4a3d6c103155e0387c6.jpg', 'doc', 1, '2022-09-13 16:35:27', 0, NULL);
INSERT INTO `s_attachment` VALUES (13, 'product/20220913/13ee7fae30b608c83e5546cbbff29b72.jpg', 'product/20220913/13ee7fae30b608c83e5546cbbff29b72.jpg', 'doc', 1, '2022-09-13 16:35:27', 0, NULL);
INSERT INTO `s_attachment` VALUES (14, 'product/20220913/59f83a8213c3fc5e73f1d4fb8e0a1c9c.jpg', 'product/20220913/59f83a8213c3fc5e73f1d4fb8e0a1c9c.jpg', 'doc', 1, '2022-09-13 16:39:14', 0, NULL);
INSERT INTO `s_attachment` VALUES (15, 'product/20220927/a6f6c6d246a27f3d97115175488e099c.jpg', 'product/20220927/a6f6c6d246a27f3d97115175488e099c.jpg', 'doc', 1, '2022-09-27 11:02:59', 0, NULL);
INSERT INTO `s_attachment` VALUES (16, 'product/20220927/2c9440ffbcc2fb0fb3163fd18be546d3.jpg', 'product/20220927/2c9440ffbcc2fb0fb3163fd18be546d3.jpg', 'doc', 1, '2022-09-27 11:04:44', 0, NULL);
INSERT INTO `s_attachment` VALUES (17, 'product/20220927/a9c211d5bdfb659b7748ed0382f576b6.jpg', 'product/20220927/a9c211d5bdfb659b7748ed0382f576b6.jpg', 'doc', 1, '2022-09-27 15:01:42', 0, NULL);
INSERT INTO `s_attachment` VALUES (18, 'product/20220927/3a56fbfe1159aded1bfa7c357e1c5543.jpg', 'product/20220927/3a56fbfe1159aded1bfa7c357e1c5543.jpg', 'doc', 1, '2022-09-27 15:01:51', 0, NULL);
INSERT INTO `s_attachment` VALUES (19, 'product/20220927/7ef114b7c557dac99fc99a521d5da1e9.jpg', 'product/20220927/7ef114b7c557dac99fc99a521d5da1e9.jpg', 'doc', 1, '2022-09-27 15:01:51', 0, NULL);
INSERT INTO `s_attachment` VALUES (20, 'product/20220927/150ad2da8f5a2ff4b7493908b786ae9d.jpg', 'product/20220927/150ad2da8f5a2ff4b7493908b786ae9d.jpg', 'doc', 1, '2022-09-27 15:16:31', 0, NULL);
INSERT INTO `s_attachment` VALUES (21, 'product/20220930/a2c26523be3b929d4aef075018a54708.png', 'product/20220930/a2c26523be3b929d4aef075018a54708.png', 'doc', 1, '2022-09-30 17:29:28', 0, NULL);
INSERT INTO `s_attachment` VALUES (22, 'product/20220930/ff0e7a9f99ec9723615d43e42107f771.png', 'product/20220930/ff0e7a9f99ec9723615d43e42107f771.png', 'doc', 1, '2022-09-30 17:29:31', 0, NULL);
INSERT INTO `s_attachment` VALUES (23, 'product/20220930/531bf816597fdf2550f617036a7f8086.png', 'product/20220930/531bf816597fdf2550f617036a7f8086.png', 'doc', 1, '2022-09-30 17:29:31', 0, NULL);
INSERT INTO `s_attachment` VALUES (24, 'product/20220930/6b6a40e45bdbcdb3ab72c1a58b7f429d.png', 'product/20220930/6b6a40e45bdbcdb3ab72c1a58b7f429d.png', 'doc', 1, '2022-09-30 17:31:09', 0, NULL);
INSERT INTO `s_attachment` VALUES (25, 'product/20220930/086efd1bca70366578f13070c50ca954.png', 'product/20220930/086efd1bca70366578f13070c50ca954.png', 'doc', 1, '2022-09-30 17:31:23', 0, NULL);
INSERT INTO `s_attachment` VALUES (26, 'product/20220930/6eed72f7653c201132a5e14d75d48c7d.png', 'product/20220930/6eed72f7653c201132a5e14d75d48c7d.png', 'doc', 1, '2022-09-30 17:31:23', 0, NULL);
INSERT INTO `s_attachment` VALUES (27, 'product/20220930/0f683ad5b822c1c938e33f0758b8815b.png', 'product/20220930/0f683ad5b822c1c938e33f0758b8815b.png', 'doc', 1, '2022-09-30 17:35:00', 0, NULL);
INSERT INTO `s_attachment` VALUES (28, 'product/20220930/3e98244edfbe32a3975ca9ba7937265a.png', 'product/20220930/3e98244edfbe32a3975ca9ba7937265a.png', 'doc', 1, '2022-09-30 17:36:27', 0, NULL);
INSERT INTO `s_attachment` VALUES (29, 'product/20220930/cb7d9901d53262028a7d16d841f7b996.png', 'product/20220930/cb7d9901d53262028a7d16d841f7b996.png', 'doc', 1, '2022-09-30 17:36:31', 0, NULL);
INSERT INTO `s_attachment` VALUES (30, 'product/20221014/4cda1acc58343780d01c9d3e9aa8623a.jpg', 'product/20221014/4cda1acc58343780d01c9d3e9aa8623a.jpg', 'doc', 1, '2022-10-14 16:35:48', 0, NULL);
INSERT INTO `s_attachment` VALUES (31, 'product/20221014/1d50b20ecd8b80c05752ffdef23a0a1d.jpg', 'product/20221014/1d50b20ecd8b80c05752ffdef23a0a1d.jpg', 'doc', 1, '2022-10-14 16:42:55', 0, NULL);
INSERT INTO `s_attachment` VALUES (32, 'product/20221221/a3e8580e398100cd0b262051abc3f3f2.jpeg', 'product/20221221/a3e8580e398100cd0b262051abc3f3f2.jpeg', 'doc', 1, '2022-12-21 16:11:51', 0, NULL);
INSERT INTO `s_attachment` VALUES (33, 'product/20221221/14526c4cc5fd7bda515d81ec9e291e2f.jpeg', 'product/20221221/14526c4cc5fd7bda515d81ec9e291e2f.jpeg', 'doc', 1, '2022-12-21 16:11:59', 0, NULL);
INSERT INTO `s_attachment` VALUES (34, 'product/20221221/ef304470a719d791a3acfffd5325b2ac.jpeg', 'product/20221221/ef304470a719d791a3acfffd5325b2ac.jpeg', 'doc', 1, '2022-12-21 17:18:00', 0, NULL);
INSERT INTO `s_attachment` VALUES (35, 'product/20221221/4205ff8eafe7c971b1278058aacfbbcc.jpeg', 'product/20221221/4205ff8eafe7c971b1278058aacfbbcc.jpeg', 'doc', 1, '2022-12-21 17:21:59', 0, NULL);

-- ----------------------------
-- Table structure for s_cart
-- ----------------------------
DROP TABLE IF EXISTS `s_cart`;
CREATE TABLE `s_cart`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `user_id` int NOT NULL DEFAULT 0,
  `cart_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `updated_date` datetime NULL DEFAULT NULL,
  `expired_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_cart' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_cart
-- ----------------------------
INSERT INTO `s_cart` VALUES (8, 'e879f421cbafe263a4d1010de61e622b', 0, '{\"product_list\":[{\"product_id\":\"1\",\"uri\":\"product1\",\"product_name\":\"product1\",\"qty\":1,\"price\":\"66\",\"item_price\":66}],\"price_obj\":{\"total_price\":66,\"need_payment\":true,\"payment_type\":\"paypal\"}}', '2022-07-19 17:59:08', NULL);

-- ----------------------------
-- Table structure for s_cate
-- ----------------------------
DROP TABLE IF EXISTS `s_cate`;
CREATE TABLE `s_cate`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `img_uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `desc` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uri`(`uri` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'product cate' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_cate
-- ----------------------------
INSERT INTO `s_cate` VALUES (2, 'sui55', 'uwiw', '', '2222', 1, '2022-08-30 16:47:43', 1, '2022-08-30 16:47:54');
INSERT INTO `s_cate` VALUES (3, '777', '777', '', '7777', 1, '2022-12-21 16:10:56', 0, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'cate relation' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_cate_rela
-- ----------------------------
INSERT INTO `s_cate_rela` VALUES (10, 2, 0);
INSERT INTO `s_cate_rela` VALUES (11, 3, 2);

-- ----------------------------
-- Table structure for s_loop_banner
-- ----------------------------
DROP TABLE IF EXISTS `s_loop_banner`;
CREATE TABLE `s_loop_banner`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `img_uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `text` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `btn` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `btn_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `order` int NOT NULL DEFAULT 0 COMMENT 'sort index',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'loop banner' ROW_FORMAT = DYNAMIC;

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
  `id` int NOT NULL AUTO_INCREMENT,
  `order_num` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `paid_date` datetime NULL DEFAULT NULL,
  `paid_type` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'wechatpay | alipay | paypal',
  `order_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1.pending 2.process 3. complete 4. failed 5. cancel 6. refund',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_order
-- ----------------------------
INSERT INTO `s_order` VALUES (1, '649ac44152587', NULL, '', 2, 0, '2023-06-27 19:13:05', 1, '2023-07-05 18:28:35');
INSERT INTO `s_order` VALUES (2, '64bfab096da0f', NULL, '', 0, 1, '2023-07-25 18:59:21', 0, NULL);

-- ----------------------------
-- Table structure for s_order_price
-- ----------------------------
DROP TABLE IF EXISTS `s_order_price`;
CREATE TABLE `s_order_price`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL DEFAULT 0,
  `discount_price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `total_price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_price' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_order_price
-- ----------------------------
INSERT INTO `s_order_price` VALUES (2, 2, '', '66');
INSERT INTO `s_order_price` VALUES (3, 3, '', '66');
INSERT INTO `s_order_price` VALUES (4, 4, '', '66');
INSERT INTO `s_order_price` VALUES (5, 5, '', '66');
INSERT INTO `s_order_price` VALUES (6, 6, '', '66');
INSERT INTO `s_order_price` VALUES (7, 7, '', '66');
INSERT INTO `s_order_price` VALUES (8, 8, '', '666');
INSERT INTO `s_order_price` VALUES (9, 9, '', '666');
INSERT INTO `s_order_price` VALUES (10, 10, '', '666');
INSERT INTO `s_order_price` VALUES (11, 11, '', '666');
INSERT INTO `s_order_price` VALUES (12, 12, '', '666');
INSERT INTO `s_order_price` VALUES (13, 13, '', '666');
INSERT INTO `s_order_price` VALUES (14, 14, '', '666');
INSERT INTO `s_order_price` VALUES (15, 15, '', '666');
INSERT INTO `s_order_price` VALUES (16, 16, '', '666');
INSERT INTO `s_order_price` VALUES (17, 17, '', '666');
INSERT INTO `s_order_price` VALUES (18, 18, '', '666');
INSERT INTO `s_order_price` VALUES (19, 1, '', '666');
INSERT INTO `s_order_price` VALUES (20, 2, '', '22');

-- ----------------------------
-- Table structure for s_order_product
-- ----------------------------
DROP TABLE IF EXISTS `s_order_product`;
CREATE TABLE `s_order_product`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL DEFAULT 0,
  `product_id` int NOT NULL DEFAULT 0,
  `product_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `qty` int NOT NULL DEFAULT 0,
  `item_price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_product' ROW_FORMAT = DYNAMIC;

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
INSERT INTO `s_order_product` VALUES (8, 8, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (9, 9, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (10, 10, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (11, 11, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (12, 12, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (13, 13, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (14, 14, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (15, 15, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (16, 16, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (17, 17, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (18, 18, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (19, 1, 3, '666', '666', 1, '666');
INSERT INTO `s_order_product` VALUES (20, 2, 2, '55599', '22', 1, '22');

-- ----------------------------
-- Table structure for s_order_user
-- ----------------------------
DROP TABLE IF EXISTS `s_order_user`;
CREATE TABLE `s_order_user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL DEFAULT 0,
  `user_id` int NOT NULL DEFAULT 0,
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
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_order_user' ROW_FORMAT = DYNAMIC;

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
INSERT INTO `s_order_user` VALUES (8, 8, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', '8888', '8888', '8888', '888888888', '88888');
INSERT INTO `s_order_user` VALUES (9, 9, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', '8888', '888', '888', '88888', '888');
INSERT INTO `s_order_user` VALUES (10, 10, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', '888', '888', '8888', '8888', '8888');
INSERT INTO `s_order_user` VALUES (11, 11, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', 'suoiw', 'dddd', 'yuan', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (12, 12, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', 'suoiw', 'dddd', 'yufffff', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (13, 13, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', 'suoiw', 'dddd', 'yurfranm', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (14, 14, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', 'suoiw', 'dddd', 'yuaf', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (15, 15, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', 'suoiw', 'dddd', 'yuuuuu', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (16, 16, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', 'suoiw', 'dddd', 'yuoooo', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (17, 17, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', 'suoiw', 'dddd', 'yuanm77', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (18, 18, 0, 'bfa62b52751af7ec44e2bd0be7abf148', '', '', '', 'suoiw', 'dddd', 'y888', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (19, 1, 0, '207267dc0631dc8181c326c713cd844b', '', '', '', 'suoiw', 'dddd', 'yuaang@ed.com', '12345, 9999658588', '888888');
INSERT INTO `s_order_user` VALUES (20, 2, 1, '5f477868f4ae6318de790b8c2543f6fe', '', '', '', 'tee', 'ee', 'rreee', 'eeeerr', '4444');

-- ----------------------------
-- Table structure for s_page
-- ----------------------------
DROP TABLE IF EXISTS `s_page`;
CREATE TABLE `s_page`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uri`(`uri` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'page' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of s_page
-- ----------------------------
INSERT INTO `s_page` VALUES (1, '二二贴吧', '655rr', '<p>厄特特<span style=\"color: rgb(225, 60, 57);\"><strong>的ddfd</strong></span></p><p><span style=\"color: rgb(225, 60, 57);\"><strong>dsisi</strong></span></p><p><span style=\"color: rgb(225, 60, 57);\"><strong>djfff</strong></span><span style=\"color: rgb(0, 0, 0);\"><strong>fifkkf</strong></span></p><p><span style=\"color: rgb(0, 0, 0);\"><strong>dkdkkdf</strong></span></p>', 1, '2023-08-15 18:59:37', 1, '2023-08-16 18:33:22');
INSERT INTO `s_page` VALUES (2, 'dfff', 'ffffffff', '<p><br></p><h3>ONLY fit Samsung Galaxy A14 5G Case, 6.6in, Phone Model: SM-A146U, SM-A146W, SM-S146VL, SM-A146P, SM-A146M, SM-A146U1/DS, SM-A146B/DS, SM-A146P/N, etc</h3><h3><img src=\"https://m.media-amazon.com/images/S/aplus-media-library-service-media/195c35ee-c364-47a7-b744-3a2ebdeeda73.__CR0,0,970,600_PT0_SX970_V1___.jpg\" alt=\"galaxy a14 5g case with screen protector\" data-href=\"\" style=\"\"/></h3><p><img src=\"https://m.media-amazon.com/images/S/aplus-media-library-service-media/977b1e8b-dc74-482a-a081-c1db7a57e775.__CR0,0,970,600_PT0_SX970_V1___.jpg\" alt=\"samsung galaxy a14 5g case android\" data-href=\"\" style=\"\"/></p><p><img src=\"https://m.media-amazon.com/images/S/aplus-media-library-service-media/8d70a5bb-12f3-4fe7-916e-8d17343a8859.__CR0,0,970,600_PT0_SX970_V1___.jpg\" alt=\"samsung a14 5g case protective\" data-href=\"\" style=\"\"/></p>', 1, '2023-08-16 19:18:06', 1, '2023-08-16 19:18:47');

-- ----------------------------
-- Table structure for s_product
-- ----------------------------
DROP TABLE IF EXISTS `s_product`;
CREATE TABLE `s_product`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `uri` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'product' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_product
-- ----------------------------
INSERT INTO `s_product` VALUES (1, 'product1', 'product1', 0, NULL, 0, NULL);
INSERT INTO `s_product` VALUES (2, '55599', '222', 1, '2022-09-27 15:16:40', 1, '2022-12-21 17:18:03');
INSERT INTO `s_product` VALUES (3, '666', '666', 1, '2022-12-21 17:22:04', 0, NULL);

-- ----------------------------
-- Table structure for s_product_cate_rela
-- ----------------------------
DROP TABLE IF EXISTS `s_product_cate_rela`;
CREATE TABLE `s_product_cate_rela`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL DEFAULT 0,
  `cate_id` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `product_id`(`product_id` ASC, `cate_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'product cate relation' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_product_cate_rela
-- ----------------------------
INSERT INTO `s_product_cate_rela` VALUES (1, 1, 1);
INSERT INTO `s_product_cate_rela` VALUES (2, 2, 2);
INSERT INTO `s_product_cate_rela` VALUES (3, 3, 2);

-- ----------------------------
-- Table structure for s_product_detail
-- ----------------------------
DROP TABLE IF EXISTS `s_product_detail`;
CREATE TABLE `s_product_detail`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL DEFAULT 0,
  `price` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `short_desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `long_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_product_detail' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_product_detail
-- ----------------------------
INSERT INTO `s_product_detail` VALUES (1, 1, '66', '6666666', 'dddddddddd');
INSERT INTO `s_product_detail` VALUES (2, 2, '22', '222333399', '2229');
INSERT INTO `s_product_detail` VALUES (3, 3, '666', '7', '8');

-- ----------------------------
-- Table structure for s_product_img
-- ----------------------------
DROP TABLE IF EXISTS `s_product_img`;
CREATE TABLE `s_product_img`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL DEFAULT 0,
  `attachment_id` int NOT NULL DEFAULT 0,
  `sort` tinyint(1) NOT NULL DEFAULT 0,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 's_product_img' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_product_img
-- ----------------------------
INSERT INTO `s_product_img` VALUES (1, 2, 20, 0, 1);
INSERT INTO `s_product_img` VALUES (13, 2, 32, 0, 0);
INSERT INTO `s_product_img` VALUES (14, 2, 34, 0, 0);
INSERT INTO `s_product_img` VALUES (15, 3, 35, 0, 1);

-- ----------------------------
-- Table structure for s_role
-- ----------------------------
DROP TABLE IF EXISTS `s_role`;
CREATE TABLE `s_role`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'role' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_role
-- ----------------------------
INSERT INTO `s_role` VALUES (1, 'administrator', 0, '2023-07-05 12:12:12', 0, NULL);
INSERT INTO `s_role` VALUES (2, 'customer', 0, '2023-07-05 12:12:12', 0, NULL);

-- ----------------------------
-- Table structure for s_user
-- ----------------------------
DROP TABLE IF EXISTS `s_user`;
CREATE TABLE `s_user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `account` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `pwd` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account`(`account` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_user
-- ----------------------------
INSERT INTO `s_user` VALUES (1, 'admin', '2fc6535054e083ee8adf0b255e740372', 0, '2021-05-28 12:12:12', 1, '2023-08-01 19:32:16');

-- ----------------------------
-- Table structure for s_user_role
-- ----------------------------
DROP TABLE IF EXISTS `s_user_role`;
CREATE TABLE `s_user_role`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT 0,
  `role_id` int NOT NULL DEFAULT 0,
  `added_by` int NOT NULL DEFAULT 0,
  `added_date` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL DEFAULT 0,
  `updated_date` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_id`(`user_id` ASC, `role_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'user role' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of s_user_role
-- ----------------------------
INSERT INTO `s_user_role` VALUES (1, 1, 1, 0, '2023-07-05 12:12:12', 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
