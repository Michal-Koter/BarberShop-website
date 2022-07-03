<?php

class Client
{
    private string $firstname;
    private string $lastname;
    private string $email;
    private float $totalCost;
    private float $totalDuration;
    private int $countOfVisits;

    public function __construct(string $firstname, string $lastname, string $email, float $totalDuration=0, float $totalCost=0, int $countOfVisits=0)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->totalCost = $totalCost;
        $this->totalDuration = $totalDuration;
        $this->countOfVisits = $countOfVisits;
    }


    public function getTotalDuration(): float|int
    {
        return $this->totalDuration;
    }/**
     * @param float|int $totalDuration
     */
    public function setTotalDuration(float|int $totalDuration): void
    {
        $this->totalDuration += $totalDuration;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return float|int
     */
    public function getTotalCost(): float|int
    {
        return $this->totalCost;
    }

    /**
     * @param float|int $totalCost
     */
    public function setTotalCost(float|int $totalCost): void
    {
        $this->totalCost += $totalCost;
    }

    /**
     * @return int
     */
    public function getCountOfVisits(): int
    {
        return $this->countOfVisits;
    }

    /**
     * @param int $countOfVisits
     */
    public function setCountOfVisits(int $countOfVisits): void
    {
        $this->countOfVisits = $countOfVisits;
    }

    public static function cmpByAvg($o1, $o2)
    {
        try{
            if (($o1->getTotalCost()/$o1->getCountOfVisits()) > ($o2->getTotalCost()/$o2->getCountOfVisits())) {
                return 1;
            } else if (($o1->getTotalCost()/$o1->getCountOfVisits()) < ($o2->getTotalCost()/$o2->getCountOfVisits())) {
                return -1;
            } else {
                return 0;
            }
        } catch (DivisionByZeroError){
            return -1;
        }

    }


}