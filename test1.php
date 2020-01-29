<?php
require __DIR__.'/vendor/autoload.php';
use FastForms\Forms;

Class LoginForm extends Forms{
    static $form;

    static function show(){
        self::$form = [
            'method' => 'POST',
            'action' => '#'
        ];
        $all = self::tags();
        foreach($all as $data){
            echo $data."\n";
        }
    }


    function tags(){
        return self::parse([
            'username' => [
                'classes' => ['data', 'test'],
                'name' => 'data',
            ],
            'input' => [
                'tag' => 'input',
                'type' => 'password',
                'name' => 'data',
            ],
            'button' => [
                'tag' => 'button',
                'type' => 'button',
                'text' => 'Confirm'
            ],
            'submit' => [
                'classes' => ['no', 'test'],
                'value' => 'test',
            ],
        ], self::$form);
    }


}
//echo LoginForm::tags();
LoginForm::show();
//echo LoginForm::username(['data', 'hej'], 'form');
?>