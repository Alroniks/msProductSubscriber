<?php

$xpdo_meta_map[psArrival::class] = [
    'package' => 'msprodsub',
    'version' => '1.1',
    'table' => 'msprodsub_arrivals',
    'extends' => 'xPDOSimpleObject',
    'tableMeta' =>
        [
            'engine' => 'InnoDB',
        ],
    'fields' =>
        [
            'res_id' => 0,
            'mailing_index' => 2,
            'title' => '',
            'uri' => '',
            'thumb' => null,
            'createdon' => 0,
            'updatedon' => 0,
            'senddate' => 0,
            'email' => '',
            'user_id' => 0,
            'count' => 1,
            'status' => 1,
            'confirmed' => 0,
            'hash' => '',
        ],
    'fieldMeta' =>
        [
            'res_id' =>
                [
                    'dbtype' => 'int',
                    'precision' => '10',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 0,
                ],
            'mailing_index' =>
                [
                    'dbtype' => 'int',
                    'precision' => '2',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 2,
                ],
            'title' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '191',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ],
            'uri' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ],
            'thumb' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => true,
                ],
            'createdon' =>
                [
                    'dbtype' => 'int',
                    'precision' => '20',
                    'phptype' => 'timestamp',
                    'null' => false,
                    'default' => 0,
                ],
            'updatedon' =>
                [
                    'dbtype' => 'int',
                    'precision' => '20',
                    'phptype' => 'timestamp',
                    'null' => false,
                    'default' => 0,
                ],
            'senddate' =>
                [
                    'dbtype' => 'int',
                    'precision' => '20',
                    'phptype' => 'timestamp',
                    'null' => false,
                    'default' => 0,
                ],
            'email' =>
                [
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ],
            'user_id' =>
                [
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ],
            'count' =>
                [
                    'dbtype' => 'int',
                    'precision' => '10',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 1,
                ],
            'status' =>
                [
                    'dbtype' => 'int',
                    'precision' => '1',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 1,
                ],
            'confirmed' =>
                [
                    'dbtype' => 'int',
                    'precision' => '1',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ],
            'hash' =>
                [
                    'dbtype' => 'char',
                    'precision' => '40',
                    'phptype' => 'string',
                    'null' => true,
                    'default' => '',
                ],
        ],
    'indexes' =>
        [
            'res_id' =>
                [
                    'alias' => 'res_id',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'res_id' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
            'mailing_index' =>
                [
                    'alias' => 'mailing_index',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'mailing_index' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
            'title' =>
                [
                    'alias' => 'title',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'title' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
            'email' =>
                [
                    'alias' => 'email',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'email' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
            'user_id' =>
                [
                    'alias' => 'user_id',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'user_id' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => true,
                                ],
                        ],
                ],
            'status' =>
                [
                    'alias' => 'status',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'status' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
            'hash' =>
                [
                    'alias' => 'hash',
                    'primary' => false,
                    'unique' => true,
                    'type' => 'BTREE',
                    'columns' =>
                        [
                            'hash' =>
                                [
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ],
                        ],
                ],
        ],
    'aggregates' =>
        [
            'Mailing' =>
                [
                    'class' => 'psMailing',
                    'local' => 'mailing_index',
                    'foreign' => 'id',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ],
            'Resource' =>
                [
                    'class' => 'modResource',
                    'local' => 'id',
                    'foreign' => 'id',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ],
            'User' =>
                [
                    'class' => 'modUser',
                    'local' => 'user_id',
                    'foreign' => 'id',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ],
            'UserProfile' =>
                [
                    'class' => 'modUserProfile',
                    'local' => 'user_id',
                    'foreign' => 'internalKey',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ],
        ],
];
