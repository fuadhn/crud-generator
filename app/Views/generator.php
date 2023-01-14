<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to KUCRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <header class="p-10 bg-blue-50">
        <div class="container max-w-6xl mx-auto">
            <h1 class="text-3xl text-slate-900 font-light mb-1">Welcome to KUCRUD</h1>
            <p class="text-slate-600">KUCRUD is a free no-code PHP CodeIgniter CRUD generator from database.</p>
        </div>
    </header>
    <main class="p-10 pb-20">
        <div class="container max-w-6xl mx-auto">
            <h2 class="text-xl text-slate-900 mb-4">List of Tables</h2>
            <?php if(count($tables) > 0) { ?>
            <?php foreach($tables as $table) { ?>
                <?php if(check_have_pk($table) && check_have_fields($table)) { ?>
                <div class="rounded-xl mb-4 border-[1px] border-blue-100">
                    <div class="flex gap-2 items-center justify-between header-accordion rounded-xl p-4 bg-blue-50" data-id="#contentAcc_<?php echo $table; ?>">
                        <div class="text-blue-600 font-semibold">
                            <h3><?php echo "Table: " . $table; ?></h3>
                        </div>
                        <div class="wrap_label_header_<?php echo $table; ?>" class="text-gray-700">
                            <span>Generate CRUD?</span>&nbsp;
                            <input type="checkbox" class="toggle-accordion" name="generate_<?php echo $table; ?>" data-accordion="#contentAcc_<?php echo $table; ?>" data-table="<?php echo $table; ?>" />&nbsp;Yes
                        </div>
                    </div>
                    <div class="p-4 content-accordion hidden" data-id="#contentAcc_<?php echo $table; ?>">
                        <?php $fields = get_fields($table); ?>
                        <div class="flex flex-col gap-4">
                            <div>
                                <h4 class="text-blue-600 font-semibold mb-4">Table Options</h4>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Subject</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <input type="text" name="set_subject_<?php echo $table; ?>" class="p-1 rounded border-[1px] border-slate-300 set_subject_<?php echo $table; ?>" value="<?php echo get_display_as($table); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Route URI</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <input type="text" name="set_route_<?php echo $table; ?>" class="p-1 rounded border-[1px] border-slate-300 lowercase no-space set_route_<?php echo $table; ?>" value="<?php echo $table; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div><hr></div>

                            <?php $i = 0; ?>
                            <?php foreach($fields as $field) { ?>
                            <div>
                                <h4 class="text-blue-600 font-semibold mb-4"><?php echo "Field: " . $field->name; ?></h4>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Display as</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <input type="text" name="display_as_<?php echo $field->name; ?>" class="p-1 rounded border-[1px] border-slate-300 display_as_<?php echo $table; ?>" value="<?php echo get_display_as($field->name); ?>" data-field="<?php echo $field->name; ?>" />
                                            </div>
                                            
                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Type</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <span><?php echo $field->type . (is_null($field->max_length) ? '' : '(' . $field->max_length. ')'); ?></span>
                                            </div>

                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Null</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <span><?php echo ($field->nullable ? 'Yes' : 'No'); ?></span>
                                            </div>

                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Default</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <span><?php echo (is_null($field->default) ? 'NULL' : $field->default); ?></span>
                                            </div>

                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Primary Key</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <span class="is_primary_<?php echo $table; ?>" data-primary="<?php echo ($field->primary_key ? 'Yes' : 'No'); ?>" data-field="<?php echo $field->name; ?>"><?php echo ($field->primary_key ? 'Yes' : 'No'); ?></span>
                                            </div>

                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Key(s)</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <span><?php echo get_html_keys($field->name, $table); ?></span>
                                            </div>

                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Relation(s)</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <span><?php echo get_html_relations($field->name, $table); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Visible in overview?</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <input type="checkbox" name="columns_<?php echo $field->name; ?>" class="columns_<?php echo $table; ?>" value="1" checked="checked" data-field="<?php echo $field->name; ?>" />&nbsp;<span>Specifying the fields that the end user will see as the datagrid columns.</span>
                                            </div>
                                            
                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Is field?</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <input type="checkbox" name="fields_<?php echo $field->name; ?>" class="fields_<?php echo $table; ?>" value="1" checked="checked" data-field="<?php echo $field->name; ?>" />&nbsp;<span>The fields that will be visible to the end user for form and datagrid columns.</span>
                                            </div>
                                            
                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Is required?</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <input type="checkbox" name="required_fields_<?php echo $field->name; ?>" class="required_fields_<?php echo $table; ?>" value="1" checked="checked" data-field="<?php echo $field->name; ?>" />&nbsp;<span>The most common validation. Checks is the field provided by the user is empty.</span>
                                            </div>
                                            
                                            <div class="text-gray-700 text-sm font-semibold">
                                                <span>Is unique?</span>
                                            </div>
                                            <div class="col-span-2 text-gray-700 text-sm">
                                                <?php if(!check_is_unique($field->name, $table)) { ?>
                                                <input type="checkbox" name="unique_fields_<?php echo $field->name; ?>" class="unique_fields_<?php echo $table; ?>" value="1" data-field="<?php echo $field->name; ?>" />&nbsp;<span>Check if the data for the specified fields are unique. This is used at the insert and the update operation.</span>
                                                <?php } else { ?>
                                                <input type="checkbox" name="unique_fields_<?php echo $field->name; ?>" class="unique_fields_<?php echo $table; ?>" value="1" checked="checked" data-field="<?php echo $field->name; ?>" onclick="return false;" />&nbsp;<span>Check if the data for the specified fields are unique. This is used at the insert and the update operation.</span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($i < count($fields) - 1) { ?>
                            <div><hr></div>
                            <?php } ?>

                            <?php $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
            <?php } else { ?>
            <p class="text-gray-600">No tables defined.</p>
            <?php } ?>
        </div>
    </main>
    <footer class="fixed bottom-0 left-0 w-full bg-white py-4">
        <div class="container max-w-6xl mx-auto">
            <div class="flex justify-between gap-4 items-center">
                <span id="label-selected-tables" class="ml-2 text-gray-700">0/0 table(s) selected.</span>
                <button id="generate-crud" type="button" class="<?php echo (count($tables) > 0 ? 'bg-blue-600' : 'bg-gray-400'); ?> py-2 px-6 rounded text-white font-semibold" <?php echo (count($tables) > 0 ? '' : 'disabled="disabled"'); ?>>Generate CRUD</button>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script type="module" defer>
        $(document).ready(function() {
            var updateSelectedTables = function() {
                $('#label-selected-tables').html($('.toggle-accordion:checked').length + '/' + $('.toggle-accordion').length +' table(s) selected.');
            }

            $(document).on('click', '.reload-page', function(e) {
                e.preventDefault();

                document.location.href = "";
            })

            if($('.no-space').length) {
                $('.no-space').on('keypress', (function(e) {
                    if(e.which === 32) {
                        return false;
                    }
                }))
            }

            if($('.toggle-accordion').length) {
                updateSelectedTables();
                
                $('.toggle-accordion').on('click', function(e) {
                    var accordion = $(this).data('accordion');

                    $('.content-accordion[data-id="' + accordion + '"]').toggleClass('hidden');

                    if($('.content-accordion[data-id="' + accordion + '"]').hasClass('hidden')) {
                        $('.header-accordion[data-id="' + accordion + '"]').removeClass('rounded-br-none rounded-bl-none');
                        $('.header-accordion[data-id="' + accordion + '"]').removeClass('border-b-[1px] border-blue-100');
                    } else {
                        $('.header-accordion[data-id="' + accordion + '"]').addClass('rounded-br-none rounded-bl-none');
                        $('.header-accordion[data-id="' + accordion + '"]').addClass('border-b-[1px] border-blue-100');
                    }

                    updateSelectedTables();
                })
            }

            if($('#generate-crud').length) {
                $('#generate-crud').on('click', (function(e) {
                    e.preventDefault();

                    var _generate_btn = $(this);

                    var _total_checked = $('.toggle-accordion:checked').length;
                    var _total_generated = 1;

                    if(_total_checked > 0) {
                        // Remove uncheck header
                        $('.toggle-accordion:not(:checked)').each(function() {
                            var _table = $(this).data('table');

                            $('.wrap_label_header_' + _table).html('');
                        })

                        // _generate_btn.attr('disabled', 'disabled');
                        // _generate_btn.html('Please wait..');

                        _generate_btn.after('<a href="" type="button" class="bg-gray-600 py-2 px-6 rounded text-white font-semibold">Reset</a>');
                        _generate_btn.remove();

                        $('.toggle-accordion:checked').each(function() {
                            var accordion = $(this).data('accordion');

                            // Close toggle content
                            $('.header-accordion[data-id="' + accordion + '"]').removeClass('rounded-br-none rounded-bl-none');
                            $('.header-accordion[data-id="' + accordion + '"]').removeClass('border-b-[1px] border-blue-100');

                            $('.content-accordion[data-id="' + accordion + '"]').addClass('hidden');

                            var _table = $(this).data('table');
                            var _subject = $('.set_subject_' + _table).val();
                            var _route = $('.set_route_' + _table).val();
                            var _primary_key = ($('.is_primary_' + _table + '[data-primary="Yes"]').length ? $('.is_primary_' + _table + '[data-primary="Yes"]').data('field') : null);
                            var _relation = [];
                            var _display_as = [];
                            var _columns = [];
                            var _fields = [];
                            var _required_fields = [];
                            var _unique_fields = [];
                            var _ai_fields = [];

                            if($('.set_relation_' + _table).length) {
                                $('.set_relation_' + _table).each(function() {
                                    var _field = $(this).data('field');
                                    var _ftable = $(this).data('ftable');
                                    var _column = $(this).find('option:selected').val();

                                    var _temp = {
                                        'field': _field,
                                        'table': _ftable,
                                        'column': _column,
                                    };

                                    _relation.push(_temp);
                                })
                            }

                            if($('.display_as_' + _table).length) {
                                $('.display_as_' + _table).each(function() {
                                    var _field = $(this).data('field');
                                    var _label = $(this).val();

                                    var _temp = {
                                        'field': _field,
                                        'label': _label,
                                    };

                                    _display_as.push(_temp);
                                })
                            }

                            if($('.columns_' + _table).length) {
                                $('.columns_' + _table + ':checked').each(function() {
                                    var _field = $(this).data('field');

                                    _columns.push(_field);
                                })
                            }

                            if($('.fields_' + _table).length) {
                                $('.fields_' + _table + ':checked').each(function() {
                                    var _field = $(this).data('field');

                                    _fields.push(_field);
                                })
                            }

                            if($('.required_fields_' + _table).length) {
                                $('.required_fields_' + _table + ':checked').each(function() {
                                    var _field = $(this).data('field');

                                    _required_fields.push(_field);
                                })
                            }

                            if($('.unique_fields_' + _table).length) {
                                $('.unique_fields_' + _table + ':checked').each(function() {
                                    var _field = $(this).data('field');

                                    _unique_fields.push(_field);
                                })
                            }

                            if($('.auto_increment_' + _table).length) {
                                $('.auto_increment_' + _table + ':checked').each(function() {
                                    var _field = $(this).data('field');

                                    _ai_fields.push(_field);
                                })
                            }

                            var _data = {
                                'table': _table,
                                'subject': _subject,
                                'route': _route,
                                'primary_key': _primary_key,
                                'relation': _relation,
                                'display_as': _display_as,
                                'columns': _columns,
                                'fields': _fields,
                                'required_fields': _required_fields,
                                'unique_fields': _unique_fields,
                                'auto_increment': _ai_fields,
                            };

                            $.ajax({
                                method: 'POST',
                                url: '<?php echo site_url('generator/create'); ?>',
                                data: _data,
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    $('.wrap_label_header_' + _table).html('<svg fill="#16a34a" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="inline" width="20px" height="20px" viewBox="0 0 342.508 342.508" xml:space="preserve"><g><path d="M171.254,0C76.837,0,0.003,76.819,0.003,171.248c0,94.428,76.829,171.26,171.251,171.26 c94.438,0,171.251-76.826,171.251-171.26C342.505,76.819,265.697,0,171.254,0z M245.371,136.161l-89.69,89.69 c-2.693,2.69-6.242,4.048-9.758,4.048c-3.543,0-7.059-1.357-9.761-4.048l-39.007-39.007c-5.393-5.398-5.393-14.129,0-19.521 c5.392-5.392,14.123-5.392,19.516,0l29.252,29.262l79.944-79.948c5.381-5.386,14.111-5.386,19.504,0 C250.764,122.038,250.764,130.769,245.371,136.161z"/></g></svg><span class="ml-2"><a href="' + response.url + '" target="_blank" class="text-sm underline">View page</a></span>');
                                }
                            })
                        })
                    }
                }))
            }
        })
    </script>
</body>
</html>