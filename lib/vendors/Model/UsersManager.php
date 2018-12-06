<?php
namespace Model;

use \Fram\Manager;
use \Entity\Users;

abstract class UsersManager extends Manager
{
    /**
   * Méthode permettant d'ajouter un users.
   * @param $users Users Le users à ajouter
   * @return void
   */
  abstract protected function add(Users $users);
  
}