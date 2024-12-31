<?php

/**
 * Copyright (c) 2021 DarkWeb Design.
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

use DarkWebDesign\SymfonyAddonFormTypes\JsonSchemaSubscriber;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
#[CoversClass(JsonSchemaSubscriber::class)]
class JsonSchemaSubscriberTest extends TypeTestCase
{
    public function test(): void
    {
        $form = $this->factory->createBuilder()
            ->add('schema', TextType::class)
            ->addEventSubscriber(new JsonSchemaSubscriber())
            ->getForm();

        $form->submit([
            '$schema' => 'https://example.com/product.schema.json',
        ]);

        $expected = [
            'schema' => 'https://example.com/product.schema.json',
        ];

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($expected, $form->getData());
    }

    public function testAlternativeFieldName(): void
    {
        $form = $this->factory->createBuilder()
            ->add('alternativeFieldName', TextType::class)
            ->addEventSubscriber(new JsonSchemaSubscriber('alternativeFieldName'))
            ->getForm();

        $form->submit([
            '$schema' => 'https://example.com/product.schema.json',
        ]);

        $expected = [
            'alternativeFieldName' => 'https://example.com/product.schema.json',
        ];

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($expected, $form->getData());
    }

    public function testDataNoSchema(): void
    {
        $form = $this->factory->createBuilder()
            ->add('schema', TextType::class)
            ->addEventSubscriber(new JsonSchemaSubscriber())
            ->getForm();

        $form->submit([]);

        $expected = [
            'schema' => null,
        ];

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($expected, $form->getData());
    }

    public function testDataNotArray(): void
    {
        $form = $this->factory->createBuilder()
            ->add('alternativeFieldName', TextType::class)
            ->addEventSubscriber(new JsonSchemaSubscriber('alternativeFieldName'))
            ->getForm();

        $form->submit('not-array');

        $this->assertFalse($form->isSynchronized());
        $this->assertNull($form->getData());
    }
}
