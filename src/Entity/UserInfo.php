<?php

namespace App\Entity;

use App\Exceptions\InvalidContractRoleException;
use App\Repository\UserInfoRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserInfoRepository::class)
 */
class UserInfo
{

    /* Literally placeholder for no_team */
    const TEAM_NONE = 0;

    /**
     * ==========================================
     * Contract types
     * Add any contract types that you add to VALID_CONTRACTS. This constant is used to check if CONTRACT is valid or not
     */
    const VALID_CONTRACTS = [
        self::CONTRACT_TYPE_PERM, self::CONTRACT_TYPE_TEMP
    ];
    const CONTRACT_TYPE_PERM = "permanent";
    const CONTRACT_TYPE_TEMP = "temporarily";

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_of_birth;

    /**
     * @var string
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $nationality;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $religious_holiday;

    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $religious_date;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $school;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $address;

    /**
     * @var integer
     * @ORM\Column(type="integer", length=16, nullable=true)
     */
    private $cellphone;

    /**
     * @var integer
     * @ORM\Column(type="integer", length=20, nullable=true)
     */
    private $unique_citizen_number;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $married;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $partner_name;

    /**
     * @var integer
     * @ORM\Column(type="integer", length=2, nullable=true)
     */
    private $kids_count;

    /**
     * @var string
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $contract_type;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $contract_end_date;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="userInfo")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return DateTime|null
     */
    public function getDateOfBirth(): ?DateTime
    {
        return $this->date_of_birth;
    }

    /**
     * @param DateTime $date_of_birth
     */
    public function setDateOfBirth(DateTime $date_of_birth): void
    {
        $this->date_of_birth = $date_of_birth;
    }

    /**
     * @return string|null
     */
    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     */
    public function setNationality(string $nationality): void
    {
        $this->nationality = $nationality;
    }

    /**
     * @return string|null
     */
    public function getReligiousHoliday(): ?string
    {
        return $this->religious_holiday;
    }

    /**
     * @param string $religious_holiday
     */
    public function setReligiousHoliday(string $religious_holiday): void
    {
        $this->religious_holiday = $religious_holiday;
    }

    /**
     * @return DateTime|null
     */
    public function getReligiousDate(): ?DateTime
    {
        return $this->religious_date;
    }

    /**
     * @param DateTime $religious_date
     */
    public function setReligiousDate(DateTime $religious_date): void
    {
        $this->religious_date = $religious_date;
    }

    /**
     * @return string|null
     */
    public function getSchool(): ?string
    {
        return $this->school;
    }

    /**
     * @param string $school
     */
    public function setSchool(string $school): void
    {
        $this->school = $school;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return int|null
     */
    public function getCellphone(): ?int
    {
        return $this->cellphone;
    }

    /**
     * @param int $cellphone
     */
    public function setCellphone(int $cellphone): void
    {
        $this->cellphone = $cellphone;
    }

    /**
     * @return int|null
     */
    public function getUniqueCitizenNumber(): ?int
    {
        return $this->unique_citizen_number;
    }

    /**
     * @param int $unique_citizen_number
     */
    public function setUniqueCitizenNumber(int $unique_citizen_number): void
    {
        $this->unique_citizen_number = $unique_citizen_number;
    }

    /**
     * @return bool|null
     */
    public function isMarried(): ?bool
    {
        return $this->married;
    }

    /**
     * @param bool $married
     */
    public function setMarried(bool $married): void
    {
        $this->married = $married;
    }

    /**
     * @return string|null
     */
    public function getPartnerName(): ?string
    {
        return $this->partner_name;
    }

    /**
     * @param string $partner_name
     */
    public function setPartnerName(string $partner_name): void
    {
        $this->partner_name = $partner_name;
    }

    /**
     * @return int|null
     */
    public function getKidsCount(): ?int
    {
        return $this->kids_count;
    }

    /**
     * @param int $kids_count
     */
    public function setKidsCount(int $kids_count): void
    {
        $this->kids_count = $kids_count;
    }

    /**
     * @return string|null
     */
    public function getContractType(): ?string
    {
        return $this->contract_type;
    }

    /**
     * @param string $contract_type
     * @throws InvalidContractRoleException
     */
    public function setContractType(string $contract_type): void
    {
        if (!$this->isValidContract($contract_type)) {
            throw new InvalidContractRoleException("Invalid contract type " . $contract_type);
        }
        $this->contract_type = $contract_type;
    }

    /**
     * @param string $contract
     * @return bool
     */
    public function isValidContract(string $contract): bool
    {
        return in_array($contract, self::VALID_CONTRACTS);
    }

    /**
     * @return mixed
     */
    public function getContractEndDate()
    {
        return $this->contract_end_date;
    }

    /**
     * @param mixed $contract_end_date
     */
    public function setContractEndDate($contract_end_date): void
    {
        $this->contract_end_date = $contract_end_date;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->user_id = $user->getId();
    }


}
