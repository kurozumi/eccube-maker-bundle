<?php
/**
 * This file is part of EccubeMakerBundle
 *
 * Copyright(c) Akira Kurozumi <info@a-zumi.net>
 *
 * https://a-zumi.net
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\EccubeMakerBundle\Maker;


use Plugin\EccubeMakerBundle\Generator\FormExtensionGenerator;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Doctrine\ORMDependencyBuilder;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

final class EccubeMakeFormExtension extends AbstractMaker
{
    /**
     * @var array
     */
    private $types;

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var Generator
     */
    private $generator;

    public function __construct(array $types = [], FileManager $fileManager, Generator $generator = null)
    {
        $this->types = $types;
        $this->fileManager = $fileManager;
        $this->generator = $generator;

        if (null === $generator) {
            @trigger_error(sprintf('Passing a "%s" instance as 3th argument is mandatory since version 1.5.', Generator::class), E_USER_DEPRECATED);
            $this->generator = new Generator($fileManager, 'App\\');
        } else {
            $this->generator = $generator;
        }
    }

    /**
     * Return the command name for your maker (e.g. make:report).
     *
     * @return string
     */
    public static function getCommandName(): string
    {
        return 'eccube:make:form-extension';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     *
     * @param Command $command
     * @param InputConfiguration $inputConfig
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription('Creates a ec-cube form extension')
            ->addArgument('name', InputArgument::OPTIONAL, sprintf('FQCN (e.g. <fg=yellow>%s</>)', 'Eccube\Form\Type\Front\EntryType'))
            ->setHelp(file_get_contents(__DIR__.'/../Resource/help/MakeFormExtension.txt'))
        ;

        $inputConfig->setArgumentAsNonInteractive('name');
    }

    /**
     * @param InputInterface $input
     * @param ConsoleStyle $io
     * @param Command $command
     */
    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {
        if($input->getArgument('name')) {
            return;
        }

        $argument = $command->getDefinition()->getArgument('name');
        $question = $this->createFormTypeClassQuestion($argument->getDescription());
        $value = $io->askQuestion($question);

        $input->setArgument('name', $value);
    }

    /**
     * Configure any library dependencies that your maker requires.
     *
     * @param DependencyBuilder $dependencies
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->requirePHP71();

        ORMDependencyBuilder::buildDependencies($dependencies);
    }

    /**
     * Called after normal code generation: allows you to do anything.
     *
     * @param InputInterface $input
     * @param ConsoleStyle $io
     * @param Generator $generator
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        // TODO: Implement generate() method.
        $extendedFullClassName = $input->getArgument('name');

        $explodeExtendedFullClassName = explode('\\', $extendedFullClassName);
        $extendedShortClassName = array_pop($explodeExtendedFullClassName);

        $formTypeClassNameDetails = $generator->createClassNameDetails(
            $extendedShortClassName,
            'Form\\Extension\\',
            'Extension'
        );

        $classExists = class_exists($formTypeClassNameDetails->getFullName());
        if (!$classExists) {
            $formExtensionGenerator = new FormExtensionGenerator($generator);
            $entityPath = $formExtensionGenerator->generateFormExtension(
                $formTypeClassNameDetails,
                $extendedFullClassName,
                $extendedShortClassName
            );

            $generator->writeChanges();

            $this->writeSuccessMessage($io);
        }else{
            $io->error([
                'Your form extension already exists!',
            ]);
        }
    }

    private function createFormTypeClassQuestion(string $questionText): Question
    {
        $question = new Question($questionText);
        $question->setValidator([Validator::class, 'notBlank']);
        $question->setAutocompleterValues($this->types);

        return $question;
    }
}
