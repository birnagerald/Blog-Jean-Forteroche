<?php
namespace App\Backend\Modules\Connexion;
 
use \Fram\BackController;
use \Fram\HTTPRequest;
 
class ConnexionController extends BackController
{
  protected function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Connexion');

    if ($request->postExists('login')) {
        $login = $request->postData('login');
        $password = $request->postData('password');
        $pw = $this->managers->getManagerOf('Users')->getPw($login);

        if (password_verify($password, $pw)) {
            $this->app->user()->setAuthenticated(true);
            $this->app->user()->setAttribute('start', time());
            $this->app->user()->setAttribute('expire', ($_SESSION['start'] + (35 * 60)));
            $this->app->httpResponse()->redirect('.');

        } else {
            $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
        }
    }
  }

  public function executeLogout(HTTPRequest $request)
    {
        $this->app->user()->logout();
        $this->app->httpResponse()->redirect('.');

    }
}