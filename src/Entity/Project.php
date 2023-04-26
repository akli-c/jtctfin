<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'projects')]
    private $user;

    #[ORM\Column(type: 'string', length: 4000, nullable: true)]
    private $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $logo;

    #[ORM\Column(type: 'decimal', precision: 10, scale:2, nullable: true)]
    private $Price;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $progress;

    #[ORM\OneToMany(mappedBy: 'Project', targetEntity: Qna::class)]
    private Collection $qnas;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Comments::class)]
    private Collection $comments;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mot = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ticket = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $invite = null;

    #[ORM\ManyToMany(targetEntity: Founder::class, mappedBy: 'project')]
    private Collection $founders;


    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->qnas = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->founders = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(?string $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getProgress(): ?int
    {
        return $this->progress;
    }

    public function setProgress(?int $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * @return Collection<int, Qna>
     */
    public function getQnas(): Collection
    {
        return $this->qnas;
    }

    public function addQna(Qna $qna): self
    {
        if (!$this->qnas->contains($qna)) {
            $this->qnas->add($qna);
            $qna->setProject($this);
        }

        return $this;
    }

    public function removeQna(Qna $qna): self
    {
        if ($this->qnas->removeElement($qna)) {
            // set the owning side to null (unless already changed)
            if ($qna->getProject() === $this) {
                $qna->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProject($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProject() === $this) {
                $comment->setProject(null);
            }
        }

        return $this;
    }

    public function getMot(): ?string
    {
        return $this->mot;
    }

    public function setMot(?string $mot): self
    {
        $this->mot = $mot;

        return $this;
    }

    public function getTicket(): ?string
    {
        return $this->ticket;
    }

    public function setTicket(?string $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProject($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProject() === $this) {
                $image->setProject(null);
            }
        }

        return $this;
    }

    public function getInvite(): ?string
    {
        return $this->invite;
    }

    public function setInvite(?string $invite): self
    {
        $this->invite = $invite;

        return $this;
    }

    /**
     * @return Collection<int, Founder>
     */
    public function getFounders(): Collection
    {
        return $this->founders;
    }

    public function addFounder(Founder $founder): self
    {
        if (!$this->founders->contains($founder)) {
            $this->founders->add($founder);
            $founder->addProject($this);
        }

        return $this;
    }

    public function removeFounder(Founder $founder): self
    {
        if ($this->founders->removeElement($founder)) {
            $founder->removeProject($this);
        }

        return $this;
    }

}
