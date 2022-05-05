<?php

namespace App\Entity;

use App\Repository\HobbieRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HobbieRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Hobbie
{
    use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $deseniation;

    #[ORM\ManyToMany(targetEntity: Personne::class, mappedBy: 'hobbie')]
    private $personnes;

    public function __construct()
    {
        $this->personnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeseniation(): ?string
    {
        return $this->deseniation;
    }

    public function setDeseniation(string $deseniation): self
    {
        $this->deseniation = $deseniation;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes[] = $personne;
            $personne->addHobbie($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): self
    {
        if ($this->personnes->removeElement($personne)) {
            $personne->removeHobbie($this);
        }

        return $this;
    }
//    public function __toString(): string
//    {
//        return $this->deseniation;
//    }
}
