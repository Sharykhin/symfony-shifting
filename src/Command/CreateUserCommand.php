<?php

namespace App\Command;

use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Output\OutputInterface;
use App\Contract\Service\User\UserRetrieverInterface;
use App\Contract\Service\Validate\ValidateInterface;
use Symfony\Component\Console\Input\InputInterface;
use App\Contract\Service\User\UserCreateInterface;
use App\Request\Constraint\User\CreateConstraint;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Command\Command;
use App\Request\Type\User\UserCreateType;
use App\ValueObject\ValidatorBag;
use DateTimeImmutable;

/**
 * Class CreateUserCommand
 * @package App\Command
 */
class CreateUserCommand extends Command
{
    const ROLES = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ACCOUNTANT'];

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    /** @var UserCreateInterface $userCreate */
    protected $userCreate;

    /** @var UserRetrieverInterface $userRetriever */
    protected $userRetriever;

    /** @var ValidateInterface $validate */
    protected $validate;

    /**
     * CreateUserCommand constructor.
     * @param UserCreateInterface $userCreate
     * @param UserRetrieverInterface $userRetriever
     * @param ValidateInterface $validate
     */
    public function __construct(
        UserCreateInterface $userCreate,
        UserRetrieverInterface $userRetriever,
        ValidateInterface $validate
    )
    {
        $this->userCreate = $userCreate;
        $this->userRetriever = $userRetriever;
        $this->validate = $validate;

        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {

        $output->writeln('
            <comment>I am going to ask you a couple of questions, so be patient, actually you have no choice!</comment>
        ');

        $email = $this->fillEmail($input, $output);
        $firstName = $this->fillFirstName($input, $output);
        $lastName = $this->fillLastName($input, $output);
        $password = $this->fillPassword($input, $output);
        $roles = $this->fillRoles($input, $output);
        $activated = $this->fillActivated($input, $output);

        $userCreateType = new UserCreateType([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'roles' => $roles,
            'activated' => $activated,
            'password' => $password,
        ]);

        /** @var ValidatorBag $validatorBag */
        $validatorBag = $this->validate->validate(
            $userCreateType->toArray(),
            CreateConstraint::class,
            ['creating']
        );

        if (!$validatorBag->isValid()) {
            $errors = [];
            foreach ($validatorBag->getErrors() as $key => $value) {
                $errors[] = "<fg=red>{$key}: {$value}</>";
            }
            $output->writeln($errors);
            exit(1);
        }

        $user = $this->userCreate->create($userCreateType);

        $output->writeln('<fg=green>Great! your user id: '. $user->getId() . '</>');
        exit(0);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
     */
    protected function fillEmail(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');

        $question = new Question('<question>Please enter the email:</question> ', '');
        $email = trim($helper->ask($input, $output, $question));
        if ($this->userRetriever->existsEmail($email)) {
            $output->writeln('<fg=red>Uoops! Looks like this email is already in use</>');
            $question = new ConfirmationQuestion('<info>Hey man don\'t worry and let\'s try again?</info> ', false);
            if (!$helper->ask($input, $output, $question)) {
                $this->leave($output);
            } else {
                return $this->fillEmail($input, $output);
            }
        }

        return $email;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
     */
    protected function fillFirstName(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');

        $question = new Question('<question>Please enter the first name:</question> ', '');
        $firstName = trim($helper->ask($input, $output, $question));

        return $firstName;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
     */
    protected function fillPassword(InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');

        $question = new Question('<question>Please enter the password:</question> ', '');
        $password = trim($helper->ask($input, $output, $question));

        return $password;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null|string
     */
    protected function fillLastName(InputInterface $input, OutputInterface $output): ?string
    {
        $helper = $this->getHelper('question');

        $question = new Question('<question>Please enter the last name (optional):</question> ', '');
        $lastName = trim($helper->ask($input, $output, $question));

        return empty($lastName) === '' ? null : $lastName;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array
     */
    protected function fillRoles(InputInterface $input, OutputInterface $output): array
    {
        $helper = $this->getHelper('question');

        $question = new Question('<question>Please enter the roles (ROLE_USER, ROLE_ADMIN, ROLE_ACCOUNTANT):</question> ', 'ROLE_USER');
        $roles = trim($helper->ask($input, $output, $question));
        $roles = explode(',', $roles);

        $invalidRoles = array_diff($roles, self::ROLES);
        if (!empty($invalidRoles)) {
            $output->writeln('<fg=red>Uoops! Looks like one of the specified role is invalid</>');
            $question = new ConfirmationQuestion('<info>Hey man don\'t worry and let\'s try again?</info> ', false);
            if (!$helper->ask($input, $output, $question)) {
                $this->leave($output);
            } else {
                return $this->fillRoles($input, $output);
            }
        }

        return $roles;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return DateTimeImmutable|null
     */
    protected function fillActivated(InputInterface $input, OutputInterface $output): ?DateTimeImmutable
    {
        $helper = $this->getHelper('question');

        $question = new ConfirmationQuestion('<question>Would you like to activate this user now?</question> ', true);
        if ($helper->ask($input, $output, $question)) {
            return new DateTimeImmutable('now');
        }

        return null;
    }

    /**
     * @param OutputInterface $output
     */
    protected function leave(OutputInterface $output): void
    {
        $output->writeln('<fg=green>So it\'s pretty sad, see you again, bye!</>');
        exit(0);
    }
}
