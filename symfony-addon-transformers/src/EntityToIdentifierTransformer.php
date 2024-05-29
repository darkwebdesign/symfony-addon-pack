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

namespace DarkWebDesign\SymfonyAddonTransformers;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

// @codeCoverageIgnoreStart
if (!interface_exists(ObjectManager::class)) {
    throw new \LogicException('You cannot use "DarkWebDesign\SymfonyAddonTransformers\EntityToIdentifierTransformer" as the "doctrine/orm" package is not installed. Try running "composer require doctrine/orm".');
}
// @codeCoverageIgnoreEnd

/**
 * Transforms between an identifier and a Doctrine entity.
 *
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class EntityToIdentifierTransformer implements DataTransformerInterface
{
    private string $className;
    private ObjectRepository $repository;
    private ClassMetadata $metadata;

    /**
     * Constructor.
     */
    public function __construct(
        private ObjectManager $entityManager,
        string $className
    ) {
        $this->repository = $this->entityManager->getRepository($className);
        $this->metadata = $this->entityManager->getClassMetadata($className);
        $this->className = $this->metadata->getName();
    }

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * @param object $value
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function transform(mixed $value): mixed
    {
        if (null === $value) {
            return null;
        }

        if (!is_object($value) || is_callable($value)) {
            throw new TransformationFailedException('Expected an object.');
        }

        if (!class_exists(ClassUtils::class)) {
            throw new \LogicException(sprintf('You cannot use "%s" as the "doctrine/orm" package is not installed. Try running "composer require doctrine/orm".', self::class));
        }

        $className = ClassUtils::getClass($value);

        if ($className !== $this->className && !is_subclass_of($className, $this->className)) {
            throw new TransformationFailedException(sprintf('Expected entity %s.', $this->className));
        }

        $identifierValues = $this->metadata->getIdentifierValues($value);

        if (count($identifierValues) > 1) {
            throw new TransformationFailedException('Expected an entity with a single identifier.');
        }

        return reset($identifierValues);
    }

    /**
     * Transforms a value from the transformed representation to its original representation.
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function reverseTransform(mixed $value): ?object
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!is_scalar($value)) {
            throw new TransformationFailedException('Expected a scalar.');
        }

        $entity = $this->repository->find($value);

        if (null === $entity) {
            throw new TransformationFailedException(
                sprintf('Entity %s with identifier "%s" not found.', $this->className, $value)
            );
        }

        return $entity;
    }
}
