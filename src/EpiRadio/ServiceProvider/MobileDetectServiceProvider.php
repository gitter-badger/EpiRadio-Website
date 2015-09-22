<?php

namespace EpiRadio\ServiceProvider;

use EpiRadio\Utils\MobileDetect;
use Silex\Application;
use Silex\ServiceProviderInterface;

class MobileDetectServiceProvider implements ServiceProviderInterface
{
  public function register(Application $app)
  {
    $app['mobile_detect'] = new MobileDetect($app);
  }

  public function boot(Application $app)
  {
  }
}
