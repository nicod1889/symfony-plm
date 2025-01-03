<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\String\u;

#[ORM\Entity]
#[ORM\Table(name: 'symfony_demo_comment')]
class Comment {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'comment.blank')]
    #[Assert\Length(min: 5, minMessage: 'comment.too_short', max: 10000, maxMessage: 'comment.too_long')]
    private ?string $content = null;

    #[ORM\Column]
    private \DateTimeImmutable $publishedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    public function __construct() {
        $this->publishedAt = new \DateTimeImmutable();
    }

    #[Assert\IsTrue(message: 'comment.is_spam')]
    public function isLegitComment(): bool {
        $containsInvalidCharacters = null !== u($this->content)->indexOf('@');
        return !$containsInvalidCharacters;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function getPublishedAt(): \DateTimeImmutable {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): void {
        $this->publishedAt = $publishedAt;
    }

    public function getAuthor(): ?User {
        return $this->author;
    }

    public function setAuthor(User $author): void {
        $this->author = $author;
    }

    public function getPost(): ?Post {
        return $this->post;
    }

    public function setPost(Post $post): void {
        $this->post = $post;
    }
}
