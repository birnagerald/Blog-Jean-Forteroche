<?php
namespace App\Frontend\Modules\News;

use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \Fram\BackController;
use \Fram\HTTPRequest;

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

        if ($pagination == null || $pagination == 0) {
            $pagination = 1;
        }
        $currentPage = $pagination;

        if ($pagination > $nombreDePages) {
            $this->app->httpResponse()->redirect404();
        } else {
            $pagination = (($pagination - 1) * $nombreNews);

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

    public function executeReportComment(HTTPRequest $request)
    {
        $commentInfo = $this->managers->getManagerOf('Comments')->get($request->getData('id'));

        if ($commentInfo['report'] == 0) {
            $this->managers->getManagerOf('Comments')->report($request->getData('id'));
            $this->app->httpResponse()->addHTTPCode(201);
        } elseif ($commentInfo['report'] == 1) {
            $this->app->httpResponse()->addHTTPCode(429);
        } elseif (empty($commentInfo)) {
            $this->app->httpResponse()->addHTTPCode(400);
        } else {
            $this->app->httpResponse()->addHTTPCode(503);
        }

    }

    public function executeShow(HTTPRequest $request)
    {
        $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));

        if (empty($news)) {
            $this->app->httpResponse()->redirect404();
        }

        $this->page->addVar('title', $news->titre());
        $this->page->addVar('news', $news);
        $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));

        $comment = new Comment;

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $this->page->addVar('form', $form->createView());

    }

    public function executeInsertComment(HTTPRequest $request)
    {
        // Si le formulaire a été envoyé.
        if ($request->method() == 'POST') {
            if (empty($request->postData('auteur')) || empty($request->postData('contenu'))) {
                $this->app->httpResponse()->addHTTPCode(400);
            } else {
                $comment = new Comment([
                    'news' => $request->getData('news'),
                    'auteur' => $request->postData('auteur'),
                    'contenu' => $request->postData('contenu'),
                ]);
                $this->managers->getManagerOf('Comments')->add($comment);
                $lastComment = $this->managers->getManagerOf('Comments')->getLastComment();
                $this->app->httpResponse()->redirect('news-' . $request->getData('news') . '.html');

            }

        } else {

            $this->app->httpResponse()->addHTTPCode(503);
        }

    }
}
