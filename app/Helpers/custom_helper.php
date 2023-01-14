<?php

if(!function_exists('check_have_pk')) {
    function check_have_pk($table, $purge=false) {
        $db = db_connect();
        $pk = false;

        if($purge) {
            $keys = $db->getIndexData($table);
        } else {
            if (! $keys = cache('keys_' . $table)) {
                $keys = $db->getIndexData($table);
            
                cache()->save('keys_' . $table, $keys, 300);
            }
        }

        foreach($keys as $key => $value) {
            if($key == 'PRIMARY') {
                $pk = true;
            }
        }

        return $pk;
    }
}

if(!function_exists('check_have_fields')) {
    function check_have_fields($table, $purge=false) {
        $db = db_connect();
        
        if($purge) {
            $fields = $db->getFieldData($table);
        } else {
            if (! $fields = cache('fields_' . $table)) {
                $fields = $db->getFieldData($table);
            
                cache()->save('fields_' . $table, $fields, 300);
            }
        }

        return (count($fields) > 0 ? true : false);
    }
}

if(!function_exists('get_fields')) {
    function get_fields($table, $purge=false) {
        $db = db_connect();
        
        if($purge) {
            $fields = $db->getFieldData($table);
        } else {
            if (! $fields = cache('fields_' . $table)) {
                $fields = $db->getFieldData($table);
            
                cache()->save('fields_' . $table, $fields, 300);
            }
        }

        return $fields;
    }
}

if(!function_exists('get_html_keys')) {
    function get_html_keys($field, $table, $purge=false) {
        $db = db_connect();
        
        $html = "";
        $arr = array();

        if($purge) {
            $keys = $db->getIndexData($table);
        } else {
            if (! $keys = cache('keys_' . $table)) {
                $keys = $db->getIndexData($table);
            
                cache()->save('keys_' . $table, $keys, 300);
            }
        }

        foreach($keys as $key) {
            if(in_array($field, $key->fields)) {
                $arr[] = $key->type;
            }
        }

        if(count($arr) > 0) {
            $html .= '<div class="flex flex-col gap-4">';

            foreach($arr as $type) {
                $html .= '<div>';
                $html .= '<h5 class="font-semibold">' . $type . '</h5>';

                if($type == 'PRIMARY') {
                    $html .= '<input type="checkbox" name="auto_increment_' . $field . '" class="auto_increment_' . $table . '" value="1" data-field="' . $field . '" />&nbsp;<span>Is auto increment?</span>';
                }

                $html .= '</div>';
            }

            $html .= '</div>';
        }

        return (count($arr) > 0 ? $html  : 'None');
    }
}

if(!function_exists('get_html_relations')) {
    function get_html_relations($field, $table, $purge=false) {
        $db = db_connect();
        
        $html = "";
        $arr = array();

        if($purge) {
            $fkeys = $db->getForeignKeyData($table);
        } else {
            if (! $fkeys = cache('fkeys_' . $table)) {
                $fkeys = $db->getForeignKeyData($table);
            
                cache()->save('fkeys_' . $table, $fkeys, 300);
            }
        }

        foreach($fkeys as $fkey) {
            if(in_array($field, $fkey->column_name)) {
                $j = null;
                $i = 0;

                foreach($fkey->column_name as $column) {
                    if($field == $column) {
                        $j = $i;
                    }

                    $i++;
                }

                $temp = array(
                    'constraint_name' => $fkey->constraint_name,
                    'column_name' => $fkey->column_name[$j],
                    'foreign_table_name' => $fkey->foreign_table_name,
                    'foreign_column_name' => $fkey->foreign_column_name[$j],
                    'on_delete' => $fkey->on_delete,
                    'on_update' => $fkey->on_update,
                    'match' => $fkey->match
                );

                array_push($arr, $temp);
            } else {
                continue;
            }
        }

        if(count($arr) > 0) {
            $html .= '<div class="flex flex-col gap-4">';

            foreach($arr as $item) {
                if($purge) {
                    $ffields = $db->getFieldData($item['foreign_table_name']);
                } else {
                    if (! $ffields = cache('fields_' . $item['foreign_table_name'])) {
                        $ffields = $db->getFieldData($item['foreign_table_name']);
                    
                        cache()->save('fields_' . $item['foreign_table_name'], $ffields, 300);
                    }
                }

                $html .= '<div>';
                $html .= '<h5 class="font-semibold">' . $item['constraint_name'] . '</h5>';
                $html .= '<p>' . $item['foreign_table_name'] . '.' . $item['foreign_column_name'] . '</p>';
                $html .= '<p class="text-xs mb-2">ON DELETE (' . $item['on_delete'] . '), ON UPDATE (' . $item['on_update'] . ')</p>';

                $html .= '<div class="flex items-center gap-1">';
                $html .= '<span>Visible column</span>';
                $html .= '<select class="p-1 bg-white rounded border-[1px] border-slate-300 set_relation_' . $table . '" name="' . $item['constraint_name'] . '" data-field="' . $field . '" data-ftable="' . $item['foreign_table_name'] . '">';

                foreach($ffields as $ffield) {
                    $html .= '<option value="' . $ffield->name . '">' . $ffield->name . '</option>';
                }

                $html .= '</select>';
                $html .= '</div>';

                $html .= '</div>';
            }

            $html .= '</div>';
        } else {
            $html = 'None';
        }

        return $html;
    }
}

if(!function_exists('get_display_as')) {
    function get_display_as($field) {
        $field = str_replace('_', ' ', $field);
        $arr_str = explode(' ', $field);
        $arr_result = array();

        foreach($arr_str as $str) {
            $arr_result[] = ucfirst($str);
        }

        return implode(' ', $arr_result);
    }
}

if(!function_exists('check_is_unique')) {
    function check_is_unique($field, $table, $purge=false) {
        $db = db_connect();
        
        $is_unique = false;
        
        if($purge) {
            $keys = $db->getIndexData($table);
        } else {
            if (! $keys = cache('keys_' . $table)) {
                $keys = $db->getIndexData($table);
            
                cache()->save('keys_' . $table, $keys, 300);
            }
        }

        foreach($keys as $key) {
            if(in_array($field, $key->fields)) {
                if($key->type == 'UNIQUE') {
                    $is_unique = true;
                }
            }
        }

        return $is_unique;
    }
}