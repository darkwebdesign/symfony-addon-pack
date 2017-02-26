<?php

namespace DarkWebDesign\SymfonyAddon\FormType\Tests\Models;

/**
 * @Table(name="city")
 *
 * @Entity
 */
class City
{
    /**
     * @var int
     *
     * @Column(name="id", type="integer", nullable=false)
     *
     * @Id
     *
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
}
