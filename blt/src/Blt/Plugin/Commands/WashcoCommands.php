<?php

namespace Washco\Blt\Plugin\Commands;

use Acquia\Blt\Robo\BltTasks;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Acquia\Blt\Robo\Blt;
use Acquia\Blt\Robo\Common\UserConfig;
use Acquia\Blt\Robo\Exceptions\BltException;
use Symfony\Component\Yaml\Yaml;
use Zumba\Amplitude\Amplitude;

/**
 * Defines commands in the "custom" namespace.
 */
class WashcoCommands extends BltTasks {

  /**
   * Get latest version of develop build.
   *
   * @command custom:catchup
   * @description Syncs and builds from the latest develop branch and environment.
   */
  public function catchup() {
    $this->say( "Checking out develop branch..." );
    shell_exec( "git checkout develop" );
    $this->say( "Unlocking permissions..." );
    shell_exec( "chmod 644 docroot/sites/default/settings.php && chmod -R u+w docroot/sites/default" );
    $this->say( "Pulling upstream repo..." );
    shell_exec( "git pull upstream develop" );
    $this->say( "Locking permissions..." );
    shell_exec( "chmod 444 docroot/sites/default/settings.php" );
    $this->say( "Syncing database..." );
    shell_exec( "acli pull:database wcor.dev" );
    $this->say( "Running composer..." );
    shell_exec( "composer install" );
    $this->say( "Deploying site..." );
    shell_exec( "drush deploy" );
  }

}
