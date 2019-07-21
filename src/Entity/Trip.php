<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trips
 *
 * @ORM\Table(name="trips")
 * @ORM\Entity
 */
class Trip
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="measure_interval", type="integer", nullable=false)
     */
    private $measureInterval;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TripMeasure", mappedBy="trip")
     */
    private $trip_measures;

    public function __construct()
    {
        $this->trip_measures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMeasureInterval(): ?int
    {
        return $this->measureInterval;
    }

    public function setMeasureInterval(int $measureInterval): self
    {
        $this->measureInterval = $measureInterval;

        return $this;
    }

    /**
     * @return Collection|TripMeasure[]
     */
    public function getTripMeasures(): Collection
    {
        return $this->trip_measures;
    }

    public function addTripMeasure(TripMeasure $tripMeasure): self
    {
        if (!$this->trip_measures->contains($tripMeasure)) {
            $this->trip_measures[] = $tripMeasure;
            $tripMeasure->setTrip($this);
        }

        return $this;
    }

    public function removeTripMeasure(TripMeasure $tripMeasure): self
    {
        if ($this->trip_measures->contains($tripMeasure)) {
            $this->trip_measures->removeElement($tripMeasure);
            // set the owning side to null (unless already changed)
            if ($tripMeasure->getTrip() === $this) {
                $tripMeasure->setTrip(null);
            }
        }

        return $this;
    }

    public function getMaxAvgSpeed(): int
    {
        $tripMeasures = $this->getTripMeasures();
        $maxAvgSpeed = 0;

        if (!$this->hasEnoughMeasures($tripMeasures)) {
            // Car was not moving
            return $maxAvgSpeed;
        }

        $prevMeasure = $tripMeasures->first();

        while ($measure = $tripMeasures->next()) {
            $avgSpeed = $this->getAvgSpeed($prevMeasure, $measure, $this->getMeasureInterval());

            if ($avgSpeed > $maxAvgSpeed) {
                // Update max speed
                $maxAvgSpeed = $avgSpeed;
            }

            $prevMeasure = $measure;
        }

        return $maxAvgSpeed;
    }

    private function getAvgSpeed(TripMeasure $firstMeasure, TripMeasure $secondMeasure, int $measureInterval): int
    {
        $deltaDistance = $secondMeasure->getDistance() - $firstMeasure->getDistance();

        return floor((3600 * $deltaDistance) / $measureInterval);
    }

    private function hasEnoughMeasures(Collection $tripMeasures)
    {
        return $tripMeasures->count() > 1;
    }

}
