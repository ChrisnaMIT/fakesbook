<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $profile = null;

    #[ORM\OneToOne(inversedBy: 'notification', cascade: ['persist', 'remove'])]
    private ?Like $likeNotification = null;

    #[ORM\OneToOne(inversedBy: 'notification', cascade: ['persist', 'remove'])]
    private ?Message $messageNotification = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function getLikeNotification(): ?Like
    {
        return $this->likeNotification;
    }

    public function setLikeNotification(?Like $likeNotification): static
    {
        $this->likeNotification = $likeNotification;

        return $this;
    }

    public function getMessageNotification(): ?Message
    {
        return $this->messageNotification;
    }

    public function setMessageNotification(?Message $messageNotification): static
    {
        $this->messageNotification = $messageNotification;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }


}
