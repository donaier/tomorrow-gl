<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<?php
  $calendar = Concrete\Core\Calendar\Calendar::getByID($calendar_id);
?>

<form method="post" action="<?= $view->action('new_entry') ?>" class="needs-validation">
  <div class="row">
    <div class="col col-sm-12 col-lg-6">
      <div class="row form-group">
        <div class="col col-xs-2">
          <label class="control-label" for="start_date">Wann:</label>
        </div>
        <div class="col col-xs-10">
          <input type="date" name="date" class="form-control" required/>
        </div>
      </div>

      <div class="row form-group">
        <div class="col col-xs-2">
          <label class="control-label" for="start_time">Von:</label>
        </div>
        <div class="col col-xs-4">
          <input type="time" name="start_time" class="form-control" required/>
        </div>
          <div class="col col-xs-2">
            <label class="control-label" for="end_time">Bis:</label>
          </div>
          <div class="col col-xs-4">
            <input type="time" name="end_time" class="form-control" required/>
        </div>
      </div>

    </div>
    <div class="col col-sm-12 col-lg-6">
      <div class="form-group">
        <input type="text" name="author" class="form-control" placeholder="Kontaktperson:" required/>
      </div>
      <div class="form-group">
        <input type="text" name="title" class="form-control" placeholder="Titel:" required/>
      </div>
      <div class="form-group">
        <textarea name="comment" class="form-control" placeholder="Beschreibung:" required></textarea>
      </div>
    </div>
  </div>
  
  <div class="col text-center">
    <button class="btn btn-primary">
      Anfragen
    </button>
  </div>
</form>

<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>