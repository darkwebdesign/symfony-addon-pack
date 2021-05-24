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

namespace DarkWebDesign\SymfonyAddonTransformers\Tests;

use DarkWebDesign\SymfonyAddonTransformers\EntityToIdentifierTransformer;
use DarkWebDesign\SymfonyAddonTransformers\Tests\Models\AbstractPerson;
use DarkWebDesign\SymfonyAddonTransformers\Tests\Models\City;
use DarkWebDesign\SymfonyAddonTransformers\Tests\Models\Employee;
use DarkWebDesign\SymfonyAddonTransformers\Tests\Models\PointOfInterest;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityToIdentifierTransformerTest extends TestCase
{
    /** @var \DarkWebDesign\SymfonyAddonTransformers\Tests\Models\City */
    private $entity;

    /** @var string */
    private $className;

    /** @var int */
    private $identifier;

    /** @var \Doctrine\Common\Persistence\ObjectManager|\PHPUnit_Framework_MockObject_MockObject */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository|\PHPUnit_Framework_MockObject_MockObject */
    private $repository;

    /** @var \Doctrine\Common\Persistence\Mapping\ClassMetadata|\PHPUnit_Framework_MockObject_MockObject */
    private $metadata;

    protected function setUp(): void
    {
        $this->entity = new City();
        $this->entity->setId(123);

        $this->className = get_class($this->entity);
        $this->identifier = $this->entity->getId();

        $this->entityManager = $this->createMock(ObjectManager::class);
        $this->repository = $this->createMock(ObjectRepository::class);
        $this->metadata = $this->createMock(ClassMetadata::class);

        $this->entityManager->method('getRepository')->willReturn($this->repository);
        $this->entityManager->method('getClassMetadata')->willReturn($this->metadata);

        $this->metadata->method('getName')->willReturnCallback([$this, 'getClassName']);
        $this->metadata->method('getIdentifierValues')->willReturnCallback([$this, 'getIdentifier']);

        $this->metadata->isIdentifierComposite = false;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return array
     */
    public function getIdentifier()
    {
        return ['id' => $this->identifier];
    }

    public function testConstructIdentifierComposite()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected an entity with a single identifier.');

        $this->metadata->isIdentifierComposite = true;

        new EntityToIdentifierTransformer($this->entityManager, $this->className);
    }

    public function testTransform()
    {
        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $identifier = $transformer->transform($this->entity);

        $this->assertSame($this->identifier, $identifier);
    }

    public function testTransformAlias()
    {
        $transformer = new EntityToIdentifierTransformer($this->entityManager, 'AppBundle:City');

        $identifier = $transformer->transform($this->entity);

        $this->assertSame($this->identifier, $identifier);
    }

    public function testTransformDiscriminated()
    {
        $this->className = AbstractPerson::class;

        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $entity = new Employee();

        $identifier = $transformer->transform($entity);

        $this->assertSame($this->identifier, $identifier);
    }

    public function testTransformNull()
    {
        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $identifier = $transformer->transform(null);

        $this->assertNull($identifier);
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoObject
     */
    public function testTransformNoObject($value)
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('Expected an object.');

        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $transformer->transform($value);
    }

    public function testTransformInvalidEntity()
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('Expected entity DarkWebDesign\SymfonyAddonTransformers\Tests\Models\City.');

        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $entity = new PointOfInterest();

        $transformer->transform($entity);
    }

    public function testReverseTransform()
    {
        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $this->repository->method('find')->willReturn($this->entity);

        $entity = $transformer->reverseTransform($this->identifier);

        $this->assertSame($this->identifier, $entity->getId());
    }

    public function testReverseTransformNull()
    {
        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $entity = $transformer->reverseTransform(null);

        $this->assertNull($entity);
    }

    public function testReverseTransformEmptyString()
    {
        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $entity = $transformer->reverseTransform('');

        $this->assertNull($entity);
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoScalar
     */
    public function testReverseTransformNoScalar($value)
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('Expected a scalar.');

        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $transformer->reverseTransform($value);
    }

    public function testReverseTransformEntityNotFound()
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('Entity DarkWebDesign\SymfonyAddonTransformers\Tests\Models\City with identifier "123" not found.');

        $transformer = new EntityToIdentifierTransformer($this->entityManager, $this->className);

        $this->repository->method('find')->willReturn(null);

        $transformer->reverseTransform($this->identifier);
    }

    /**
     * @return array[]
     */
    public function providerNoObject()
    {
        return [
            'bool' => [true],
            'int' => [1],
            'float' => [1.2],
            'string' => ['foo'],
            'array' => [['foo', 'bar']],
            'resource' => [tmpfile()],
            'callable' => [function () {}],
        ];
    }

    /**
     * @return array[]
     */
    public function providerNoScalar()
    {
        return [
            'array' => [['foo', 'bar']],
            'object' => [new \stdClass()],
            'resource' => [tmpfile()],
            'callable' => [function () {}],
        ];
    }
}
