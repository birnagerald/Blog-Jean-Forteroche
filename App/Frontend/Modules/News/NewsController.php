<?php
namespace App\Frontend\Modules\News;

use \Fram\BackController;
use \Fram\HTTPRequest;
use \Entity\Comment;
use \Fram\Form;
use \Fram\StringField;
use \Fram\TextField;

class NewsController extends BackController
{
  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé, on crée le commentaire avec les valeurs du formulaire.
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'news' => $request->getData('news'),
        'auteur' => $request->postData('auteur'),
        'contenu' => $request->postData('contenu')
      ]);
    }
    else
    {
      $comment = new Comment;
    }
    
    $form = new Form($comment);
    
    $form->add(new StringField([
        'label' => 'Auteur',
        'name' => 'auteur',
        'maxLength' => 50,
       ]))
       ->add(new TextField([
        'label' => 'Contenu',
        'name' => 'contenu',
        'rows' => 7,
        'cols' => 50,
       ]));
    
    if ($form->isValid())
    {
      // On enregistre le commentaire
    }
    
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView()); // On passe le formulaire généré à la vue.
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }
}