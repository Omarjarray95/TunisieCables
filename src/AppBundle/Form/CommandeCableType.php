<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeCableType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, array('mapped' => false))
            ->add('type', TextType::class, array('mapped' => false))
            ->add('couleur', TextType::class, array('mapped' => false))
            ->add('typeMetal', TextType::class, array('mapped' => false))
            ->add('poidsKgKm', NumberType::class, array('mapped' => false))
            ->add('longueurCable')
            ->add('cableDecoupe')
            ->add('enregistrerpasser', SubmitType::class, array('label' => 'Enregistrer & Passer'))
            ->add('enregistrerajouter', SubmitType::class, array('label' => 'Enregistrer & Ajouter'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CommandeCable'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_commandecable';
    }


}
