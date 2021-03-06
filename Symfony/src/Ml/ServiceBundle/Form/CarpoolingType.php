<?php

namespace Ml\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarpoolingType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('creationDate')
            ->add('comment')
            //->add('indicate')
            ->add('price')
            ->add('departure')
            ->add('arrival')
            ->add('meetingPoint')
            ->add('arrivalPoint')
            ->add('bends')
            ->add('departureDate')
            ->add('estimatedDuration')
            ->add('estimatedDistance')
            ->add('packageTransport')
            ->add('packageSize')
            ->add('car')
            ->add('smoker')
            ->add('pets')
            ->add('music')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ml\ServiceBundle\Entity\Carpooling'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ml_servicebundle_carpooling';
    }
}
