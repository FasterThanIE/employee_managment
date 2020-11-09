<?php

namespace App\Command\User;

use App\Entity\User;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeactivateOldAccountsCommandsCommand extends Command
{
    protected static $defaultName = 'user:deactivate_old_users';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('This command is used to deactivate user account if they are inactive for more than 30 days');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = [];
        $em = $this->container->get('doctrine')->getManager();

        $users = $em->getRepository(User::class)->getUsersOlderThan(User::INVALID_ACCOUNT_AFTER);

        foreach ($users as $user) {
            $user->setStatus(User::USER_STATUS_INACTIVE);
            $em->persist($user);
            $output->writeln("User " . $user->getId() . " has been deactivated due to inactivity.");
        }

        $em->flush();

        return Command::SUCCESS;
    }
}
