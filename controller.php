<?php 

namespace Concrete\Package\Tomorrow;

use Concrete\Core\Package\Package;
use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package
{
  protected $pkgHandle = 'tomorrow'; 
  protected $appVersionRequired = '5.7.5.6';
  protected $pkgVersion = '0.0.5';

  public function getPackageDescription() {
    return t("tomorrow glarus");
  }

  public function getPackageName() {
    return t("tomorrow");
  }

  public function install() {
    $pkg = parent::install();
    Theme::add('tomorrow', $pkg);
    
    $this->install_block_types($pkg);
    $this->install_single_pages($pkg);
  }

  public function upgrade() {
    parent::upgrade();
    $pkg = Package::getByHandle('tomorrow');

    $this->install_block_types($pkg);
    $this->install_single_pages($pkg);
  }

  public function uninstall() {
    $pkg = parent::uninstall();
  }

  function install_single_pages($pkg) {
    // $directoryDefault = SinglePage::add('/dashboard/sample_package/', $pkg);
    // $directoryDefault->update(array('cName' => t('Sample Package'), 'cDescription' => t('Sample Package')));
  }

  function install_block_types() {
    $pkg = Package::getByHandle('tomorrow');

    foreach (['calendar_entry'] as $btHandle) {
      $bt = BlockType::getByHandle($btHandle);
      if (!is_object($bt)) {
        $bt = BlockType::installBlockTypeFromPackage($btHandle, $pkg);
      }
    }
  }
}