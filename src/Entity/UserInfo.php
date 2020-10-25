<?php

namespace App\Entity;

use App\Repository\UserInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserInfoRepository::class)
 */
class UserInfo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_of_birth;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $religious_holiday;

    /**
     * @ORM\Column(type="date")
     */
    private $religious_date;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $school;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", length=16)
     */
    private $cellphone;

    /**
     * @ORM\Column(type="integer", length=20)
     */
    private $unique_citizen_number;

    /**
     * @ORM\Column(type="boolean")
     */
    private $married;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $partner_name;

    /**
     * @ORM\Column(type="integer", length=2)
     */
    private $kids_count;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @param mixed $date_of_birth
     */
    public function setDateOfBirth($date_of_birth): void
    {
        $this->date_of_birth = $date_of_birth;
    }

    /**
     * @return mixed
     */
    public function getnationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setnationality($nationality): void
    {
        $this->nationality = $nationality;
    }

    /**
     * @return mixed
     */
    public function getReligiousHoliday()
    {
        return $this->religious_holiday;
    }

    /**
     * @param mixed $religious_holiday
     */
    public function setReligiousHoliday($religious_holiday): void
    {
        $this->religious_holiday = $religious_holiday;
    }

    /**
     * @return mixed
     */
    public function getReligiousDate()
    {
        return $this->religious_date;
    }

    /**
     * @param mixed $religious_date
     */
    public function setReligiousDate($religious_date): void
    {
        $this->religious_date = $religious_date;
    }

    /**
     * @return mixed
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param mixed $school
     */
    public function setSchool($school): void
    {
        $this->school = $school;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * @param mixed $cellphone
     */
    public function setCellphone($cellphone): void
    {
        $this->cellphone = $cellphone;
    }

    /**
     * @return mixed
     */
    public function getUniqueCitizenNumber()
    {
        return $this->unique_citizen_number;
    }

    /**
     * @param mixed $unique_citizen_number
     */
    public function setUniqueCitizenNumber($unique_citizen_number): void
    {
        $this->unique_citizen_number = $unique_citizen_number;
    }

    /**
     * @return mixed
     */
    public function getMarried()
    {
        return $this->married;
    }

    /**
     * @param mixed $married
     */
    public function setMarried($married): void
    {
        $this->married = $married;
    }

    /**
     * @return mixed
     */
    public function getPartnerName()
    {
        return $this->partner_name;
    }

    /**
     * @param mixed $partner_name
     */
    public function setPartnerName($partner_name): void
    {
        $this->partner_name = $partner_name;
    }

    /**
     * @return mixed
     */
    public function getKidsCount()
    {
        return $this->kids_count;
    }

    /**
     * @param mixed $kids_count
     */
    public function setKidsCount($kids_count): void
    {
        $this->kids_count = $kids_count;
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
    }

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

}
