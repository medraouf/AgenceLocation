<?php
namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 * @UniqueEntity("title")
 * @Vich\Uploadable
 */
class Property
{
    const HEAT = [
        0 => 'Electrique',
        1 => 'Gaz'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * 
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="filename")
     * @Assert\Image(
     *      mimeTypes="image/jpeg"     
     * )
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string|null
     */
    private $filename;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=255)
     */
    private $title;

    /**
     * @Assert\Length(min=25, max=512)
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=10, max=5000)
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThan(
     *     value = 20
     * )
     * @Assert\GreaterThan(
     *     value = 0
     * )
     */
    private $rooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThan(
     *     value = 20
     * )
     * @Assert\GreaterThan(
     *     value = 0
     * )
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThan(
     *     value = 20
     * )
     * @Assert\GreaterThan(
     *     value = 0
     * )
     */
    private $floor;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThan(
     *     value =9999999
     * )
     * @Assert\GreaterThan(
     *     value = 50000
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $heat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 1,
     *      max = 50000000,
     *      minMessage = "Your Adress must be at least {{ limit }} characters long",
     *      maxMessage = "Your Adress cannot be longer than {{ limit }} characters"
     * )
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{4}/")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $sold = false;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->options = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Option", inversedBy="properties")
     */
    private $options;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;


    public function getId() : ? int
    {
        return $this->id;
    }

    public function getTitle() : ? string
    {
        return $this->title;
    }

    public function setTitle(string $title) : self
    {
        $this->title = $title;

        return $this;
    }
    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(? string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface() : ? int
    {
        return $this->surface;
    }

    public function setSurface(int $surface) : self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms() : ? int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms) : self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms() : ? int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms) : self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor() : ? int
    {
        return $this->floor;
    }

    public function setFloor(int $floor) : self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPrice() : ? int
    {
        return $this->price;
    }

    public function setPrice(int $price) : self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormattedPrice() : string
    {
        return number_format($this->price, 0, '', ' ');
    }

    public function getHeat() : ? int
    {
        return $this->heat;
    }

    public function setHeat(int $heat) : self
    {
        $this->heat = $heat;

        return $this;
    }

    public function getHeatType() : string
    {
        return self::HEAT[$this->heat];
    }

    public function getCity() : ? string
    {
        return $this->city;
    }

    public function setCity(string $city) : self
    {
        $this->city = $city;

        return $this;
    }

    public function getAdress() : ? string
    {
        return $this->adress;
    }

    public function setAdress(string $adress) : self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode() : ? string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code) : self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getSold() : ? bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold) : self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt() : ? \DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at) : self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addProperty($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            $option->removeProperty($this);
        }

        return $this;
    }



    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of filename
     *
     * @return  string|null
     */ 
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @param  string|null  $filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get the value of imageFile
     *
     * @return  File|null
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File|null  $imageFile
     *
     * @return  self
     */ 
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }
}
