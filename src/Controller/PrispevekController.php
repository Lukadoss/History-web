<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 12. 3. 2016
 * Time: 20:35
 */

namespace App\Controller;

class PrispevekController extends AppController
{
    function newArticle()
    {
        $district = $this->Prispevek->find('all');
        $this->set(compact("district"));
    }

    function detail($prispevek_id)
    {
        $this->set('test', $prispevek_id);
    }

    function edit()
    {

    }
}