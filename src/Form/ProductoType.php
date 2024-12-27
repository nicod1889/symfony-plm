<?php

namespace App\Form;

use App\Entity\Producto;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Type\DateTimePickerType;

class ProductoType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name')
            ->add('sku')
            ->add('price')
            ->add('createdOn', DateTimePickerType::class, [
                'label' => 'Created on',
                //'help' => 'help.post_publication',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}