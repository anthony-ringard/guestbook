<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;

final class ConferenceEntityListener
{

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {

        $this->slugger = $slugger;
    }


    public function prePersit(Conference $conference, LifecycleEventArgs $eventArgs){
        $conference->computeSlug($this->slugger);
    }

    public function preUpdate(Conference $conference, LifecycleEventArgs $eventArgs){
        $conference->computeSlug($this->slugger);
    }




}
