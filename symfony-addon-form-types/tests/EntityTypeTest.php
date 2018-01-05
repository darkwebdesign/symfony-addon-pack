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

namespace DarkWebDesign\SymfonyAddonFormTypes\Tests;

use DarkWebDesign\SymfonyAddonFormTypes\EntityType;
use DarkWebDesign\SymfonyAddonFormTypes\Tests\Models\City;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class EntityTypeTest extends TypeTestCase
{
    /** @var \DarkWebDesign\SymfonyAddonFormTypes\Tests\Models\City */
    private $entity;

    /** @var string */
    private $className;

    /** @var int */
    private $identifier;

    /** @var \Doctrine\Common\Persistence\ManagerRegistry */
    private $registry;

    /** @var \Doctrine\Common\Persistence\ObjectManager */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $repository;

    /** @var \Doctrine\Common\Persistence\Mapping\ClassMetadata */
    private $metadata;

    protected function setUp()
    {
        $this->entity = new City();
        $this->entity->setId(123);

        $this->className = get_class($this->entity);
        $this->identifier = $this->entity->getId();

        $this->registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $this->entityManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->metadata = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');

        $this->entityManager->method('getRepository')->willReturn($this->repository);
        $this->entityManager->method('getClassMetadata')->willReturn($this->metadata);

        $this->metadata->method('getName')->willReturn($this->className);
        $this->metadata->method('getIdentifierValues')->willReturn(array('id' => $this->identifier));

        $this->metadata->isIdentifierComposite = false;

        parent::setUp();
    }

    /**
     * @return array
     */
    protected function getExtensions()
    {
        $type = new EntityType($this->registry);

        return array(
            new PreloadedExtension(array($type), array()),
        );
    }

    public function test()
    {
        $this->registry->method('getManagerForClass')->willReturn($this->entityManager);

        $this->repository->method('find')->willReturn($this->entity);

        $options = array(
            'class' => $this->className,
        );

        $form = $this->factory->create(EntityType::class, null, $options);
        $form->submit($this->identifier);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($this->entity, $form->getData());
    }

    public function testEntityNotFound()
    {
        $this->registry->method('getManagerForClass')->willReturn($this->entityManager);

        $this->repository->method('find')->willReturn(null);

        $options = array(
            'class' => $this->className,
        );

        $form = $this->factory->create(EntityType::class, null, $options);
        $form->submit($this->identifier);

        $this->assertFalse($form->isSynchronized());
        $this->assertNull($form->getData());
    }

    public function testEntityManagerObject()
    {
        $this->repository->method('find')->willReturn($this->entity);

        $options = array(
            'class' => $this->className,
            'entity_manager' => $this->entityManager,
        );

        $form = $this->factory->create(EntityType::class, null, $options);
        $form->submit($this->identifier);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($this->entity, $form->getData());
    }

    public function testEntityManagerString()
    {
        $this->registry->method('getManager')->willReturn($this->entityManager);

        $this->repository->method('find')->willReturn($this->entity);

        $options = array(
            'class' => $this->className,
            'entity_manager' => 'Doctrine\ORM\EntityManager',
        );

        $form = $this->factory->create(EntityType::class, null, $options);
        $form->submit($this->identifier);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($this->entity, $form->getData());
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\RuntimeException
     * @expectedExceptionMessage Class "DarkWebDesign\SymfonyAddonFormTypes\Tests\Models\City" seems not to be a managed Doctrine entity. Did you forget to map it?
     */
    public function testNoEntityManager()
    {
        $this->registry->method('getManager')->willReturn(null);
        $this->registry->method('getManagerForClass')->willReturn(null);

        $this->repository->method('find')->willReturn($this->entity);

        $options = array(
            'class' => $this->className,
        );

        $form = $this->factory->create(EntityType::class, null, $options);
        $form->submit($this->identifier);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($this->entity, $form->getData());
    }
}
