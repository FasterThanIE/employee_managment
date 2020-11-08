<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AlreadyOwnsTeam extends Constraint
{
    public $message = '';
}
