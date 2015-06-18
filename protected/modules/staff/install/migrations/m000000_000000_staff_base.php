<?php

class m000000_000000_staff_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{staff_staff}}',
            [
                'id'                => 'pk',
                'first_name'        => 'varchar(250) NOT NULL',
                'last_name'         => 'varchar(250) NOT NULL',
                'patronymic'        => 'varchar(250) NOT NULL',
                'image'             => 'varchar(250) DEFAULT NULL',
                'data'              => 'text NOT NULL',
                'sort'			    => 	"integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{staff_staff}}');
    }
}
