<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $phone;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="client", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=AdresseFacturation::class, mappedBy="client", orphanRemoval=true)
     */
    private $adresseFacturations;

    /**
     * @ORM\OneToMany(targetEntity=AdresseLivraison::class, mappedBy="client", orphanRemoval=true)
     */
    private $adresseLivraisons;

    public function __construct()
    {
        $this->adresseFacturations = new ArrayCollection();
        $this->adresseLivraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setClient(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getClient() !== $this) {
            $user->setClient($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|AdresseFacturation[]
     */
    public function getAdresseFacturations(): Collection
    {
        return $this->adresseFacturations;
    }

    public function addAdresseFacturation(AdresseFacturation $adresseFacturation): self
    {
        if (!$this->adresseFacturations->contains($adresseFacturation)) {
            $this->adresseFacturations[] = $adresseFacturation;
            $adresseFacturation->setClient($this);
        }

        return $this;
    }

    public function removeAdresseFacturation(AdresseFacturation $adresseFacturation): self
    {
        if ($this->adresseFacturations->removeElement($adresseFacturation)) {
            // set the owning side to null (unless already changed)
            if ($adresseFacturation->getClient() === $this) {
                $adresseFacturation->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AdresseLivraison[]
     */
    public function getAdresseLivraisons(): Collection
    {
        return $this->adresseLivraisons;
    }

    public function addAdresseLivraison(AdresseLivraison $adresseLivraison): self
    {
        if (!$this->adresseLivraisons->contains($adresseLivraison)) {
            $this->adresseLivraisons[] = $adresseLivraison;
            $adresseLivraison->setClient($this);
        }

        return $this;
    }

    public function removeAdresseLivraison(AdresseLivraison $adresseLivraison): self
    {
        if ($this->adresseLivraisons->removeElement($adresseLivraison)) {
            // set the owning side to null (unless already changed)
            if ($adresseLivraison->getClient() === $this) {
                $adresseLivraison->setClient(null);
            }
        }

        return $this;
    }
}
