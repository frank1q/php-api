<?php 
$configArr = include('./Conf/config.php');
return array (
  'REWRITE' => 
  array (
  ),
  'APP' => 
  array (
    'DEBUG' => true,
    'LOG_ON' => false,
    'LOG_PATH' => BASE_PATH . 'cache/log/',
    'URL_HTTP_HOST' => '',
    'TIMEZONE' => 'PRC',
    'ENCODE_KEY' => 'api_',
    'COOKIE_PRE' => 'api_',
    'HTML_CACHE_ON' => false,
    'HTML_CACHE_PATH' => BASE_PATH . 'cache/html_cache/',
    'HTML_CACHE_RULE' => 
    array (
      'default' => 
      array (
        'index' => 
        array (
          'index' => 3000,
        ),
        'news' => 
        array (
          '*' => 3000,
        ),
        'photo' => 
        array (
          '*' => 3000,
        ),
        'page' => 
        array (
          '*' => 3000,
        ),
      ),
    ),
  ),
  'DB' => 
  array (
    'DB_TYPE' => $configArr['DB_TYPE'],
    'DB_HOST' => $configArr['DB_HOST'],
    'DB_USER' => $configArr['DB_USER'],
    'DB_PWD' => $configArr['DB_PWD'],
    'DB_PORT' => $configArr['DB_PORT'],
    'DB_NAME' => $configArr['DB_NAME'],
    'DB_CHARSET' => $configArr['DB_CHARSET'],
    'DB_PREFIX' => $configArr['DB_PREFIX'],
    'DB_CACHE_ON' => false,
    'DB_CACHE_PATH' => BASE_PATH . 'cache/db_cache/',
    'DB_CACHE_TIME' => 600,
    'DB_PCONNECT' => false,
    'DB_CACHE_CHECK' => true,
    'DB_CACHE_FILE' => 'cachedata',
    'DB_CACHE_SIZE' => '15M',
    'DB_CACHE_FLOCK' => true,
  ),
  'TPL' => 
  array (
    'TPL_TEMPLATE_PATH' => '',
    'TPL_TEMPLATE_SUFFIX' => '.php',
    'TPL_CACHE_ON' => false,
    'TPL_CACHE_TYPE' => '',
    'TPL_CACHE_PATH' => BASE_PATH . 'cache/tpl_cache/',
    'TPL_CACHE_SUFFIX' => '.php',
  ),
  'ver_name' => 'YxcmsApp 1.2.4',
  'ver_date' => '20140527',
  'copyright' => '由Ycms提供技术支持',
  'sitename' => 'php-api文档系统',
  'siteurl' => 'http://localhost/php-api/',
  'keywords' => 'php-api文档系统,开源，强大，实用',
  'description' => 'php-api文档系统,开源，强大，实用',
  'telephone' => '13638888888',
  'QQ' => 8888888,
  'email' => '8888888@qq.com',
  'address' => 'your address',
  'icp' => 'ICPxxxxxx',
  'fileupSize' => 90000000,
  'imgupSize' => 7000000,
  'ifwatermark' => true,
  'watermarkImg' => 'logo.png',
  'watermarkPlace' => 9,
  'sortMaxwidth' => 200,
  'sortMaxheight' => 200,
  'coverMaxwidth' => 260,
  'coverMaxheight' => 208,
  'thumbMaxwidth' => 145,
  'thumbMaxheight' => 110,
  'allowType' => 'jpg,bmp,gif,png,flv,mp4,mp3,wma,mp4,7z,zip,rar,ppt,txt,pdf,xls,doc,swf,wmv,avi,rmvb,rm',
);