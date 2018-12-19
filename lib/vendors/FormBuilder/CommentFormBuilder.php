<?php
namespace FormBuilder;

use \Fram\FormBuilder;
use \Fram\MaxLengthValidator;
use \Fram\NotNullValidator;
use \Fram\StringField;
use \Fram\TextField;

class CommentFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form->add(new StringField([
            'label' => 'Pseudo',
            'name' => 'auteur',
            'maxLength' => 50,
            'class' => 'form-control',
            'placeholder' => 'Pseudo...',
            'validators' => [
                new MaxLengthValidator('L\'auteur spécifié est trop long (50 caractères maximum)', 50),
                new NotNullValidator('Merci de spécifier l\'auteur du commentaire'),
            ],
        ]))
            ->add(new TextField([
                'label' => 'Contenu',
                'name' => 'contenu',
                'rows' => 7,
                'cols' => 50,
                'class' => 'form-control',
                'placeholder' => 'Commentaire...',
                'id' => '',
                'validators' => [
                    new NotNullValidator('Merci de spécifier votre commentaire'),
                ],
            ]));
    }
}
