<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity(fields:['name'])]
class Category
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 50, unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Wish>
     */
    #[ORM\OneToMany(targetEntity: Wish::class, mappedBy: 'category')]
    private Collection $Wishes;

    public function __construct()
    {
        $this->Wishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Wish>
     */
    public function getWishes(): Collection
    {
        return $this->Wishes;
    }

    public function addWish(Wish $wish): static
    {
        if (!$this->Wishes->contains($wish)) {
            $this->Wishes->add($wish);
            $wish->setCategory($this);
        }

        return $this;
    }

    public function removeWish(Wish $wish): static
    {
        if ($this->Wishes->removeElement($wish)) {
            // set the owning side to null (unless already changed)
            if ($wish->getCategory() === $this) {
                $wish->setCategory(null);
            }
        }

        return $this;
    }
}
