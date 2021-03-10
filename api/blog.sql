/*
 Navicat Premium Data Transfer

 Source Server         : hutu
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : blog

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 10/11/2020 23:14:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for blog_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin_user`;
CREATE TABLE `blog_admin_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_time` int(11) NULL DEFAULT NULL,
  `current_time` int(11) NOT NULL,
  `power` tinyint(4) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_admin_user_name_pwd`(`user_name`, `password`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_article`;
CREATE TABLE `blog_front_article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '文章标题',
  `author` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '作者',
  `email` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `type` int(11) NOT NULL COMMENT '类别',
  `tag` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '标签',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '内容',
  `create_time` int(11) NOT NULL COMMENT '时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `read_num` int(4) NOT NULL DEFAULT 0 COMMENT '阅读量',
  `thumb_num` int(4) NOT NULL DEFAULT 0 COMMENT '点赞',
  `state` tinyint(4) NOT NULL DEFAULT 2 COMMENT '回收站',
  `sort` int(11) NULL DEFAULT 1 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_article_id_type`(`id`, `type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 155 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_article_comment_one
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_article_comment_one`;
CREATE TABLE `blog_front_article_comment_one`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `qq` varchar(13) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `create_time` int(11) NOT NULL,
  `content` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `thumb_num` int(11) NOT NULL DEFAULT 0,
  `master` tinyint(4) NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_article_comment_aid`(`article_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_article_comment_two
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_article_comment_two`;
CREATE TABLE `blog_front_article_comment_two`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `qq` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `master` tinyint(4) NOT NULL DEFAULT 2,
  `content` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_qq` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_master` tinyint(4) NOT NULL DEFAULT 2,
  `create_time` int(11) NOT NULL,
  `thumb_num` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_article_comment_cid`(`comment_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_info
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_info`;
CREATE TABLE `blog_front_info`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `release` tinyint(4) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_link
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_link`;
CREATE TABLE `blog_front_link`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `site` varchar(70) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 1,
  `release` tinyint(4) NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_message_one
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_message_one`;
CREATE TABLE `blog_front_message_one`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qq` varchar(13) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `create_time` int(11) NOT NULL,
  `content` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `thumb_num` int(11) NOT NULL DEFAULT 0,
  `master` tinyint(4) NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_message_two
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_message_two`;
CREATE TABLE `blog_front_message_two`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `qq` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `master` tinyint(4) NOT NULL DEFAULT 2,
  `content` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_qq` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `be_master` tinyint(4) NOT NULL DEFAULT 2,
  `create_time` int(11) NOT NULL,
  `thumb_num` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_message_cid`(`comment_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_tag
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_tag`;
CREATE TABLE `blog_front_tag`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 1,
  `release` tinyint(4) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_total
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_total`;
CREATE TABLE `blog_front_total`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitors_num` int(11) NULL DEFAULT 0,
  `visits_num` int(11) NULL DEFAULT 0,
  `visits_time` int(11) NULL DEFAULT 0,
  `article_num` int(11) NULL DEFAULT 0,
  `current_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_type
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_type`;
CREATE TABLE `blog_front_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 1,
  `release` tinyint(4) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `IX_FRONT_TYPE_ID`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 151 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_user`;
CREATE TABLE `blog_front_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `create_time` int(11) NOT NULL,
  `visits_time` int(11) NOT NULL DEFAULT 0,
  `visits_num` int(11) NOT NULL DEFAULT 0,
  `frequent_num` int(11) NOT NULL DEFAULT 0,
  `black_list` tinyint(4) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_user_id_ip`(`id`, `ip`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_user_visits_interval
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_user_visits_interval`;
CREATE TABLE `blog_front_user_visits_interval`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total_id` int(11) NOT NULL,
  `ip` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `current_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
