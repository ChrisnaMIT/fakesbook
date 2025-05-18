<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[Vich\Uploadable]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $displayName = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ofUser = null;

    #[Vich\UploadableField(mapping: 'profile_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'profile')]
    private Collection $posts;

    /**
     * @var Collection<int, Friendship>
     */
    #[ORM\OneToMany(targetEntity: Friendship::class, mappedBy: 'personA', orphanRemoval: true)]
    private Collection $friendAsPersonA;

    /**
     * @var Collection<int, Friendship>
     */
    #[ORM\OneToMany(targetEntity: Friendship::class, mappedBy: 'personB', orphanRemoval: true)]
    private Collection $friendAsPersonB;

    /**
     * @var Collection<int, FriendRequest>
     */
    #[ORM\OneToMany(targetEntity: FriendRequest::class, mappedBy: 'sender')]
    private Collection $sentRequest;

    /**
     * @var Collection<int, FriendRequest>
     */
    #[ORM\OneToMany(targetEntity: FriendRequest::class, mappedBy: 'recipient')]
    private Collection $receivedFriendRequests;

    /**
     * @var Collection<int, Conversation>
     */
    #[ORM\ManyToMany(targetEntity: Conversation::class, mappedBy: 'participants')]
    private Collection $conversations;


    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $messages;

    /**
     * @var Collection<int, Follow>
     */
    #[ORM\OneToMany(targetEntity: Follow::class, mappedBy: 'author')]
    private Collection $follows;

    /**
     * @var Collection<int, Share>
     */
    #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'sender')]
    private Collection $sentShares;

    /**
     * @var Collection<int, Share>
     */
    #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'recipient')]
    private Collection $receivedShares;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'profile', orphanRemoval: true)]
    private Collection $notifications;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->friendAsPersonA = new ArrayCollection();
        $this->friendAsPersonB = new ArrayCollection();
        $this->sentRequest = new ArrayCollection();
        $this->receivedFriendRequests = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->follows = new ArrayCollection();
        $this->sentShares = new ArrayCollection();
        $this->receivedShares = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): static
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getOfUser(): ?User
    {
        return $this->ofUser;
    }

    public function setOfUser(User $ofUser): static
    {
        $this->ofUser = $ofUser;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setProfile($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getProfile() === $this) {
                $post->setProfile(null);
            }
        }

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendAsPersonA(): Collection
    {
        return $this->friendAsPersonA;
    }

    public function addFriendAsPersonA(Friendship $friendAsPersonA): static
    {
        if (!$this->friendAsPersonA->contains($friendAsPersonA)) {
            $this->friendAsPersonA->add($friendAsPersonA);
            $friendAsPersonA->setPersonA($this);
        }

        return $this;
    }

    public function removeFriendAsPersonA(Friendship $friendAsPersonA): static
    {
        if ($this->friendAsPersonA->removeElement($friendAsPersonA)) {
            // set the owning side to null (unless already changed)
            if ($friendAsPersonA->getPersonA() === $this) {
                $friendAsPersonA->setPersonA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendAsPersonB(): Collection
    {
        return $this->friendAsPersonB;
    }

    public function addFriendAsPersonB(Friendship $friendAsPersonB): static
    {
        if (!$this->friendAsPersonB->contains($friendAsPersonB)) {
            $this->friendAsPersonB->add($friendAsPersonB);
            $friendAsPersonB->setPersonB($this);
        }

        return $this;
    }

    public function removeFriendAsPersonB(Friendship $friendAsPersonB): static
    {
        if ($this->friendAsPersonB->removeElement($friendAsPersonB)) {
            // set the owning side to null (unless already changed)
            if ($friendAsPersonB->getPersonB() === $this) {
                $friendAsPersonB->setPersonB(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FriendRequest>
     */
    public function getSentRequest(): Collection
    {
        return $this->sentRequest;
    }

    public function addSentRequest(FriendRequest $sentRequest): static
    {
        if (!$this->sentRequest->contains($sentRequest)) {
            $this->sentRequest->add($sentRequest);
            $sentRequest->setSender($this);
        }

        return $this;
    }

    public function removeSentRequest(FriendRequest $sentRequest): static
    {
        if ($this->sentRequest->removeElement($sentRequest)) {
            // set the owning side to null (unless already changed)
            if ($sentRequest->getSender() === $this) {
                $sentRequest->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FriendRequest>
     *
     */

    public function getReceviedFriendRequest(): Collection
    {
        return $this->receivedFriendRequests
            ;
    }

    public function receivedFriendRequests
    (): Collection
    {
        return $this->receivedFriendRequests;
    }

    public function addReceivedFriendRequests(FriendRequest $receivedFriendRequests): static
    {
        if (!$this->receivedFriendRequests->contains($receivedFriendRequests)) {
            $this->receivedFriendRequests->add($receivedFriendRequests);
            $receivedFriendRequests->setRecipient($this);
        }

        return $this;
    }

    public function removeReceivedFriendRequests(FriendRequest $receivedFriendRequests): static
    {
        if ($this->receivedFriendRequests->removeElement($receivedFriendRequests)) {
            // set the owning side to null (unless already changed)
            if ($receivedFriendRequests->getRecipient() === $this) {
                $receivedFriendRequests->setRecipient(null);
            }
        }

        return $this;
    }

    public function isPendingFriendRequest(Profile $profile): bool
    {
        foreach ($this->receivedFriendRequests as $friendRequest) {
            if ($friendRequest->getSender() === $profile) {
                return true;
            }
        }

        foreach ($this->sentRequest as $friendRequest) {
            if ($friendRequest->getRecipient() === $profile) {
                return true;
            }
        }
        return false;
    }


    public function isFriendsWith(Profile $profile): bool
    {

        foreach($this->friendAsPersonA as $friendShip){
            if ($friendShip->getPersonA() === $profile) {
                return true;
            }
        }
        return false;
    }

    public function getFriends(): array
    {
        $friends = [];
        foreach ($this->friendAsPersonA as $friendShip) {
            $friends[] = $friendShip->getPersonB();
        }
        foreach ($this->friendAsPersonB as $friendShip) {
            $friends[] = $friendShip->getPersonA();
        }
        return $friends;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): static
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->setParticipants($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): static
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getParticipants() === $this) {
                $conversation->setParticipants(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    public function isChattingWith(Profile $profile): Conversation | bool
    {
        foreach($this->conversations as $conversation){
            if ($conversation->getParticipants()->contains($profile)){
                return $conversation;
            }
        }
        return false;
    }


    public function isFollowedBy(User $user): bool
    {
        foreach ($this->followers as $follower) {
            if ($follower === $user) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection<int, Follow>
     */
    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function addFollow(Follow $follow): static
    {
        if (!$this->follows->contains($follow)) {
            $this->follows->add($follow);
            $follow->setAuthor($this);
        }

        return $this;
    }

    public function removeFollow(Follow $follow): static
    {
        if ($this->follows->removeElement($follow)) {
            // set the owning side to null (unless already changed)
            if ($follow->getAuthor() === $this) {
                $follow->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getSentShares(): Collection
    {
        return $this->sentShares;
    }

    public function addSentShare(Share $sentShare): static
    {
        if (!$this->sentShares->contains($sentShare)) {
            $this->sentShares->add($sentShare);
            $sentShare->setSender($this);
        }

        return $this;
    }

    public function removeSentShare(Share $sentShare): static
    {
        if ($this->sentShares->removeElement($sentShare)) {
            // set the owning side to null (unless already changed)
            if ($sentShare->getSender() === $this) {
                $sentShare->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getReceivedShares(): Collection
    {
        return $this->receivedShares;
    }

    public function addReceivedShare(Share $receivedShare): static
    {
        if (!$this->receivedShares->contains($receivedShare)) {
            $this->receivedShares->add($receivedShare);
            $receivedShare->setRecipient($this);
        }

        return $this;
    }

    public function removeReceivedShare(Share $receivedShare): static
    {
        if ($this->receivedShares->removeElement($receivedShare)) {
            // set the owning side to null (unless already changed)
            if ($receivedShare->getRecipient() === $this) {
                $receivedShare->setRecipient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setProfile($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getProfile() === $this) {
                $notification->setProfile(null);
            }
        }

        return $this;
    }



}
