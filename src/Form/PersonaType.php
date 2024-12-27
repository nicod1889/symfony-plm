<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Persona;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('nombre', TextType::class, [
                'required' => false])
            ->add('apellido', TextType::class, [
                'required' => false])
            ->add('dni', NumberType::class, [
                'required'=> false])
            ->add('edad', NumberType::class, [
                'required'=> false])
            ->add('club', EntityType::class, [
                'class' => Club::class,
                'choice_label' => 'name',
                'required' => true,
                'placeholder' => 'Seleccione un club.'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Persona::class,
        ]);
    }
}
