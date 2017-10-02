<?php

namespace DarkWebDesign\SymfonyAddon\Transformer\Tests\Models;

/**
 * @Table(name="person")
 *
 * @Entity
 *
 * @InheritanceType("SINGLE_TABLE")
 *
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"person" = "Person", "employee" = "Employee"}) */
abstract class AbstractPerson
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
    protected $id;

    /**
     * @var string
     *
     * @Column(name="name", type="string", length=50, nullable=false)
     */
    protected $name;

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
