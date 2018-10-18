<?php

namespace MakinaCorpus\IbanBundle\Form\Type;

use Symfony\Component\Form\DataTransformerInterface;

class SimpleIbanTransformer implements DataTransformerInterface
{
    private function canonicalize($value)
    {
        if (!\trim($value)) {
            return null;
        }
        return \preg_replace('/[^a-zA-Z0-9]+/', '', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return \is_string($value) ? ['value' => $this->canonicalize($value)] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($submitted)
    {
        return $this->canonicalize(\is_array($submitted) ? ($submitted['value'] ?? null) : null);
    }
}
