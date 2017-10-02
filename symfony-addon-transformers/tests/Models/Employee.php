<?php

namespace DarkWebDesign\SymfonyAddon\Transformer\Tests\Models;

/**
 * @Table(name="employee")
 *
 * @Entity
 */
class Employee extends AbstractPerson
{
    /**
     * @var string
     *
     * @Column(name="function", type="string", length=50, nullable=false)
     */
    private $function;

    /**
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param string $function
     */
    public function setFunction($function)
    {
        $this->function = $function;
    }
}
