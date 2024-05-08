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

namespace Plugin\EccubeMakerBundle\Generator;

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;

final class EntityClassGenerator
{
    private Generator $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param ClassNameDetails $entityClassDetails
     * @return string
     * @throws \Exception
     */
    public function generateEntityClass(ClassNameDetails $entityClassDetails): string
    {
        $repoClassDetails = $this->generator->createClassNameDetails(
            $entityClassDetails->getRelativeName(),
            'Repository\\',
            'Repository'
        );

        $entityPath = $this->generator->generateClass(
            $entityClassDetails->getFullName(),
            __DIR__.'/../Resource/skeleton/doctrine/Entity.tpl.php',
            [
                'table_name' => $this->generateTableName($entityClassDetails),
                'repository_full_class_name' => $repoClassDetails->getFullName(),
            ]
        );

        $entityAlias = strtolower($entityClassDetails->getShortName()[0]);
        $this->generator->generateClass(
            $repoClassDetails->getFullName(),
            __DIR__.'/../Resource/skeleton/doctrine/Repository.tpl.php',
            [
                'entity_full_class_name' => $entityClassDetails->getFullName(),
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_alias' => $entityAlias,
            ]
        );

        return $entityPath;
    }

    /**
     * @param ClassNameDetails $entityClassDetails
     * @return string
     */
    protected function generateTableName(ClassNameDetails $entityClassDetails): string
    {
        return Str::asSnakeCase(
            $this->generator->getRootNamespace().'\\'.$entityClassDetails->getShortName()
        );
    }
}
