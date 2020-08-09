<?php defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header_top.php');

$as = new GlobalArea('Header Search');
$blocks = $as->getTotalBlocksInArea();
$displayThirdColumn = $blocks > 0 || $c->isEditMode();
?>

<header>
  <div class="container-fluid">
    <!-- <div class="row"> -->
      <div class="main-logo"></div>
    <!-- </div> -->
  </div>
</header>
