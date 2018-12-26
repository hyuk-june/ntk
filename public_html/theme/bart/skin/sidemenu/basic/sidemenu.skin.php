<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<link rel="stylesheet" type="text/css" href="<?php echo BT_SKIN_URL?>/sidemenu/basic/css/style.css" />
<div id="sidemenu">
	<nav>
	<?php if($bm_pidx){?>
	    <h2><?php echo $bt['curpath'][0]['bm_name']?></h2>
	<?php }else{?>
		<h2><?php echo $config['cf_title']?></h2>
	<?php }?>
	    <ul>
			<?php echo Menu::getInstance()->printMenu($list, $bt['curmenu']['bm_idx']);?>
	    </ul>
	</nav>
</div>