<?php

namespace App\Entity;

use App\Repository\FollowRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowRepository::class)]
class Follow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'follows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $author = null;

    #[ORM\ManyToOne(inversedBy: null)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $target = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?Profile
    {
        return $this->author;
    }

    public function setAuthor(?Profile $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getTarget(): ?Profile
    {
        return $this->target;
    }

    public function setTarget(?Profile $target): static
    {
        $this->target = $target;

        return $this;
    }
}
