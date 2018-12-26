<?php exit()?>

--
-- 테이블의 덤프 데이터 `bt_frame`
--

INSERT INTO `bt_frame` (`fs_idx`, `fs_skin`, `fs_path`, `fs_mtype`, `fs_mid`, `fs_private`, `fs_config`, `fs_regdate`) VALUES
(1, 'basic', '', '', '', 0, '{"margin_top":"10","margin_bot":"","wing_top":"","wing_scroll_top":"","footer_bg":"","footer_color":"fff","mheader_bg":"333","mheader_color":"fff"}', '2018-12-26 10:43:26'),
(2, 'basic', '', '', '', 1, '{"fs_private":"1","margin_top":"0","margin_bot":"","hide_wing":"1","wing_top":"","wing_scroll_top":"","footer_bg":"","footer_color":"fff","mheader_bg":"000","mheader_color":"fff"}', '2018-12-26 10:36:20'),
(4, 'basic', 'index.php', 'page', 'page', 1, '{"fs_private":"1","margin_top":"0","margin_bot":"","wing_top":"103","wing_scroll_top":"10","footer_bg":"","footer_color":"fff","mheader_bg":"333","mheader_color":"fff"}', '2018-12-26 10:44:17'),
(5, 'basic', 'index.php', 'wpage', 'wpage', 1, '{"fs_private":"1","margin_top":"0","margin_bot":"","wing_top":"103","wing_scroll_top":"10","footer_bg":"","footer_color":"fff","mheader_bg":"333","mheader_color":"fff"}', '2018-12-26 10:44:25'),
(6, 'basic', 'index.php', 'mpage', 'mpage', 1, '{"fs_private":"1","margin_top":"0","margin_bot":"","wing_top":"103","wing_scroll_top":"10","footer_bg":"","footer_color":"fff","mheader_bg":"333","mheader_color":"fff"}', '2018-12-26 10:44:32');

=====123456789=====

--
-- 테이블의 덤프 데이터 `bt_menu`
--

INSERT INTO `bt_menu` (`bm_idx`, `bm_pidx`, `bm_name`, `bm_subtitle`, `bm_type`, `bm_target`, `bm_step`, `bm_depth`, `bm_perm`, `bm_skin_frame`, `bm_skin_layout`, `bm_icon`, `bm_mid`, `bm_device`, `bm_url`, `bm_regdate`) VALUES
(1, 0, '', '', 'page', '_self', 1, 0, 0, 'basic', 'full', 'sticky-note-o', 'page', 'both', '', '2018-12-26 07:15:22'),
(2, 0, '', '', 'wpage', '_self', 2, 0, 0, 'basic', 'full', 'star-o', 'wpage', 'both', '', '2018-12-26 07:15:29'),
(3, 0, '', '', 'mpage', '_self', 3, 0, 0, 'basic', 'full', 'hdd-o', 'mpage', 'both', '', '2018-12-26 07:15:38'),
(4, 0, '', '', 'wpage', '_self', 4, 0, 0, 'basic', 'full', 'building-o', 'intro', 'both', '', '2018-12-26 07:15:58'),
(5, 0, '', '', 'wpage', '_self', 5, 0, 0, 'basic', 'full', 'comment-o', 'cmn', 'both', '', '2018-12-26 07:16:06'),
(6, 5, '공지사항', 'Notice', 'board', '_self', 1, 1, 0, 'basic', 'rside', '', 'notice', 'both', '', '2018-12-26 07:16:26'),
(7, 5, '자유게시판', 'Free Talk BBS', 'board', '_self', 2, 1, 0, 'basic', 'rside', '', 'free', 'both', '', '2018-12-26 07:16:44'),
(8, 5, '갤러리', 'Gallery', 'board', '_self', 3, 1, 0, 'basic', 'rside', '', 'gallery', 'both', '', '2018-12-26 07:17:01'),
(9, 0, '', '', 'wpage', '_self', 6, 0, 0, 'basic', 'full', 'user-o', 'mypage', 'both', '', '2018-12-26 07:17:12'),
(10, 9, '', '', 'mpage', '_self', 1, 1, 0, 'basic', 'full', '', 'alim', 'both', '', '2018-12-26 07:17:20');

=====123456789=====

--
-- 테이블의 덤프 데이터 `bt_page`
--

INSERT INTO `bt_page` (`pg_id`, `pg_type`, `pg_system`, `pg_module`, `pg_title`, `pg_subtitle`, `pg_keyword`, `pg_desc`, `pg_skin_frame`, `pg_skin_layout`, `pg_skin_wpage`, `pg_content`, `pg_config`, `pg_level_min`, `pg_level_max`, `pg_regdate`) VALUES
('agree', 'page', 0, '', '사이트 이용약관', '사이트 이용약관입니다', '', '', 'basic', 'basic', '', '<p><b>사이트 이용약관</b></p><p><br></p><p>이용약관입니다.....</p><p>빌더메뉴 -&gt; 페이지관리에서 수정해주세요</p>', '', 1, 10, '2018-12-26 07:10:16'),
('alim', 'mpage', 0, 'alim', '알림페이지', 'Message', '', '', 'basic', 'rside', '', '', '[]', 1, 10, '2018-12-26 07:14:35'),
('cmn', 'wpage', 0, '', '커뮤니티', '커뮤니티입니다', '', '', 'basic', 'rside', '', '', '[{"rowid":"g4gni5","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]},{"rowid":"9fwdfr","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"6","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}},{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"6","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]}]', 1, 10, '2018-12-26 07:12:48'),
('email', 'page', 0, '', '이메일수집거부', '이메일수집거부입니다', '', '', 'basic', 'basic', '', '<p><b>이메일수집거부</b></p><p><br></p><p>이메일 수집거부입니다.....</p><p>빌더메뉴 -&gt; 페이지관리에서 수정해주세요</p>', '', 1, 10, '2018-12-26 07:11:10'),
('intro', 'wpage', 0, '', '회사소개', 'Company Introduction', '', '', 'basic', 'rside', '', '', '[{"rowid":"ybie2g","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]},{"rowid":"nzxbbf","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]}]', 1, 10, '2018-12-26 07:13:36'),
('main', 'wpage', 0, '', '메인페이지', '', '', '', 'basic', 'visual', '', '', '[{"rowid":"cy002e","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]},{"rowid":"doq3vg","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"6","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}},{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"6","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]}]', 1, 10, '2018-12-25 22:35:40'),
('mpage', 'mpage', 0, 'moddesc', '모듈페이지란', '모듈페이지의 개념을 설명합니다', '', '', 'basic', 'visual', '', '', '[]', 1, 10, '2018-12-26 07:14:56'),
('mypage', 'wpage', 0, '', '마이페이지', 'My Page', '', '', 'basic', 'rside', '', '', '[{"rowid":"fgm8b8","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]},{"rowid":"t6j8o3","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"6","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}},{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"6","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]}]', 1, 10, '2018-12-26 07:14:06'),
('page', 'page', 0, '', '페이지란', '페이지의 개념설명입니다', '', '', 'basic', 'visual', '', '<p><span style="font-size: 18pt;">페이지 설명</span></p><p>페이지는 그누보드5의 내용관리와 비슷한 개념입니다<br></p><p>빌더메뉴의 페이지관리에서 생성이 가능합니다.</p><p><br></p><p>[<a href="http://kbay.co.kr/guide/page.php" target="_blank" title="kbay ntk빌더 페이지 도움말">페이지 도움말</a>]</p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p>', '', 1, 10, '2018-12-26 07:09:48'),
('private', 'page', 0, '', '개인정보취급방침', '개인정보취급방침입니다', '', '', 'basic', 'basic', '', '<p><b>개인정보취급방침입니다</b></p><p><br></p><p>개인정보취급방침입니다...</p><p>빌더메뉴 -&gt; 페이지관리에서 수정해주세요</p>', '', 1, 10, '2018-12-26 07:10:47'),
('wpage', 'wpage', 0, '', '위젯페이지란', '위젯페이지의 개념을 설명합니다', '', '', 'basic', 'visual', '', '', '[{"rowid":"u2frpk","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]},{"rowid":"xsyrge","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]},{"rowid":"5xcl2t","cols":[{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"4","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}},{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"4","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}},{"xs":{"value":"12","hide":null},"sm":{"value":"","hide":null},"md":{"value":"4","hide":null},"lg":{"value":"","hide":null},"xl":{"value":"","hide":null}}]}]', 1, 10, '2018-12-26 07:12:04');

=====123456789=====

--
-- 테이블의 덤프 데이터 `bt_widget`
--

INSERT INTO `bt_widget` (`wg_idx`, `wg_skindir`, `wp_id`, `wg_id`, `wg_name`, `wg_step`, `wg_data`, `wg_margin`, `wg_padding`, `wg_class`, `wg_attr`, `wg_cache`, `wg_cache_date`, `wg_isset`) VALUES
(2, 'skin^layout^visual', 'main', 'visual', 'basic_bxslider', 1, '{"wg_step":"1","css":"","vbg":[".\\/theme\\/bart\\/img\\/demo_bx_01.jpg",".\\/theme\\/bart\\/img\\/demo_bx_02.jpg",".\\/theme\\/bart\\/img\\/demo_bx_03.jpg"],"vheight":{"lg":"","md":"400","sm":"","xs":"200"}}', '0|0|20|0', '0|0|0|0', '', '', '', '', 1),
(3, 'widget^basic_bxslider', '', 'visual_inner2', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<div class=\\\\\\"text-center\\\\\\">\\r\\n<img src=\\\\\\".\\/theme\\/bart\\/img\\/demo_bx_text.png\\\\\\" class=\\\\\\"img-fluid\\\\\\">\\r\\n<\\/div>"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(4, 'widget^basic_bxslider', '', 'visual_inner1', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<div class=\\\\\\"text-center\\\\\\">\\r\\n<img src=\\\\\\".\\/theme\\/bart\\/img\\/demo_bx_text.png\\\\\\" class=\\\\\\"img-fluid\\\\\\">\\r\\n<\\/div>"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(5, 'widget^basic_bxslider', '', 'visual_inner3', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<div class=\\\\\\"text-center\\\\\\">\\r\\n<img src=\\\\\\".\\/theme\\/bart\\/img\\/demo_bx_text.png\\\\\\" class=\\\\\\"img-fluid\\\\\\">\\r\\n<\\/div>"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(6, 'wpage', 'main', 'sid_doq3vg_1', 'basic_latest', 1, '{"wg_step":"1","bo_table":"notice","skin":"theme\\/basic","rowcnt":"5","subject_len":"30","show_date":"1","options":"","cache_min":""}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(7, 'wpage', 'main', 'sid_doq3vg_2', 'basic_latest', 1, '{"wg_step":"1","bo_table":"free","skin":"theme\\/basic","rowcnt":"5","subject_len":"30","show_date":"1","options":"","cache_min":""}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(8, 'skin^frame^basic', '', 'main_menu', 'basic_main_menu', 1, '{"wg_step":"1","type":"both","bgcolor":"","bgcolor_n":"","color_n":"","bgcolor_o":"","color_o":"","bgcolor_c":"","color_c":"","s_bgcolor":"","s_bgcolor_n":"","s_color_n":"","s_bgcolor_o":"","s_color_o":"","s_bgcolor_c":"","s_color_c":"","border_color":"ddd","split":"1"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(9, 'skin^frame^basic', '', 'logo', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<a href=\\\\\\"\\/\\\\\\"><img src=\\\\\\"\\/theme\\/bart\\/img\\/logo.png\\\\\\" alt=\\\\\\"\\ub85c\\uace0.png\\\\\\" class=\\\\\\"img-fluid\\\\\\"><\\/a>"}', '20|0|20|0', '0|0|0|0', '', '', '', '', 1),
(10, 'skin^frame^basic', '', 'header_right', 'basic_gsearch', 1, '{"wg_step":"1","pop_cnt":"","pre_word":"","date_cnt":""}', '50|0|0|0', '0|0|0|0', '', '', '', '', 1),
(11, 'skin^frame^basic', '', 'tail1', 'basic_linktab', 1, '{"wg_step":"1","css":"","ele_id":"bot_link","url":["\\/index.php?mtype=page&mid=agree","\\/index.php?mtype=page&mid=private","\\/index.php?mtype=page&mid=email","\\/index.php?mtype=page&mid=guide"],"text":["\\uc774\\uc6a9\\uc57d\\uad00","\\uac1c\\uc778\\uc815\\ubcf4\\ucde8\\uae09\\ubc29\\uce68","\\uc774\\uba54\\uc77c\\uc218\\uc9d1\\uac70\\ubd80","\\uc774\\uc6a9\\ubc29\\ubc95"],"line_color":"777","text_color":"fff","flex_align":"between","text_align":"center"}', '10|0|0|0', '0|0|0|0', '', '', '', '', 1),
(12, 'skin^frame^basic', '', 'tail5', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<div class=\\\\\\"text-center\\\\\\">copyright \\u24d2 kbay.co.kr<\\/div>"}', '0|0|20|0', '0|0|0|0', '', '', '', '', 1),
(13, 'skin^frame^basic', '', 'wing_lside', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<img src=\\\\\\"\\/theme\\/bart\\/img\\/demo_wing_left.jpg\\\\\\" class=\\\\\\"img-fluid\\\\\\">"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(14, 'skin^frame^basic', '', 'wing_rside', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<img src=\\\\\\"\\/theme\\/bart\\/img\\/demo_wing_right.jpg\\\\\\" class=\\\\\\"img-fluid\\\\\\">"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(15, 'skin^layout^visual', '', 'visual', 'basic_html', 1, '{"wg_step":"1","css":".visual{\\r\\n    background-image: url(\\\\\'.\\/theme\\/bart\\/img\\/demo_top_page.jpg\\\\\');\\r\\n    background-position: center;\\r\\n    background-size: cover;\\r\\n}","html":"<div class=\\\\\\"visual\\\\\\">\\r\\n    <div class=\\\\\\"container text-center py-3\\\\\\">\\r\\n        <img src=\\\\\\".\\/theme\\/bart\\/img\\/demo_top_text.png\\\\\\" class=\\\\\\"img-fluid\\\\\\">\\r\\n    <\\/div>\\r\\n<\\/div>"}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(16, 'skin^layout^visual', 'wpage', 'visual', 'basic_html', 1, '{"wg_step":"1","css":".visual{\\r\\n    background-image: url(\\\\\'.\\/theme\\/bart\\/img\\/demo_top_page.jpg\\\\\');\\r\\n    background-position: center;\\r\\n    background-size: cover;\\r\\n}","html":"<div class=\\\\\\"visual\\\\\\">\\r\\n    <div class=\\\\\\"container text-center py-3\\\\\\">\\r\\n        <img src=\\\\\\".\\/theme\\/bart\\/img\\/demo_top_text.png\\\\\\" class=\\\\\\"img-fluid\\\\\\">\\r\\n    <\\/div>\\r\\n<\\/div>"}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(17, 'wpage', 'intro', 'sid_ybie2g_1', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<h4>\\uc774 \\ud398\\uc774\\uc9c0\\ub3c4 \\uc704\\uc82f\\ud398\\uc774\\uc9c0\\uc785\\ub2c8\\ub2e4<\\/h4>\\r\\n\\uc544\\ub798 \\uc704\\uc82f\\uc740 basic_cp_history (\\ud68c\\uc0ac\\uc5f0\\ud601 ) \\uc704\\uc82f\\uc785\\ub2c8\\ub2e4"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(18, 'wpage', 'intro', 'sid_nzxbbf_1', 'basic_cp_history', 1, '{"wg_step":"1","css":"","ele_id":"history","year":["2016","2016","2017","2018"],"month":["1","5","12","12"],"memo":["\\uc124\\ub0a0 \\uc0c8\\ubc30\\uc6a9\\ub3c8\\uc73c\\ub85c \\ud68c\\uc0ac\\ub97c \\uc124\\ub9bd\\ud569\\ub2c8\\ub2e4","\\uc5b4\\ub9b0\\uc774\\ub0a0\\uc744 \\ub9de\\uc774\\ud558\\uc5ec \\uc9c1\\uc6d0\\ub4e4\\uacfc \\ud68c\\uc2dd\\uc744 \\ud569\\ub2c8\\ub2e4","\\uc194\\ub85c\\ub77c \\ud06c\\ub9ac\\uc2a4\\ub9c8\\ub9c8\\uc2a4 \\uc774\\ube0c\\uc5d0 \\ud63c\\uc790 \\uc788\\uae30 \\uc2eb\\uc5b4\\uc11c \\uac15\\uc81c \\uc57c\\uadfc\\uc2dc\\ud0b5\\ub2c8\\ub2e4","NTK \\ube4c\\ub354 \\ucd9c\\uc2dc\\ud569\\ub2c8\\ub2e4"]}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(19, 'wpage', 'intro', 'sid_nzxbbf_1', 'basic_html', 2, '{"wg_step":"2","css":"","html":"\\uc544\\ub798\\uc704\\uc82f\\uc740 \\ub2e4\\uc74c\\uc9c0\\ub3c4\\uc704\\uc82f\\uc785\\ub2c8\\ub2e4. \\uad00\\ub9ac\\uc790 \\ub85c\\uadf8\\uc778 \\ud6c4 \\uc544\\ub798 \\uc704\\uc82f\\uc5d0 api key \\ub97c \\ub123\\uc5b4\\ubcf4\\uc138\\uc694"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(20, 'wpage', 'intro', 'sid_nzxbbf_1', 'basic_daum_map', 3, '{"wg_step":"3","ele_id":"cp_map","daum_map_apikey":"1111","address":"\\ubd80\\uc0b0\\uc2dc \\ub0a8\\uad6c \\uc6a9\\ud638\\ub3d9 232\\ubc88\\uae38 31","label":"\\ubd04\\ube44 Bombi"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(21, 'skin^layout^rside', '', 'side', 'basic_outlogin', 1, '{"wg_step":"1","skin":"theme\\/basic","alim_mid":"alim","mypage_mid":"mypage"}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(22, 'skin^layout^rside', '', 'side', 'basic_sidemenu', 2, '{"wg_step":"2","h_bg":"","h_color":""}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(23, 'skin^layout^rside', '', 'side', 'basic_new', 3, '{"wg_step":"3","rowcnt":"5","subject_len":"30","show_date":"1","cache_min":""}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(24, 'skin^layout^rside', '', 'side', 'basic_new_reply', 4, '', '', '', '', '', '', '', 0),
(25, 'wpage', 'cmn', 'sid_g4gni5_1', 'basic_latest_gallery', 1, '{"wg_step":"1","bo_table":"free","rowcnt":"","numpr":{"lg":"","md":"","sm":"","xs":""},"ma_w":{"lg":"","md":"","sm":"","xs":""},"ma_h":{"lg":"","md":"","sm":"","xs":""},"thumb_w":"","thumb_h":"","show_date":"1","cache_min":""}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(26, 'wpage', 'cmn', 'sid_9fwdfr_1', 'basic_latest', 1, '{"wg_step":"1","bo_table":"notice","skin":"theme\\/basic","rowcnt":"5","subject_len":"30","show_date":"1","options":"","cache_min":""}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(27, 'wpage', 'cmn', 'sid_9fwdfr_2', 'basic_latest', 1, '{"wg_step":"1","bo_table":"free","skin":"theme\\/basic","rowcnt":"5","subject_len":"30","show_date":"1","options":"","cache_min":""}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(28, 'wpage', 'mypage', 'sid_fgm8b8_1', 'basic_alim', 1, '{"wg_step":"1","mid":"alim"}', '0|0|10|0', '0|0|0|0', '', '', '', '', 1),
(29, 'wpage', 'mypage', 'sid_t6j8o3_1', 'basic_new', 1, '', '', '', '', '', '', '', 0),
(30, 'wpage', 'mypage', 'sid_t6j8o3_2', 'basic_new_reply', 1, '', '', '', '', '', '', '', 0),
(31, 'wpage', 'wpage', 'sid_u2frpk_1', 'basic_html', 1, '{"wg_step":"1","css":"@media(max-width:576px){\\r\\n    .widget-help ol{padding-left: 10px;}\\r\\n}","html":"<div class=\\\\\\"card widget-help\\\\\\">\\r\\n    <div class=\\\\\\"card-body\\\\\\">\\r\\n        <h4 class=\\\\\\"card-title\\\\\\">\\uc704\\uc82f\\ud398\\uc774\\uc9c0\\ub780?<\\/h4>\\r\\n        <div class=\\\\\\"card-text\\\\\\">\\r\\n\\t\\t<ol>\\r\\n\\t\\t\\t<li>\\uc704\\uc82f\\ud398\\uc774\\uc9c0\\ub780 \\ub2e4\\uc74c\\uadf8\\ub9bc\\uacfc \\uac19\\uc774 \\ucd5c\\uc2e0\\uae00, \\uc678\\ubd80\\ub85c\\uadf8\\uc778 \\ub4f1\\uc758 \\uc704\\uc82f\\uc744 \\ub9c8\\uc6b0\\uc2a4 \\ud074\\ub9ad\\uc73c\\ub85c \\uc0bd\\uc785\\uac00\\ub2a5\\ud55c \\ud398\\uc774\\uc9c0\\ub97c \\ub9d0\\ud569\\ub2c8\\ub2e4<\\/li>\\r\\n\\t\\t\\t<li>\\uc704\\uc82f\\ud398\\uc774\\uc9c0\\ub294 \\ube4c\\ub354\\uba54\\ub274 -> \\uc704\\uc82f\\ud398\\uc774\\uc9c0\\ub85c \\uc0dd\\uc131\\ud560 \\uc218 \\uc788\\uc73c\\uba70 \\ud398\\uc774\\uc9c0\\ub808\\uc774\\uc544\\uc6c3\\uc744 \\uc790\\uc720\\ub86d\\uac8c \\ubcc0\\uacbd\\ud560 \\uc218 \\uc788\\uc2b5\\ub2c8\\ub2e4<\\/li>\\r\\n\\t\\t\\t<li>\\uc544\\ub798 \\uc678\\ubd80\\ub85c\\uadf8\\uc778\\uacfc \\ubc29\\ubb38\\uc790\\uc9d1\\uacc4\\ub294 \\uc774\\ub7ec\\ud55c \\uae30\\ub2a5\\uc73c\\ub85c \\ub4f1\\ub85d\\ud574\\ubcf8 \\uc0d8\\ud50c\\uc785\\ub2c8\\ub2e4.<\\/li>\\r\\n\\t\\t\\t<li>\\uad00\\ub9ac\\uc790 \\ub85c\\uadf8\\uc778 \\ud6c4 \\uc6b0\\uce21 \\ud558\\ub2e8\\uc758 <i class=\\\\\\"fa fa-cog\\\\\\"><\\/i> \\uc544\\uc774\\ucf58\\uc744 \\ud074\\ub9ad\\ud558\\uc5ec \\ub4f1\\ub85d\\ud574 \\ubcf4\\uc138\\uc694<\\/li>\\r\\n\\t\\t\\t<li>\\uc704\\uc82f\\ud398\\uc774\\uc9c0 \\ub9cc\\ub4e4\\uae30\\ub294 \\uc544\\uc8fc \\uac04\\ub2e8\\ud558\\uace0 \\uc27d\\uc2b5\\ub2c8\\ub2e4.  <a href=\\\\\\"\\/\\/kbay.co.kr\\\\\\" target=\\\\\\"_blank\\\\\\">kbay.co.kr<\\/a>\\uc758 \\uba54\\ub274\\uc5bc\\uc744 \\ud655\\uc778\\ud574 \\uc8fc\\uc138\\uc694<\\/li>\\r\\n\\t\\t<\\/ol>\\r\\n                <br>\\r\\n                [<a href=\\\\\\"http:\\/\\/kbay.co.kr\\/guide\\/wpage.php\\\\\\" target=\\\\\\"_blank\\\\\\" title=\\\\\\"kbay ntk\\ube4c\\ub354 \\uc704\\uc82f\\ud398\\uc774\\uc9c0 \\ub3c4\\uc6c0\\ub9d0\\\\\\">\\uc704\\uc82f\\ud398\\uc774\\uc9c0 \\ub3c4\\uc6c0\\ub9d0<\\/a>]\\r\\n        <\\/div>\\r\\n    <\\/div>\\r\\n<\\/div>"}', '0|0|30|0', '0|0|0|0', '', '', '', '', 1),
(32, 'wpage', 'wpage', 'sid_xsyrge_1', 'basic_html', 1, '{"wg_step":"1","css":"","html":"<img src=\\\\\\"\\/theme\\/bart\\/adm\\/img\\/guide_1.gif\\\\\\" class=\\\\\\"img-fluid\\\\\\">"}', '0|0|30|0', '0|0|0|0', '', '', '', '', 1),
(33, 'wpage', 'wpage', 'sid_5xcl2t_1', 'basic_outlogin', 1, '{"wg_step":"1","skin":"basic","alim_mid":"","mypage_mid":""}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(34, 'wpage', 'wpage', 'sid_5xcl2t_2', 'basic_visit', 1, '', '', '', '', '', '', '', 0),
(35, 'wpage', 'wpage', 'sid_5xcl2t_3', 'basic_iframe', 1, '{"wg_step":"1","height":"150","src":"\\/\\/kbay.co.kr"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(36, 'wpage', 'wpage', 'sid_5xcl2t_1', 'basic_html', 2, '{"wg_step":"2","css":"","html":"\\uc608) \\uc678\\ubd80\\ub85c\\uadf8\\uc778 \\uc704\\uc82f"}', '0|0|20|0', '0|0|0|0', '', '', '', '', 1),
(37, 'wpage', 'wpage', 'sid_5xcl2t_2', 'basic_html', 2, '{"wg_step":"2","css":"","html":"\\uc608) \\uc811\\uc18d\\uc790\\uc9d1\\uacc4 \\uc704\\uc82f"}', '0|0|20|0', '0|0|0|0', '', '', '', '', 1),
(38, 'wpage', 'wpage', 'sid_5xcl2t_3', 'basic_html', 2, '{"wg_step":"2","css":"","html":"\\uc608) IFRAME \\uc704\\uc82f \\uc608"}', '0|0|0|0', '0|0|0|0', '', '', '', '', 1),
(39, 'skin^frame^basic', '', 'logo-m', 'basic_html', 1, '{"wg_step":"1","css":".mb-logo{max-width:80px}","html":"<a href=\\\\\\"\\/\\\\\\"><img src=\\\\\\"\\/theme\\/bart\\/img\\/logo_mobile.png\\\\\\" alt=\\\\\\"\\ub85c\\uace0.png\\\\\\" class=\\\\\\"mb-logo img-fluid\\\\\\"><\\/a>"}', '15|0|10|0', '0|0|0|0', '', '', '', '', 1),
(40, 'skin^frame^basic', '', 'slide_2', 'basic_outlogin', 1, '{"wg_step":"1","skin":"theme\\/basic","alim_mid":"alim","mypage_mid":"mypage"}', '5|5|10|5', '0|0|0|0', '', '', '', '', 1);

=====123456789=====

--
-- 테이블의 덤프 데이터 `g5_board`
--

INSERT INTO `g5_board` (`bo_table`, `gr_id`, `bo_subject`, `bo_mobile_subject`, `bo_device`, `bo_admin`, `bo_list_level`, `bo_read_level`, `bo_write_level`, `bo_reply_level`, `bo_comment_level`, `bo_upload_level`, `bo_download_level`, `bo_html_level`, `bo_link_level`, `bo_count_delete`, `bo_count_modify`, `bo_read_point`, `bo_write_point`, `bo_comment_point`, `bo_download_point`, `bo_use_category`, `bo_category_list`, `bo_use_sideview`, `bo_use_file_content`, `bo_use_secret`, `bo_use_dhtml_editor`, `bo_use_rss_view`, `bo_use_good`, `bo_use_nogood`, `bo_use_name`, `bo_use_signature`, `bo_use_ip_view`, `bo_use_list_view`, `bo_use_list_file`, `bo_use_list_content`, `bo_table_width`, `bo_subject_len`, `bo_mobile_subject_len`, `bo_page_rows`, `bo_mobile_page_rows`, `bo_new`, `bo_hot`, `bo_image_width`, `bo_skin`, `bo_mobile_skin`, `bo_include_head`, `bo_include_tail`, `bo_content_head`, `bo_mobile_content_head`, `bo_content_tail`, `bo_mobile_content_tail`, `bo_insert_content`, `bo_gallery_cols`, `bo_gallery_width`, `bo_gallery_height`, `bo_mobile_gallery_width`, `bo_mobile_gallery_height`, `bo_upload_size`, `bo_reply_order`, `bo_use_search`, `bo_order`, `bo_count_write`, `bo_count_comment`, `bo_write_min`, `bo_write_max`, `bo_comment_min`, `bo_comment_max`, `bo_notice`, `bo_upload_count`, `bo_use_email`, `bo_use_cert`, `bo_use_sns`, `bo_use_captcha`, `bo_sort_field`, `bo_1_subj`, `bo_2_subj`, `bo_3_subj`, `bo_4_subj`, `bo_5_subj`, `bo_6_subj`, `bo_7_subj`, `bo_8_subj`, `bo_9_subj`, `bo_10_subj`, `bo_1`, `bo_2`, `bo_3`, `bo_4`, `bo_5`, `bo_6`, `bo_7`, `bo_8`, `bo_9`, `bo_10`) VALUES
('notice', 'community', '공지사항', '', 'both', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, 5, 1, -20, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 15, 15, 24, 100, 835, 'theme/basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 1048576, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('qa', 'community', '질문답변', '', 'both', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, 5, 1, -20, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 15, 15, 24, 100, 835, 'theme/basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 1048576, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('free', 'community', '자유게시판', '', 'both', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, 5, 1, -20, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 15, 15, 24, 100, 835, 'theme/basic', 'basic', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 1048576, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('gallery', 'community', '갤러리', '', 'both', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, 5, 1, -20, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 60, 30, 15, 15, 24, 100, 835, 'theme/basic', 'gallery', '_head.php', '_tail.php', '', '', '', '', '', 4, 202, 150, 125, 100, 1048576, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 2, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `g5_write_free`
--

CREATE TABLE IF NOT EXISTS `g5_write_free` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ;

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `g5_write_gallery`
--

CREATE TABLE IF NOT EXISTS `g5_write_gallery` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ;

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `g5_write_notice`
--

CREATE TABLE IF NOT EXISTS `g5_write_notice` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ;

=====123456789=====

-- --------------------------------------------------------

--
-- 테이블 구조 `g5_write_qa`
--

CREATE TABLE IF NOT EXISTS `g5_write_qa` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ;
