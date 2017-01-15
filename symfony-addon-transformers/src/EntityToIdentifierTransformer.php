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

namespace DarkWebDesign\SymfonyAddon\Transformer;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between an identifier and a Doctrine entity.
 *
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class EntityToIdentifierTransformer implements DataTransformerInterface
{
    /** @var \Doctrine\Common\Persistence\ObjectManager */
    private $entityManager;

    /** @var string */
    private $className;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $repository;

    /** @var \Doctrine\Common\Persistence\Mapping\ClassMetadata */
    private $metadata;

    /**
     * Constructor.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $entityManager
     * @param string $className
     *
     * @throws \Symfony\Component\Form\Exception\InvalidArgumentException
     */
    public function __construct(ObjectManager $entityManager, $className)
    {
        $this->entityManager = $entityManager;
        $this->className = $className;
        $this->repository = $this->entityManager->getRepository($this->className);
        $this->metadata = $this->entityManager->getClassMetadata($this->className);

        if ($this->metadata->isIdentifierComposite) {
            throw new InvalidArgumentException('Expected an entity with a single identifier.');
        }
    }

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * @param object $value
     *
     * @return mixed
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if (!is_object($value) || is_callable($value)) {
            throw new TransformationFailedException('Expected an object.');
        }

        $class = ClassUtils::getClass($value);

        if ($class !== $this->className) {
            throw new TransformationFailedException(sprintf('Expected entity %s.', $this->className));
        }

        $identifierValues = $this->metadata->getIdentifierValues($value);

        return reset($identifierValues);
    }

    /**
     * Transforms a value from the transformed representation to its original representation.
     *
     * @param mixed $value
     *
     * @return object
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function reverseTransform($value)
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
