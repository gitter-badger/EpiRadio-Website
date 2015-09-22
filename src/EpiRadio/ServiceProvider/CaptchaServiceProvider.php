<?php

namespace EpiRadio\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use EpiRadio\Validator\Constraints;
use EpiRadio\Form\Type;
use EpiRadio\Form\Extension;
use EpiRadio\Form\Extension\CaptchaExtension;

class CaptchaServiceProvider implements ServiceProviderInterface
{

  public function register(Application $app)
  {

    if (isset($app['twig'])) {
      $path = $app['twig.options.views'];
      $app['twig.loader']->addLoader(new \Twig_Loader_Filesystem($path));
      $app['twig.form.templates'] = array_merge(
        $app['twig.form.templates'],
        array('captcha.html.twig')
      );
    }
    // Register recaptcha form type
    if (isset($app['form.extensions'])) {
      $app['form.extensions'] = $app->share($app->extend('form.extensions',
        function($extensions) use ($app) {
          $extensions[] = new CaptchaExtension($app);
          return $extensions;
        }));
    }
    // Register recaptcha validator constraint
    if (isset($app['validator.validator_factory'])) {
      $app['captcha.true'] = $app->share(function ($app) {
        $validator = new Constraints\TrueCaptchaValidator(
          $app['captcha.private_key'],
          $app['request_stack'],
          $app
        );
        return $validator;
      });
      $app['validator.validator_service_ids'] =
      isset($app['validator.validator_service_ids']) ? $app['validator.validator_service_ids'] : array();
      $app['validator.validator_service_ids'] = array_merge(
        $app['validator.validator_service_ids'],
        array('captcha.true' => 'captcha.true')
      );
    }

  }

  public function boot(Application $app)
  {
  }
}