<?php

$xpdo_meta_map[psMailing::class] = [
    'package' => 'msprodsub',
    'version' => '1.1',
    'table' => 'msprodsub_mailings',
    'extends' => 'xPDOSimpleObject',
    'tableMeta' =>
        [
            'engine' => 'InnoDB',
        ],
    'fields' =>
        [
            'name' => '',
            'description' => '',
            'subject' => '',
            'sender' => '',
            'reply_to' => '',
            'template' => 0,
            'attachment' => '',
            'editable' => 1,
            'index' => 0,
            'start_mailing' => 0,
            'control_date_field' => 'iu_control_date',
            'send_email_field' => '',
            'group' => '',
            'active' => 1,
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
            'subject' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '29',
                    'phptype' => 'string',
                    'null' => true,
                    'default' => '',
                ],
            'sender' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '191',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ],
            'reply_to' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '191',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ],
            'template' =>
                [
                    'dbtype' => 'int',
                    'precision' => '10',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ],
            'attachment' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '191',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ],
            'editable' =>
                [
                    'dbtype' => 'tinyint',
                    'precision' => '1',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 1,
                ],
            'index' =>
                [
                    'dbtype' => 'tinyint',
                    'precision' => '1',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ],
            'start_mailing' =>
                [
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ],
            'control_date_field' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '39',
                    'phptype' => 'string',
                    'null' => true,
                    'default' => 'iu_control_date',
                ],
            'send_email_field' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '39',
                    'phptype' => 'string',
                    'null' => true,
                    'default' => '',
                ],
            'group' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '29',
                    'phptype' => 'string',
                    'null' => true,
                    'default' => '',
                ],
            'active' =>
                [
                    'dbtype' => 'tinyint',
                    'precision' => '1',
                    'phptype' => 'boolean',
                    'null' => true,
                    'default' => 1,
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
            'group' =>
                [
                    'alias' => 'group',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'group' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
            'active' =>
                [
                    'alias' => 'active',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'active' =>
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
            'Arrival' =>
                [
                    'class' => 'psArrival',
                    'local' => 'id',
                    'foreign' => 'mailing_index',
                    'owner' => 'local',
                    'cardinality' => 'many',
                ],
        ],
    'aggregates' =>
        [
            'MailingGroup' =>
                [
                    'class' => 'psMailingGroup',
                    'local' => 'group',
                    'foreign' => 'name',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ],
        ],
];
