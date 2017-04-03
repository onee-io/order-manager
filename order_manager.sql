/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50537
 Source Host           : localhost
 Source Database       : order_manager

 Target Server Type    : MySQL
 Target Server Version : 50537
 File Encoding         : utf-8

 Date: 03/17/2017 23:28:56 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `wo_classifications`
-- ----------------------------
DROP TABLE IF EXISTS `wo_classifications`;
CREATE TABLE `wo_classifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classification_name` varchar(20) NOT NULL,
  `classification_type` int(11) NOT NULL COMMENT '1.角色管理分类 2.操作分类 3.板块分类',
  `controller` varchar(50) NOT NULL,
  `action` varchar(20) NOT NULL,
  `query_type` int(11) unsigned zerofill NOT NULL COMMENT '查询类型：0、无需查询 1、发起人查询 2、受理人查询 3、分类查询',
  `deleted` int(1) NOT NULL COMMENT '0.为删除 1.已删除',
  PRIMARY KEY (`id`),
  KEY `base` (`id`,`classification_type`,`query_type`,`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_classifications`
-- ----------------------------
BEGIN;
INSERT INTO `wo_classifications` VALUES ('1', '用户管理', '1', 'UserManager', 'index', '0', '0'), ('2', '角色管理', '1', 'RoleManager', 'index', '0', '0'), ('3', '分类管理', '1', 'ClassificationManager', 'index', '0', '0'), ('4', '新建工单', '2', 'OrderManager', 'addOrder', '0', '0'), ('5', '查询工单', '2', 'OrderManager', 'queryOrder', '0', '0'), ('6', '我发起的工单', '3', 'OrderManager', 'orderList', '1', '0'), ('7', '我受理的工单', '3', 'OrderManager', 'orderList', '2', '0'), ('8', '技术支持', '3', 'OrderManager', 'orderList', '3', '0'), ('9', '产品需求', '3', 'OrderManager', 'orderList', '3', '0'), ('10', '客户反馈', '3', 'OrderManager', 'orderList', '3', '0'), ('14', '测试分类111', '3', 'OrderManager', 'orderList', '3', '1'), ('15', '测试', '3', 'OrderManager', 'orderList', '3', '1'), ('16', '测试', '3', 'OrderManager', 'orderList', '3', '1'), ('17', '测试', '3', 'OrderManager', 'orderList', '3', '1'), ('18', '测试', '3', 'OrderManager', 'orderList', '3', '1'), ('19', 'test', '3', 'OrderManager', 'orderList', '3', '1'), ('20', '嘻嘻嘻嘻', '3', 'OrderManager', 'orderList', '3', '1'), ('21', 'ceshiasdasd', '3', 'OrderManager', 'orderList', '3', '1'), ('22', '啊哈哈啊啊啊啊', '3', 'OrderManager', 'orderList', '3', '1'), ('23', 'test', '3', 'OrderManager', 'orderList', '3', '1'), ('24', 'test', '3', 'OrderManager', 'orderList', '3', '1'), ('25', 'test', '3', 'OrderManager', 'orderList', '3', '1'), ('26', 'hahahaha', '3', 'OrderManager', 'orderList', '3', '1'), ('27', '哈哈哈哈', '3', 'OrderManager', 'orderList', '3', '1'), ('28', '技术支持', '3', 'OrderManager', 'orderList', '3', '1'), ('29', '测试', '3', 'OrderManager', 'orderList', '3', '0');
COMMIT;

-- ----------------------------
--  Table structure for `wo_comments`
-- ----------------------------
DROP TABLE IF EXISTS `wo_comments`;
CREATE TABLE `wo_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL COMMENT '工单ID',
  `content` text NOT NULL COMMENT '评论内容',
  `from_user_id` int(11) NOT NULL COMMENT '评论者',
  `to_user_id` int(11) NOT NULL COMMENT '被评论者',
  `deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `base` (`order_no`,`updated_at`,`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_comments`
-- ----------------------------
BEGIN;
INSERT INTO `wo_comments` VALUES ('12', '10011476460849', '撒打算打算打算撒的', '1002', '1001', '0', '2016-10-15 06:32:42', '2016-10-15 06:32:42'), ('20', '10011476460849', '二哥二胎后表示如果百年树人太懦弱', '1000', '1001', '0', '2016-10-18 08:56:20', '2016-10-18 08:56:20'), ('22', '14748834981002', 'xcvbxcvxcv', '1001', '1001', '0', '2016-10-25 09:27:49', '2016-10-25 09:27:49'), ('23', '10071477300593', 'asds', '1000', '1007', '0', '2016-10-26 10:20:44', '2016-10-26 10:20:44'), ('24', '10141477497563', 'ahshdahsdhahsdhasd', '1015', '1014', '0', '2016-10-26 16:00:55', '2016-10-26 16:00:55'), ('25', '10141477552382', '我没受理，知识评论', '1015', '1014', '0', '2016-10-27 07:16:54', '2016-10-27 07:16:54'), ('26', '10011477707877', '<img width=\"300px\" src=\"http://order.com/img/uploadImages/5rNoOkAnHutWon4jyYN6u0rlc1pS1pAQlIk46d1zzK7fqmR8tiwzeE83BeX5Fqrk.jpeg\">hhhahahaaha aahsdhasd啊还是大哈省的<div><br></div>', '1001', '1001', '0', '2016-10-29 02:36:55', '2016-10-29 02:36:55'), ('27', '10011477707877', 'asdadadasdashdbajkdb<div><img width=\"300px\" src=\"http://order.com/img/uploadImages/j8ug2o5caXZ4oosFnsEFjK26oc7wNqKW4hxIfhXHrRKBra7mo4wx3prpttUEDY2G.jpeg\"><br></div>', '1001', '1001', '0', '2016-10-29 02:39:40', '2016-10-29 02:39:40'), ('28', '10011477655435', '<img width=\"300px\" src=\"http://order.com/img/uploadImages/y6QH6AILxAV0Z9TYyWT2vttY4DdiJjymHLK0EFkp9ueq3qYgUFchBUTPOIa0yRBC.jpeg\"><div>jhvjhsbvjhsdblhfvsdljhfbvs</div>', '1001', '1001', '0', '2016-10-29 02:40:36', '2016-10-29 02:40:36'), ('29', '10011477707877', 'asdasd', '1000', '1001', '0', '2016-10-29 05:29:25', '2016-10-29 05:29:25'), ('30', '10011477707877', 'sasdasd', '1002', '1001', '0', '2016-10-29 05:34:26', '2016-10-29 05:34:26'), ('31', '10011477655435', 'askjdaksd', '1001', '1001', '0', '2016-10-29 06:25:47', '2016-10-29 06:25:47'), ('32', '10011477655435', '最新的评论<img width=\"300px\" src=\"http://order.com/img/uploadImages/qYtbZVH7uFdvTiQHoICxsieW938u1cpUfEheYbgBLavfPIuWpJ86BjZnbjOGnUGV.jpeg\">', '1001', '1001', '0', '2016-10-29 06:26:15', '2016-10-29 06:26:15');
COMMIT;

-- ----------------------------
--  Table structure for `wo_operates`
-- ----------------------------
DROP TABLE IF EXISTS `wo_operates`;
CREATE TABLE `wo_operates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operate_name` varchar(20) NOT NULL COMMENT '操作名称',
  `controller` varchar(50) NOT NULL,
  `action` varchar(20) NOT NULL,
  `type` int(11) NOT NULL COMMENT '操作类型：1.工单管理操作 2.用户管理操作 3.角色管理操作 4.分类分类管理操作',
  PRIMARY KEY (`id`),
  KEY `base` (`id`,`type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_operates`
-- ----------------------------
BEGIN;
INSERT INTO `wo_operates` VALUES ('1', '详情', 'OrderManager', 'detailOrder', '1'), ('2', '受理', 'OrderManager', 'acceptOrder', '1'), ('3', '验收', 'OrderManager', 'checkOrder', '1'), ('4', '取消', 'OrderManager', 'cancelOrder', '1'), ('5', '删除', 'OrderManager', 'deleteOrder', '1'), ('6', '完成', 'OrderManager', 'completeOrder', '1'), ('7', '编辑用户', 'UserManager', 'editUser', '2'), ('8', '删除用户', 'UserManager', 'deleteUser', '2'), ('9', '新建用户', 'UserManager', 'addUser', '2'), ('10', '编辑角色', 'RoleManager', 'editRole', '3'), ('11', '删除角色', 'RoleManager', 'deleteRole', '3'), ('12', '新建角色', 'RoleManager', 'addRole', '3'), ('13', '编辑分类', 'ClassificationManager', 'editClassification', '4'), ('14', '删除分类', 'ClassificationManager', 'deleteClassification', '4'), ('15', '新建分类', 'ClassificationManager', 'addClassification', '4');
COMMIT;

-- ----------------------------
--  Table structure for `wo_orders`
-- ----------------------------
DROP TABLE IF EXISTS `wo_orders`;
CREATE TABLE `wo_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL COMMENT '工单编号',
  `classification_id` int(11) NOT NULL COMMENT '分类ID',
  `title` varchar(20) NOT NULL COMMENT '工单标题',
  `content` text NOT NULL COMMENT '工单内容',
  `status` int(11) NOT NULL COMMENT '工单状态 1.未受理 2.受理中 3.待验收 4.已完成',
  `deleted` int(1) NOT NULL COMMENT '0.为删除 1.已删除',
  `create_user_id` int(11) NOT NULL COMMENT '发起人ID',
  `accept_user_id` int(11) DEFAULT NULL COMMENT '受理人ID',
  `created_at` datetime NOT NULL COMMENT '工单创建时间',
  `updated_at` datetime NOT NULL COMMENT '工单更新时间',
  PRIMARY KEY (`id`),
  KEY `base` (`order_no`,`classification_id`,`status`,`deleted`,`create_user_id`,`accept_user_id`,`updated_at`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_orders`
-- ----------------------------
BEGIN;
INSERT INTO `wo_orders` VALUES ('2', '14748834981002', '9', '产品需求的工单', '这是一个产品需求的工单需要处理', '4', '0', '1001', '1002', '2016-10-08 14:01:03', '2016-10-15 07:51:00'), ('13', '10011476460817', '9', '111223233', '32321413424', '4', '1', '1001', '1002', '2016-10-14 16:00:17', '2016-10-15 11:45:11'), ('14', '10011476460849', '9', '111223233', '32321413424', '4', '0', '1001', '1002', '2016-10-14 16:00:49', '2016-10-15 07:50:57'), ('16', '10011476460882', '10', 'qweqwe', 'qweqwe', '4', '0', '1001', '1002', '2016-10-14 16:01:22', '2016-10-18 07:12:24'), ('30', '10011476540704', '10', 'asdasdasfavdsd', 'vfsbfvsdsssvsv', '4', '0', '1001', '1002', '2016-10-15 14:11:44', '2016-10-15 14:12:55'), ('100', '10011477032697', '8', 'asdfadfasdf', 'asdfasdfasdf', '1', '0', '1001', null, '2016-10-21 06:51:37', '2016-10-21 06:51:37'), ('101', '10011477032705', '9', 'asdfasdfasdfgasgdsfg', 'fgndfgjnsdftgnjryn', '3', '0', '1001', '1002', '2016-10-21 06:51:45', '2016-10-21 06:52:29'), ('102', '10011477032713', '10', 'srtnsdrtgyndrfytndrt', 'sftnsrftghdsrftbshrthnbsr', '1', '1', '1001', null, '2016-10-21 06:51:53', '2016-10-21 06:51:53'), ('103', '10011477032726', '8', 'thnryjmndtyuhmdtuhmd', 'dtuhmdhuymdtuyhmdtm', '2', '1', '1001', '1002', '2016-10-21 06:52:06', '2016-10-21 06:52:32'), ('104', '10011477300231', '8', 'qweqweqweqweq', 'qweqeqweqweqweqweqweq', '4', '1', '1001', '1002', '2016-10-24 09:10:31', '2016-10-29 06:21:59'), ('105', '10011477300240', '9', 'qweqwqrqwerw', 'werwerfwerfweftwefw', '1', '1', '1001', null, '2016-10-24 09:10:40', '2016-10-24 09:10:40'), ('106', '10071477300580', '8', 'wefdaeg24t345tq3', '4q3t43q4tw34w3t4', '2', '0', '1007', '1002', '2016-10-24 09:16:20', '2016-10-24 09:16:50'), ('107', '10071477300593', '9', 'asdvawergb234es32', '2q4gw3qe4gv3w4gw4', '1', '0', '1007', null, '2016-10-24 09:16:33', '2016-10-24 09:16:33'), ('108', '10101477385449', '9', 'qwer', 'qwer', '1', '1', '1010', null, '2016-10-25 08:50:49', '2016-10-25 08:50:49'), ('109', '10011477387664', '9', 'asds', 'zxczxc', '1', '0', '1001', null, '2016-10-25 09:27:44', '2016-10-25 09:27:44'), ('110', '10011477394595', '9', 'cgcbc', 'cgbc', '2', '0', '1001', '1015', '2016-10-25 11:23:15', '2016-10-26 16:01:21'), ('111', '10011477394847', '9', 'cgcbc', 'cgbc', '1', '0', '1001', null, '2016-10-25 11:27:27', '2016-10-25 11:27:27'), ('112', '10011477395003', '9', 'fdsfds', 'fdsf', '1', '0', '1001', null, '2016-10-25 11:30:03', '2016-10-25 11:30:03'), ('128', '10141477497585', '10', 'hahahaha', 'hahahaha', '1', '0', '1014', null, '2016-10-26 15:59:45', '2016-10-26 15:59:45'), ('129', '10141477552382', '10', '小鲜的工单001', '需要图文详情', '3', '0', '1014', '1015', '2016-10-27 07:13:02', '2016-10-27 07:22:39'), ('130', '10011477653188', '8', '测试图文', '这里是蚊子蚊子蚊子<div><img src=\"./uploadImages/rSir4Ab6E1J8wIbxqAbHES6JV0VF3cj5.jpeg\"><br></div>', '1', '0', '1001', null, '2016-10-28 11:13:08', '2016-10-28 11:13:08'), ('131', '10011477653775', '8', '测试图片222', '<img src=\"./uploadImages/CDRDxSb1T4ohq9WoagY0vzRMvWuUGqHx.jpeg\">\\a\\sdasf', '1', '0', '1001', null, '2016-10-28 11:22:55', '2016-10-28 11:22:55'), ('132', '10011477653851', '8', '测试图片2', 'asdasd<img src=\"./uploadImages/JhMjKeW1QRvGhzW62h4fm4oVKcYTXMmm.jpeg\">', '1', '1', '1001', null, '2016-10-28 11:24:11', '2016-10-28 11:24:11'), ('133', '10011477653900', '8', '测试图片12', '<img src=\"./img/uploadImages/IV5DqpMm7gNzIjyOkOrPSYcpAvI2IXsu.jpeg\"><div><br></div><div>哈哈哈哈哈</div>', '1', '0', '1001', null, '2016-10-28 11:25:00', '2016-10-28 11:25:00'), ('134', '10011477654223', '8', '测试图文111', '哈哈哈哈哈哈哈<div><img src=\"http://order.com/img/uploadImages/ftUzXcazCxPnREDaS7lLc6zX4kpwG67l.jpeg\"><br></div><div>阿斯顿不放假啊吧韩建冬很方便</div>', '1', '0', '1001', null, '2016-10-28 11:30:23', '2016-10-28 11:30:23'), ('135', '10011477654330', '8', 'asdasd', '<img src=\"data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjI', '1', '0', '1001', null, '2016-10-28 11:32:10', '2016-10-28 11:32:10'), ('136', '10011477654878', '8', 'asdasd', 'asdas阿克苏觉得难看死的恐惧啊<div><img width=\"300px\" src=\"http://order.com/img/uploadImages/pDUCBR6Fzd3kUNjBBvajwquXbzRTd6U2.jpeg\"><br></div><div>按时打卡不是打击啊胡说八道<img width=\"300px\" src=\"http://order.com/img/uploadIm', '1', '0', '1001', null, '2016-10-28 11:41:18', '2016-10-28 11:41:18'), ('137', '10011477655435', '8', '1111111', '撒撒打算打<div><img width=\"300px\" src=\"http://order.com/img/uploadImages/EPrf2YQgqm68UDGBQM2KRyOGxuS7KS0o.jpeg\"><br></div><div>阿斯顿发送到发送地方</div><div><img width=\"300px\" src=\"http://order.com/img/uploadImages/ZNi39l7UnL5IqPE3vbVQzAsmlKNOozB7.jpeg\"><br></div><div>卡上大部分看书的风景看舒服</div><div><img width=\"300px\" src=\"http://order.com/img/uploadImages/ilvKIgnpMkWIuYAns27d6BKDXjuPYnck.jpeg\"><br></div>', '1', '0', '1001', null, '2016-10-28 11:50:35', '2016-10-29 06:07:37'), ('138', '10011477656586', '9', 'asdasd', '&lt;img src=\"asdasdasdasdasd.\"&gt;<div>askfasjhdbfja<img width=\"300px\" src=\"http://order.com/img/uploadImages/y3D2q3FO45RhJ4BtfQNUZonL5H1WmPPI.jpeg\"></div><div>哈哈等哈就萨哈夫 v</div>', '2', '0', '1001', '1002', '2016-10-28 12:09:46', '2016-10-29 05:50:22'), ('139', '10011477669470', '8', 'asd', '<img width=\"300px\" src=\"http://order.com/img/uploadImages/bM7QSTDxMQbUooxA4REwP7yWW2DW4OnRiosR5RD4kZtoIj9BMPlY9LwQynVOkFKH.jpeg\"><img width=\"300px\" src=\"http://order.com/img/uploadImages/gzI4VuLnHUNRQvhdJ9UCzt1T3q66XW6ik2zEl9FaW8Y5O1BuYjGrr1stCzVrgnW9.jpeg\">', '4', '1', '1001', '1002', '2016-10-28 15:44:30', '2016-10-29 06:22:36'), ('140', '10011477707877', '8', 'qqqqq', '&lt;img src=\"\"&gt;<div><img width=\"300px\" src=\"http://order.com/img/uploadImages/kjTXRSraOOdZwjUZlr6h1mlKmqdJ20FwavYTQoR41pWs7wxHez3OcpGL42fQebBX.jpeg\"><br></div>', '4', '0', '1001', '1015', '2016-10-29 02:24:37', '2016-10-29 06:27:12'), ('141', '10011477725122', '9', 'fs', 'sfsfsfg', '1', '0', '1001', null, '2016-10-29 15:12:02', '2016-10-29 15:12:02');
COMMIT;

-- ----------------------------
--  Table structure for `wo_role_classifications`
-- ----------------------------
DROP TABLE IF EXISTS `wo_role_classifications`;
CREATE TABLE `wo_role_classifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `classification_id` int(11) NOT NULL COMMENT '分类ID',
  `deleted` int(11) NOT NULL COMMENT '0.未删除 1.已删除',
  PRIMARY KEY (`id`),
  KEY `base` (`role_id`,`classification_id`,`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_role_classifications`
-- ----------------------------
BEGIN;
INSERT INTO `wo_role_classifications` VALUES ('11', '1', '4', '0'), ('21', '1', '5', '0'), ('12', '1', '6', '0'), ('13', '1', '8', '0'), ('14', '1', '9', '0'), ('15', '1', '10', '0'), ('16', '2', '5', '0'), ('17', '2', '7', '0'), ('18', '2', '8', '0'), ('19', '2', '9', '0'), ('20', '2', '10', '0'), ('1', '3', '1', '0'), ('2', '3', '2', '0'), ('3', '3', '3', '0'), ('5', '3', '5', '0'), ('8', '3', '8', '0'), ('9', '3', '9', '0'), ('10', '3', '10', '0'), ('22', '3', '14', '0'), ('23', '3', '15', '0'), ('24', '3', '16', '0'), ('25', '3', '17', '0'), ('26', '3', '18', '0'), ('27', '3', '19', '0'), ('28', '3', '20', '0'), ('29', '3', '21', '0'), ('30', '3', '22', '0'), ('31', '3', '25', '0'), ('32', '3', '26', '0'), ('66', '3', '27', '0'), ('74', '3', '28', '0'), ('75', '3', '29', '0'), ('33', '5', '4', '0'), ('34', '5', '6', '0'), ('35', '5', '8', '0'), ('36', '5', '10', '0'), ('37', '6', '4', '0'), ('38', '6', '5', '0'), ('39', '6', '6', '0'), ('62', '6', '8', '0'), ('40', '6', '8', '1'), ('50', '6', '8', '1'), ('51', '6', '8', '1'), ('58', '6', '8', '1'), ('49', '6', '9', '1'), ('52', '6', '9', '1'), ('53', '6', '9', '1'), ('59', '6', '9', '1'), ('63', '6', '9', '1'), ('64', '6', '10', '0'), ('54', '6', '10', '1'), ('55', '6', '10', '1'), ('60', '6', '10', '1'), ('56', '6', '14', '1'), ('57', '6', '14', '1'), ('61', '6', '14', '1'), ('65', '6', '14', '1'), ('41', '7', '4', '0'), ('42', '7', '5', '0'), ('43', '7', '6', '0'), ('44', '8', '4', '0'), ('45', '8', '5', '0'), ('46', '8', '6', '0'), ('47', '9', '5', '0'), ('48', '9', '7', '0'), ('73', '9', '8', '1'), ('67', '9', '9', '1'), ('68', '9', '10', '1'), ('69', '9', '14', '0'), ('70', '9', '27', '0'), ('76', '9', '29', '0'), ('71', '10', '5', '0'), ('72', '10', '7', '0');
COMMIT;

-- ----------------------------
--  Table structure for `wo_role_operates`
-- ----------------------------
DROP TABLE IF EXISTS `wo_role_operates`;
CREATE TABLE `wo_role_operates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_type` int(11) NOT NULL COMMENT '角色类型1.发起者2.受理者3.管理员',
  `operate_id` int(11) NOT NULL COMMENT '操作ID',
  PRIMARY KEY (`id`),
  KEY `base` (`role_type`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_role_operates`
-- ----------------------------
BEGIN;
INSERT INTO `wo_role_operates` VALUES ('1', '1', '1'), ('2', '1', '3'), ('3', '1', '5'), ('4', '2', '1'), ('5', '2', '2'), ('6', '2', '4'), ('7', '2', '6'), ('8', '3', '1'), ('9', '3', '5'), ('10', '3', '7'), ('11', '3', '8'), ('12', '3', '9'), ('13', '3', '10'), ('14', '3', '11'), ('15', '3', '12'), ('16', '3', '13'), ('17', '3', '14'), ('18', '3', '15');
COMMIT;

-- ----------------------------
--  Table structure for `wo_roles`
-- ----------------------------
DROP TABLE IF EXISTS `wo_roles`;
CREATE TABLE `wo_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL COMMENT '角色名',
  `role_type` int(11) NOT NULL COMMENT '角色类型',
  `deleted` int(1) NOT NULL COMMENT '0.未删除 1.已删除',
  PRIMARY KEY (`id`),
  KEY `base` (`id`,`role_type`,`deleted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_roles`
-- ----------------------------
BEGIN;
INSERT INTO `wo_roles` VALUES ('1', '发起者', '1', '0'), ('2', '受理者', '2', '0'), ('3', '管理员', '3', '0'), ('5', '小鲜', '1', '1'), ('6', '小鲜', '1', '0'), ('7', '运营', '1', '1'), ('8', '运营', '1', '1'), ('9', '技术部', '2', '0'), ('10', 'ad', '2', '1');
COMMIT;

-- ----------------------------
--  Table structure for `wo_user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `wo_user_roles`;
CREATE TABLE `wo_user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`),
  KEY `base` (`user_id`,`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_user_roles`
-- ----------------------------
BEGIN;
INSERT INTO `wo_user_roles` VALUES ('1', '1000', '3'), ('2', '1001', '1'), ('3', '1002', '2'), ('6', '1007', '1'), ('7', '1008', '1'), ('8', '1009', '3'), ('9', '1010', '1'), ('10', '1011', '1'), ('11', '1013', '5'), ('12', '1014', '6'), ('13', '1015', '9');
COMMIT;

-- ----------------------------
--  Table structure for `wo_users`
-- ----------------------------
DROP TABLE IF EXISTS `wo_users`;
CREATE TABLE `wo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `realname` varchar(100) NOT NULL COMMENT '真实姓名',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱地址',
  `phone_number` varchar(255) DEFAULT NULL COMMENT '手机号',
  `deleted` int(1) NOT NULL COMMENT '是否已删除：1、是 0、不是',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `base` (`id`,`username`,`realname`,`phone_number`,`deleted`,`updated_at`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1016 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `wo_users`
-- ----------------------------
BEGIN;
INSERT INTO `wo_users` VALUES ('1000', 'admin', 'admin', '刘大', '774247851@qq.com', '18611875958', '0', '2016-10-06 15:36:40', '2016-10-06 15:36:40'), ('1001', 'zhangsan', 'zhangsan', '张三', null, null, '0', '2016-10-08 12:01:58', '2016-10-08 12:02:01'), ('1002', 'lisi', 'lisi', '李四', null, null, '0', '2016-10-08 12:02:31', '2016-10-08 12:02:34'), ('1007', 'wangwu', 'wangwu', '王五', '111111111@qq.com', '13111111111', '0', '2016-10-24 09:15:56', '2016-10-24 09:15:56'), ('1008', 'a s d', 'asd ', '阿斯顿', 'sdad', 'asd', '1', '2016-10-24 09:58:53', '2016-10-24 09:58:53'), ('1009', 'wangwu22', 'asdasd22', 'asdasda22', 'asdasd22', '22asdasd', '0', '2016-10-24 11:21:13', '2016-10-24 11:21:13'), ('1010', 'qwer', 'qwer', 'dhshd', 'fgsh', 'trsh', '0', '2016-10-25 07:40:41', '2016-10-25 07:40:41'), ('1011', 'sfsdf', 'sdfsdf', 'dsfsdf', 'sdfsdf', 'dsfsdf', '1', '2016-10-25 09:27:08', '2016-10-25 09:27:08'), ('1012', 'zxc', 'zxc', 'zxc', 'zxc', 'zxc', '0', '2016-10-25 11:02:25', '2016-10-25 11:02:25'), ('1013', 'aa', 'aa', 'aa', 'aa', 'aa', '1', '2016-10-26 13:54:25', '2016-10-26 13:54:25'), ('1014', 'xx', '111111', 'xx', 'xx', 'xx', '0', '2016-10-26 15:58:30', '2016-10-26 15:58:30'), ('1015', 'tech', 'tech', 'tech', 'tech', 'tech', '0', '2016-10-26 15:58:46', '2016-10-26 15:58:46');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
