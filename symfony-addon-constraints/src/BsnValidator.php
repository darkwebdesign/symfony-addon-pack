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
 * BSN validator.
 *
 * The Dutch social security number (BSN) consists of 9 digits and complies with a variant of the eleven-test. The
 * variant is in the last digit, that instead of by 1, is multiplied by -1. This difference is intentionally inserted so
 * that a wrongly entered bank account number is considered to be faulty. If the social security number is represented
 * by ABCDEFGHI, then
 *
 * (9 × A) + (8 × B) + (7 × C) + (6 × D) + (5 × E) + (4 × F) + (3 × G) + (2 × H) + (-1 × I)
 *
 * must be a multiple of 11. With this combination nearly 91 million numbers can be created. Valid examples are:
 * 111222333 and 123456782.
 *
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class BsnValidator extends ConstraintValidator
{
    /**
     * Checks if the value is valid.
     *
     * @throws \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Bsn) {
            throw new UnexpectedTypeException($constraint, Bsn::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        if ('000000000' !== $value && preg_match('/^\d{9}$/', $value)) {
            [$a, $b, $c, $d, $e, $f, $g, $h, $i] = str_split($value);

            $sum = (9 * $a) + (8 * $b) + (7 * $c) + (6 * $d) + (5 * $e) + (4 * $f) + (3 * $g) + (2 * $h) + (-1 * $i);

            if (0 === $sum % 11) {
                return;
            }
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $this->formatValue($value))
            ->addViolation();
    }
}
