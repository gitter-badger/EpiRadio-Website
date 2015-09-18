<?php

use Symfony\Component\HttpFoundation\Response;

$app->mount('/', new EpiRadio\Controller\HomepageController());

$app->match('/sitemap.xml', function () use ($app) {
  $response = new Response($app['twig']->render('sitemap.xml.twig', array(
    'page' => 'sitemap',
    'routes' => $app['routes']->all()
  )));
  $response->headers->set('Content-Type', 'application/xml; charset=utf-8');
  return $response;
});

$app->match('/robots.txt', function () use ($app) {
  $response = new Response($app['twig']->render('robots.txt.twig', array(
    'page' => 'robots',
  )));
  $response->headers->set('Content-Type', 'text/plain; charset=utf-8');
  return $response;
});

$app->get('{url}', function() use ($app) {
  return new Response($app['twig']->render('404.html.twig',
    array(
      'page' => '404',
    )), 404);
});
$app->get('{_locale}/{url}', function() use ($app) {
  return new Response($app['twig']->render('404.html.twig',
    array(
      'page' => '404',
    )), 404);
})->bind('404');

$app->error(function (\Exception $e, $code) use($app) {
  if ($app['debug'] == true)
    return;
  $message = 'We are sorry, but something went terribly wrong.';
  return new Response($message, $code);
});

return $app;