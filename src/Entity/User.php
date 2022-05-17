<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $facebookID;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $facebookAccessToken;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $GoogleID;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $GoogleAccessToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Get the value of GoogleID
     */ 
    public function getGoogleID()
    {
        return $this->GoogleID;
    }

    /**
     * Set the value of GoogleID
     *
     * @return  self
     */ 
    public function setGoogleID($GoogleID)
    {
        $this->GoogleID = $GoogleID;

        return $this;
    }

    /**
     * Get the value of GoogleAccessToken
     */ 
    public function getGoogleAccessToken()
    {
        return $this->GoogleAccessToken;
    }

    /**
     * Set the value of GoogleAccessToken
     *
     * @return  self
     */ 
    public function setGoogleAccessToken($GoogleAccessToken)
    {
        $this->GoogleAccessToken = $GoogleAccessToken;

        return $this;
    }

    /**
     * Get the value of facebookID
     */ 
    public function getFacebookID()
    {
        return $this->facebookID;
    }

    /**
     * Set the value of facebookID
     *
     * @return  self
     */ 
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;

        return $this;
    }

    /**
     * Get the value of facebookAccessToken
     */ 
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set the value of facebookAccessToken
     *
     * @return  self
     */ 
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }
}
