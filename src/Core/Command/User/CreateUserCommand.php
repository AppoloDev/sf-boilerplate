<?php

namespace App\Core\Command\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('user:create')]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly UserManager $userManager,
        private readonly EntityManagerInterface $entityManager,
        ?string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Creation d\'un utilisateur');

        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $roleQuestion = (new ChoiceQuestion('Select user role', ['ROLE_USER', 'ROLE_ADMIN'], 0));
        $emailQuestion = (new Question('What\'s your email ?'));
        $firstnameQuestion = (new Question('What\'s your firstname ?'));
        $lastnameQuestion = (new Question('What\'s your lastname ?'));
        $passwordQuestion = (new Question('What\'s your password ?'));

        /** @var string $email */
        $email = $helper->ask($input, $output, $emailQuestion);
        /** @var string $firstname */
        $firstname = $helper->ask($input, $output, $firstnameQuestion);
        /** @var string $lastname */
        $lastname = $helper->ask($input, $output, $lastnameQuestion);
        /** @var string $password */
        $password = $helper->ask($input, $output, $passwordQuestion);
        $role = $helper->ask($input, $output, $roleQuestion);

        $user = (new User())
            ->setEmail($email)
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setRoles([$role])
            ->setPlainPassword($password)
        ;

        $this->userManager->upgradePassword($user);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('Utilisateur créé avec succès.');

        return Command::SUCCESS;
    }
}
