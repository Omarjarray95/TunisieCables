<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('libelle', ChoiceType::class, array('choices'=> array('' => '', 'AR02V' => 'AR02V',
                'SERIES 5-9' => 'SERIES 5-9', 'SERIES 298-299'=>'SERIES 298-299', 'F-YAY'=>'F-YAY',
                'SERIES 98-99' => 'SERIES 98-99'), 'mapped' => false))
            ->add('type', ChoiceType::class, array('choices'=> array(''=>'','10'=>'10', '16'=>'16','25'=>'25',
                '35'=>'35', '50' => '50'), 'mapped' => false))
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
