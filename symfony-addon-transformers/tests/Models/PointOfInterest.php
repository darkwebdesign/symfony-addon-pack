<?php
/**
 * Copyright (c) 2018 DarkWeb Design
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace DarkWebDesign\SymfonyAddonTransformers\Tests\Models;

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
     * @var \DarkWebDesign\SymfonyAddonTransformers\Tests\Models\City
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
     * @return \DarkWebDesign\SymfonyAddonTransformers\Tests\Models\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param \DarkWebDesign\SymfonyAddonTransformers\Tests\Models\City $city
     */
    public function setCity(City $city)
    {
        $this->city = $city;
    }
}
