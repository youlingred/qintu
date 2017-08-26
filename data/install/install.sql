-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2017 �?03 �?30 �?16:14
-- 服务器版本: 5.5.40
-- PHP 版本: 5.6.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `minishop_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `mini_apiconfig`
--

DROP TABLE IF EXISTS `mini_apiconfig`;
CREATE TABLE IF NOT EXISTS `mini_apiconfig` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `key` varchar(255) NOT NULL COMMENT '配置项名称',
  `value` varchar(255) NOT NULL COMMENT '配置项值',
  `description` varchar(255) DEFAULT NULL COMMENT '配置描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `mini_apiconfig`
--

INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(1, 'print_apikey', '', 'API密钥');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(2, 'print_machine_code', '', '打印机终端号');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(3, 'print_msign', '', '打印机密钥');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(4, 'print_mobiliphone', '', '终端内部手机号');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(5, 'print_partner', '', '易连云用户ID');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(6, 'print_username', '', '易连云用户名');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(7, 'print_printname', '', '打印机终端名称');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(8, 'sms_appkey', '', 'Key值');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(9, 'sms_appsecret', '', '密钥');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(10, 'sms_template_code', '', '模板ID');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(11, 'sms_signname', '', '签名名称');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(12, 'alipay_partner', '', '合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(13, 'alipay_appkey', '', ' MD5密钥，安全检验码，由数字和字母组成的32位字符串');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(14, 'wechat_appid', '', '微信公众号身份的唯一标识');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(15, 'wechat_mchid', '', '受理商ID，身份标识');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(16, 'wechat_appkey', '', '商户支付密钥Key');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(17, 'wechat_appsecret', '', 'JSAPI接口中获取openid');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(18, 'wechat_token', '', '微信通讯token值');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(19, 'baidu_map_ak', '', '百度地图秘钥(ak)');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(20, 'baidu_map_lon', '', '中心点经度');
INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES(21, 'baidu_map_lat', '', '中心点纬度');

-- --------------------------------------------------------

--
-- 表的结构 `mini_banner`
--

DROP TABLE IF EXISTS `mini_banner`;
CREATE TABLE IF NOT EXISTS `mini_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '广告名称',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '广告位置描述',
  `position` int(11) NOT NULL COMMENT '广告位置',
  `banner_path` varchar(140) NOT NULL COMMENT '图片地址',
  `link` varchar(140) NOT NULL DEFAULT '' COMMENT '连接地址',
  `level` int(4) NOT NULL DEFAULT '0' COMMENT '优先级',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态（2：禁用 1：正常）',
  `createtime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `mini_banner`
--

INSERT INTO `mini_banner` (`id`, `name`, `description`, `position`, `banner_path`, `link`, `level`, `status`, `createtime`, `endtime`) VALUES(1, 'banner图1', 'banner图1', 1, '/uploads/picture/20170330/da9448c8984d59b1b12472063f994c43.jpg', '#', 0, 1, 1474862526, 0);
INSERT INTO `mini_banner` (`id`, `name`, `description`, `position`, `banner_path`, `link`, `level`, `status`, `createtime`, `endtime`) VALUES(2, 'banner图2', 'banner图2', 1, '/uploads/picture/20170330/e109223d06f0c4edc9195e61b282da40.jpg', '#', 0, 1, 1474862717, 0);
INSERT INTO `mini_banner` (`id`, `name`, `description`, `position`, `banner_path`, `link`, `level`, `status`, `createtime`, `endtime`) VALUES(7, 'banner图3', 'banner图3', 1, '/uploads/picture/20170330/6ac502582f808cb85282562a95da76fb.jpg', '#', 0, 1, 1490774191, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_banner_position`
--

DROP TABLE IF EXISTS `mini_banner_position`;
CREATE TABLE IF NOT EXISTS `mini_banner_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL,
  `width` char(20) NOT NULL,
  `height` char(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(0:禁用 1：正常)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `mini_banner_position`
--

INSERT INTO `mini_banner_position` (`id`, `title`, `width`, `height`, `status`) VALUES(1, 'pc首页banner图', '1920', '600', 1);
INSERT INTO `mini_banner_position` (`id`, `title`, `width`, `height`, `status`) VALUES(2, '商品页推荐', '200', '260', 1);
INSERT INTO `mini_banner_position` (`id`, `title`, `width`, `height`, `status`) VALUES(3, 'wap首页焦点图', '', '', 1);
INSERT INTO `mini_banner_position` (`id`, `title`, `width`, `height`, `status`) VALUES(4, 'pc端单页广告', '1200', '139', 1);

-- --------------------------------------------------------

--
-- 表的结构 `mini_business_need`
--

DROP TABLE IF EXISTS `mini_business_need`;
CREATE TABLE IF NOT EXISTS `mini_business_need` (
  `name` char(128) NOT NULL COMMENT '姓名',
  `mobile` varchar(128) NOT NULL COMMENT '手机号',
  `wx` char(128) DEFAULT NULL COMMENT '微信号',
  `description` text COMMENT '备注',
  `createtime` int(11) NOT NULL,
  KEY `createtime` (`createtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `mini_business_need`
--

INSERT INTO `mini_business_need` (`name`, `mobile`, `wx`, `description`, `createtime`) VALUES('111111111', '2147483647', '', '', 0);
INSERT INTO `mini_business_need` (`name`, `mobile`, `wx`, `description`, `createtime`) VALUES('11111111', '2147483647', '', '', 0);
INSERT INTO `mini_business_need` (`name`, `mobile`, `wx`, `description`, `createtime`) VALUES('11111111', '2147483647', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_cart`
--

DROP TABLE IF EXISTS `mini_cart`;
CREATE TABLE IF NOT EXISTS `mini_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '购买数量',
  `createtime` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1：正常，2：已购买',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- 转存表中的数据 `mini_cart`
--

INSERT INTO `mini_cart` (`id`, `uid`, `goods_id`, `num`, `createtime`, `status`) VALUES(56, 1, 45, 1, 1487299145, 1);

-- --------------------------------------------------------

--
-- 表的结构 `mini_code`
--

DROP TABLE IF EXISTS `mini_code`;
CREATE TABLE IF NOT EXISTS `mini_code` (
  `id` int(60) NOT NULL AUTO_INCREMENT,
  `mobile` char(128) DEFAULT NULL,
  `code` char(30) DEFAULT NULL,
  `yzm_time` int(60) DEFAULT NULL,
  `num` int(60) NOT NULL DEFAULT '0',
  `captcha` char(30) NOT NULL,
  `date` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_email_check`
--

DROP TABLE IF EXISTS `mini_email_check`;
CREATE TABLE IF NOT EXISTS `mini_email_check` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `username` char(128) NOT NULL,
  `email` char(128) NOT NULL,
  `passtime` int(128) NOT NULL,
  `token` char(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_goods`
--

DROP TABLE IF EXISTS `mini_goods`;
CREATE TABLE IF NOT EXISTS `mini_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '商品名称',
  `num` int(11) NOT NULL COMMENT '商品库存数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `description` text NOT NULL COMMENT '商品描述',
  `man_profiles` text NOT NULL COMMENT '达人个人简介',
  `goods_profiles` text NOT NULL COMMENT '达人体验简介',
  `standard` varchar(255) NOT NULL COMMENT '规格型号',
  `cover_path` varchar(255) NOT NULL COMMENT '封面图',
  `photo_path_1` varchar(255) DEFAULT NULL,
  `photo_path_2` varchar(255) DEFAULT NULL,
  `photo_path_3` varchar(255) DEFAULT NULL,
  `content` text NOT NULL COMMENT '商品详情',
  `click_count` int(11) NOT NULL DEFAULT '0' COMMENT '商品点击数',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:上架，2：下架',
  `is_best` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为精品',
  `is_new` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为新品',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为热销',
  `sell_num` int(11) NOT NULL DEFAULT '0' COMMENT '已经出售的数量',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `score_num` tinyint(2) NOT NULL DEFAULT '1' COMMENT '平均评分',
  `score` int(11) DEFAULT NULL COMMENT '积分',
  `label_tese` text NOT NULL COMMENT '特色标签',
  `label_quan` text NOT NULL COMMENT '券代标签',
  `label_area` text NOT NULL COMMENT '地区标签',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- 转存表中的数据 `mini_goods`
--

INSERT INTO `mini_goods` (`id`, `uid`, `uuid`, `name`, `num`, `price`, `description`, `man_profiles`, `goods_profiles`, `standard`, `cover_path`, `photo_path_1`, `photo_path_2`, `photo_path_3`, `content`, `click_count`, `status`, `is_best`, `is_new`, `is_hot`, `sell_num`, `createtime`, `score_num`, `score`, `label_tese`, `label_quan`, `label_area`) VALUES(49, 1, '95343da3-7fef-ea09-299b-42ac8fff2e46', '轻定制产品1', 100, '0.10', '轻定制产品1', '', '', '', '/uploads/picture/20170329/f572ac82f7caf2e5695674cbf3799fe0.jpg', '/uploads/picture/20170329/c74562c8f51f0d056dcfbf5b8e8d6036.jpg', '', '', '<p style="text-align: left; width: 100%;"><img src="/uploads/editor/image/20170329/1490775224634674.jpg" title="1490775224634674.jpg" alt="map.jpg" width="985" height="610"/></p>', 0, 1, 0, 0, 1, 0, 1490775333, 1, 0, '', '', '');
INSERT INTO `mini_goods` (`id`, `uid`, `uuid`, `name`, `num`, `price`, `description`, `man_profiles`, `goods_profiles`, `standard`, `cover_path`, `photo_path_1`, `photo_path_2`, `photo_path_3`, `content`, `click_count`, `status`, `is_best`, `is_new`, `is_hot`, `sell_num`, `createtime`, `score_num`, `score`, `label_tese`, `label_quan`, `label_area`) VALUES(50, 1, '962dd595-09ac-5762-765d-c8bd8290e485', '轻定制2', 100, '0.01', '轻定制2', '', '', '', '/uploads/picture/20170329/e03c7c73f63932de6a24199467251160.jpg', '', '', '', '', 0, 1, 0, 0, 0, 0, 1490771581, 1, 0, '北极光|破冰船', '券|代', '');
INSERT INTO `mini_goods` (`id`, `uid`, `uuid`, `name`, `num`, `price`, `description`, `man_profiles`, `goods_profiles`, `standard`, `cover_path`, `photo_path_1`, `photo_path_2`, `photo_path_3`, `content`, `click_count`, `status`, `is_best`, `is_new`, `is_hot`, `sell_num`, `createtime`, `score_num`, `score`, `label_tese`, `label_quan`, `label_area`) VALUES(51, 1, 'ddefe56e-b994-39c0-e92f-cc63b268446e', '亲途达人1', 100, '0.01', '亲途达人1', '<h3>个人简介</h3>\r\n发生的发生的发生的发生的发生发的', '<h3>体验简介</h3>\r\n发生的发生的发生的发生的发生发的', '', '/uploads/picture/20170329/5f2b06cff598b809fdaed6793bfb9c02.jpg', '', '', '', '<p>111</p>', 0, 1, 1, 0, 1, 0, 1490848166, 1, 0, '', '', '');
INSERT INTO `mini_goods` (`id`, `uid`, `uuid`, `name`, `num`, `price`, `description`, `man_profiles`, `goods_profiles`, `standard`, `cover_path`, `photo_path_1`, `photo_path_2`, `photo_path_3`, `content`, `click_count`, `status`, `is_best`, `is_new`, `is_hot`, `sell_num`, `createtime`, `score_num`, `score`, `label_tese`, `label_quan`, `label_area`) VALUES(52, 1, 'b871d575-d264-6a5a-386d-9ef915ec04a0', '主题定制1', 100, '0.01', '主题定制1', '', '', '', '/uploads/picture/20170329/3fba2b4817213951c9c7e21c50d5c2f4.jpg', '', '', '', '<p>主题定制1</p>', 0, 1, 0, 0, 1, 0, 1490775051, 1, 0, '', '', '');
INSERT INTO `mini_goods` (`id`, `uid`, `uuid`, `name`, `num`, `price`, `description`, `man_profiles`, `goods_profiles`, `standard`, `cover_path`, `photo_path_1`, `photo_path_2`, `photo_path_3`, `content`, `click_count`, `status`, `is_best`, `is_new`, `is_hot`, `sell_num`, `createtime`, `score_num`, `score`, `label_tese`, `label_quan`, `label_area`) VALUES(53, 1, '46007837-b7b5-7504-bc4d-cb6cb2eb51eb', '分享旅行', 100, '0.01', '分享旅行', '', '', '', '/uploads/picture/20170329/aa16f9bb629cd94a598ffd535028b3ee.jpg', '', '', '', '<p>111</p>', 0, 1, 0, 0, 1, 0, 1490775001, 1, 0, '', '', '');
INSERT INTO `mini_goods` (`id`, `uid`, `uuid`, `name`, `num`, `price`, `description`, `man_profiles`, `goods_profiles`, `standard`, `cover_path`, `photo_path_1`, `photo_path_2`, `photo_path_3`, `content`, `click_count`, `status`, `is_best`, `is_new`, `is_hot`, `sell_num`, `createtime`, `score_num`, `score`, `label_tese`, `label_quan`, `label_area`) VALUES(54, 1, 'd4f7c7fa-ff4b-6e35-d31d-ae03ea6de5a2', '主题定制2', 100, '12345.00', '主题定制2', '', '', '', '/uploads/picture/20170329/0b8fea0977113c0b120d5c7c18f85946.jpg', '', '', '', '<p>主题定制2</p>', 0, 1, 0, 0, 1, 0, 1490775069, 1, 0, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `mini_goods_cate`
--

DROP TABLE IF EXISTS `mini_goods_cate`;
CREATE TABLE IF NOT EXISTS `mini_goods_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '分类名',
  `slug` varchar(200) NOT NULL COMMENT '缩略名',
  `cover_path` varchar(200) NOT NULL COMMENT '分类封面图',
  `pid` int(11) NOT NULL DEFAULT '0',
  `page_num` int(11) NOT NULL,
  `lists_tpl` varchar(200) NOT NULL,
  `detail_tpl` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:启用，2：禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- 转存表中的数据 `mini_goods_cate`
--

INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(25, '轻定制', 'qdz', '', 0, 6, 'goods_qdz_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(26, '亲途达人/私导', 'qtdr', '', 0, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(27, '主题定制', 'ztdz', '', 0, 6, 'goods_ztdz_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(28, '全部', 'qdz_area_all', '', 30, 6, 'goods_qdz_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(29, '北海道', 'qdz_area_bhd', '', 30, 6, 'goods_qdz_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(30, '地区', 'qdz_area', '', 25, 6, 'goods_qdz_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(32, '特色', 'qdz_tese', '', 25, 6, 'goods_qdz_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(33, '全部', 'qdz_tese_all', '', 32, 6, 'goods_qdz_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(34, '地区', 'qtdr_area', '', 26, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(35, '全部', 'qtdr_area_all', '', 34, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(36, '特色', 'qtdr_tese', '', 26, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(37, '全部', 'qtdr_tese_all', '', 36, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(38, '北海道', 'qtdr_area_bhd', '', 34, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(39, '东北', 'qtdr_area_db', '', 34, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(40, '亲途达人', 'qtdr_tese_qtdr', '', 36, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(41, '明星私导', 'qtdr_tese_mxsd', '', 36, 8, 'goods_qtdr_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(42, '独家体验', 'qdz_tese_djty', '', 32, 6, 'goods_qdz_list', 'goods_detail', 1);
INSERT INTO `mini_goods_cate` (`id`, `name`, `slug`, `cover_path`, `pid`, `page_num`, `lists_tpl`, `detail_tpl`, `status`) VALUES(43, '分享旅行', 'fx', '', 0, 6, 'goods_list', 'goods_detail', 1);

-- --------------------------------------------------------

--
-- 表的结构 `mini_goods_cate_relationships`
--

DROP TABLE IF EXISTS `mini_goods_cate_relationships`;
CREATE TABLE IF NOT EXISTS `mini_goods_cate_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=295 ;

--
-- 转存表中的数据 `mini_goods_cate_relationships`
--

INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(234, 50, 25);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(235, 50, 28);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(236, 50, 29);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(237, 50, 33);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(260, 53, 43);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(261, 52, 27);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(262, 54, 27);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(271, 49, 25);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(272, 49, 28);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(273, 49, 33);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(274, 49, 42);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(290, 51, 26);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(291, 51, 35);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(292, 51, 38);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(293, 51, 37);
INSERT INTO `mini_goods_cate_relationships` (`id`, `goods_id`, `cate_id`) VALUES(294, 51, 40);

-- --------------------------------------------------------

--
-- 表的结构 `mini_goods_collection`
--

DROP TABLE IF EXISTS `mini_goods_collection`;
CREATE TABLE IF NOT EXISTS `mini_goods_collection` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `goods_id` int(10) DEFAULT NULL COMMENT '商品id',
  `createtime` varchar(11) DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_goods_comment`
--

DROP TABLE IF EXISTS `mini_goods_comment`;
CREATE TABLE IF NOT EXISTS `mini_goods_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增唯一ID',
  `uid` int(20) DEFAULT NULL,
  `goods_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '对应文章ID',
  `order_id` varchar(20) DEFAULT NULL COMMENT '订单号',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '评论时间',
  `content` text NOT NULL COMMENT '评论正文',
  `approved` varchar(20) NOT NULL DEFAULT '0' COMMENT '审核 0-待审核  1-已审核',
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父评论ID',
  `score` int(2) DEFAULT NULL COMMENT '商品评分',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 -1-删除  1-正常',
  PRIMARY KEY (`id`),
  KEY `comment_post_ID` (`goods_id`),
  KEY `comment_approved_date_gmt` (`approved`),
  KEY `comment_parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_key_value`
--

DROP TABLE IF EXISTS `mini_key_value`;
CREATE TABLE IF NOT EXISTS `mini_key_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collection` varchar(128) NOT NULL COMMENT '命名集合键和值对',
  `uuid` varchar(128) NOT NULL DEFAULT 'default' COMMENT '系统唯一标识',
  `name` varchar(128) NOT NULL COMMENT '键名',
  `value` longtext NOT NULL COMMENT 'The value.',
  PRIMARY KEY (`id`,`collection`,`uuid`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=183 ;

--
-- 转存表中的数据 `mini_key_value`
--

INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(1, 'config.base', 'default', 'web_allow_register', '1');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(2, 'config.base', 'default', 'web_site_close', '0');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(3, 'config.base', 'default', 'web_site_description', '亲途旅游网');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(4, 'config.base', 'default', 'web_site_icp', '冀ICP备XXXXXXX');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(5, 'config.base', 'default', 'web_site_keyword', '亲途旅游网');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(6, 'config.base', 'default', 'web_site_title', '亲途旅游网');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(7, 'config.base', 'default', 'web_allow_ticket', '0');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(8, 'indextheme', 'default', 'name', 'qintu');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(8, 'users', 'ad75820a-96c3-a1a8-20c6-195534dd75d3', 'is_root', '1');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(9, 'posts.form', '9db99141-65a4-2393-bfa8-d4d100e1a1f4', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(10, 'posts.form', '1d3fa553-6e07-eed6-f459-4694de378122', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(29, 'posts.form', '085b628d-d8ae-d04c-dfa0-61992ca70f29', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(30, 'posts.form', '3cf4069c-80d0-ac82-fcfe-e7e378569c12', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(31, 'posts.form', '7df6d672-48ef-b8ed-1d18-74c3770dcbc3', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(32, 'posts.form', '7faa2c91-b173-6bd2-4b69-c0234c7c1a57', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(33, 'posts.form', 'b64c7e04-b8a0-eeda-0314-35eabe258111', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(34, 'posts.form', '8bc618f8-c8a4-2219-fee2-2da0a71ca8ff', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(35, 'posts.form', '8cfc3471-3754-30cb-b030-a11dba360e0c', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(36, 'posts.form', '9bb4e644-482b-c2cd-68c7-9a1a2f290435', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(37, 'posts.form', '1c6e5535-86e8-6e0b-548b-02e631b85b20', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(38, 'posts.form', '879bda21-07f8-df3c-9270-7789515157ed', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(39, 'posts.form', '74610495-ab86-d787-fa50-8ba3987b680b', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(40, 'posts.form', '76ce6961-894e-8d13-59c4-49881ddf6748', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(41, 'posts.form', '94714551-683d-aa79-6fb4-60dd70201473', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(42, 'posts.form', '11646a6e-cd35-bcdd-4136-c5b392b63a6f', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(43, 'posts.form', 'd27eea5e-e553-d2d5-b05b-9574af56ce3f', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(44, 'posts.form', '60e38eeb-97a5-61ac-be60-425f9f8eb1c5', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(45, 'posts.form', 'f569d8f0-0510-8c55-2cbf-f29a4ffea591', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(46, 'posts.form', 'e4ec7532-1686-71f3-f57e-e19cc49a81bf', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(47, 'posts.form', 'fabe0485-4f82-643a-6a46-cd8defc7f6d4', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(48, 'posts.form', '88de9d39-21e8-d00f-c8ff-2b56791ea559', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(49, 'users', '9fe83c25-864e-7fe8-370d-d97799be1d7e', 'is_root', '1');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(50, 'posts.form', 'f4d643a2-8507-fd72-c5af-e12a7e77b13a', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(51, 'posts.form', '6571e5b9-cf41-5e25-0cb9-9e7d07e62173', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(52, 'posts.form', '442721ec-7a93-0baa-cd58-a469fae43c13', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(53, 'posts.form', '6f4c8587-03e6-9d31-4325-c97384457543', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(54, 'posts.form', '9d348e6e-db9d-0ec9-4a36-666787af9a74', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(55, 'posts.form', 'b30eeb11-1ca4-e771-562f-644b56c66a7e', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(56, 'posts.form', 'fdd989d9-d0f4-64f8-6981-5e3945d089c0', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(66, 'posts.form', 'd5f45d6b-f40c-b798-c9ef-7d690078a166', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(67, 'posts.form', '5df49b2a-c711-301d-8320-af500ceb40c6', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(68, 'posts.form', '896d0d4d-cc3b-f43b-2000-e9604769eea0', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(69, 'posts.form', 'd842871c-3840-f944-efb2-caefedcf926e', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(70, 'posts.form', '3d57ca49-c45e-2266-067c-67cb2bde8603', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(71, 'posts.form', 'a3fc44c5-5731-114c-d576-cebcb6767ff7', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(72, 'posts.form', '591f72fc-def5-dc1d-1471-8bcb50b7d60d', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(73, 'posts.form', '0e05d041-23de-e42b-c88f-d3eb6c4dc365', 'page_tpl', 'page');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(155, 'term.taxonomy', 'a9c77921-19bf-b313-86d4-c5111d36605d', 'page_num', '20');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(156, 'term.taxonomy', 'a9c77921-19bf-b313-86d4-c5111d36605d', 'lists_tpl', 'news_list');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(157, 'term.taxonomy', 'a9c77921-19bf-b313-86d4-c5111d36605d', 'detail_tpl', 'news_detail');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(158, 'term.taxonomy', 'a9c77921-19bf-b313-86d4-c5111d36605d', 'bind_form', 'article');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(159, 'posts.form', '32812f56-1972-7d72-92f2-33e680939959', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(162, 'posts.form', '6b314ef5-23cc-77bb-275b-07a821988c5d', 'description', '已有567位朋友亲身体验了亲途的不一样。');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(165, 'posts.form', '56f9a7a3-57f5-7a07-fb6f-866ad7ef9e8b', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(166, 'posts.form', '70654547-9aec-c618-9753-e80dd876181a', 'page_tpl', 'page_srdz');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(167, 'posts.form', 'e522aff9-c7d0-9cd2-0f07-7e428c622e5b', 'page_tpl', 'page_srdz');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(168, 'posts.form', '94a5b422-2d0b-072a-bee5-2179a7793615', 'page_tpl', 'page_syjl');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(170, 'posts.form', '14664108-1e54-56cb-46cd-153f0f3916c7', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(171, 'posts.form', '482a47c1-60c9-8153-14aa-853f4ce2630b', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(172, 'posts.form', '6d3eea90-5f89-4f3e-9c74-657a8242f1ed', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(173, 'posts.form', '7b03685e-9066-073f-d109-0d66b8b78faf', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(174, 'posts.form', 'eb3497f2-9a1e-96de-7253-fde21761504d', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(175, 'posts.form', '16b3ae37-b073-37a0-5d00-b31e8789a277', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(176, 'posts.form', '533dba5e-9f57-0755-5753-f1f5e1d3b6cd', 'page_tpl', 'page_about');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(177, 'term.taxonomy', '0901e3e0-e01e-19d2-9840-b37c09ceaf3b', 'page_num', '20');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(178, 'term.taxonomy', '0901e3e0-e01e-19d2-9840-b37c09ceaf3b', 'lists_tpl', 'news_list');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(179, 'term.taxonomy', '0901e3e0-e01e-19d2-9840-b37c09ceaf3b', 'detail_tpl', 'news_detail');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(180, 'term.taxonomy', '0901e3e0-e01e-19d2-9840-b37c09ceaf3b', 'bind_form', 'article');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(181, 'posts.form', '8a9aef9c-e7b2-4dc6-d2f2-f9722c53a46a', 'description', '');
INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES(182, 'posts.form', '9f9563a1-0e4c-daf5-43bb-880e54330bb6', 'description', '');

-- --------------------------------------------------------

--
-- 表的结构 `mini_links`
--

DROP TABLE IF EXISTS `mini_links`;
CREATE TABLE IF NOT EXISTS `mini_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增唯一ID',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接URL',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '链接标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '链接图片',
  `target` varchar(25) NOT NULL DEFAULT '' COMMENT '链接打开方式',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '链接描述',
  `visible` varchar(20) NOT NULL DEFAULT 'Y' COMMENT '是否可见（Y/N）',
  `owner` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '添加者用户ID',
  `createtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `link_visible` (`visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `mini_links`
--

INSERT INTO `mini_links` (`id`, `url`, `name`, `image`, `target`, `description`, `visible`, `owner`, `createtime`) VALUES(1, 'http://www.baidu.com', '百度', '/uploads/picture/20161209/707e87d63b2b3b561df33d8a510b19cf.png', '_blank', '百度', 'Y', 1, 1474877272);

-- --------------------------------------------------------

--
-- 表的结构 `mini_menu`
--

DROP TABLE IF EXISTS `mini_menu`;
CREATE TABLE IF NOT EXISTS `mini_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- 转存表中的数据 `mini_menu`
--

INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(1, '文章', 'fa fa-fw fa-files-o', 0, 0, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(2, '订单', 'fa fa-fw fa-exchange', 0, 3, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(3, '会员', 'fa fa-fw fa-users', 0, 4, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(4, '设置', 'fa fa-gears', 0, 5, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(5, '个人', 'fa fa-fw fa-user', 0, 6, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(31, '写文章', 'fa fa-fw fa-edit', 1, 1, 'post/add', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(32, '所有文章', 'fa fa-fw fa-file', 1, 0, 'post/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(37, '分类目录', 'fa fa-fw fa-cubes', 1, 2, 'taxonomy/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(38, '订单列表', 'fa fa-money', 2, 0, 'order/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(39, '会员列表', 'fa fa-fw fa-user', 3, 0, 'member/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(40, '添加会员', 'fa fa-fw fa-user-plus', 3, 1, 'member/add', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(41, '基本设置', 'fa  fa-wrench', 4, 0, 'config/edit', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(42, '菜单设置', 'fa  fa-navicon ', 4, 1, 'menu/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(43, '个人资料', 'fa fa-user-times', 5, 0, 'user/edit', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(44, '修改密码', 'fa fa-fw fa-key', 5, 1, 'user/password', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(48, '插件', 'fa fa-puzzle-piece', 0, 7, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(49, '广告管理', 'fa  fa-picture-o', 48, 1, 'banner/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(50, '导航设置', 'fa  fa-cog', 4, 2, 'navigation/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(51, '页面', 'fa fa-newspaper-o', 0, 1, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(52, '所有页面', 'fa fa-fw fa-file', 51, 0, 'page/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(53, '新增页面', 'fa fa-edit (alias)', 51, 1, 'page/add', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(54, '权限设置', 'fa fa-plug', 4, 0, 'authmanager/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(55, '广告位置', 'fa fa-picture-o', 48, 0, 'banner_position/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(56, '链接管理', 'fa fa-link', 48, 3, 'links/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(59, '登录', '', 0, 0, 'index/index', 1, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(58, '评论管理', 'fa fa-comment-o', 48, 0, 'comment/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(60, '删除分类', '', 37, 0, 'taxonomyt/setStatus', 1, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(61, '添加分类目录', '', 37, 0, 'taxonomy/edit', 1, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(64, '主题设置', 'fa fa-sliders', 4, 5, 'theme/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(65, '微信设置', 'fa fa-plug', 4, 0, 'wx/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(67, '接口设置', 'fa fa-support', 4, 7, 'apiconfig/edit', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(68, '数据库', 'fa fa-cog', 0, 8, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(69, '数据库备份', 'fa fa-cog', 68, 0, 'Database/index?type=export', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(70, '数据库还原', 'fa fa-cog', 68, 0, 'Database/index?type=import', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(71, '商品', 'fa fa-shopping-cart', 0, 2, '#', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(72, '所有商品', ' fa fa-shopping-cart', 71, 0, 'goods/index', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(73, '添加商品', 'fa  fa-plus-square', 71, 1, 'goods/goodsAdd', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(74, '商品分类', 'fa fa-list', 71, 2, 'goods/category', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(75, '私人需求单', 'fa fa-money', 2, 0, 'order/person', 0, 0);
INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES(76, '商业需求单', 'fa fa-money', 2, 0, 'order/business', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_navigation`
--

DROP TABLE IF EXISTS `mini_navigation`;
CREATE TABLE IF NOT EXISTS `mini_navigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `mini_navigation`
--

INSERT INTO `mini_navigation` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`) VALUES(1, '轻定制', 'fa fa-fw fa-files-o', 0, 0, 'goods/lists?category=qdz_area_all|qdz_tese_all', 0);
INSERT INTO `mini_navigation` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`) VALUES(2, '亲途达人', 'fa fa-fw fa-exchange', 0, 1, 'goods/lists?category=qtdr_area_all|qtdr_tese_all', 0);
INSERT INTO `mini_navigation` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`) VALUES(3, '私人定制', 'fa fa-fw fa-users', 0, 2, 'article/page?name=srdz', 0);
INSERT INTO `mini_navigation` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`) VALUES(4, '主题路线', 'fa fa-gears', 0, 3, 'goods/lists?category=ztdz', 0);
INSERT INTO `mini_navigation` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`) VALUES(5, '商业交流', 'fa fa-fw fa-edit', 0, 5, 'article/page?name=syjl', 0);
INSERT INTO `mini_navigation` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`) VALUES(10, '关于我们', 'fa fa-fw fa-users', 0, 6, 'article/page?name=about', 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_orders`
--

DROP TABLE IF EXISTS `mini_orders`;
CREATE TABLE IF NOT EXISTS `mini_orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(128) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `print_no` varchar(30) DEFAULT NULL COMMENT '小票打印机单号',
  `express_type` varchar(100) DEFAULT NULL COMMENT '快递方式',
  `express_no` varchar(100) DEFAULT NULL COMMENT '快递编号',
  `pay_type` varchar(10) NOT NULL COMMENT '支付方式',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `createtime` int(11) NOT NULL,
  `is_pay` int(11) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL COMMENT '支付状态',
  `memo` varchar(255) DEFAULT NULL COMMENT '订单备注',
  `consignee_name` varchar(100) DEFAULT NULL COMMENT '收货人',
  `address` text COMMENT '收货地址',
  `mobile` varchar(11) DEFAULT NULL COMMENT '收货人电话',
  PRIMARY KEY (`id`,`uuid`,`order_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

--
-- 转存表中的数据 `mini_orders`
--

INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(73, '442ba8af-7fd7-84f6-1a30-6140f85703bd', 1, '2017032353485397', '', '', '', 'wxpay', '700.00', 1490255221, 0, 'nopaid', '', '哈哈', '北京东城区了开发的发放', '13810773215');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(74, 'ae637617-0e7f-6986-f645-68edfe99cd9f', 1, '2017032456564853', '', '', '', 'wxpay', '760.00', 1490332760, 0, 'nopaid', '', '哈哈', '北京东城区了开发的发放', '13810773215');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(79, 'aaa6704e-636e-0dba-f3f1-06c58d9da20e', 1, '2017032498519799', '', '', '', '', '0.00', 1490341083, 1, '', '', '', '', '');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(80, 'ca6419eb-1dbd-81f5-bb75-4dcd78b53f82', 1, '2017032410155525', '', '', '', '', '0.00', 1490341454, 1, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(81, '1f93c9b2-1d89-efc9-6894-0f15cca621bd', 1, '2017032457515455', '', '', '', '', '0.00', 1490341545, 1, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(82, '065d1da4-f4c8-0d5f-03fc-2f7694689cea', 1, '2017032448971001', '', '', '', '', '0.00', 1490342192, 1, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(83, 'abb562af-0a28-3d8b-839e-a216377eeb85', 1, '2017032410152519', '', '', '', '', '0.00', 1490343230, 1, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(84, 'd866706e-e4d7-3ef2-c865-b26955eff6f9', 1, '2017032451529949', '', '', '', '', '0.00', 1490343235, 1, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(85, '927cd2de-0f6a-c79f-c4d7-0479c614737f', 1, '2017032455545048', '', '', '', '', '0.00', 1490343911, 1, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(86, '0ed8024c-debd-8779-8f92-6bac59994a8c', 1, '2017032498971025', '', '', '', '', '0.00', 1490343915, 1, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(87, 'b69613f5-e48c-fac5-6a15-9d20ee765bff', 1, '2017032410250100', '', '', '', '', '0.00', 1490344127, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(88, 'a9ec269c-631f-403b-0b6e-6b6e368e94d8', 1, '2017032749495698', '', '', '', '', '0.00', 1490590129, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(89, 'd08e7097-f06c-c3a7-4092-e9841f0d17e0', 1, '2017032757995251', '', '', '', '', '0.00', 1490590137, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(90, '05f4ce26-483d-f1b2-504c-456c63a1646c', 1, '2017032710199555', '', '', '', '', '0.00', 1490590174, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(91, '35dc6982-5bdb-0f17-c1e8-23a96a7521a7', 1, '2017032755545051', '', '', '', '', '0.00', 1490590183, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(92, '6640c8d9-5740-a8d0-5d20-8411518eaed5', 1, '2017032748995710', '', '', '', '', '0.00', 1490590208, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(93, 'ae79a01e-db4d-0cd0-5b31-0c01dc6dae20', 1, '2017032752565148', '', '', '', '', '0.00', 1490590244, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(94, '4716317c-16c1-8a81-c898-ff09321941c6', 1, '2017032749539755', '', '', '', '', '0.00', 1490590257, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(95, '13628904-129d-2554-eeb3-cff4a5ea9571', 1, '2017032798511001', '', '', '', '', '0.00', 1490590411, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(96, '4b10ac91-24c4-934b-92ed-9f6b211f7a49', 1, '2017032751515656', '', '', '', '', '0.00', 1490590467, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(97, '47b3a405-df5a-9edd-48c0-f6bf72e932ee', 1, '2017032856971025', '', '', '', '', '0.00', 1490686360, 0, '', '', '', '', ' ');
INSERT INTO `mini_orders` (`id`, `uuid`, `uid`, `order_no`, `print_no`, `express_type`, `express_no`, `pay_type`, `amount`, `createtime`, `is_pay`, `status`, `memo`, `consignee_name`, `address`, `mobile`) VALUES(98, '121bc992-3daa-9523-1015-37fba6782091', 1, '2017032810256541', '', '', '', '', '0.00', 1490686479, 0, '', '', '', '', ' ');

-- --------------------------------------------------------

--
-- 表的结构 `mini_orders_address`
--

DROP TABLE IF EXISTS `mini_orders_address`;
CREATE TABLE IF NOT EXISTS `mini_orders_address` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `consignee_name` varchar(100) NOT NULL COMMENT '收货人',
  `province` varchar(100) NOT NULL COMMENT '省',
  `city` varchar(100) NOT NULL COMMENT '市',
  `county` varchar(100) NOT NULL COMMENT '县/区',
  `address` text NOT NULL COMMENT '详细地址',
  `mobile` varchar(11) NOT NULL COMMENT '联系电话',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '1-正常 -1-已删除',
  `default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为默认收货地址1-是 0-否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `mini_orders_address`
--

INSERT INTO `mini_orders_address` (`id`, `uid`, `consignee_name`, `province`, `city`, `county`, `address`, `mobile`, `status`, `default`) VALUES(14, 1, '哈哈', '北京', '东城区', '', '了开发的发放', '13810773215', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `mini_orders_goods`
--

DROP TABLE IF EXISTS `mini_orders_goods`;
CREATE TABLE IF NOT EXISTS `mini_orders_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(11) NOT NULL COMMENT '订单号',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `name` varchar(255) NOT NULL,
  `num` int(10) NOT NULL COMMENT '购买数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` text NOT NULL,
  `standard` varchar(255) NOT NULL,
  `cover_path` varchar(255) NOT NULL,
  `is_comment` varchar(10) NOT NULL DEFAULT '-1' COMMENT '商品是否评论 -1-否  1-是',
  `departure_time` int(11) NOT NULL,
  `man_num` int(10) NOT NULL,
  `child_num` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- 转存表中的数据 `mini_orders_goods`
--

INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(74, '73', 42, '红枣夹核桃', 28, '25.00', '红枣夹核桃', '250克X3袋', '/uploads/picture/20161223/52f5e882a665079b8795b3d2ab367431.jpg', '-1', 0, 0, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(75, '74', 44, '核桃仁', 1, '35.00', '核桃仁', '100克X10袋', '/uploads/picture/20161223/9da72a3997817954407982362b3ac40a.jpg', '-1', 0, 0, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(76, '74', 42, '红枣夹核桃', 29, '25.00', '红枣夹核桃', '250克X3袋', '/uploads/picture/20161223/52f5e882a665079b8795b3d2ab367431.jpg', '-1', 0, 0, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(79, '79', 0, '', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(80, '80', 0, '', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(81, '81', 0, '', 0, '0.00', '', '', '', '-1', 2017, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(82, '82', 0, '', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(83, '83', 0, '', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(84, '84', 0, '', 0, '0.00', '', '', '', '-1', 2147483647, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(85, '85', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(86, '86', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 1488412800, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(87, '87', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 1488585600, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(88, '88', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(89, '89', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(90, '90', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(91, '91', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(92, '92', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(93, '93', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(94, '94', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 0, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(95, '95', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 1488931200, 1, 0);
INSERT INTO `mini_orders_goods` (`id`, `order_id`, `goods_id`, `name`, `num`, `price`, `description`, `standard`, `cover_path`, `is_comment`, `departure_time`, `man_num`, `child_num`) VALUES(96, '96', 47, '陕西冬枣', 0, '0.00', '', '', '', '-1', 1490227200, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_orders_status`
--

DROP TABLE IF EXISTS `mini_orders_status`;
CREATE TABLE IF NOT EXISTS `mini_orders_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL COMMENT '订单号',
  `approve_uid` int(50) DEFAULT NULL COMMENT '审核人',
  `trade_no` varchar(50) DEFAULT NULL COMMENT '支付接口流水号',
  `trade_status` varchar(50) DEFAULT NULL COMMENT '支付接口状态',
  `status` varchar(30) NOT NULL COMMENT 'nopaid-未支付 paid-已支付,待发货  shipped-已发货  completed-收货已完成',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_person_need`
--

DROP TABLE IF EXISTS `mini_person_need`;
CREATE TABLE IF NOT EXISTS `mini_person_need` (
  `name` char(128) NOT NULL COMMENT '姓名',
  `mobile` varchar(128) NOT NULL COMMENT '手机号',
  `email` char(128) NOT NULL COMMENT '邮箱',
  `reached` char(128) DEFAULT NULL COMMENT '目的地',
  `out_date` char(128) DEFAULT NULL COMMENT '出行日期',
  `out_days` char(128) DEFAULT NULL COMMENT '出行天数',
  `man` int(11) DEFAULT NULL COMMENT '成人人数',
  `children` int(11) DEFAULT NULL COMMENT '儿童人数',
  `cost` char(128) DEFAULT NULL COMMENT '预计花费',
  `description` text COMMENT '备注',
  `createtime` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `mini_person_need`
--

INSERT INTO `mini_person_need` (`name`, `mobile`, `email`, `reached`, `out_date`, `out_days`, `man`, `children`, `cost`, `description`, `createtime`) VALUES('111111111111', '2147483647', '11@qq.com', '', '', '', 0, 0, '￥10000-￥30000', '', 0);
INSERT INTO `mini_person_need` (`name`, `mobile`, `email`, `reached`, `out_date`, `out_days`, `man`, `children`, `cost`, `description`, `createtime`) VALUES('11111111', '17744484319', '11@qq.com', '', '', '', 0, 0, '', '', 1490695473);

-- --------------------------------------------------------

--
-- 表的结构 `mini_posts`
--

DROP TABLE IF EXISTS `mini_posts`;
CREATE TABLE IF NOT EXISTS `mini_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增唯一ID',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '对应作者ID',
  `uuid` varchar(128) NOT NULL,
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `content` longtext NOT NULL COMMENT '正文',
  `title` text NOT NULL COMMENT '标题',
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'publish' COMMENT '文章状态（publish/draft/inherit等）',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open' COMMENT '评论状态（open/closed）',
  `password` varchar(20) NOT NULL DEFAULT '' COMMENT '文章密码',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '文章缩略名',
  `updatetime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父文章，主要用于PAGE',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `type` varchar(20) NOT NULL DEFAULT 'post' COMMENT '文章类型（post/page等）',
  `comment` bigint(20) NOT NULL DEFAULT '0' COMMENT '评论总数',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '文章浏览量',
  PRIMARY KEY (`id`),
  KEY `post_name` (`name`(191)),
  KEY `type_status_date` (`type`,`status`,`createtime`,`id`),
  KEY `post_parent` (`pid`),
  KEY `post_author` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- 转存表中的数据 `mini_posts`
--

INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(69, 1, '533dba5e-9f57-0755-5753-f1f5e1d3b6cd', 1490840098, '<p>关于我们</p>', '关于我们', '', 'publish', 'open', '', 'about', 1490840098, 0, 0, 'page', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(56, 1, '32812f56-1972-7d72-92f2-33e680939959', 1489980237, '<ol class=" list-paddingleft-2" style="list-style-type: decimal;"><li><p>为什么选择亲途？</p></li><li><p>为什么选择亲途？</p></li><li><p>为什么选择亲途？</p></li><li><p>为什么选择亲途？</p></li><li><p>为什么选择亲途？</p></li><li><p>为什么选择亲途？<br/></p></li></ol>', '为什么选择亲途？', '', 'publish', 'open', '', 'why-choose', 1489980237, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(57, 1, '6b314ef5-23cc-77bb-275b-07a821988c5d', 1489982273, '<table style="text-align: center;"><tbody><tr class="firstRow"><td width="33.333%" valign="top" style="word-break: break-all;">q</td><td width="33.333%" valign="top" style="word-break: break-all;">q</td><td width="33.333%" valign="top" style="word-break: break-all;">q</td></tr><tr><td width="33.333%" valign="top" style="word-break: break-all;">q</td><td width="33.333%" valign="top"><br/></td><td width="33.333%" valign="top" style="word-break: break-all;">q</td></tr></tbody></table><p style="text-align: center;"><br/></p>', '轻定制服务流程', '', 'publish', 'open', '', 'qdz-server-process', 1489982745, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(71, 1, '9f9563a1-0e4c-daf5-43bb-880e54330bb6', 1490846546, '<p>222222222</p>', '免责声明', '', 'publish', 'open', '', 'mzsm', 1490846546, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(70, 1, '8a9aef9c-e7b2-4dc6-d2f2-f9722c53a46a', 1490845222, '<p>1111111</p>', '关于我们', '', 'publish', 'open', '', 'about_me', 1490845222, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(60, 1, '56f9a7a3-57f5-7a07-fb6f-866ad7ef9e8b', 1490601140, '<p>1111<br/></p>', '达人体验服务流程', '', 'publish', 'open', '', 'qtdr-server-process', 1490601140, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(61, 1, 'e522aff9-c7d0-9cd2-0f07-7e428c622e5b', 1490686244, '<p>11111</p>', '私人定制', '', 'publish', 'open', '', 'srdz', 1490686344, 0, 0, 'page', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(62, 1, '94a5b422-2d0b-072a-bee5-2179a7793615', 1490691894, '<p>saaaa</p>', '商业交流', '', 'publish', 'open', '', 'syjl', 1490691894, 0, 0, 'page', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(63, 1, '14664108-1e54-56cb-46cd-153f0f3916c7', 1490779682, '<p>商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域商业交流领域</p>', '商业交流领域', '', 'publish', 'open', '', 'post-syjl', 1490779701, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(64, 1, '482a47c1-60c9-8153-14aa-853f4ce2630b', 1490780313, '<p>工业制造工业制造工业制造</p>', '工业制造', '', 'publish', 'open', '', 'post-gyzz', 1490780313, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(65, 1, '6d3eea90-5f89-4f3e-9c74-657a8242f1ed', 1490780338, '<p>社会服务社会服务社会服务社会服务社会服务社会服务社会服务</p>', '社会服务', '', 'publish', 'open', '', 'post-shfw', 1490780338, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(66, 1, '7b03685e-9066-073f-d109-0d66b8b78faf', 1490780361, '<p>动漫文化动漫文化动漫文化动漫文化动漫文化</p>', '动漫文化', '', 'publish', 'open', '', 'post-dmwh', 1490780361, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(67, 1, 'eb3497f2-9a1e-96de-7253-fde21761504d', 1490780380, '<p>时尚流行时尚流行时尚流行时尚流行</p>', '时尚流行', '', 'publish', 'open', '', 'post-shlx', 1490780380, 0, 0, 'post', 0, 0);
INSERT INTO `mini_posts` (`id`, `uid`, `uuid`, `createtime`, `content`, `title`, `description`, `status`, `comment_status`, `password`, `name`, `updatetime`, `pid`, `level`, `type`, `comment`, `view`) VALUES(68, 1, '16b3ae37-b073-37a0-5d00-b31e8789a277', 1490780423, '<p>机器人制造机器人制造机器人制造机器人制造</p>', '机器人制造', '', 'publish', 'open', '', 'post-jqrzz', 1490780423, 0, 0, 'post', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_terms`
--

DROP TABLE IF EXISTS `mini_terms`;
CREATE TABLE IF NOT EXISTS `mini_terms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '分类名',
  `slug` varchar(200) NOT NULL DEFAULT '' COMMENT '缩略名',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  `sort` decimal(50,0) NOT NULL COMMENT '用于排序',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `mini_terms`
--

INSERT INTO `mini_terms` (`id`, `name`, `slug`, `term_group`, `sort`) VALUES(13, '关于我们', 'about', 0, '0');
INSERT INTO `mini_terms` (`id`, `name`, `slug`, `term_group`, `sort`) VALUES(12, '页面内容', 'page-block', 0, '0');

-- --------------------------------------------------------

--
-- 表的结构 `mini_term_relationships`
--

DROP TABLE IF EXISTS `mini_term_relationships`;
CREATE TABLE IF NOT EXISTS `mini_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '对应文章ID/链接ID',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '对应分类方法ID',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `mini_term_relationships`
--

INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(56, 12, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(57, 12, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(71, 13, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(70, 13, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(60, 12, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(63, 12, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(64, 12, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(65, 12, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(66, 12, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(67, 12, 0);
INSERT INTO `mini_term_relationships` (`object_id`, `term_taxonomy_id`, `sort`) VALUES(68, 12, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_term_taxonomy`
--

DROP TABLE IF EXISTS `mini_term_taxonomy`;
CREATE TABLE IF NOT EXISTS `mini_term_taxonomy` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类方法ID',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类方法(post_tag)',
  `uuid` varchar(128) NOT NULL,
  `taxonomy` varchar(32) NOT NULL DEFAULT '' COMMENT '分类方法(category)',
  `description` longtext NOT NULL,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '所属父分类方法ID',
  `count` bigint(20) NOT NULL DEFAULT '0' COMMENT '文章数统计',
  PRIMARY KEY (`id`,`count`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `mini_term_taxonomy`
--

INSERT INTO `mini_term_taxonomy` (`id`, `term_id`, `uuid`, `taxonomy`, `description`, `pid`, `count`) VALUES(12, 12, 'a9c77921-19bf-b313-86d4-c5111d36605d', 'category', '', 0, 9);
INSERT INTO `mini_term_taxonomy` (`id`, `term_id`, `uuid`, `taxonomy`, `description`, `pid`, `count`) VALUES(13, 13, '0901e3e0-e01e-19d2-9840-b37c09ceaf3b', 'category', '', 0, 2);

-- --------------------------------------------------------

--
-- 表的结构 `mini_users`
--

DROP TABLE IF EXISTS `mini_users`;
CREATE TABLE IF NOT EXISTS `mini_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(128) NOT NULL COMMENT '系统唯一标识符',
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(11) NOT NULL,
  `regdate` int(10) NOT NULL DEFAULT '0',
  `regip` char(15) NOT NULL DEFAULT '0',
  `salt` varchar(6) NOT NULL DEFAULT '0' COMMENT '加密盐',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1正常，2禁用，-1删除',
  `last_login` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `wechat_openid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `qq_openid` varchar(255) DEFAULT NULL COMMENT 'qqopenid',
  `sina_openid` varchar(255) NOT NULL COMMENT '微博openid',
  `score` int(11) DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `mini_users`
--

INSERT INTO `mini_users` (`id`, `uuid`, `username`, `password`, `nickname`, `email`, `mobile`, `regdate`, `regip`, `salt`, `status`, `last_login`, `wechat_openid`, `qq_openid`, `sina_openid`, `score`) VALUES(1, 'ad75820a-96c3-a1a8-20c6-195534dd75d3', 'admin', 'e3725a90e473b27068b29205a7f7c2dd', 'admin', 'admin@qq.com', ' ', 1487298736, '1', '071cf9', 1, 1490340592, '', '', '', 0);
INSERT INTO `mini_users` (`id`, `uuid`, `username`, `password`, `nickname`, `email`, `mobile`, `regdate`, `regip`, `salt`, `status`, `last_login`, `wechat_openid`, `qq_openid`, `sina_openid`, `score`) VALUES(30, '0018d7c7-15f1-58e5-5853-570e1bdfda17', '13810773215', 'bbde9d236d823fee26a48a4d525987ee', '111', '', '13810773215', 1490170291, '0', '3d10f9', 1, 1490331170, '', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_extend`
--

DROP TABLE IF EXISTS `mini_user_extend`;
CREATE TABLE IF NOT EXISTS `mini_user_extend` (
  `group_id` mediumint(10) unsigned NOT NULL COMMENT '用户id',
  `extend_id` varchar(300) NOT NULL COMMENT '扩展表中数据的id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '扩展类型标识 1:栏目分类权限;2:模型权限',
  UNIQUE KEY `group_extend_type` (`group_id`,`extend_id`,`type`),
  KEY `uid` (`group_id`),
  KEY `group_id` (`extend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组与分类的对应关系表';

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_group`
--

DROP TABLE IF EXISTS `mini_user_group`;
CREATE TABLE IF NOT EXISTS `mini_user_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '用户组所属模块',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '组类型',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为-1禁用',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `mini_user_group`
--

INSERT INTO `mini_user_group` (`id`, `module`, `type`, `title`, `description`, `status`, `rules`) VALUES(1, 'admin', 1, '测试用户组', '', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_group_access`
--

DROP TABLE IF EXISTS `mini_user_group_access`;
CREATE TABLE IF NOT EXISTS `mini_user_group_access` (
  `uid` bigint(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_rule`
--

DROP TABLE IF EXISTS `mini_user_rule`;
CREATE TABLE IF NOT EXISTS `mini_user_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1-url;2-主菜单',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_wx_menu`
--

DROP TABLE IF EXISTS `mini_wx_menu`;
CREATE TABLE IF NOT EXISTS `mini_wx_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '菜单名',
  `type` mediumint(2) NOT NULL COMMENT '菜单类型(1跳转，2消息)',
  `url` varchar(225) NOT NULL COMMENT '菜单跳转地址',
  `msg` varchar(1000) NOT NULL COMMENT '回复消息',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `key` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_wx_reply`
--

DROP TABLE IF EXISTS `mini_wx_reply`;
CREATE TABLE IF NOT EXISTS `mini_wx_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` mediumint(2) NOT NULL COMMENT '回复类型，1关注回复2消息回复3关键词回复',
  `key` varchar(225) DEFAULT NULL COMMENT '关键词',
  `msg` varchar(1000) DEFAULT NULL COMMENT '回复内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
