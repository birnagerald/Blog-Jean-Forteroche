<?php
namespace App\Frontend\Modules\News;
 
use \Fram\BackController;
use \Fram\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \Fram\FormHandler;
 
class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $nombreNews = $this->app->config()->get('nombre_news');
        $nombreCaracteres = $this->app->config()->get('nombre_caracteres');

        // On ajoute une définition pour le titre.
        $this->page->addVar('title', 'Acceuil');

        // On récupère le manager des news.
        $manager = $this->managers->getManagerOf('News');
        $paginationLien = [];
        $nombreDePages = ceil($this->managers->getManagerOf('News')->count() / $nombreNews);

        for ($i = 0; $i < $nombreDePages; $i++) {
            $paginationLien[$i] = $i + 1;
        }
        $lastPage = end($paginationLien);

        $pagination = $request->getData('pagination');
        

        if ($pagination == null) {
            $pagination = 1;
        }
        $currentPage = $pagination;

        if ($pagination > $nombreDePages) {
            $this->app->httpResponse()->redirect404();
        } else {
            $pagination = (($pagination - 1) * 5);

        }

        $listeNews = $manager->getList($pagination, $nombreNews);

        foreach ($listeNews as $news) {
            if (strlen($news->contenu()) > $nombreCaracteres) {
                $debut = substr($news->contenu(), 0, $nombreCaracteres);
                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                $news->setContenu($debut);
            }
        }

        // On ajoute la variable $listeNews à la vue.
        $this->page->addVar('listeNews', $listeNews);

        // On ajoute la variable $paginationLien et $currentPage et $lastPage à la vue.
        $this->page->addVar('paginationLien', $paginationLien);
        $this->page->addVar('currentPage', $currentPage);
        $this->page->addVar('lastPage', $lastPage);
  }
 
  public function executeShow(HTTPRequest $request)
  {
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
 
    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }
 
    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
  }
 
  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
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
 
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
 
      $this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
    }
 
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }
}