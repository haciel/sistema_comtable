<?php

namespace BackendBundle\DataFixtures\ORM\Seeds;


use BackendBundle\DataFixtures\AbstractDataFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use BackendBundle\Entity\AccountType;

class AccountTypeSeed extends AbstractDataFixture
{

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 0;
    }

    /**
     * Perform the database objects
     * @param ObjectManager $manager The object manager.
     */
    protected function doLoad(ObjectManager $manager)
    {
        $tipos = [
            [
                'name' => 'Agrupación',
            ],
            [
                'name' => 'Movimiento',
            ]
        ];
        foreach ($tipos as $item) {
            $entity = new AccountType();
            $entity->setName($item['name']);

            $manager->persist($entity);
            $manager->flush();
        }
    }

    /**
     * Get the environments the data fixtures are ran on
     * @return array The name of the environments.
     */
    protected function getEnvironments()
    {
        return ['dev'];
    }

}