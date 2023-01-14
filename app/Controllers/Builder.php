<?php

namespace App\Controllers;

class Builder extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $tables = $db->listTables();
        
        return view('builder', array(
            'tables' => $tables
        ));
    }


    public function create() {
        $request = \Config\Services::request();
        $response = array();

        $file = fopen("./app/Controllers/" . ucfirst($request->getPost('table')) . ".php","w");

        $contents = "<?php
        namespace App\Controllers;
        
        use App\Libraries\GroceryCrud;
        
        class " . ucfirst($request->getPost('table')) . " extends BaseController {
            public function index() {
                \$crud = new GroceryCRUD();
        
                \$crud->setTable('" . $request->getPost('table') . "');
                \$crud->setSubject('" . $request->getPost('subject') . "');
                
                " . (!is_null($request->getPost('primary_key')) ? "\$crud->setPrimaryKey('" . $request->getPost('primary_key') . "', '" . $request->getPost('table') . "');\n" : "\n");

        // Relations
        $relations = (array) $request->getPost('relation');

        if(count($relations) > 0) {
            foreach($relations as $relation) {
                $contents .= "\t\t\t\t\$crud->setRelation('" . $relation['field'] . "', '" . $relation['table'] . "', '" . $relation['column'] . "');\n";
            }
        }

        // Display as
        $display_as = (array) $request->getPost('display_as');

        if(count($display_as) > 0) {
            $contents .= "\n";
            foreach($display_as as $da) {
                $contents .= "\t\t\t\t\$crud->displayAs('" . $da['field'] . "', '" . $da['label'] . "');\n";
            }
        }

        // Columns
        $columns = (array) $request->getPost('columns');

        if(count($columns) > 0) {
            $contents .= "\n";

            $i=1;
            $str_columns = "";
            foreach($columns as $column) {
                $str_columns .= "'" . $column . "'" . ($i==count($columns) ? "" : ",");

                $i++;
            }

            $contents .= "\t\t\t\t\$crud->columns([" . $str_columns . "]);\n";
        }

        $auto_increment = (array) $request->getPost('auto_increment');

        // Fields
        $fields = (array) $request->getPost('fields');

        if(count($fields) > 0) {
            $i=1;
            $str_fields = "";
            foreach($fields as $field) {
                if(in_array($field, $auto_increment)) {
                    continue;
                }

                $str_fields .= "'" . $field . "'" . ($i==count($fields) ? "" : ",");

                $i++;
            }

            $contents .= "\t\t\t\t\$crud->fields([" . $str_fields . "]);\n";
        }

        // Required Fields
        $required_fields = (array) $request->getPost('required_fields');

        if(count($required_fields) > 0) {
            $i=1;
            $str_required_fields = "";
            foreach($required_fields as $required_field) {
                if(in_array($field, $auto_increment)) {
                    continue;
                }

                $str_required_fields .= "'" . $required_field . "'" . ($i==count($required_fields) ? "" : ",");

                $i++;
            }

            $contents .= "\t\t\t\t\$crud->requiredFields([" . $str_required_fields . "]);\n";
        }

        // Unique Fields
        $unique_fields = (array) $request->getPost('unique_fields');

        if(count($unique_fields) > 0) {
            $i=1;
            $str_unique_fields = "";
            foreach($unique_fields as $unique_field) {
                if(in_array($field, $auto_increment)) {
                    continue;
                }
                
                $str_unique_fields .= "'" . $unique_field . "'" . ($i==count($unique_fields) ? "" : ",");

                $i++;
            }

            $contents .= "\t\t\t\t\$crud->uniqueFields([" . $str_unique_fields . "]);\n";
        }

        $contents .= "\n\t\t\t\t\$output = \$crud->render();
                \$output->title = '" . $request->getPost('subject') . "';

                return \$this->_output(\$output);
            }

            private function _output(\$output=null) {
                return view('default/output', (array) \$output);
            }
        }";

        // Create controller
        fwrite($file, $contents);
        fclose($file);

        // Remove route before
        $file = file_get_contents("./app/Config/Routes.php");
        $start = strpos($file, "#start-" . $request->getPost('table'));
        $end = strpos($file, "#end-" . $request->getPost('table'));
        $length = $end-$start+strlen("#end-" . $request->getPost('table'));

        if(strpos($file, "#start-" . $request->getPost('table')) !== false && strpos($file, "#end-" . $request->getPost('table')) !== false) {
            $file = substr_replace($file, '', $start, $length);
            file_put_contents("./app/Config/Routes.php", $file);
        }

        // Rewrite route
        $fp = fopen('./app/Config/Routes.php', 'a');
        $contents = "#start-" . $request->getPost('table') . "
        \$routes->get('/" . $request->getPost('route') . "', '" . ucfirst($request->getPost('table')) . "::index');
        \$routes->get('/" . $request->getPost('route') . "/(:any)', '" . ucfirst($request->getPost('table')) . "::index/$1');
        \$routes->post('/" . $request->getPost('route') . "/(:any)', '" . ucfirst($request->getPost('table')) . "::index/$1');
        #end-" . $request->getPost('table');

        fwrite($fp, $contents);
        fclose($fp);

        $response['url'] = site_url($request->getPost('route'));

        echo json_encode($response);
    }
}
