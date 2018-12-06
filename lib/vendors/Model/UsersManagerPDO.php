<?php
namespace Model;

use \Entity\Users;

class UsersManagerPDO extends UsersManager
{
    public function add(Users $users)
    {
        $requete = $this->dao->prepare('INSERT INTO users SET name = :name, password = :password, registration_date = NOW()');

        $requete->bindValue(':password', $users->password());
        $requete->bindValue(':name', $users->name());

        $requete->execute();
    }

    public function getPw($login)
    {
        $requete = $this->dao->prepare('SELECT password FROM users WHERE name = :name');
        $requete->bindValue(':name', $login);
        $requete->execute();

        if (!empty($requete)) {

            $data = $requete->fetchColumn();
            return $data;
            
        }

        return null;
    }
}
