<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

/**
 * TPage -> Cria uma página
 * TWindow -> Cria um modal
 */

class NewController extends TPage
{
    # Variavel que vai conter o formulario
    private $form;

    public function __construct() {

        #Construtor da página
        parent::__construct();

        /**
         * BootstrapFormBuilder -> Cria um formulário
         * Parêmetros:
         *     $name
         */
        $this->form = new BootstrapFormBuilder();


        /**
         * TEntry -> Cria o input do formulário
         * Parâmetros:
         *     $name
         */
        $nome = new TEntry('nome');
        $sobrenome = new TEntry('sobrenome');
        $email = new TEntry('email');
        $senha = new TEntry('senha');


        /**
         * addFields -> Adiciona um campo ao formulário
         * 
         * TLabel -> Cria uma label no fomulário
         * Parâmetros:
         *     $value
         *     $color
         *     $fontsize
         *     $decoration
         *     $size
         */
        $row1 = $this->form->addFields(
            [new TLabel('Nome'), $nome],
            [new TLabel('Sobrenome'), $sobrenome],
        );

        $row2 = $this->form->addFields(
            [new TLabel('Email'), $email],
            [new TLabel('Senha'), $senha]
        );


        /**
         * layout -> Altera o layout dos inputs do formulário
         * Parâmetros:
         *     Array contendo os tamanhos de acordo com a quantidade de inputs
         */
        $row1->layout = ['col-6', 'col-6'];
        $row2->layout = ['col-6', 'col-6'];


        /**
         * addAction -> Adiciona botão com uma ação ao formulário
         * Parâmetros:
         *     $label
         *     $action(TAction)
         *     $icon
         *     $name
         * 
         * TAction -> Cria uma ação no botão do formulário
         * Parâmetros:
         *     $action
         *     $parameters
         */
        $btn_save = $this->form->addAction(
            'Salvar',
            new TAction([$this, 'onSalvar']),
            'fa:check-circle #ffffff'
        );

        $btn_clear = $this->form->addAction(
            'Limpar formulário',
            new TAction([$this, 'onLimpar']),
            'fas:eraser #dd5a43'
        );

        $btn_back = $this->form->addAction(
            'Voltar',
            new TAction([$this, 'onMostrar']),
            'fas:arrow-left #ffffff'
        );


        /**
         * addStyleClass -> Adiciona estilo a um componente do formulário
         * Parâmetros:
         *     Classe que contém a estilização desejada
         */
        $btn_save->addStyleClass('btn-primary');
        

        # Adicionando o formulário na página
        parent::add($this->form);
    }

    public function onSalvar() {

        # Pegando o nome do campo input do formulário
        $data = $this->form->getData();

        try {
            /**
             * TTransaction -> Cria uma transação no banco de dados
             * 
             * open() -> Inicia a transação no banco
             * Parâmetros:
             *     $database
             *     $dbinfo
             * 
             * close() -> Encerra a transação no banco de dados
             */
            TTransaction::open('sample');

                $user = new Users();
                $user->nome = $data->nome;
                $user->sobrenome = $data->sobrenome;
                $user->email = $data->email;
                $user->senha = $data->senha;
                $user->store();

            TTransaction::close();

            /**
             * TMessage -> Cria um alert
             * Parâmetros:
             *    $type
             *    $message
             *    $action(TAction)
             *    $title_msg
             */
            new TMessage(
                'info',
                "Todos os dados foram salvos"
            );

        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public function onLimpar() {
        $this->form->clear(true);
    }

    public function onMostrar() {

    }
}