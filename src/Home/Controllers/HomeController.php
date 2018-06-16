<?php

namespace Home\Controllers;

use Core\Controller\AbstractController;
use Core\View\View;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class HomeController extends AbstractController
{
    /**
     * @return View
     */
    public function indexAction()
    {
        $this->render('home/index', [
            'name' => 'teste'
        ]);
    }
}
