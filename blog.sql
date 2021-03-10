/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : 1.0.2-blog

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 10/03/2021 16:47:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for blog_admin_power
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin_power`;
CREATE TABLE `blog_admin_power`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `power` int(11) NOT NULL COMMENT '级别',
  `rules` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '开发API',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `IX_FRONT_TYPE_ID`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_admin_power_level
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin_power_level`;
CREATE TABLE `blog_admin_power_level`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '类别',
  `sort` tinyint(4) NOT NULL DEFAULT 1 COMMENT '权重',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `IX_FRONT_TYPE_ID`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin_user`;
CREATE TABLE `blog_admin_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT ' 密码',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '当前IP',
  `last_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '0' COMMENT '上次登陆IP',
  `power` int(11) NOT NULL DEFAULT 1 COMMENT '权限 ',
  `last_at` int(11) NOT NULL DEFAULT 0 COMMENT '上次登陆时间',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_admin_user_name_pwd`(`username`, `password`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_article`;
CREATE TABLE `blog_front_article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '文章标题',
  `img_url` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '图片路径',
  `cover_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '封面',
  `author` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '作者',
  `email` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `type` int(11) NOT NULL COMMENT '类别',
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '内容',
  `read_num` int(4) NOT NULL DEFAULT 0 COMMENT '阅读量',
  `thumb_num` int(4) NOT NULL DEFAULT 0 COMMENT '点赞',
  `sort` tinyint(11) NOT NULL DEFAULT 100 COMMENT '权重',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_article_id_type`(`id`, `type`) USING BTREE,
  FULLTEXT INDEX `ft_index`(`content`) WITH PARSER `ngram`
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_comment
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_comment`;
CREATE TABLE `blog_front_comment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `qq` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'qq账号',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '昵称',
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '头像',
  `content` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '内容',
  `thumb_num` int(11) NOT NULL DEFAULT 0 COMMENT '点赞',
  `master` tinyint(4) NOT NULL DEFAULT 2 COMMENT '角色1=站长，2=游客',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_comment_sub
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_comment_sub`;
CREATE TABLE `blog_front_comment_sub`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `msg_id` int(11) NOT NULL COMMENT '评论ID',
  `qq` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'QQ账号',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '昵称 ',
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '头像',
  `master` tinyint(4) NOT NULL DEFAULT 2 COMMENT '角色 ',
  `content` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '内容',
  `be_qq` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '被评论QQ',
  `be_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '被评论昵称',
  `be_avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '被评论头像',
  `be_email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '被评论邮箱',
  `be_master` tinyint(4) NOT NULL DEFAULT 2 COMMENT '被评论角色',
  `thumb_num` int(11) NOT NULL DEFAULT 0 COMMENT '点赞',
  `release` int(11) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_message_cid`(`msg_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_discoloration
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_discoloration`;
CREATE TABLE `blog_front_discoloration`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `nick_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '昵称',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=一般，2=进阶',
  `level` tinyint(4) NOT NULL DEFAULT 0 COMMENT '级别',
  `steps` int(255) NOT NULL DEFAULT 0 COMMENT '步数',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_info
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_info`;
CREATE TABLE `blog_front_info`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '标题',
  `english` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '翻译',
  `copyright` varchar(70) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '版权信息',
  `email` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱 ',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '简介',
  `record` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '备案信息',
  `record_link` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '备案链接',
  `sort` tinyint(4) NOT NULL DEFAULT 100 COMMENT '权重',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_link
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_link`;
CREATE TABLE `blog_front_link`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '站点名称',
  `img_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '站点logo',
  `site` varchar(70) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '站点地址',
  `email` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `visit_num` int(11) NOT NULL DEFAULT 0 COMMENT '访问数量',
  `sort` int(11) NOT NULL DEFAULT 1 COMMENT '权重 ',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_log
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_log`;
CREATE TABLE `blog_front_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类别',
  `version` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '版本号',
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '更新内容',
  `release` tinyint(1) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_message
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_message`;
CREATE TABLE `blog_front_message`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `qq` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'qq账号',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '昵称',
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '头像',
  `content` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '内容',
  `thumb_num` int(11) NOT NULL DEFAULT 0 COMMENT '点赞',
  `master` tinyint(4) NOT NULL DEFAULT 2 COMMENT '角色',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_message_sub
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_message_sub`;
CREATE TABLE `blog_front_message_sub`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `msg_id` int(11) NOT NULL COMMENT '评论ID',
  `qq` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'qq账号',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '昵称',
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '头像',
  `master` tinyint(4) NOT NULL DEFAULT 2 COMMENT '角色',
  `content` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '内容',
  `be_qq` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '被评论qq账号',
  `be_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '被评论昵称',
  `be_avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '被评论头像',
  `be_email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '被评论邮箱',
  `be_master` tinyint(4) NOT NULL DEFAULT 2 COMMENT '被评论角色 ',
  `thumb_num` int(11) NOT NULL DEFAULT 0 COMMENT '点赞',
  `release` int(11) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_message_cid`(`msg_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_total
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_total`;
CREATE TABLE `blog_front_total`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitors_num` int(11) NOT NULL DEFAULT 0 COMMENT '访客量',
  `visits_num` int(11) NOT NULL DEFAULT 0 COMMENT '访问量',
  `visits_time` int(11) NOT NULL DEFAULT 0 COMMENT '访问时间',
  `article_num` int(11) NOT NULL DEFAULT 0 COMMENT '文章数量',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_type_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_type_article`;
CREATE TABLE `blog_front_type_article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '类别',
  `sort` tinyint(4) NOT NULL DEFAULT 1 COMMENT '权重',
  `release` tinyint(4) NOT NULL DEFAULT 2 COMMENT '发布',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `IX_FRONT_TYPE_ID`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_user`;
CREATE TABLE `blog_front_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '当前ip',
  `last_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '上次访问ip',
  `visits_time` int(11) NOT NULL DEFAULT 0 COMMENT '访问时间',
  `frequent_num` int(11) NOT NULL DEFAULT 0 COMMENT '异常访问次数',
  `black_list` tinyint(4) NOT NULL DEFAULT 2 COMMENT '黑名单',
  `province` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '省',
  `city` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '市',
  `adcode` mediumint(6) NOT NULL COMMENT '地址码',
  `rectangle` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '经纬度',
  `last_at` int(11) NOT NULL DEFAULT 0 COMMENT '上次登陆时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_user_id_ip`(`id`, `ip`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_front_user_visits_interval
-- ----------------------------
DROP TABLE IF EXISTS `blog_front_user_visits_interval`;
CREATE TABLE `blog_front_user_visits_interval`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_gallery
-- ----------------------------
DROP TABLE IF EXISTS `blog_gallery`;
CREATE TABLE `blog_gallery`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '图片路径',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_router
-- ----------------------------
DROP TABLE IF EXISTS `blog_router`;
CREATE TABLE `blog_router`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '接口',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `remarks` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '0' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 154 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_wechat_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_wechat_user`;
CREATE TABLE `blog_wechat_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '微信id',
  `nick_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '昵称',
  `avatar_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '头像',
  `gender` tinyint(1) NOT NULL DEFAULT 0 COMMENT '性别',
  `visits_time` int(11) NOT NULL DEFAULT 0 COMMENT '浏览时长',
  `visits_num` int(11) NOT NULL DEFAULT 0 COMMENT '访问次数',
  `last_at` int(11) NULL DEFAULT 0 COMMENT '上次登陆时间',
  `created_at` int(11) NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
