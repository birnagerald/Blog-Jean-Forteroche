<?php
namespace Entity;

use \Fram\Entity;

class Users extends Entity
{
    protected $id,
    $name,
    $password,
        $registrationDate;

    const USER_INVALIDE = 1;

    public function isValid()
    {
        return !(empty($this->name) || empty($this->password));
    }

    // SETTERS //

    public function setName($name)
    {
        if (!is_string($name) || empty($name)) {
            $this->erreurs[] = self::USER_INVALIDE;
        }

        $this->name = $name;
    }

    public function setPassword($password)
    {
        if (empty($password)) {
            $this->erreurs[] = self::USER_INVALIDE;
        }

        $this->password = $password;
    }

    public function setRegistrationDate(\DateTime $registrationDate)
  {
    $this->registrationDate = $registrationDate;
  }

    // GETTERS //

    public function name()
    {
        return $this->name;
    }

    public function password()
    {
        return $this->password;
    }

    public function registrationDate()
    {
        return $this->registrationDate;
    }
}