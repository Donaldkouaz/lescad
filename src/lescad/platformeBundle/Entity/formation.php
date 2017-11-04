<?php

namespace lescad\platformeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="lescad\platformeBundle\Repository\formationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class formation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
     /**
     * @var string
     *
     * @ORM\Column(name="prerequis", type="text", nullable=true)
     */
    private $prerequis = 'Aucune connaissance spécifique n\'est requise pour commencer cette formation.';
    
    /**
     * @var string
     *
     * @ORM\Column(name="cout", type="string", length=255)
     */
    private $cout;

    /**
     * @var string
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    private $duree;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetimetz")
     */
    private $datecreation;

        /**
     * @var \DateTime
     *
     * @ORM\Column(name="datemodification", type="datetimetz", nullable=true)
     */
    private $datemodification;
    
    


    /**
     * @ORM\ManyToMany(targetEntity="lescad\platformeBundle\Entity\matiere",inversedBy="formations", cascade={"persist"})
     * 
     */
     private $matieres;


    /**
     * @ORM\ManyToOne(targetEntity="lescad\platformeBundle\Entity\categorie", inversedBy="formations", cascade={"persist"})
     * 
     * 
     */
    private $categorie;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return formation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return formation
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
     * Set duree
     *
     * @param integer $duree
     *
     * @return formation
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return int
     */
    public function getDuree()
    {
        foreach($this->matieres as $matiere)
        {
            $this->duree += $matiere->getDuree();
        }
        return $this->duree;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return formation
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return formation
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datecreation = new \Datetime();
    }

    /**
     * Add matiere
     *
     * @param \lescad\platformeBundle\Entity\matiere $matiere
     *
     * @return formation
     */
    public function addMatiere(\lescad\platformeBundle\Entity\matiere $matiere)
    {
        $this->matieres[] = $matiere;

        return $this;
    }

    /**
     * Remove matiere
     *
     * @param \lescad\platformeBundle\Entity\matiere $matiere
     */
    public function removeMatiere(\lescad\platformeBundle\Entity\matiere $matiere)
    {
        $this->matieres->removeElement($matiere);
    }

    /**
     * Get matieres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * Set categorie
     *
     * @param \lescad\platformeBundle\Entity\categorie $categorie
     *
     * @return formation
     */
    public function setCategorie(\lescad\platformeBundle\Entity\categorie $categorie = null)
    {
        $this->categorie = $categorie;
        $categorie->addFormation($this);

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \lescad\platformeBundle\Entity\categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set datemodification
     *
     * @param \DateTime $datemodification
     *
     * @return formation
     */
    public function setDatemodification($datemodification)
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    /**
     * Get datemodification
     *
     * @return \DateTime
     */
    public function getDatemodification()
    {
        return $this->datemodification;
    }

    /**
     * @ORM\PreUpdate
     */
    public function modifierDatemodification()
    {
        $this->setDatemodification(new \DateTime());
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return formation
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set prerequis
     *
     * @param string $prerequis
     *
     * @return formation
     */
    public function setPrerequis($prerequis)
    {
        $this->prerequis = $prerequis;

        return $this;
    }

    /**
     * Get prerequis
     *
     * @return string
     */
    public function getPrerequis()
    {
        return $this->prerequis;
    }

    /**
     * Set cout
     *
     * @param string $cout
     *
     * @return formation
     */
    public function setCout($cout)
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * Get cout
     *
     * @return string
     */
    public function getCout()
    {
        return $this->cout;
    }
}
