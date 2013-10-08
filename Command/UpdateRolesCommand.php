<?php

namespace ITE\SecurityBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ITE\SecurityBundle\Entity\Role;

/**
 * Class UpdateRolesCommand
 * @package ITE\SecurityBundle\Command
 */
class UpdateRolesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ite:security:roles:update')
            ->setDescription('Update roles in database')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $roles = $this->getContainer()->getParameter('security.role_hierarchy.roles');

        $confRoles = array_keys($roles);

        $output->writeln(sprintf('There are %d roles in the config file.', count($confRoles)));

        /** @var $em EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $dbRoles = $em->getRepository('ITESecurityBundle:Role')->findAllIndexedByName();

        $output->writeln(sprintf('There are %d roles in the database.', count($dbRoles)));

        $newRoles = array_diff($confRoles, array_keys($dbRoles));
        $output->writeln(sprintf('There are %d new roles.', count($newRoles)));

        $removedRoles = array_diff(array_keys($dbRoles), $confRoles);
        $output->writeln(sprintf('There are %d removed roles.', count($removedRoles)));

        // add new roles
        foreach ($newRoles as $roleName) {
            $role = new Role();
            $role->setName($roleName);

            $em->persist($role);
        }

        // remove roles
        foreach ($removedRoles as $roleName) {
            $em->remove($dbRoles[$roleName]);
        }

        $em->flush();
    }
}