<?php

namespace AppBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use AppBundle\Entity\appointment;
use User\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CalendarEventListener extends Controller
{
	private $entityManager;
	
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}
	
	public function loadEvents(CalendarEvent $calendarEvent)
	{
        $rdv = $this->entityManager->getRepository('AppBundle:appointment')->findAll();

		$dateA = $rdv[0]->getDate();

		$eventEntity = new EventEntity("safouane", $dateA ,  $dateA);

		$eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
		    $eventEntity->setBgColor('#FF0000'); //set the background color of the event's label
		    $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
		    $eventEntity->setUrl('http://www.google.com'); // url to send user to when event label is clicked
		    $eventEntity->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels

		    //finally, add the event to the CalendarEvent for displaying on the calendar
		    $calendarEvent->addEvent($eventEntity);

		
	}
}