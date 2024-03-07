<?php

namespace App\Entity;

use App\Repository\WishRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WishRepository::class)]
#[ORM\Table(name: 'Wishes')]
class Wish
{

    /**
     * @var int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER, options: ['unsigned' => true])]
    private int $id;

    /**
     * @var string
     */
    #[ORM\Column(name: 'title', type: Types::STRING, length: 250)]
    private string $title;

    /**
     * @var string
     */
    #[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
    private string $description;

    /**
     * @var string
     */
    #[ORM\Column(name: 'author', type: Types::STRING, length: 50)]
    private string $author;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'is_published', type: Types::BOOLEAN, nullable: true)]
    private bool $isPublished;

    /**
     * @var DateTime
     */
    #[ORM\Column(name: 'date_created', type: Types::DATETIME_MUTABLE)]
    private DateTime $dateCreated;

    /**
     * @var Category|null
     */
    #[ORM\ManyToOne(inversedBy: 'Wishes')]
    private ?Category $category = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }


    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }


    /**
     * @return bool
     */
    public function getIsPublished(): bool
    {
        return $this->isPublished;
    }


    /**
     * @param bool $isPublished
     */
    public function setIsPublished(bool $isPublished): void
    {
        $this->isPublished = $isPublished;
    }


    /**
     * @return DateTime
     */
    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }


    /**
     * @param DateTime $dateCreated
     */
    public function setDateCreated(DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}