<?php
/*
Plugin Name: Lightbox's Evolution
Version: 1.0
Plugin URL: http://lab.i-xider.com/em-lightbox-evolution-plugin-release
Description: 给博客中的图片添加LightBox效果。
Author: Xider
Author Email: xiderowg@foxmail.com
Author URL: http://blog.i-xider.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
emLoadJQuery();
function xd_lightbox()
{
	if(isset($_GET['plugin']) && $_GET['plugin'] == 'kl_album') return;

	$path = '';
	if(isset($_SERVER['REQUEST_URI']))
	{
		$path = $_SERVER['REQUEST_URI'];
	}else{
		if(isset($_SERVER['argv']))
		{
			$path = $_SERVER['PHP_SELF'].'?'.$_SERVER['argv'][0];
		}else{
			$path = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		}
	}
	//for ie6 header location
	$r = explode('#', $path, 2);
	$path = $r[0];
	//for iis6
	$path = str_replace('index.php', '', $path);
	//for subdirectory
	$t = parse_url(BLOG_URL);
	$path = str_replace($t['path'], '/', $path);
	if($path == '/t/') return;

	$data = ob_get_contents();
	$dataArr = array();
	$search_pattern = "%<a([^>]*?)href=\"[^\"]*?(jpg|gif|png|jpeg|bmp)\"([^>]*?)>.*?</a>%s";
	preg_match_all($search_pattern, $data, $dataArr, PREG_PATTERN_ORDER);
	if(empty($dataArr[0])) return;

	$active_plugins = Option::get('active_plugins');
	echo '<link href="'.BLOG_URL.'content/plugins/xd_lightbox_evo/xd_lightbox_evo/jquery.lightbox.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 7]><link href="'.BLOG_URL.'content/plugins/xd_lightbox_evo/xd_lightbox_evo/jquery.lightbox.ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
<script type="text/javascript" src="'.BLOG_URL.'content/plugins/xd_lightbox_evo/xd_lightbox_evo/jquery.lightbox.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function($){
    $("a[href$=jpg],a[href$=gif],a[href$=png],a[href$=jpeg],a[href$=bmp]").lightbox();
  });
</script>
'."\r\n";
}
addAction('index_footer', 'xd_lightbox');