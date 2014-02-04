<?php

namespace App\Controller;

use App\Framework\BaseController;
use League\Plates\Template;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends BaseController
{
    public function indexAction()
    {
        /** @var Template $template */
        $template = $this->render('Index::home');

        (new Response($template))->send();
    }
}
