<?php

namespace MakinaCorpus\IbanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * IBAN input field with 7 4-digit input fields.
 */
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
            ->add('g', TextType::class, [
                'required' => false,
                'attr' => $commonAttr,
            ])
            ->add('h', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxlength' => 2,
                    'placeholder' => '12',
                    'size' => 2,
                    'style' => 'width: auto;',
                ],
            ])
            ->addModelTransformer(new IbanTransformer())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['with_js'] = $options['with_js'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'error_bubbling' => false,
            'with_js' => true,
        ]);
        $resolver->setAllowedTypes('with_js', ['bool']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'iban';
    }
}
