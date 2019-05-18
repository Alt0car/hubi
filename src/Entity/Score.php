<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoreRepository")
 */
class Score
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "La note minimum est de {{ limit }}",
     *      maxMessage = "La note maximum de doit pas dépasser {{ limit }}"
     * )
     */
    protected $score;

    /**
     * @ORM\Column(type="string", length=35, nullable=false)
     */
    protected $class;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="scores")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;


    /**
     * @return integer
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param integer $score
     */
    public function setScore($score): void
    {
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass($class): void
    {
        $this->class = $class;
    }

    /**
     * @return Student|null
     */
    public function getStudent(): ?Student
    {
        return $this->student;
    }

    /**
     * @param Student|null $student
     * @return Score
     */
    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

}