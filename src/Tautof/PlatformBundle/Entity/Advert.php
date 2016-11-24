<?php

namespace Tautof\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advert
 * 
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass = "Tautof\PlatformBundle\Repository\AdvertRepository")
 */
class Advert
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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="km", type="integer", nullable=false)
     */
    private $km;

    /**
     * @var string
     *
     * @ORM\Column(name="photo1", type="string", length=255, nullable=true)
     */
    private $photo1;

    /**
     * @var string
     *
     * @ORM\Column(name="photo2", type="string", length=255, nullable=true)
     */
    private $photo2;

    /**
     * @var string
     *
     * @ORM\Column(name="photo3", type="string", length=255, nullable=true)
     */
    private $photo3;

    /**
     * @var \Tautof\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Tautof\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Tautof\PlatformBundle\Entity\Color
     *
     * @ORM\ManyToOne(targetEntity="Tautof\PlatformBundle\Entity\Color")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="color_id", referencedColumnName="id")
     * })
     */
    
    private $color;

    /**
     * @var \Tautof\PlatformBundle\Entity\Model
     *
     * @ORM\ManyToOne(targetEntity="Tautof\PlatformBundle\Entity\Model")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     * })
     */
    private $model;



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
     * Set title
     *
     * @param string $title
     *
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Advert
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Advert
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set km
     *
     * @param integer $km
     *
     * @return Advert
     */
    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Get km
     *
     * @return integer
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set photo1
     *
     * @param string $photo1
     *
     * @return Advert
     */
    public function setPhoto1($photo1)
    {
        $this->photo1 = $photo1;

        return $this;
    }

    /**
     * Get photo1
     *
     * @return string
     */
    public function getPhoto1()
    {
        return $this->photo1;
    }

    /**
     * Set photo2
     *
     * @param string $photo2
     *
     * @return Advert
     */
    public function setPhoto2($photo2)
    {
        $this->photo2 = $photo2;

        return $this;
    }

    /**
     * Get photo2
     *
     * @return string
     */
    public function getPhoto2()
    {
        return $this->photo2;
    }

    /**
     * Set photo3
     *
     * @param string $photo3
     *
     * @return Advert
     */
    public function setPhoto3($photo3)
    {
        $this->photo3 = $photo3;

        return $this;
    }

    /**
     * Get photo3
     *
     * @return string
     */
    public function getPhoto3()
    {
        return $this->photo3;
    }

    /**
     * Set user
     *
     * @param \Tautof\UserBundle\Entity\User $user
     *
     * @return Advert
     */
    public function setUser(\Tautof\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Tautof\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set color
     *
     * @param \Tautof\PlatformBundle\Entity\Color $color
     *
     * @return Advert
     */
    public function setColor(\Tautof\PlatformBundle\Entity\Color $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \Tautof\PlatformBundle\Entity\Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set model
     *
     * @param \Tautof\PlatformBundle\Entity\Model $model
     *
     * @return Advert
     */
    public function setModel(\Tautof\PlatformBundle\Entity\Model $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \Tautof\PlatformBundle\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }
    
}
