<?php
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use SilexAssetic\AsseticServiceProvider;

$app->register(new HttpCacheServiceProvider());

$app->register(new SessionServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new SwiftmailerServiceProvider());

$app->register(new MonologServiceProvider(), array(
  'monolog.logfile' => __DIR__ . '/../log/app.log',
  'monolog.name' => 'app',
  'monolog.level' => 300
));

$app->register(new TwigServiceProvider(), array(
  'twig.options' => array(
    'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
    'strict_variables' => true
  ),
  'twig.form.templates' => array(
    'form_div_layout.html.twig',
    'common/form_div_layout.html.twig'
  ),
  'twig.path' => array(
    __DIR__ . '/../views',
    __DIR__ . '/../views/pages'
  )
));

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
  $twig->addExtension(new EpiRadio\Twig\Extension\EvaluateExtension());
  return $twig;
}));

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
  $twig->addFunction(new \Twig_SimpleFunction('loremipsum', function($words) {
    $loremIpsum = new EpiRadio\Utils\LoremIpsum();
    return $loremIpsum->words($words);
  }));
  return $twig;
}));

if ($app['debug'] && isset($app['cache.path'])) {
  $app->register(new ServiceControllerServiceProvider());
  $app->register(new WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => $app['cache.path'] . '/profiler'
  ));
}

if (isset($app['assetic.enabled']) && $app['assetic.enabled']) {
  $app->register(new AsseticServiceProvider(), array(
    'assetic.options' => array(
      'debug' => $app['debug'],
      'auto_dump_assets' => $app['debug']
    )
  ));

  $app['assetic.filter_manager'] = $app->share($app->extend('assetic.filter_manager', function ($fm, $app) {
    $fm->set('lessphp', new Assetic\Filter\LessphpFilter());

    return $fm;
  }));

  $app['assetic.asset_manager'] = $app->share($app->extend('assetic.asset_manager', function ($am, $app) {
    $am->set('styles', new Assetic\Asset\AssetCache(new Assetic\Asset\GlobAsset($app['assetic.input.path_to_css'], array(
      $app['assetic.filter_manager']->get('lessphp')
    )), new Assetic\Cache\FilesystemCache($app['assetic.path_to_cache'])));
    $am->get('styles')
      ->setTargetPath($app['assetic.output.path_to_css']);

    $am->set('scripts', new Assetic\Asset\AssetCache(new Assetic\Asset\GlobAsset($app['assetic.input.path_to_js']), new Assetic\Cache\FilesystemCache($app['assetic.path_to_cache'])));
    $am->get('scripts')
      ->setTargetPath($app['assetic.output.path_to_js']);

    return $am;
  }));
}

$app->register(new EpiRadio\ServiceProvider\MobileDetectServiceProvider());

// Register Captcha type
$app['captcha.private_key'] = "API_PRIVATEKEY_HERE";
$app['captcha.public_key'] = "API_PUBLICKEY_HERE";
$app['captcha.locale_key'] = $app['locale'];
$app['captcha.ajax'] = false;

$app->register(new EpiRadio\ServiceProvider\CaptchaServiceProvider());

return $app;
