<?php

/*
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

use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputAwareMakerInterface;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\BrowserKit\History;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\CssSelector\CssSelectorConverter;

final class EccubeMakeTest extends AbstractMaker implements InputAwareMakerInterface
{
    private const DESCRIPTIONS = [
        'TestCase' => 'basic PHPUnit tests',
        'KernelTestCase' => 'basic tests that have access to Symfony services',
        'WebTestCase' => 'to run browser-like scenarios, but that don\'t execute JavaScript code',
        'ShoppingControllerTestCase' => 'to run browser-like scenarios for shopping controller, but that don\'t execute JavaScript code',
    ];
    private const DOCS = [
        'TestCase' => 'https://symfony.com/doc/current/testing.html#unit-tests',
        'KernelTestCase' => 'https://symfony.com/doc/current/testing/database.html#functional-testing-of-a-doctrine-repository',
        'WebTestCase' => 'https://symfony.com/doc/current/testing.html#functional-tests',
        'ShoppingControllerTestCase' => 'https://github.com/EC-CUBE/ec-cube/blob/4.3/tests/Eccube/Tests/Web/ShoppingControllerTest.php',
    ];

    public static function getCommandName(): string
    {
        return 'eccube:make:test';
    }

    public static function getCommandDescription(): string
    {
        return 'Create a new test class';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $typesDesc = [];
        $typesHelp = [];
        foreach (self::DESCRIPTIONS as $type => $desc) {
            $typesDesc[] = sprintf('<fg=yellow>%s</> (%s)', $type, $desc);
            $typesHelp[] = sprintf('* <info>%s</info>: %s', $type, $desc);
        }

        $command
            ->addArgument('type', InputArgument::OPTIONAL, 'The type of test: ' . implode(', ', $typesDesc))
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the test class (e.g. <fg=yellow>BlogPostTest</>)')
            ->setHelp(file_get_contents(__DIR__ . '/../Resource/help/MakeTest.txt') . implode("\n", $typesHelp));

        $inputConfig->setArgumentAsNonInteractive('name');
        $inputConfig->setArgumentAsNonInteractive('type');
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command): void
    {
        if (null !== $type = $input->getArgument('type')) {
            if (!isset(self::DESCRIPTIONS[$type])) {
                throw new RuntimeCommandException(sprintf('The test type must be one of "%s", "%s" given.', implode('", "', array_keys(self::DESCRIPTIONS)), $type));
            }
        } else {
            $input->setArgument(
                'type',
                $io->choice('Which test type would you like?', self::DESCRIPTIONS)
            );
        }

        if (null === $input->getArgument('name')) {
            $io->writeln([
                '',
                'Choose a class name for your test, like:',
                ' * <fg=yellow>UtilTest</> (to create tests/UtilTest.php)',
                ' * <fg=yellow>Service\\UtilTest</> (to create tests/Service/UtilTest.php)',
                ' * <fg=yellow>\\App\Tests\\Service\\UtilTest</> (to create tests/Service/UtilTest.php)',
            ]);

            $nameArgument = $command->getDefinition()->getArgument('name');
            $value = $io->ask($nameArgument->getDescription(), $nameArgument->getDefault(), Validator::notBlank(...));
            $input->setArgument($nameArgument->getName(), $value);
        }
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $testClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            'Tests\\',
            'Test'
        );

        $type = $input->getArgument('type');

        $generator->generateClass(
            $testClassNameDetails->getFullName(),
            __DIR__ . "/../Resource/skeleton/test/$type.tpl.php",
            [
                'web_assertions_are_available' => trait_exists(WebTestAssertionsTrait::class),
            ]
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Next: Open your new test class and start customizing it.',
            sprintf('Find the documentation at <fg=yellow>%s</>', self::DOCS[$type]),
        ]);
    }

    public function configureDependencies(DependencyBuilder $dependencies, ?InputInterface $input = null): void
    {
        if (null === $input) {
            return;
        }

        switch ($input->getArgument('type')) {
            case 'WebTestCase':
                $dependencies->addClassDependency(
                    History::class,
                    'browser-kit',
                    true,
                    true
                );
                $dependencies->addClassDependency(
                    CssSelectorConverter::class,
                    'css-selector',
                    true,
                    true
                );

                return;
        }
    }
}
