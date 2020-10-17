<?php

/*
 * This file is part of the Acme PHP project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AcmePhp\Cli;

use AcmePhp\Cli\Command\Helper\DistinguishedNameHelper;
use AcmePhp\Cli\Command\RevokeCommand;
use AcmePhp\Cli\Command\RunCommand;
use AcmePhp\Cli\Command\SelfUpdateCommand;
use AcmePhp\Cli\Command\StatusCommand;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputOption;
use Webmozart\PathUtil\Path;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class Application extends BaseApplication
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('Acme PHP - Let\'s Encrypt/ZeroSSL client', '');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        return array_merge(parent::getDefaultCommands(), [
            new RunCommand(),
            new RevokeCommand(),
            new StatusCommand(),
            new SelfUpdateCommand(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultHelperSet()
    {
        $set = parent::getDefaultHelperSet();
        $set->set(new DistinguishedNameHelper());

        return $set;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();

        $definition->addOption(new InputOption(
            'server',
            null,
            InputOption::VALUE_REQUIRED,
            'Set the ACME server directory to use',
            'https://acme-v02.api.letsencrypt.org/directory'
        ));

        return $definition;
    }

    /**
     * @return string
     */
    public function getConfigFile()
    {
        return Path::canonicalize('~/.acmephp/acmephp.conf');
    }

    /**
     * @return string
     */
    public function getConfigReferenceFile()
    {
        return Path::canonicalize(__DIR__.'/../../res/acmephp.conf.dist');
    }

    /**
     * @return string
     */
    public function getStorageDirectory()
    {
        return Path::canonicalize('~/.acmephp/master');
    }
}
