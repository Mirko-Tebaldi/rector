<?php

declare (strict_types=1);
namespace RectorPrefix20211215;

use RectorPrefix20211215\SebastianBergmann\Diff\Differ;
use RectorPrefix20211215\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use RectorPrefix20211215\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20211215\Symplify\PackageBuilder\Composer\VendorDirProvider;
use RectorPrefix20211215\Symplify\PackageBuilder\Yaml\ParametersMerger;
use RectorPrefix20211215\Symplify\SmartFileSystem\Json\JsonFileSystem;
use RectorPrefix20211215\Symplify\VendorPatches\Command\GenerateCommand;
use function RectorPrefix20211215\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('RectorPrefix20211215\Symplify\\VendorPatches\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    $services->set(\RectorPrefix20211215\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->args(['$addLineNumbers' => \true]);
    $services->set(\RectorPrefix20211215\SebastianBergmann\Diff\Differ::class)->args(['$outputBuilder' => \RectorPrefix20211215\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20211215\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)]);
    $services->set(\RectorPrefix20211215\Symplify\PackageBuilder\Composer\VendorDirProvider::class);
    $services->set(\RectorPrefix20211215\Symplify\SmartFileSystem\Json\JsonFileSystem::class);
    $services->set(\RectorPrefix20211215\Symfony\Component\Console\Application::class)->call('addCommands', [[\RectorPrefix20211215\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20211215\Symplify\VendorPatches\Command\GenerateCommand::class)]]);
    $services->set(\RectorPrefix20211215\Symplify\PackageBuilder\Yaml\ParametersMerger::class);
};
