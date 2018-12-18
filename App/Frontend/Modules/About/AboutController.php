<?php
namespace App\Frontend\Modules\About;

use \Fram\BackController;
use \Fram\HTTPRequest;

class AboutController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {

        // On ajoute une définition pour le titre.
        $this->page->addVar('title', 'À propos');
        $this->page->addvar('bg', '/images/about-bg.jpg');
        $this->page->addvar('mainTitle', 'L\'AUTEUR');
        $this->page->addvar('secondTitle', '');

    }
}
