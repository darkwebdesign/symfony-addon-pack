<?php
/**
 * Copyright (c) 2021 DarkWeb Design
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

namespace DarkWebDesign\SymfonyAddonFormTypes;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Raymond Schouten
 *
 * @since 5.2.1
 */
class BooleanToYesNoSubscriber implements EventSubscriberInterface
{
    public function __construct(
        /** @var string[] */
        private array $fieldNames
    ) {
    }

    /**
     * Rewrites the pure boolean values to "yes" or "no".
     */
    public function onPreSubmit(FormEvent $event): void
    {
        $data = $event->getData();

        if (!is_array($data)) {
            return;
        }

        foreach ($this->fieldNames as $fieldName) {
            if (!array_key_exists($fieldName, $data)) {
                continue;
            }

            $data[$fieldName] = true === $data[$fieldName] ? 'yes' : (false === $data[$fieldName] ? 'no' : null);
        }

        $event->setData($data);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        ];
    }
}
