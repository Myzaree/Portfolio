<?php

namespace App\Controller;

use App\Framework\Base\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $template = $this->render('Home/index');
        $this->response($template);
    }
}
