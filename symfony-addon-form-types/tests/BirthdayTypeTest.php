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

namespace DarkWebDesign\SymfonyAddonFormTypes\Tests;

use DarkWebDesign\SymfonyAddonFormTypes\BirthdayType;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
#[CoversClass(BirthdayType::class)]
class BirthdayTypeTest extends TypeTestCase
{
    public function test(): void
    {
        $form = $this->factory->create(BirthdayType::class);

        $choices = $form->get('year')->getConfig()->getOption('choices');

        $this->assertCount(121, $choices);
        $this->assertSame((int) date('Y'), reset($choices));
        $this->assertSame(date('Y') - 120, end($choices));
    }
}
