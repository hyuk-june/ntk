<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

$keywords = bt\binstr($cur_keyword, $g5_head_title);

$keywords = preg_replace('~\[[^\]]+\]~i', '', $keywords);
$keywords = preg_replace('~[^가-힣a-z0-9\s]~is', '', $keywords);
$keywords = trim(str_replace('.', '', $keywords));
//preg_match('~[^a-z]+~is', $keywords, $m);

$keywords = $keywords;// trim($m[0]);
$keywords = str_replace("-", "", $keywords);
$keywords = explode(" ", $keywords);
$keywords = array_filter(array_map('trim', $keywords));
$keywords = implode(",", $keywords);
if($cur_title) $keywords .= ','.$cur_title;

$desc = bt\binstr($cur_desc, $keywords);
$protocol = strtolower( substr($_SERVER["SERVER_PROTOCOL"], 0, strpos($_SERVER["SERVER_PROTOCOL"], '/')) );
if(strtolower( bt\varset($_SERVER["HTTPS"]) )=='on') $protocol = 'https';

$site_name = $config['cf_title'];
$site_url = $protocol.'://'.$_SERVER["HTTP_HOST"];
$sns_logo = $site_url.'/theme/bart/img/sns_logo.png';
$favicon = $site_url.'/theme/bart/img/favicon.ico';
?>
<!-- Default -->
<meta name="keywords" content="<?php echo $keywords?>" />
<meta name="author" content="<?php echo $site_name?>" />
<meta name="robots" content="index, follow" />
<meta name="description" content="<?php echo $desc?>" />
<?php if($cur_title){?>
<meta name="classification" content="<?php echo $cur_title?>">
<?php }?>
<link rel="canonical" href="<?php echo $site_url?>" />
<link rel="alternate" href="<?php echo $site_url?>" />
<link rel="shortcut icon" href="<?php echo $favicon?>" />
<link rel="apple-touch-icon" href="<?php echo $sns_logo?>" />
<link rel="image_src" href="<?php echo $sns_logo?>" />
<!-- //Default -->

<!-- facebook-->
<meta property="fb:app_id" content="<?php echo $config['cf_title']?>" />
<meta property="og:locale" content="ko_KR" />
<meta property="og:type" content="article" />
<meta property="og:site_name" content="<?php echo $config['cf_title']?>" />
<meta property="og:title" content="<?php echo $g5_head_title?>" />
<meta property="og:url" content="<?php echo $site_url?>" />
<meta property="og:image" content="<?php echo $sns_logo?>" />
<meta property="og:description" content="<?php echo $desc?>" />

<meta property="article:tag" content="<?php echo $keywords?>" />
<meta property="article:section" content="<?php echo $cur_title?>" />
<meta property="article:publisher" content="<?php echo $site_name?>" />
<meta property="article:author" content="<?php echo $site_name?>" />
<!-- //facebook-->

<!-- google -->
<meta itemprop="headline" content="<?php echo $g5_head_title?>" />
<meta itemprop="alternativeHeadline" content="<?php echo $site_name?>" />
<meta itemprop="name" content="<?php echo $site_name?>" />
<meta itemprop="description" content="<?php echo $desc?>" />

<meta itemprop="image" content="<?php echo $sns_logo?>" />
<meta itemprop="url" content="<?php echo $site_url?>" />
<meta itemprop="thumbnailUrl" content="<?php echo $sns_logo?>" />

<meta itemprop="publisher" content="<?php echo $site_name?>" />
<meta itemprop="genre" content="blog" />
<meta itemprop="inLanguage" content="ko-kr" />
<!-- //google -->

<!-- twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="<?php echo $site_name?>" />
<meta name="twitter:creator" content="<?php echo $site_name?>" />
<meta name="twitter:url" content="<?php echo $site_url?>" />
<meta name="twitter:image" content="<?php echo $sns_logo?>" />
<meta name="twitter:title" content="<?php echo $g5_head_title?>" />
<meta name="twitter:description" content="<?php echo $desc?>" />
<!-- //twitter -->

<!-- nateon -->
<meta name="nate:title" content="<?php echo $g5_head_title?>" />
<meta name="nate:site_name" content="<?php echo $site_name?>" />
<meta name="nate:url" content="<?php echo $site_url?>" />
<meta name="nate:image" content="<?php echo $sns_logo?>" />
<meta name="nate:description" content="<?php echo $desc?>" />
<!-- //nateon -->

