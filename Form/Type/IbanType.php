<?php

namespace MakinaCorpus\IbanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IbanType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $commonAttr = [
            'maxlength' => 4,
            'placeholder' => '1234',
            'size' => 4,
            'style' => 'width: auto;',
        ];

        $builder
            // CCCD (Country Code, Check Digits)
            ->add('cccd', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'FR76'] + $commonAttr,
            ])
            // BBAN (Basic Bank Account Number)
            ->add('a', TextType::class, [
                'required' => true,
                'attr' => $commonAttr,
            ])
            ->add('b', TextType::class, [
                'required' => true,
                'attr' => $commonAttr,
            ])
            ->add('c', TextType::class, [
                'required' => true,
                'attr' => $commonAttr,
            ])
            ->add('d', TextType::class, [
                'required' => false,
                'attr' => $commonAttr,
            ])
            ->add('e', TextType::class, [
                'required' => false,
                'attr' => $commonAttr,
            ])
            ->add('f', TextType::class, [
                'required' => false,
                'attr' => $commonAttr,
            ])
            ->addModelTransformer(new IbanTransformer())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'error_bubbling' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'iban';
    }
}
