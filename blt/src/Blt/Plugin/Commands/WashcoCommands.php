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
    $this->say("Unlocking permissions...");
    shell_exec("chmod 644 ~/project/docroot/sites/default/settings.php && chmod -R u+w ~/project/docroot/sites/default");
    $this->say("Checking out develop branch...");
    shell_exec("git checkout develop");
    $this->say("Pulling upstream repo...");
    shell_exec("git pull upstream develop");
    $this->say("Locking permissions...");
    shell_exec("chmod 444 ~/project/docroot/sites/default/settings.php");
    $this->say("Syncing Secrets...");
    shell_exec("scp wcor.dev@wcordev.ssh.prod.acquia-sites.com:/mnt/files/wcor.dev/secrets.settings.php /mnt/files/wcor.ide");
    $this->say("Running composer...");
    shell_exec("composer install --working-dir ~/project");
    $this->say("Syncing database...");
    shell_exec("acli pull:database wcor.dev");
    $this->say("Syncing files...");
    shell_exec("acli pull:files wcor.dev");
    $this->say("Deploying site...");
    shell_exec("drush deploy");
  }

  /**
   * Precheck build status.
   *
   * @command custom:check
   * @description Check build for errors.
   */
  public function check()
  {
    $this->say("Validate composer.json...");
    shell_exec("composer validate --no-check-all --ansi --working-dir ~/project");
    $this->say("Checking for config differences...");
    shell_exec("drush cst");
    $this->say("Checking for security updates...");
    shell_exec("blt tests:security-drupal && blt tests:security-composer");
  }

  /**
   * Sync secret settings.
   *
   * @command custom:secrets
   * @description Syncs secrets.settings.php from develop.
   */
  public function secrets()
  {
    $this->say("Syncing Secrets...");
    shell_exec("scp wcor.dev@wcordev.ssh.prod.acquia-sites.com:/mnt/files/wcor.dev/secrets.settings.php /mnt/files/wcor.ide");
  }

  /**
   * Get one time user login for CD environments.
   *
   * @command custom:cd
   * @description SSH and drush uli a CD ODE.
   */
  public function cd($cd)
  {
    $this->say("Grabbing user login from CD #$cd ...");
    passthru(shell_exec('ssh wcor.ode' . $cd . '@wcorode' . $cd . '.ssh.prod.acquia-sites.com -y "drush @wcor.ode' . $cd . ' uli && exit"'));
    $this->say("The URL has been generated above. Ensure that the colon at the end is removed when visiting the URL.");
  }

  /**
   * Checkout a GitHub PR locally.
   *
   * @command custom:pr
   * @description Fetch and create a PR branch locally to review.
   */
  public function pr($pr)
  {
    $this->say("Fetching PR #$pr from GitHub...");
    shell_exec( 'git fetch upstream pull/' . $pr . '/head:PR' . $pr );
    $this->say("Checking out PR branch...");
    shell_exec('git checkout PR' . $pr);
  }

}
