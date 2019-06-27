<?php

namespace MakinaCorpus\IbanBundle\Form\Type;

use Symfony\Component\Form\DataTransformerInterface;

class IbanTransformer implements DataTransformerInterface
{
    private function canonicalize($value)
    {
        return \preg_replace('/[^a-zA-Z0-9]+/', '', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (!is_string($value)) {
            return null;
        }

        $value = $this->canonicalize($value);
        $length = strlen($value);

        if ($length < 4) {
            return ['cccd' => $value];
        }

        $ret = [];
        $ret['cccd'] = substr($value, 0, 4);

        foreach (['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'] as $i => $key) {

            // String starts at (array offset starts with 0)
            $start = $i * 4 + 4;
            $size = $length - $start;

            if ($size < 4) {
                $ret[$key] = substr($value, $start, $size);

                break; // Do not continue spitting values.

            } else {
                $ret[$key] = substr($value, $start, 4);
            }
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($submitted)
    {
        $value = '';

        foreach (['cccd', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'] as $key) {
            $value .= $this->canonicalize($submitted[$key]);
        }

        return $value;
    }
}
