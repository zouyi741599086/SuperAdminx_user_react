
CREATE TABLE `sa_user_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型，1》菜单目录，2》菜单，3》外部链接菜单，4》iframe菜单，5》内页菜单权限，6》按钮操作权限',
  `icon` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '链接图标代码',
  `path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '访问路劲',
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '路由的name值',
  `pid_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '上级的name',
  `pid_name_path` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '上级的name的路劲',
  `component_path` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '组件的路劲',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '外部链接的时候的url',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `hidden` tinyint(4) DEFAULT '1' COMMENT '是否显示，1为显示，2为隐藏',
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述，用于菜单功能搜索',
  `is_params` tinyint(1) DEFAULT '1' COMMENT '访问此url是否有参数，1》无，2》有，用于菜单功能搜索的时候有参数的不能直接访问需要找上级的url',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户端权限节点';

INSERT INTO `sa_user_menu` VALUES ('1', '测试菜单', '2', 'icon-weibiaoti1', '/test', 'test', null, ',test,', '/test', null, '0', '1', null, '1', '2024-12-07 20:00:25', '2024-12-07 20:00:35');
