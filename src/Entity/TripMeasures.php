<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TripMeasures
 *
 * @ORM\Table(name="trip_measures")
 * @ORM\Entity
 */
class TripMeasures
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="trip_id", type="integer", nullable=false)
     */
    private $tripId;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $distance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTripId(): ?int
    {
        return $this->tripId;
    }

    public function setTripId(int $tripId): self
    {
        $this->tripId = $tripId;

        return $this;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function setDistance($distance): self
    {
        $this->distance = $distance;

        return $this;
    }


}
