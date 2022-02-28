<?php

namespace App\Entity;

use App\Repository\HeaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeaderRepository::class)]
class Header
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'string', length: 255)]
    private $btnTitle;

    #[ORM\Column(type: 'string', length: 255)]
    private $btnUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $illustration;

    #[ORM\Column(type: 'string', length: 255)]
    private $illustration2;

    #[ORM\Column(type: 'string', length: 255)]
    private $illustration3;

    #[ORM\Column(type: 'string', length: 255)]
    private $btnUrl2;

    #[ORM\Column(type: 'string', length: 255)]
    private $btnUrl3;

    #[ORM\Column(type: 'string', length: 255)]
    private $title2;

    #[ORM\Column(type: 'string', length: 255)]
    private $title3;

    #[ORM\Column(type: 'string', length: 255)]
    private $btnTitle2;

    #[ORM\Column(type: 'string', length: 255)]
    private $btnTitle3;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getBtnTitle(): ?string
    {
        return $this->btnTitle;
    }

    public function setBtnTitle(string $btnTitle): self
    {
        $this->btnTitle = $btnTitle;

        return $this;
    }

    public function getBtnUrl(): ?string
    {
        return $this->btnUrl;
    }

    public function setBtnUrl(string $btnUrl): self
    {
        $this->btnUrl = $btnUrl;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getIllustration2(): ?string
    {
        return $this->illustration2;
    }

    public function setIllustration2(string $illustration2): self
    {
        $this->illustration2 = $illustration2;

        return $this;
    }

    public function getIllustration3(): ?string
    {
        return $this->illustration3;
    }

    public function setIllustration3(string $illustration3): self
    {
        $this->illustration3 = $illustration3;

        return $this;
    }

    public function getBtnUrl2(): ?string
    {
        return $this->btnUrl2;
    }

    public function setBtnUrl2(string $btnUrl2): self
    {
        $this->btnUrl2 = $btnUrl2;

        return $this;
    }

    public function getBtnUrl3(): ?string
    {
        return $this->btnUrl3;
    }

    public function setBtnUrl3(string $btnUrl3): self
    {
        $this->btnUrl3 = $btnUrl3;

        return $this;
    }

    public function getTitle2(): ?string
    {
        return $this->title2;
    }

    public function setTitle2(string $title2): self
    {
        $this->title2 = $title2;

        return $this;
    }

    public function getTitle3(): ?string
    {
        return $this->title3;
    }

    public function setTitle3(string $title3): self
    {
        $this->title3 = $title3;

        return $this;
    }

    public function getBtnTitle2(): ?string
    {
        return $this->btnTitle2;
    }

    public function setBtnTitle2(string $btnTitle2): self
    {
        $this->btnTitle2 = $btnTitle2;

        return $this;
    }

    public function getBtnTitle3(): ?string
    {
        return $this->btnTitle3;
    }

    public function setBtnTitle3(string $btnTitle3): self
    {
        $this->btnTitle3 = $btnTitle3;

        return $this;
    }
}
