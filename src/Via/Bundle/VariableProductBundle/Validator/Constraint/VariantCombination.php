<?php

/*
 * This file is part of the Via package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Via\Bundle\VariableProductBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Unique option values combination for variant constraint.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 *
 * @Annotation
 */
class VariantCombination extends Constraint
{
    public $message = 'via.variant.combination';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'via.validator.variant.combination';
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
