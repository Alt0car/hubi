<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SoftDeletedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 * @UniqueEntity(fields={"firstName","lastName","birthDate"}, message="Cet étudiant existe déjà.")
 */
class Student
{
    use NameTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date
     */
    protected $birthDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Score", mappedBy="student", orphanRemoval=true)
     */
    private $scores;

    /**
     * Student constructor.
     */
    public function __construct()
    {
        $this->scores = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Score[]
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    /**
     * @param Score $score
     * @return Student
     */
    public function addScore(Score $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores[] = $score;
            $score->setStudent($this);
        }

        return $this;
    }

    /**
     * @param Score $score
     * @return Student
     */
    public function removeScore(Score $score): self
    {
        if ($this->scores->contains($score)) {
            $this->scores->removeElement($score);
            if ($score->getStudent() === $this) {
                $score->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

}