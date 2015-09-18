<?php
namespace EpiRadio\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

class HomepageController implements ControllerProviderInterface
{

  public function connect(Application $app)
  {
    $controllers = $app['controllers_factory'];
    $controllers->match('/', array(
      $this,
      'index'
    ))->bind('homepage');

    return $controllers;
  }

  public function index(Application $app)
  {
    return $app['twig']->render('homepage.html.twig', array(
      'page' => 'homepage',
    ));
  }
}