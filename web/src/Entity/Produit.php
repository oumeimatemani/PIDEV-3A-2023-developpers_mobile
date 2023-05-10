<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     *  @Groups({"post:read"})
     */
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"nom produit doit etre non vide !")]
    #[Assert\Length( min : 5,minMessage :"Entrer un nom au min de 5 caracteres")]
    /**
     *  @Groups({"post:read"})
     */
    private ?string $nomP = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"ajouter le prix du produit !")]
    #[Assert\Positive(message: "le prix doit etre possitif")]
    /**
     *  @Groups({"post:read"})
     */
    private ?float $prixP = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"description doit etre non vide !")]
    #[Assert\Length( min : 10,minMessage :"Entrer un nom au min de 10 caracteres")]
    /**
     *  @Groups({"post:read"})
     */
    private ?string $descriptionP = null;

    #[ORM\Column(length: 255)]
    /**
     *  @Groups({"post:read"})
     */
    private ?string $imageP = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:"ajouter le stock !")]
    #[Assert\Range(min : 1 , max : 1000 , notInRangeMessage: "le stock doit etre entre {{ min }} et {{ max }} ")]
    /**
     *  @Groups({"post:read"})
     */
    private ?int $stock = null;

    #[ORM\Column(nullable: true)]
    /**
     *  @Groups({"post:read"})
     */
    private ?int $quantiteproduit = null;
    #[ORM\Column(length: 255)]
    /**
     *  @Groups({"post:read"})
     */
    private ?string $imageQrCode = null;

    #[ORM\ManyToOne]
    /**
     *  @Groups({"post:read"})
     */
    private ?User $iduserproduit = null;



    #[ORM\ManyToOne]
    /**
     *  @Groups({"post:read"})
     */
    private ?CategorieP $idcatP = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): self
    {
        $this->nomP = $nomP;

        return $this;
    }

    public function getPrixP(): ?float
    {
        return $this->prixP;
    }

    public function setPrixP(float $prixP): self
    {
        $this->prixP = $prixP;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->descriptionP;
    }

    public function setDescriptionP(string $descriptionP): self
    {
        $this->descriptionP = $descriptionP;

        return $this;
    }

    public function getImageP(): ?string
    {
        return $this->imageP;
    }

    public function setImageP(string $imageP): self
    {
        $this->imageP = $imageP;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getQuantiteproduit(): ?int
    {
        return $this->quantiteproduit;
    }

    public function setQuantiteproduit(?int $quantiteproduit): self
    {
        $this->quantiteproduit = $quantiteproduit;

        return $this;
    }

    public function getIduserproduit(): ?User
    {
        return $this->iduserproduit;
    }

    public function setIduserproduit(?User $iduserproduit): self
    {
        $this->iduserproduit = $iduserproduit;

        return $this;
    }



    public function getIdcatP(): ?CategorieP
    {
        return $this->idcatP;
    }

    public function setIdcatP(?CategorieP $idcatP): self
    {
        $this->idcatP = $idcatP;

        return $this;
    }
    /**
     * @return string|null
     */
    public function getImageQrCode(): ?string
    {
        return $this->imageQrCode;
    }

    /**
     * @param string|null $imageQrCode
     */
    public function setImageQrCode(?string $imageQrCode): void
    {
        $this->imageQrCode = $imageQrCode;
    }
}
