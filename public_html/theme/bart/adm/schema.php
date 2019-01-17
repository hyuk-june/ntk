<?php exit();?>

--
-- 테이블 구조 `bt_alim`
--

CREATE TABLE IF NOT EXISTS `bt_alim` (
  `al_idx` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(40) NOT NULL,
  `al_url` varchar(255) NOT NULL,
  `al_message` varchar(255) NOT NULL,
  `al_read` tinyint(4) NOT NULL,
  `al_regdate` varchar(20) NOT NULL,
  PRIMARY KEY (`al_idx`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `bt_file_manager`
--

CREATE TABLE IF NOT EXISTS `bt_file_manager` (
  `fm_idx` int(11) NOT NULL AUTO_INCREMENT,
  `fm_name` varchar(255) NOT NULL,
  `fm_rname` varchar(255) NOT NULL,
  `fm_type` varchar(20) NOT NULL,
  `fm_ext` varchar(10) NOT NULL,
  `fm_size` varchar(20) NOT NULL,
  `fm_width` int(11) NOT NULL,
  `fm_height` int(11) NOT NULL,
  `fm_dir` varchar(255) NOT NULL,
  `fm_regdate` varchar(20) NOT NULL,
  PRIMARY KEY (`fm_idx`),
  KEY `fm_dir` (`fm_dir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `bt_frame`
--

CREATE TABLE IF NOT EXISTS `bt_frame` (
  `fs_idx` int(11) NOT NULL AUTO_INCREMENT,
  `fs_skin` varchar(20) NOT NULL,
  `fs_path` varchar(255) NOT NULL,
  `fs_mtype` varchar(20) NOT NULL,
  `fs_mid` varchar(20) NOT NULL,
  `fs_private` tinyint(4) NOT NULL,
  `fs_config` text NOT NULL,
  `fs_regdate` varchar(20) NOT NULL,
  PRIMARY KEY (`fs_idx`),
  UNIQUE KEY `4` (`fs_idx`,`fs_skin`,`fs_path`,`fs_mtype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `bt_menu`
--

CREATE TABLE IF NOT EXISTS `bt_menu` (
  `bm_idx` int(11) NOT NULL AUTO_INCREMENT,
  `bm_pidx` int(11) NOT NULL,
  `bm_name` varchar(255) NOT NULL,
  `bm_subtitle` varchar(255) NOT NULL,
  `bm_type` varchar(10) NOT NULL,
  `bm_target` varchar(10) NOT NULL,
  `bm_step` int(11) NOT NULL,
  `bm_depth` int(11) NOT NULL,
  `bm_perm` int(11) NOT NULL,
  `bm_skin_frame` varchar(40) NOT NULL,
  `bm_skin_layout` varchar(40) NOT NULL,
  `bm_icon` varchar(40) NOT NULL,
  `bm_mid` varchar(20) NOT NULL COMMENT '게시판아이디 또는 페이지아이디',
  `bm_device` varchar(10) NOT NULL,
  `bm_url` varchar(255) DEFAULT NULL,
  `bm_regdate` varchar(20) NOT NULL,
  PRIMARY KEY (`bm_idx`),
  KEY `bm_mid` (`bm_mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `bt_page`
--

CREATE TABLE IF NOT EXISTS `bt_page` (
  `pg_id` varchar(20) NOT NULL COMMENT '페이지아이디(기본키)',
  `pg_type` varchar(20) NOT NULL COMMENT 'page,wpage,mpage',
  `pg_system` tinyint(4) NOT NULL COMMENT '시스템용인지(모듈페이지전용)',
  `pg_module` varchar(40) NOT NULL COMMENT '모듈디렉토리명',
  `pg_title` varchar(255) NOT NULL COMMENT '페이지제목',
  `pg_subtitle` varchar(255) NOT NULL COMMENT '부제목',
  `pg_keyword` varchar(255) NOT NULL COMMENT '키워드',
  `pg_desc` varchar(255) NOT NULL COMMENT '페이지설명',
  `pg_skin_frame` varchar(40) NOT NULL COMMENT '프레임',
  `pg_skin_layout` varchar(40) NOT NULL COMMENT '레이아웃',
  `pg_skin_wpage` varchar(40) NOT NULL COMMENT '위젯스킨(위젯페이지전용)',
  `pg_content` text NOT NULL COMMENT '페이지내용(page전용)',
  `pg_config` text NOT NULL COMMENT '설정',
  `pg_level_min` int(11) NOT NULL COMMENT '최소접근권한',
  `pg_level_max` int(11) NOT NULL COMMENT '최대접근권한',
  `pg_regdate` varchar(20) NOT NULL COMMENT '등록일자',
  PRIMARY KEY (`pg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `bt_widget`
--

CREATE TABLE IF NOT EXISTS `bt_widget` (
  `wg_idx` int(11) NOT NULL AUTO_INCREMENT,
  `wg_skindir` varchar(100) NOT NULL,
  `wp_id` varchar(40) NOT NULL,
  `wg_id` varchar(40) NOT NULL,
  `wg_name` varchar(255) NOT NULL,
  `wg_step` int(11) NOT NULL,
  `wg_data` text NOT NULL,
  `wg_margin` varchar(40) NOT NULL,
  `wg_padding` varchar(40) NOT NULL,
  `wg_class` varchar(255) NOT NULL,
  `wg_style` text NOT NULL,
  `wg_eid` varchar(255) NOT NULL,
  `wg_attr` varchar(255) NOT NULL,
  `wg_cache_min` int(11) NOT NULL,
  `wg_cache` text NOT NULL,
  `wg_cache_date` varchar(20) NOT NULL,
  `wg_isset` tinyint(4) NOT NULL,
  PRIMARY KEY (`wg_idx`),
  KEY `wg_group` (`wg_skindir`,`wp_id`,`wg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;