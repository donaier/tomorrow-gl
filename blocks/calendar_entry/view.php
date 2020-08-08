<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<?php
  $calendar = Concrete\Core\Calendar\Calendar::getByID($calendar_id);
?>

<div>
  <form method="post" action="<?= $view->action('new_entry') ?>">

    <div class="form-group">
      <label class="control-label" for="start_date">Wann:</label>
      <input type="date" name="date" class="form-control"/>
    </div>
    <div class="form-group">
      <label class="control-label" for="start_time">Von:</label>
      <input type="time" name="start_time" class="form-control"/>
    </div>
    <div class="form-group">
      <label class="control-label" for="end_time">Bis:</label>
      <input type="time" name="end_time" class="form-control"/>
    </div>
    <div class="form-group">
      <label class="control-label" for="author">Kontaktperson:</label>
      <input type="text" name="author" class="form-control"/>
    </div>
    <div class="form-group">
      <label class="control-label" for="title">Titel:</label>
      <input type="text" name="title" class="form-control"/>
    </div>
    <div class="form-group">
      <label class="control-label" for="comment">Beschreibung:</label>
      <textarea name="comment" class="form-control"></textarea>
    </div>
    
    <button class="btn btn-primary">
      Anfragen
    </button>
  </form>
</div>