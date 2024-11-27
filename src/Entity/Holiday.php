<?php

namespace App\Entity;

use App\Repository\HolidayRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HolidayRepository::class)]
class Holiday
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'holidays')]
    #[ORM\JoinColumn(nullable: false)]
    private ?holidayStatus $statusId = null;

    #[ORM\ManyToOne(inversedBy: 'holidays')]
    #[ORM\JoinColumn(nullable: false)]
    private ?employees $employeeId = null;

    #[ORM\ManyToOne(inversedBy: 'holidays')]
    #[ORM\JoinColumn(nullable: false)]
    private ?holidayTypes $typeId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatusId(): ?holidayStatus
    {
        return $this->statusId;
    }

    public function setStatusId(?holidayStatus $statusId): static
    {
        $this->statusId = $statusId;

        return $this;
    }

    public function getEmployeeId(): ?employees
    {
        return $this->employeeId;
    }

    public function setEmployeeId(?employees $employeeId): static
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    public function getTypeId(): ?holidayTypes
    {
        return $this->typeId;
    }

    public function setTypeId(?holidayTypes $typeId): static
    {
        $this->typeId = $typeId;

        return $this;
    }
}
