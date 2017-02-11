<?php
/**
 * Copyright (c) 2017 DarkWeb Design
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace DarkWebDesign\SymfonyAddon\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * Collection constraint.
 *
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class Collection extends Constraint
{
    /** @var \Symfony\Component\Validator\Constraint[] */
    public $constraints;

    /**
     * Constructor.
     *
     * @param mixed $options
     */
    public function __construct($options = null)
    {
        parent::__construct($options);

        if (!is_array($this->constraints)) {
            throw new ConstraintDefinitionException(sprintf(
                'The option "constraints" is expected to be an array in constraint %s',
                __CLASS__
            ));
        }

        foreach ($this->constraints as $constraint) {
            if (!$constraint instanceof Constraint) {
                throw new ConstraintDefinitionException(
                    sprintf('The value %s is not an instance of Constraint in constraint %s', $constraint, __CLASS__)
                );
            }

            if ($constraint instanceof Valid) {
                throw new ConstraintDefinitionException(
                    sprintf(
                        'The constraint Valid cannot be nested inside constraint %s. ' .
                        'You can only declare the Valid constraint directly on a field or method.',
                        __CLASS__
                    )
                );
            }
        }
    }

    /**
     * Returns the name of the default option.
     *
     * @return string
     */
    public function getDefaultOption()
    {
        return 'constraints';
    }

    /**
     * Returns the name of the required options.
     *
     * @return array
     */
    public function getRequiredOptions()
    {
        return array('constraints');
    }
}
