<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatRepository")
 */
class Cat
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private string $email;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $age;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $height;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $hasDriveLicence;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    public function isHasDriveLicence(): bool
    {
        return $this->hasDriveLicence;
    }

    public function setHasDriveLicence(bool $hasDriveLicence): void
    {
        $this->hasDriveLicence = $hasDriveLicence;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
