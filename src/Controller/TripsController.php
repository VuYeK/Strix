<?php

namespace App\Controller;

use App\Entity\Trip;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TripsController extends AbstractController
{
    /**
     * @Route("/trips", name="trips")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Trip::class);

        $trips = $repository->findAll();
        $data = [];

        /** @var Trip $trip */
        foreach ($trips as $trip) {
            $data[] = [
                'trip' => $trip->getName(),
                'distance' => $trip->getTripMeasures()->last()->getDistance(),
                'measure_interval' => $trip->getMeasureInterval(),
                'avg_speed' => $trip->getMaxAvgSpeed()
            ];
        }

        return $this->json(compact('data'));
    }
}
