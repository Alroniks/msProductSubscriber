<?php
$xpdo_meta_map['msInformUserMailing']= array (
  'package' => 'msinformuser',
  'version' => '1.1',
  'table' => 'msinformuser_mailing',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
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
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '191',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'subject' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '29',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'sender' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '191',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'reply_to' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '191',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'template' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'attachment' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '191',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'editable' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => true,
      'default' => 1,
    ),
    'index' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'start_mailing' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'control_date_field' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '39',
      'phptype' => 'string',
      'null' => true,
      'default' => 'iu_control_date',
    ),
    'send_email_field' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '39',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'group' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '29',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
    ),
  ),
  'indexes' => 
  array (
    'name' => 
    array (
      'alias' => 'name',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'name' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'group' => 
    array (
      'alias' => 'group',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'group' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'active' => 
    array (
      'alias' => 'active',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'active' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Arrival' => 
    array (
      'class' => 'msInformUserArrival',
      'local' => 'id',
      'foreign' => 'mailing_index',
      'owner' => 'local',
      'cardinality' => 'many',
    ),
  ),
  'aggregates' => 
  array (
    'MailingGroup' => 
    array (
      'class' => 'msInformUserMailingGroup',
      'local' => 'group',
      'foreign' => 'name',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
