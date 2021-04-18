<?php

namespace app\controllers;

use core\base\View;

class MainController extends AppController {
    
    public function indexAction() {
    
       View::setMeta(
           'TonePHP Framework',
           'TonePHP Framework',
           'TonePHP, framework'
       );
    }
}