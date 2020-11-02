<?php

$xpdo_meta_map[psMailingGroup::class] = [
    'package' => 'msprodsub',
    'version' => '1.1',
    'table' => 'msprodsub_mailing_groups',
    'extends' => 'xPDOSimpleObject',
    'tableMeta' =>
        [
            'engine' => 'InnoDB',
        ],
    'fields' =>
        [
            'name' => '',
            'description' => '',
            'class' => 'modResource',
        ],
    'fieldMeta' =>
        [
            'name' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '191',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ],
            'description' =>
                [
                    'dbtype' => 'text',
                    'phptype' => 'string',
                    'null' => true,
                    'default' => '',
                ],
            'class' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '191',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => 'modResource',
                ],
        ],
    'indexes' =>
        [
            'name' =>
                [
                    'alias' => 'name',
                    'primary' => false,
                    'unique' => true,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'name' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
            'class' =>
                [
                    'alias' => 'class',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'class' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
        ],
    'composites' =>
        [
            'Mailing' =>
                [
                    'class' => 'psMailing',
                    'local' => 'name',
                    'foreign' => 'group',
                    'owner' => 'local',
                    'cardinality' => 'many',
                ],
        ],
];
