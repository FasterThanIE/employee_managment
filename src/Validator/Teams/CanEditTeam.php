<?php

namespace App\Validator\Teams;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CanEditTeam extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The value "{{ value }}" is not valid.';
}
