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

$container->addCompilerPass(new \Plugin\EccubeMakerBundle\DependencyInjection\Compiler\FormPass());
