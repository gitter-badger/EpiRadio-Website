<?php

namespace EpiRadio\Form\Extension;

use Silex\Application;
use Symfony\Component\Form\AbstractExtension;
use EpiRadio\Form\Type\CaptchaType;

/**
 * Extends form to register captcha type
 */
class CaptchaExtension extends AbstractExtension
{
  /**
   * Container
   *
   * @var \Silex\Application
   */
  private $app;

  /**
   * Constructor
   *
   * @param \Silex\Application $app container
   */
  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  /**
   * Register the captcha form type
   *
   * @return array
   */
  protected function loadTypes()
  {
    return array(
      new CaptchaType(
        $this->app['captcha.public_key'],
        $this->app['captcha.ajax'],
        $this->app['captcha.locale_key']
      )
    );
  }
}