<?php

namespace App\EventSubscriber;

use App\Entity\Events;
use CalendarBundle\Entity\Event;
use CalendarBundle\CalendarEvents;
use App\Repository\AbsencesRepository;
use CalendarBundle\Event\CalendarEvent;
use Doctrine\DBAL\Events as DBALEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $absencesRepository;
    private $router;

    public function __construct(
        AbsencesRepository $absencesRepository,
        UrlGeneratorInterface $router
    ) {
        $this->absencesRepository = $absencesRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change absences.beginAt by your start date property
        $absences = $this->absencesRepository
            ->createQueryBuilder('absences')
            ->where('absences.dateDebut BETWEEN :start and :end OR absences.dateFin BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

        foreach ($absences as $absence) {
            // this create the events with your data (here absences data) to fill calendar
            if ($absence->getEnfants()) {
                $i = $absence->getEnfants();
            }else {
                $i = $absence->getEffectifs();
            }
            $absenceEvent = new Event(
                $absence->getMotif(),
                $i,
                $absence->getDateDebut(),
                $absence->getDateFin(), // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */
            $absenceEvent->setOptions([
                'backgroundColor' => '#F0F4DA',
                'borderColor' => '#CEE59F',
            ]);
            $absenceEvent->addOption(
                'url',
                $this->router->generate('absences_show', [
                    'id' => $absence->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($absenceEvent);
        }
    }
}
