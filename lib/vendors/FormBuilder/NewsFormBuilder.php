<?php
namespace FormBuilder;

use \Fram\FormBuilder;
use \Fram\StringField;
use \Fram\TextField;
use \Fram\MaxLengthValidator;
use \Fram\NotNullValidator;

class NewsFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'label' => 'Auteur',
        'name' => 'auteur',
        'maxLength' => 20,
        'class' => 'form-control',
        'validators' => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (20 caractères maximum)', 20),
          new NotNullValidator('Merci de spécifier l\'auteur de la news'),
        ],
       ]))
       ->add(new StringField([
        'label' => 'Titre',
        'name' => 'titre',
        'maxLength' => 100,
        'class' => 'form-control',
        'validators' => [
          new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier le titre de la news'),
        ],
       ]))
       ->add(new TextField([
        'label' => 'Contenu',
        'name' => 'contenu',
        'rows' => 8,
        'cols' => 60,
        'class' => 'form-control',
        'id' => 'TintMCE',
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu de la news'),
        ],
       ]));
  }
}