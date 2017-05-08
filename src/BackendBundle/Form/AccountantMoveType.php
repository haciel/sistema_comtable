<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountantMoveType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('companyId',null,['label' => 'accountantMove.companyId'])
            ->add('date',null,['label' => 'accountantMove.date'])
            ->add('slipeNumber',null,['label' => 'accountantMove.slipeNumber'])
            ->add('slipeId',null,['label' => 'accountantMove.slipeId'])
            ->add('description',null,['label' => 'accountantMove.description']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\AccountantMove'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_accountantMove';
    }


}
