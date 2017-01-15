<?php

namespace DarkWebDesign\SymfonyAddon\Transformer\Tests\Models;

use DarkWebDesign\SymfonyAddon\Transformer\Tests\Models\City;

/**
 * @Table(name="pointofinterest")
 *
 * @Entity
 */
class PointOfInterest
{
    /**
     * @var int
     *
     * @Column(name="latitude", type="integer", nullable=false)
     *
     * @Id
     */
    private $latitude;

    /**
     * @var string
     *
     * @Column(name="longitude", type="integer", nullable=false)
     *
     * @Id
     */
    private $longitude;

    /**
     * @var string
     *
     * @Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var \DarkWebDesign\SymfonyAddon\Transformer\Tests\Models\City
     *
     * @ManyToOne(targetEntity="City")
     *
     * @JoinColumns({
     *   @JoinColumn(name="city_id", referencedColumnName="id")
     * })
     */
    private $city;

    /**
     * @return int
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param int $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return int
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param int $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \DarkWebDesign\SymfonyAddon\Transformer\Tests\Models\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param \DarkWebDesign\SymfonyAddon\Transformer\Tests\Models\City $city
     */
    public function setCity(City $city)
    {
        $this->city = $city;
    }
}
