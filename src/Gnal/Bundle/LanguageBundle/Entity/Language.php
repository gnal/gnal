<?php

namespace Gnal\Bundle\LanguageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="language_language")
 * @ORM\Entity
 */
class Language
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(unique="true")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Lexeme", mappedBy="language")
     */
    protected $lexemes;

    public function __construct()
    {
        $this->lexemes = new ArrayCollection;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
}