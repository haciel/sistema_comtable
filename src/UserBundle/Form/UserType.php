<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_user';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, ['label' => 'user.name'])
            ->add('email', null, ['label' => 'user.email'])
            ->add('password', 'Symfony\Component\Form\Extension\Core\Type\PasswordType', ['label' => 'user.password'])
            ->add('roles', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
                'multiple' => true,
                'choices' => [
                    'ROLE_ADMIN' => 'Usuario',
                    'ROLE_SUPER_ADMIN' => 'Administrador'
                ],
                'label' => 'user.roll'
            ])
            ->add('enabled',null,['label'=>'user.enabled'])
            ->add('locked',null,['label'=>'user.locked'])
        ;
    }


}
