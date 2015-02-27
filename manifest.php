<?php

$manifest = array(
    'acceptable_sugar_versions' =>
    array(
        'regex_matches' => array(
            0 => "5\.*\.*",
            1 => "6\.*\.*"
        ),
    ),
    'acceptable_sugar_flavors' =>
    array(
        'CE'
    ),
    'readme' => 'SugarCRM OData intergration',
    'key' => 'sugarodata',
    'author' => 'MS Opentech',
    'description' => 'SugarCRM OData intergration',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'SugarCRM OData',
    'published_date' => '2014-12-05 08:00:00',
    'type' => 'module',
    'version' => '1.0',
    'remove_tables' => 'prompt',
);

$installdefs = array(
    'id' => 'SugarOData',
    'beans' =>
    array(
        0 =>
        array(
            'module' => 'sugarodata',
            'class' => 'sugarodata',
            'path' => 'modules/sugarodata/sugarodata.php',
            'tab' => false,
        ),
    ),
    'administration' =>
    array(
        0 =>
        array(
            'from' => '<basepath>/administration/SugarodataAdmin.menu.php',
        ),
    ),
    'copy' =>
    array(
        0 =>
        array(
            'from' => '<basepath>/SugarModules/modules/sugarodata',
            'to' => 'modules/sugarodata',
        ),
        1 =>
        array(
            'from' => '<basepath>/icons/default/images/icon_sugarodata_32.gif',
            'to' => 'custom/themes/default/images/icon_sugarodata.gif',
        ),
        2 =>
        array(
            'from' => '<basepath>/icons/default/images/sugarodata.gif',
            'to' => 'custom/themes/default/images/sugarodata.gif',
        ),
        3 => 
        array(
            'from' => '<basepath>/odata',
            'to' => 'odata',            
        ),
    ),
    'language' =>
    array(
        0 =>
        array(
            'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
            'to_module' => 'application',
            'language' => 'en_us',
        ),
        1 =>
        array(
            'from' => '<basepath>/language/en_us.SugarodataAdmin.php',
            'to_module' => 'Administration',
            'language' => 'en_us'
        ),
    ),
);
