<?php

namespace App\Entity;

use App\Exceptions\User\InvalidUserRoleException;
use App\Exceptions\User\InvalidUserStatusException;
use App\Repository\UsersRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{

    const INVALID_ACCOUNT_AFTER = "- 30days";

    /**
     * ==========================================
     * Status
     * Add any statuses that you add to VALID_STATUSES. This constant is used to check if STATUS is valid or not
     */
    const VALID_STATUSES = [
        self::USER_STATUS_ACTIVE, self::USER_STATUS_INACTIVE, self::USER_STATUS_PENDING,
        self::USER_STATUS_BANNED,
    ];
    const USER_STATUS_ACTIVE = "active";
    const USER_STATUS_INACTIVE = "inactive";
    const USER_STATUS_PENDING = "pending";
    const USER_STATUS_BANNED = "banned";

    /**
     * ==========================================
     * Types
     * Add any roles that you add to VALID_ROLES. This constant is used to check if ROLE is valid or not
     */
    const VALID_ROLES = [
        self::ROLE_ADMIN, self::ROLE_DEVELOPER, self::ROLE_NORMAL,
        self::ROLE_PENDING,
    ];
    const MAPPED_ROLES = [
        self::ROLE_ADMIN => "ROLE_ADMIN",
        self::ROLE_PENDING => "ROLE_PENDING",
        self::ROLE_DEVELOPER => "ROLE_DEVELOPER",
        self::ROLE_NORMAL => "ROLE_NORMAL",
    ];
    const ROLE_PENDING = "pending";
    const ROLE_NORMAL = "normal";
    const ROLE_ADMIN = "administrator";
    const ROLE_DEVELOPER = "developer";
    /**
     * @ORM\OneToOne(targetEntity="TeamMembers", mappedBy="user")
     */
    protected $teamMember;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @Assert\NotBlank(message="First name cannot be empty")
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $first_name;
    /**
     * @Assert\NotBlank(message="Last name cannot be empty")
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
    private $role = self::ROLE_PENDING;
    /**
     * @var UserInfo
     * @ORM\OneToOne(targetEntity="UserInfo", mappedBy="user", cascade={"persist"})
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
     * @var string
     * @ORM\Column(type="string", length=20)
     */
    private $status = self::USER_STATUS_PENDING;

    /**
     * @return mixed
     */
    public function getTeamMember()
    {
        return $this->teamMember;
    }

    /**
     * @param mixed $teamMember
     */
    public function setTeamMember($teamMember): void
    {
        $this->teamMember = $teamMember;
    }

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
    public function getFirstName(): string
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
    public function getLastName(): string
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
    public function getPassword(): string
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
    public function getEmail(): string
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return [
            self::MAPPED_ROLES[$this->getRole()]
        ];
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @throws InvalidUserRoleException
     */
    public function setRole(string $role): void
    {
        if (!self::isValidRole($role)) {
            throw new InvalidUserRoleException("Invalid user role " . $role);
        }
        $this->role = $role;
    }

    /**
     * @param string $role
     * @return bool
     */
    public static function isValidRole(string $role): bool
    {
        return in_array($role, self::VALID_ROLES);
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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @throws InvalidUserStatusException
     */
    public function setStatus(string $status): void
    {
        if (!self::isValidStatus($status)) {
            throw new InvalidUserStatusException("Status " . $status . " is not a valid status");
        }
        $this->status = $status;
    }

    /**
     * @param string $status
     * @return bool
     */
    public static function isValidStatus(string $status): bool
    {
        return in_array($status, self::VALID_STATUSES);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

}
