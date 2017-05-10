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
            ->add('name', null, ['label' => 'user.name'])
            ->add('lastname', null, ['label' => 'user.lastname'])
            ->add('phone', null, ['label' => 'user.phone'])
            ->add('dni', null, ['label' => 'user.dni'])
            ->add('institutionId', 'entity', array(
                'class' => 'BackendBundle:Institution',
                'query_builder' => function ($repository) {
                    return $repository->createQueryBuilder('p')->orderBy('p.id', 'ASC');
                },
                'property' => 'name',
                'label' => 'user.institutionId',
            ))
          ->add('educationallevelId', 'entity', array(
            'class' => 'BackendBundle:EducationalLevel',
            'query_builder' => function ($repository) {
                return $repository->createQueryBuilder('p')->orderBy('p.id', 'ASC');
            },
            'property' => 'title',
            'label' => 'user.educationallevelId',
          ))
          ->add('cityId', 'entity', array(
            'class' => 'BackendBundle:City',
            'query_builder' => function ($repository) {
                return $repository->createQueryBuilder('p')->orderBy('p.id', 'ASC');
            },
            'property' => 'name',
            'label' => 'user.cityId',
          ))
            ->add('username', null, ['label' => 'user.username'])
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
