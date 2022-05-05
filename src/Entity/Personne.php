<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Personne
{
    use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'smallint')]
    private $age;

    #[ORM\Column(type: 'string', length: 50)]
    private $firstname;

    #[ORM\OneToOne(inversedBy: 'personne', targetEntity: Profil::class, cascade: ['persist', 'remove'])]
    private $profil;

    #[ORM\ManyToMany(targetEntity: Hobbie::class, inversedBy: 'personnes')]
    private $hobbie;



    public function __construct()
    {
        $this->hobbie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getProfil(): ?profil
    {
        return $this->profil;
    }

    public function setProfil(?profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * @return Collection<int, Hobbie>
     */
    public function getHobbie(): Collection
    {
        return $this->hobbie;
    }

    public function addHobbie(Hobbie $hobbie): self
    {
        if (!$this->hobbie->contains($hobbie)) {
            $this->hobbie[] = $hobbie;
        }

        return $this;
    }

    public function removeHobbie(Hobbie $hobbie): self
    {
        $this->hobbie->removeElement($hobbie);

        return $this;
    }



    #[ORM\PrePersist]
public function onPrePersist(){
$this->createdAt=new \DateTime();
$this->UpdatedAt=new \DateTime();
}
    #[ORM\PreUpdate]
public function onPreUpdate(){
        $this->UpdatedAt=new \DateTime();
    }


}
