<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sku', TextType::class, [
                'attr' => array(
                    'class' => 'bg-transparent block border-b-5 w-50 h-10 text-3xl',
                    'placeholder' => 'Enter SKU code'
                ),
                'label' => false,
                'required' => true
            ])
            ->add('product_name', TextType::class, [
                'attr' => array(
                    'class' => 'bg-transparent block border-b-5 w-50 h-10 text-3xl mt-10',
                    'placeholder' => 'Enter product name',
                ),
                'label' => false,
                'required' => true
            ])
            ->add('description', TextType::class, [
                'attr' => array(
                    'class' => 'bg-transparent block mt-10 border-b-5 w-50 h-60 text-3xl',
                    'placeholder' => 'Product description'
                ),
                'label' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
