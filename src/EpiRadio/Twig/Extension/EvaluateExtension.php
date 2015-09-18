<?php

namespace EpiRadio\Twig\Extension;

/**
 * A twig extension that will add a dynamic evaluate filter.
 */
class EvaluateExtension extends \Twig_Extension {

  public function getFilters( ) {
    return array(
      'evaluate' => new \Twig_Filter_Method( $this, 'evaluate', array(
        'needs_environment' => true,
        'needs_context' => true,
        'is_safe' => array(
          'evaluate' => true
        )
      ))
    );
  }

  public function evaluate( \Twig_Environment $environment, $context, $string ) {
    $loader = $environment->getLoader( );

    $parsed = $this->parseString( $environment, $context, $string );

    $environment->setLoader( $loader );
    return $parsed;
  }

  protected function parseString( \Twig_Environment $environment, $context, $string ) {
    $environment->setLoader( new \Twig_Loader_String( ) );
    return $environment->render( $string, $context );
  }

  public function getName( ) {
    return 'evaluate';
  }
}
