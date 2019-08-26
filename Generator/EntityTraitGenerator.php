<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\EccubeMakerBundle\Generator;

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;

/**
 * @internal
 * @author Akira Kurozumi <info@a-zumi.net>
 */
final class EntityTraitGenerator
{
    private $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function generateEntityTrait(ClassNameDetails $entityClassDetails, string $entityExtention): string
    {
        $entityPath = $this->generator->generateClass(
            $entityClassDetails->getFullName(),
            __DIR__.'/../Resource/skeleton/doctrine/EntityTrait.tpl.php',
            [
                'entity_extension' => $entityExtention,
            ]
        );

        return $entityPath;
    }
}
