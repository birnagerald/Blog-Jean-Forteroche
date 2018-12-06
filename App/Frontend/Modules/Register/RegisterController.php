<?php
namespace App\Frontend\Modules\Register;

use \Entity\Users;
use \Fram\BackController;
use \Fram\HTTPRequest;

class RegisterController extends BackController
{

    public function executeIndex(HTTPRequest $request)
    {
        // if ($request->method() == 'POST') {

        //     if (!empty($request->postData('name')) && !empty($request->postData('password'))) {
        //         $hash = password_hash($request->postData('password'), PASSWORD_BCRYPT);
        //         $users = new Users([
        //             'name' => $request->postData('name'),
        //             'password' => $hash,
        //         ]);

        //         $this->managers->getManagerOf('Users')->add($users);

        //         $this->app->user()->setFlash('Vous êtes maintenant inscrit !');
        //         $this->app->httpResponse()->redirect('.');
        //     }
        //     else{
        //         $this->app->user()->setFlash('Il faut remplir les champs !');
        //     }

        // }
        //  Décommenter cette ligne et commenter executeIndex() pour désactiver la fonctionnalité d'inscription
         $this->app->httpResponse()->redirectDisable();
    }

}
