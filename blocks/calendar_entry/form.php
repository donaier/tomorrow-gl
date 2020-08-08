<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

?>


<div class="form-group">
  <label class="control-label" for="calendar_id">In welchem Kalender sollen die Einträge erstellt werden?</label>
  <br>
  <br>
  <div class="text-center">
    <select name="calendar_id">
      <?php 
      foreach ($calendars as $calendar) {
        ?>
        <option value="<?=$calendar->getID()?>" <?= $calendar->getID() == $calendar_id ? 'selected' : ''?>><?=$calendar->getName()?></option>
      <?php
      }
      ?>
    </select>
  </div>
</div>
