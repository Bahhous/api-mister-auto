<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CharOccurenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Api\FindMostOccurenceAction;

/**
 * @ApiResource(
 *      itemOperations={
 *          "get_most_occurence"={
 *              "method"="GET",
 *              "path"="/find_most_occurence/{id}",
 *              "controller"=FindMostOccurenceAction::class,
 *              "read"=false,
 *              "normalization_context"={"groups"={"read"}}
 *          },
 *      },
 *      collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/history",
 *              "normalization_context"={"groups"={"read"}}
 *          },
 *      },
 *      attributes={
 *          "pagination_items_per_page"=10
 *     }
 * )
 * @ORM\Entity(repositoryClass=CharOccurenceRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class CharOccurence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     * @Groups({"read"})
     */
    private $top_char;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $occurence_number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopChar(): ?string
    {
        return $this->top_char;
    }

    public function setTopChar(string $top_char): self
    {
        $this->top_char = $top_char;

        return $this;
    }

    public function getOccurenceNumber(): ?int
    {
        return $this->occurence_number;
    }

    public function setOccurenceNumber(int $occurence_number): self
    {
        $this->occurence_number = $occurence_number;

        return $this;
    }
}
