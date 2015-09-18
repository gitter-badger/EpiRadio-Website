<?php

// Date Timezone
date_default_timezone_set('Europe/Paris');

// Locale
$app['app_default_locale'] = 'fr';
$app['app_allowed_locales'] = array('fr','en');

// Cache
$app['cache.path'] = __DIR__ . '/../cache';

// Translates cache
$app['translates.path_to_cache'] = $app['cache.path']  . '/translates';

// Http cache
$app['http_cache.cache_dir'] = $app['cache.path'] . '/http';
$app['http_cache.options'] = array( 'allow_reload' => true, 'allow_revalidate' => true);

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig';

$app['twig.options.views'] = __DIR__ . '/../views';

// Assetic
$app['assetic.enabled']              = true;
$app['assetic.path_to_cache']        = $app['cache.path'] . '/assetic' ;
$app['assetic.path_to_web']          = __DIR__ . '/../../web/assets';
$app['assetic.input.path_to_assets'] = __DIR__ . '/../assets';

$app['assetic.input.path_to_css']       = array(
	$app['assetic.input.path_to_assets'] . '/less/style.less',
	$app['assetic.input.path_to_assets'] . '/css/ladda-themeless.css',
);
$app['assetic.output.path_to_css']      = 'css/styles.css';
$app['assetic.input.path_to_js']        = array(
    __DIR__ . '/../../vendor/twbs/bootstrap/js/tooltip.js',
    __DIR__ . '/../../vendor/twbs/bootstrap/js/*.js',
    $app['assetic.input.path_to_assets'] . '/js/jquery.ui.map.js',
    $app['assetic.input.path_to_assets'] . '/js/jquery.geocomplete.js',
    $app['assetic.input.path_to_assets'] . '/js/bootstrap-typeahead.js',
    $app['assetic.input.path_to_assets'] . '/js/moment.js',
    $app['assetic.input.path_to_assets'] . '/js/bootstrap-datetimepicker.js',
    $app['assetic.input.path_to_assets'] . '/js/spin.js',
    $app['assetic.input.path_to_assets'] . '/js/ladda.js',
    $app['assetic.input.path_to_assets'] . '/js/script.js',
);
$app['assetic.output.path_to_js']       = 'js/scripts.js';
