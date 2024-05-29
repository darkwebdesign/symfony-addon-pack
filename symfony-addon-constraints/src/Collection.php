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

declare(strict_types=1);

namespace DarkWebDesign\SymfonyAddonConstraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
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
    /** @var Constraint[] */
    public array $constraints;

    public function __construct(mixed $options = null)
    {
        parent::__construct($options);

        foreach ($this->constraints as $constraint) {
            if (!$constraint instanceof Constraint) {
                throw new ConstraintDefinitionException(
                    sprintf('The value %s is not an instance of Constraint in constraint %s', $constraint, self::class)
                );
            }

            if ($constraint instanceof Valid) {
                throw new ConstraintDefinitionException(
                    sprintf(
                        'The constraint Valid cannot be nested inside constraint %s. ' .
                        'You can only declare the Valid constraint directly on a field or method.',
                        self::class
                    )
                );
            }
        }
    }

    public function getDefaultOption(): string
    {
        return 'constraints';
    }

    public function getRequiredOptions(): array
    {
        return ['constraints'];
    }
}
