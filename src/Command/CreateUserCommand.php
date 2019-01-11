<?php

namespace App\Command;

use App\Entity\Logistician;
use App\Entity\Manager;
use App\Entity\Printer;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
// command example
    //php bin/console app:user:create username password ROLE_MANAGER
    public function configure()
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Create a new user')
            ->addArgument('name', InputArgument::REQUIRED, 'The username of the user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user')
            ->addArgument('role', InputArgument::REQUIRED, 'The user role');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        /** @var EntityManagerInterface $em */
        $em = $container->get('doctrine.orm.default_entity_manager');
        $passwordPlain = $input->getArgument('password');
        $name = $input->getArgument('name');
        $role = $input->getArgument('role');

        $user = $this->createUser($role);

        $user->setUsername($name);
        $user->setUsernameCanonical($name);
        $user->setEmail($name . "@crm.com");
        $user->setEmailCanonical($name . "@crm.com");
        $user->setEnabled(true);

        $password = $container->get('security.password_encoder')
            ->encodePassword($user, $passwordPlain);

        $user->setPassword($password);

        $em->persist($user);
        $em->flush();

        $output->writeln("<info>user with name={$name} and password={$passwordPlain}, role= {$role} has been successfully created</info>");
    }
    /**
     * @param $role
     * @return Manager|Logistician|Printer
     * @throws \Exception
     */
    private function createUser($role)
    {
        switch ($role) {
            case User::ROLE_LOGISTICIAN: return new Logistician();
            case User::ROLE_PRINTER: return new Printer();
            case User::ROLE_MANAGER: return new Manager();
            default: throw new \Exception('Unsupported role '. $role);
        }
    }
}