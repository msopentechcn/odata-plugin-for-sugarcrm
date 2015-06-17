<?php

$manifest = array(
    'acceptable_sugar_versions' =>
    array(
        'regex_matches' => array(
            0 => "5\.*\.*",
            1 => "6\.*\.*",
            2 => "7\.*\.*"
        ),
    ),
    'acceptable_sugar_flavors' =>
    array(
        'CE', 'PRO', 'ENT'
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
    'version' => '1.7',
    'remove_tables' => 'prompt',
);

$installdefs = array(
    'id' => 'SugarOData',
    'beans' =>
    array (
        array (
            'module' => 'suga_SugarOData',
            'class' => 'suga_SugarOData',
            'path' => 'modules/suga_SugarOData/suga_SugarOData.php',
            'tab' => true,
        ),
    ),
    'administration' =>
    array(
        array(
            'from' => '<basepath>/administration/SugarodataAdmin.menu.php',
        ),
    ),
    'copy' =>
    array(
        array(
            'from' => '<basepath>/icons/default/images/icon_sugarodata_32.gif',
            'to' => 'custom/themes/default/images/icon_sugarodata.gif',
        ),
        array(
            'from' => '<basepath>/icons/default/images/sugarodata.gif',
            'to' => 'custom/themes/default/images/sugarodata.gif',
        ),
        array(
            'from' => '<basepath>/odata',
            'to' => 'custom/odata',
        ),
        array(
            'from' => '<basepath>/custom',
            'to' => 'custom',
        ),
        array (
            'from' => '<basepath>/SugarModules/modules/suga_SugarOData',
            'to' => 'modules/suga_SugarOData',
        ),
    ),
    'language' =>
    array(
        array(
            'from' => '<basepath>/language/en_us.SugarodataAdmin.php',
            'to_module' => 'Administration',
            'language' => 'en_us'
        ),
        array (
            'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
            'to_module' => 'application',
            'language' => 'en_us',
        ),
    ),
);
