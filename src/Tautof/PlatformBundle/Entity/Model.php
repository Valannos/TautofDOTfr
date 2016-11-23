<?php

namespace Tautof\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="model")
 * @ORM\Entity
 */
class Model
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \Tautof\PlatformBundle\Entity\Year
     *
     * @ORM\ManyToOne(targetEntity="Tautof\PlatformBundle\Entity\Year")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     * })
     */
    private $year;

    /**
     * @var \Tautof\PlatformBundle\Entity\Make
     *
     * @ORM\ManyToOne(targetEntity="Tautof\PlatformBundle\Entity\Make")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="make_id", referencedColumnName="id")
     * })
     */
    private $make;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Model
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set year
     *
     * @param \Tautof\PlatformBundle\Entity\Year $year
     *
     * @return Model
     */
    public function setYear(\Tautof\PlatformBundle\Entity\Year $year = null)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \Tautof\PlatformBundle\Entity\Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set make
     *
     * @param \Tautof\PlatformBundle\Entity\Make $make
     *
     * @return Model
     */
    public function setMake(\Tautof\PlatformBundle\Entity\Make $make = null)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return \Tautof\PlatformBundle\Entity\Make
     */
    public function getMake()
    {
        return $this->make;
    }
    public function __toString() {
        return $this->getName();
    }
}
