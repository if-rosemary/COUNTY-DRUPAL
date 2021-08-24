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
class WashcoCommands extends BltTasks
{

  /**
   * Get latest version of develop build.
   *
   * @command custom:catchup
   * @description Syncs and builds from the latest develop branch and environment.
   */
  public function catchup()
  {
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
    shell_exec("composer install --working-dir ~/project && composer update --lock  --working-dir ~/project");
    $this->say("Syncing database...");
    shell_exec("acli pull:database wcor.dev");
    $this->say("Syncing files...");
    shell_exec("acli pull:files wcor.dev");
    $this->say("Deploying site...");
    shell_exec("blt drupal:config:import");
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
   * @command custom:secret
   * @description Syncs secrets.settings.php from develop.
   */
  public function secret($cd = null)
  {
    $this->say("Downloading secrets from wcor.dev...");
    shell_exec("scp -pr wcor.dev@wcordev.ssh.prod.acquia-sites.com:/mnt/gfs/wcor.dev/nobackup /mnt/gfs/wcor.ide");

    if ($cd) {
      $this->say("Uploading secrets to wcor.ode" . $cd . "...");
      shell_exec("scp -pr /mnt/gfs/wcor.ide/nobackup wcor.ode" . $cd . "@wcorode" . $cd . ".ssh.prod.acquia-sites.com:/mnt/gfs/wcor.ode" . $cd);
    }
  }

  /**
   * Export display configurations for entities.
   *
   * @command custom:dex
   * @description Export form and view display configurations for entities.
   */
  public function dex()
  {
    $this->say("Dropping local database...");
    shell_exec('blt internal:drupal:install -n');
    $this->say("Importing existing local configurations. Might take a minute...");
    shell_exec('blt drupal:config:import');
    $this->say("Exporting corrected display configs...");
    shell_exec('drush cex -y');
    $this->say("Importing develop database backup...");
    shell_exec('acli pull:database @wcor.dev');
    $this->say("Importing corrected configuration exports...");
    shell_exec('blt drupal:config:import');
  }

  /**
   * Get one time user login for Acquia ODEs.
   *
   * @command custom:ode:uli
   * @description SSH and drush uli a ODE.
   */
  public function ode_uli($cd)
  {
    $this->secret($cd);
    $this->say("Grabbing user login from wcor.ode" . $cd . "...");
    $url = shell_exec('acli remote:dr @wcor.ode' . $cd . ' uli && exit');
    $url = explode('/default', $url);
    if ($url[1]) {
      print_r('https://wcorode' . $cd . '.prod.acquia-sites.com' . $url[1]);
      $this->say("The one time login URL has been generated above.");
    }
  }

  /**
   * Checkout a GitHub PR locally.
   *
   * @command custom:pr
   * @description Fetch and create a PR branch locally to review.
   */
  public function pr($pr)
  {
    $this->say("Fetching PR #" . $pr . " from GitHub...");
    shell_exec('git fetch upstream pull/' . $pr . '/head:PR' . $pr);
    $this->say("Checking out PR branch...");
    shell_exec('git checkout PR' . $pr);
  }
}
