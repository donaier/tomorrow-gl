<?php defined('C5_EXECUTE') or die('Access Denied.');

if (!isset($calendar) || !is_object($calendar)) {
    $calendar = null;
}
$c = Page::getCurrentPage();
if ($c->isEditMode()) {
    $loc = Localization::getInstance();
    $loc->pushActiveContext(Localization::CONTEXT_UI);
    ?><div class="ccm-edit-mode-disabled-item"><?=t('Calendar disabled in edit mode.')?></div><?php
    $loc->popActiveContext();
} elseif ($calendar !== null && $permissions->canViewCalendar()) { ?>
    <div class="ccm-block-calendar-wrapper hidden-xs" data-calendar="<?=$bID?>" id="cal-month"></div>
    <div class="ccm-block-calendar-wrapper visible-xs-block" data-calendar="<?=$bID?>" id="cal-month-list"></div>

    <script>
        $(function() {
            $('#cal-month').fullCalendar({
                dateFormat: 'H:mm',
                header: {
                    left: 'prev,next today',
                    center: '',
                    right: 'title'
                },
                locale: <?= json_encode(Localization::activeLanguage()); ?>,
                views: {
                    listDay: { buttonText: '<?= t('list day'); ?>' },
                    listWeek: { buttonText: '<?= t('list week'); ?>' },
                    listMonth: { buttonText: '<?= t('list month'); ?>' },
                    listYear: { buttonText: '<?= t('list year'); ?>' }
                },
                contentHeight: 'auto',

                <?php if ($defaultView) { ?>
                    defaultView: 'month',
                <?php } ?>
                <?php if ($navLinks) { ?>
                    navLinks: true,
                <?php } ?>
                <?php if ($eventLimit) { ?>
                    eventLimit: true,
                <?php } ?>

                events: '<?=$view->action('get_events')?>',
                nextDayThreshold: '00:00:00',
                eventDataTransform: function(event) {
                    if(event.allDay) {
                        event.end = moment(event.end).add(1, 'days')
                    }
                    return event;
                },

                eventRender: function(event, element) {
                    <?php if ($controller->supportsLightbox()) { ?>
                        element.attr('href', '<?=rtrim(URL::route(array('/view_event', 'calendar'), $bID))?>/' + event.id).magnificPopup({
                            type: 'ajax',
                            callbacks: {
                                beforeOpen: function () {
                                    // just a hack that adds mfp-anim class to markup
                                    this.st.mainClass = 'mfp-zoom';
                                }
                            },
                            closeBtnInside: true,
                            closeOnContentClick: true,
                            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                        });
                    <?php } ?>
                }
            });
        });

        $(function() {
            $('#cal-month-list').fullCalendar({
                dateFormat: 'H:mm',
                header: {
                    left: 'prev,next',
                    center: '',
                    right: 'title'
                },
                locale: <?= json_encode(Localization::activeLanguage()); ?>,
                views: {
                    listDay: { buttonText: '<?= t('list day'); ?>' },
                    listWeek: { buttonText: '<?= t('list week'); ?>' },
                    listMonth: { buttonText: '<?= t('list month'); ?>' },
                    listYear: { buttonText: '<?= t('list year'); ?>' }
                },
                contentHeight: 'auto',

                <?php if ($defaultView) { ?>
                    defaultView: 'listMonth',
                <?php } ?>
                <?php if ($navLinks) { ?>
                    navLinks: true,
                <?php } ?>
                <?php if ($eventLimit) { ?>
                    eventLimit: true,
                <?php } ?>

                events: '<?=$view->action('get_events')?>',
                nextDayThreshold: '00:00:00',
                eventDataTransform: function(event) {
                    if(event.allDay) {
                        event.end = moment(event.end).add(1, 'days')
                    }
                    return event;
                },

                eventRender: function(event, element) {
                    <?php if ($controller->supportsLightbox()) { ?>
                        element.attr('href', '<?=rtrim(URL::route(array('/view_event', 'calendar'), $bID))?>/' + event.id).magnificPopup({
                            type: 'ajax',
                            callbacks: {
                                beforeOpen: function () {
                                    // just a hack that adds mfp-anim class to markup
                                    this.st.mainClass = 'mfp-zoom';
                                }
                            },
                            closeBtnInside: true,
                            closeOnContentClick: true,
                            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                        });
                    <?php } ?>
                }
            });
        });
    </script>
<?php
} ?>
