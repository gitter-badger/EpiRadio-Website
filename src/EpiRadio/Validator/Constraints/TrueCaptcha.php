<?php
namespace EpiRadio\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


class TrueCaptcha extends Constraint
{
  public $message = 'Vous devez valider correctement le captcha.';

  public function getTargets()
  {
    return Constraint::PROPERTY_CONSTRAINT;
  }

  public function validatedBy()
  {
    return 'captcha.true';
  }
}