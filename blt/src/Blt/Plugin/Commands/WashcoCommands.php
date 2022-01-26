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

  // Determines appropriate environment and sets values.
  public function envsetup(){
    // Default directory for Drupal in ACP is ~/project
    $envdir = '~/project';
    // If environment is Lando:
    if ($_ENV['AH_SITE_ENVIRONMENT'] == "LANDO"){
      $envdir = '/app';
    }
    return $envdir;
  }

  /**
   * Get latest version of develop build.
   *
   * @command custom:catchup
   * @description Syncs and builds from the latest develop branch and environment.
   */
  public function catchup()
  {

    $envdir = $this->envsetup();

    $this->say("Unlocking permissions...");
    shell_exec("chmod 644 " . $envdir . "/docroot/sites/default/settings.php && chmod -R u+w " . $envdir . "/docroot/sites/default");
    $this->say("Checking out develop branch...");
    shell_exec("git checkout develop");
    $this->say("Pulling upstream repo...");
    shell_exec("git pull upstream develop");
    $this->say("Locking permissions...");
    shell_exec("chmod 444 " . $envdir . "/docroot/sites/default/settings.php");
    $this->say("Syncing Secrets...");
    $this->secret();
    $this->say("Running composer...");
    shell_exec("composer install --working-dir " . $envdir . " && composer update --lock  --working-dir " . $envdir . "");
    $this->say("Syncing database...");
    shell_exec("acli pull:database wcor.dev");
    $this->say("Syncing files...");
    shell_exec("acli pull:files wcor.dev");
    $this->say("Deploying site...");
    shell_exec("blt drupal:config:import");
    shell_exec("drush deploy");
    $this->say("Importing structures...");
    shell_exec("drush ia --choice='safe'");
    $this->say("Building theme assets...");
    $this->theme_build();
  }

  /**
   * Build subtheme assets.
   *
   * @command custom:theme:build
   * @description Installs and builds radix subtheme via npm.
   */
  public function theme_build()
  {
    $envdir = $this->envsetup();

    if ($_ENV['AH_SITE_ENVIRONMENT'] == "LANDO"){
      $this->say("Skipping for Lando. Run 'lando build-theme' manually...");
    }
    else {
      $this->say("Installing package dependencies...");
      shell_exec("npm install --prefix " . $envdir . "/docroot/themes/custom/westy/");
      $this->say("Building assets...");
      shell_exec("npm run production --prefix " . $envdir . "/docroot/themes/custom/westy/");
    }
  }

  /**
   * Precheck build status.
   *
   * @command custom:check
   * @description Check build for errors.
   */
  public function check()
  {
    $envdir = $this->envsetup();

    $this->say("Validate composer.json...");
    shell_exec("composer validate --no-check-all --ansi --working-dir " . $envdir);
    $this->say("Checking for config differences...");
    shell_exec("drush cst");
    $this->say("Checking for security updates...");
    shell_exec("blt tests:security-drupal && blt tests:security-composer");
  }

  /**
   * Sync secret settings.
   *
   * @command custom:secret
   * @description Syncs secrets.settings.php from wcor.dev.
   */
  public function secret($cd = null)
  {
    $envid = 'local';
    if ($_ENV['AH_SITE_ENVIRONMENT'] && $_ENV['AH_SITE_GROUP']){
      $envid = $_ENV['AH_SITE_GROUP'] . '.' . $_ENV['AH_SITE_ENVIRONMENT'];
    }


    $envdir = '/mnt/gfs/' . $envid;
    $this->say("Downloading secrets from wcor.dev...");
    shell_exec("scp -o 'StrictHostKeyChecking=no' -pr wcor.dev@wcordev.ssh.prod.acquia-sites.com:/mnt/gfs/wcor.dev/nobackup " . $envdir);

    if ($cd) {
      $this->say("Uploading secrets to wcor.ode" . $cd . "...");
      shell_exec("scp -o 'StrictHostKeyChecking=no' -pr " . $envdir . "/nobackup wcor.ode" . $cd . "@wcorode" . $cd . ".ssh.prod.acquia-sites.com:/mnt/gfs/wcor.ode" . $cd);
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
