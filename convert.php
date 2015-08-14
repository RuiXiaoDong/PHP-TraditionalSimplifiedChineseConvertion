<?php
/**
 * This file is for 3rd party only.
 * 
 * Through include, you can use the function: zhconversion($str, $variant)
 * if $_GET['doconversion'] or $_POST['doconversion']) are occupied
 * then $_REQUEST['data'] will be converted based on $_REQUEST['variant'] setting.
 *
 */

global $zh2Hans, $zh2Hant, $zh2TW, $zh2CN, $zh2SG, $zh2HK;
require_once( dirname(__FILE__) . '/ZhConversion.php');

global $wpcc_langs;
$wpcc_langs = array(
	'zh-hans' => array('zhconversion_hans', 'zh2Hans', '简体中文'),
	'zh-hant' => array('zhconversion_hant', 'zh2Hant', '繁體中文'),
	'zh-cn' => array('zhconversion_cn', 'zh2CN', '大陆简体'),
	'zh-hk' => array('zhconversion_hk', 'zh2HK', '港澳繁體'),
	'zh-sg' => array('zhconversion_sg', 'zh2SG', '马新简体'),
	'zh-tw' => array('zhconversion_tw', 'zh2TW', '台灣正體'),
	'zh-mo' => array('zhconversion_hk', 'zh2MO', '澳門繁體'),
	'zh-my' => array('zhconversion_sg', 'zh2MY', '马来西亚简体'),
	'zh' => array('zhconversion_zh', 'zh2ZH', '中文'),
);

if( empty($nochineseconversion) && empty($GLOBALS['nochineseconversion']) ) {
	if( ( isset($_GET['dochineseconversion']) || isset($_POST['dochineseconversion']) ) && isset($_REQUEST['data']) ) {
		$wpcc_data = get_magic_quotes_gpc() ? stripslashes($_REQUEST['data']) : $_REQUEST['data'];
		$wpcc_variant = str_replace('_', '-', strtolower(trim($_REQUEST['variant'])));
		if( !empty($wpcc_variant) && in_array($wpcc_variant, array('zh-hans', 'zh-hant', 'zh-cn', 'zh-hk', 'zh-sg', 'zh-tw', 'zh-my', 'zh-mo')) )
			echo zhconversion($wpcc_data, $wpcc_variant);
		else echo $wpcc_data;
		die();
	}
}

function zhconversion($str, $variant) {
	global $wpcc_langs;
	return $wpcc_langs[$variant][0]($str);
}

function zhconversion_hant($str) {
	global $zh2Hant;
	return strtr($str, $zh2Hant );
}

function zhconversion_hans($str) {
	global $zh2Hans;
	return strtr($str, $zh2Hans);
}

function zhconversion_cn($str) {
	global $zh2Hans, $zh2CN;
	return strtr(strtr($str, $zh2CN), $zh2Hans);
}

function zhconversion_tw($str) {
	global $zh2Hant, $zh2TW;
	return strtr(strtr($str, $zh2TW), $zh2Hant);
}

function zhconversion_sg($str) {
	global $zh2Hans, $zh2SG;
	return strtr(strtr($str, $zh2SG), $zh2Hans);
}

function zhconversion_hk($str) {
	global $zh2Hant, $zh2HK;
	return strtr(strtr($str, $zh2HK), $zh2Hant);
}

function zhconversion_zh($str) {
	return $str;
}

?>