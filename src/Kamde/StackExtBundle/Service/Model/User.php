<?php

namespace Kamde\StackExtBundle\Service\Model;

use Kamde\StackExtBundle\Service\Resource\ResourceNormalizer;

class User extends AbstractModel
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $type;

    /** @var string */
    protected $displayName;

    /** @var string */
    protected $link;

    /** @var int */
    protected $reputation;

    /** @var string */
    protected $profileImage;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return User
     */
    public function setType(string $type): User
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return User
     */
    public function setDisplayName(string $displayName): User
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return User
     */
    public function setLink(string $link): User
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return int
     */
    public function getReputation(): int
    {
        return $this->reputation;
    }

    /**
     * @param int $reputation
     * @return User
     */
    public function setReputation(int $reputation): User
    {
        $this->reputation = $reputation;

        return $this;
    }

    /**
     * @return string
     */
    public function getProfileImage(): string
    {
        return $this->profileImage;
    }

    /**
     * @param string $profileImage
     * @return User
     */
    public function setProfileImage(string $profileImage): User
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        $resourceNormalizer = new ResourceNormalizer();
        $posts = $this->resource->getPosts()->getItems();

        return $resourceNormalizer->normalizeCollection(Post::class, $posts);
    }
}