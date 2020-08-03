<?php 

namespace Concrete\Package\Tomorrow;

use Concrete\Core\Package\Package;
use Concrete\Core\Page\Theme\Theme;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package
{
    protected $pkgHandle = 'tomorrow'; 
    protected $appVersionRequired = '5.7.5.6';
    protected $pkgVersion = '0.0.1';

    public function getPackageDescription()
    {
        return t("allerhand im glarnerland");
    }

    public function getPackageName()
    {
        return t("tomorrow");
    }

    public function install()
    {
        $pkg = parent::install();
        Theme::add('tomorrow', $pkg);

        $this->install_single_pages($pkg);
    }

    public function uninstall()
    {
        $pkg = parent::uninstall();
    }

    function install_single_pages($pkg)
    {
        // $directoryDefault = SinglePage::add('/dashboard/sample_package/', $pkg);
        // $directoryDefault->update(array('cName' => t('Sample Package'), 'cDescription' => t('Sample Package')));
    }

}