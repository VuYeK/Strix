<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trips
 *
 * @ORM\Table(name="trips")
 * @ORM\Entity
 */
class Trips
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


}
