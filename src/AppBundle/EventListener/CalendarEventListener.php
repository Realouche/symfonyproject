<?php

namespace AppBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use AppBundle\Entity\appointment;
use User\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CalendarEventListener
{
	private $entityManager;
	private $user;
	
	public function __construct(EntityManager $entityManager,TokenStorageInterface $tokenStorage)
	{
		$this->entityManager = $entityManager;
		        $this->user = $tokenStorage->getToken()->getUser();

	}
	
	public function loadEvents(CalendarEvent $calendarEvent)
	{
		if($this->user->hasRole('ROLE_USER'))
			dump(true);
        $rdvs = $this->entityManager->getRepository('AppBundle:appointment')->findBy(array('idCitoyen' => $this->user->getId()));
		dump($this->user);
		dump($rdvs);

		foreach ($rdvs as $rdv)
		{
			$userResp =		$this->entityManager->getRepository('UserUserBundle:User')
												->createQueryBuilder('fos_user_table')
												->where('fos_user_table.id = :idResp')
												->setParameter('idResp', $rdv->getIdResp())
												->getQuery()->getSingleResult();
			dump($userResp);
			$eventEntity = new EventEntity($userResp->getUsername(), $rdv->getDate(),null,true );
			$eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
			$eventEntity->setBgColor($this->rand_color()); //set the background color of the event's label
			$eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
			$eventEntity->setUrl('http://www.google.com'); // url to send user to when event label is clicked
			$eventEntity->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels

			//finally, add the event to the CalendarEvent for displaying on the calendar
			$calendarEvent->addEvent($eventEntity);

		}

		
		
	}

	function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
	}
}