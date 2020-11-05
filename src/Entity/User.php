<?php

namespace App\Entity;

use App\Exceptions\InvalidUserRoleException;
use App\Repository\UsersRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{

    /**
     * ==========================================
     * Types
     * Add any roles that you add to VALID_ROLES. This constant is used to check if ROLE is valid or not
     */
    const VALID_ROLES = [
        self::USER_ROLE_NORMAL, self::USER_ROLE_ADMIN, self::USER_ROLE_DEVELOPER,
    ];
    const USER_ROLE_NORMAL      = "normal";
    const USER_ROLE_ADMIN       = "administrator";
    const USER_ROLE_DEVELOPER   = "developer";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type = self::USER_ROLE_NORMAL;

    /**
     * @var UserInfo
     * @ORM\OneToMany(targetEntity="UserInfo", mappedBy="user")
     * @ORM\JoinColumn(name="id", referencedColumnName="user_id")
     */
    private $userInfo;


    /**
     * @var DateTime
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $registrationDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @return DateTime
     */
    public function getRegistrationDate(): DateTime
    {
        return $this->registrationDate;
    }

    /**
     * @param DateTime $registrationDate
     */
    public function setRegistrationDate(DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return UserInfo
     */
    public function getUserInfo(): UserInfo
    {
        return $this->userInfo;
    }

    /**
     * @param UserInfo $userInfo
     */
    public function setUserInfo(UserInfo $userInfo): void
    {
        $this->userInfo = $userInfo;
    }

    /**
     * @return mixed
     */
    public function getFirstName() : string
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName() : string
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @throws InvalidUserRoleException
     */
    public function setType($type): void
    {
        if(!self::isValidRole($type))
        {
            throw new InvalidUserRoleException("Role ".$type." is not a valid role");
        }
        $this->type = $type;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function getRoles() : array
    {
        return [
            self::USER_ROLE_NORMAL,
            self::USER_ROLE_ADMIN,
            self::USER_ROLE_DEVELOPER
        ];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @param string $role
     * @return bool
     */
    public static function isValidRole(string $role) : bool
    {
        return in_array($role, self::VALID_ROLES);
    }
}
