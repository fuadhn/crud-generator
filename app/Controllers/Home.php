<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $output = [
            'css_files' => array(),
            'title' => 'Demo KUCRUD',
            'subtitle' => 'KUCRUD is a free no-code PHP CodeIgniter CRUD generator from database.',
            'output' => NULL,
            'js_files' => array(),
        ];

        return $this->_output($output);
    }

    private function _output($output=null) {
        return view('default/output', (array) $output);
    }
}
