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
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class CollectionValidator extends ConstraintValidator
{
    /**
     * @throws UnexpectedTypeException
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Collection) {
            throw new UnexpectedTypeException($constraint, Collection::class);
        }

        if (null === $value) {
            return;
        }

        if (!is_array($value) && !$value instanceof \Traversable) {
            throw new UnexpectedTypeException($value, 'array or Traversable');
        }

        foreach ($value as $field => $fieldValue) {
            foreach ($constraint->constraints as $fieldConstraint) {
                $this->context->getValidator()
                    ->inContext($this->context)
                    ->atPath('[' . $field . ']')
                    ->validate($fieldValue, $fieldConstraint);
            }
        }
    }
}
