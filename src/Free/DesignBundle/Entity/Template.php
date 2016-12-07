<?php

namespace Free\DesignBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Template
 *
 * @ORM\Table(name="template")
 * @ORM\Entity(repositoryClass="Free\DesignBundle\Repository\TemplateRepository")
 */
class Template
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;
    /**
     * @ORM\ManyToMany(targetEntity="Free\DesignBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;

    /**
     * @var string
     *
     * @ORM\Column(name="tumbnail", type="string", length=255, unique=true)
     */
    private $tumbnail;

     /**
     * @var string
     *
     * @ORM\Column(name="files", type="string", length=255, unique=true)
     */
    private $files;


    public function __construct() {
        $this->date = new \Datetime();
        $this->categories = new ArrayCollection();
    }

    // Notez le singulier, on ajoute une seule catégorie à la fois
    public function addCategory(Category $category) {
        // Ici, on utilise l'ArrayCollection vraiment comme un tableau
        $this->categories[] = $category;

        return $this;
    }

    public function removeCategory(Category $category) {
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
        $this->categories->removeElement($category);
    }

    // Notez le pluriel, on récupère une liste de catégories ici !
    public function getCategories() {
        return $this->categories;
    }

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
     * Set uri
     *
     * @param string $uri
     *
     * @return Template
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Template
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
     * Set info
     *
     * @param string $info
     *
     * @return Template
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set tumbnail
     *
     * @param string $tumbnail
     *
     * @return Template
     */
    public function setTumbnail($tumbnail)
    {
        $this->tumbnail = $tumbnail;

        return $this;
    }

    /**
     * Get tumbnail
     *
     * @return string
     */
    public function getTumbnail()
    {
        return $this->tumbnail;
        
    }

    /**
     * Set files
     *
     * @param string $files
     *
     * @return Template
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get files
     *
     * @return string
     */
    public function getFiles()
    {
        return $this->files;
    }
}
