<?php
/**
 * Copyright (c) 2017 DarkWeb Design.
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

namespace DarkWebDesign\SymfonyAddonConstraints\Tests;

use DarkWebDesign\SymfonyAddonConstraints\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * @covers \DarkWebDesign\SymfonyAddonConstraints\Collection
 *
 * @internal
 */
class CollectionTest extends TestCase
{
    public function testConstruct(): void
    {
        new Collection([
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);

        $this->assertTrue(true);
    }

    public function testConstructDefaultOption(): void
    {
        new Collection([
            new Assert\NotBlank(),
        ]);

        $this->assertTrue(true);
    }

    public function testConstructMissingRequiredConstraintsOption(): void
    {
        $this->expectException(MissingOptionsException::class);

        new Collection();
    }

    public function testConstructNoConstraint(): void
    {
        $this->expectException(ConstraintDefinitionException::class);

        new Collection([
            'constraints' => [
                'foo',
            ],
        ]);
    }

    public function testConstructValidConstraint(): void
    {
        $this->expectException(ConstraintDefinitionException::class);

        new Collection([
            'constraints' => [
                new Assert\Valid(),
            ],
        ]);
    }
}
