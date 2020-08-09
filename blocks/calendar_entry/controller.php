<?php

namespace Concrete\Package\Tomorrow\Block\CalendarEntry;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Calendar\Calendar;
use Concrete\Core\Calendar\Event\EventRepetition;
use Concrete\Core\Calendar\Event\EditResponse;
use Concrete\Core\Calendar\Event\EventOccurrenceList;
use Concrete\Core\Calendar\Event\EventService;
use Concrete\Core\Entity\Calendar\CalendarEvent;
use Concrete\Core\Entity\Calendar\CalendarEventVersionRepetition;
use Concrete\Core\Entity\Calendar\CalendarEventRepetition;
use Concrete\Core\User\User;
use Concrete\Core\Workflow\Request\ApproveCalendarEventRequest;
use Core;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends BlockController
{
  protected $btTable = "btCalendarEntry";
  protected $btInterfaceWidth = "700";
  protected $btInterfaceHeight = "480";
  protected $btDefaultSet = 'basic';

  public function getBlockTypeName() {
    return t('Neuer Kalendereintrag/Anfrage');
  }

  public function getBlockTypeDescription() {
    return t('Zeigt den BesucherInnen ein Formular, um eine neue Kalenderanfrage zu erstellen.');
  }

  public function add() {
    $calendars = Calendar::getList();
    $this->set('calendars', $calendars);
  }

  public function edit() {

  }

  public function save($data) {
    parent::save($data);
  }

  public function action_new_entry($bID = false) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();

    $category = 'new_request';
    $start_date = $this->post()['date'] . ' ' . $this->post()['start_time'];
    $end_date = $this->post()['date'] . ' ' . $this->post()['end_time'];
    $author = $this->post()['author'];
    $title = $this->post()['title'];
    $comment = $this->post()['comment'];

      
    $calendar = Calendar::getByID($this->calendar_id);
    $eventService = $app->make(EventService::class);
    $u = User::getByUserID(1);
    $timezone = $calendar->getSite()->getConfigRepository()->get('timezone');
    if (!$timezone) {
        $timezone = date_default_timezone_get();
    }
    $timezone = new \DateTimeZone($timezone);

    $dateStart = date('Y-m-d H:i:s', strtotime($start_date));
    $dateEnd = date('Y-m-d H:i:s', strtotime($end_date));
    
    $pd = new EventRepetition();
    $pd->setTimezone($timezone);
    $pd->setStartDateAllDay(0);
    $pd->setStartDate($dateStart);
    $pd->setEndDate($dateEnd);
    $pd->setRepeatPeriod($pd::REPEAT_NONE);
    $pdEntity = new CalendarEventRepetition($pd);
    
    $event = new CalendarEvent($calendar);
    $eventVersion = $eventService->getVersionToModify($event, $u);
    $eventVersion->setName('-- offene Anfrage --');
    $eventVersion->setDescription('Für diesen Termin wurde schon eine Anfrage erstellt.');
    
    $repetitions[] = new CalendarEventVersionRepetition($eventVersion, $pdEntity);
    $eventService->addEventVersion($event, $calendar, $eventVersion, $repetitions);
    $eventService->generateDefaultOccurrences($eventVersion);
    
    $pkr = new ApproveCalendarEventRequest();
    $pkr->setCalendarEventVersionID($eventVersion->getID());
    $pkr->setRequesterUserID($u->getUserID());
    $response = $pkr->trigger();

    // unapproved version to display in the frontend
    $eventVersion = $eventService->getVersionToModify($event, $u);
    $eventVersion->setName($title);
    $eventVersion->setDescription('Von: ' . $author . '<br/>' . $comment);
    
    $eventService->addEventVersion($event, $calendar, $eventVersion, $repetitions);
    $eventService->generateDefaultOccurrences($eventVersion);
  }
}
