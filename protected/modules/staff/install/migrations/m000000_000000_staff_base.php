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
                'position_id'       => 'integer DEFAULT NULL',
                'contact_id'        => 'integer DEFAULT NULL',
            ],
            $this->getOptions()
        );

        $this->createTable(
            '{{staff_position}}',
            [
                'id'                => 'pk',
                'name'              => 'varchar(250) NOT NULL',
                'duties'            => 'varchar(250) NOT NULL',
            ],
            $this->getOptions()
        );

        $this->createTable(
            '{{staff_contact}}',
            [
                'id'                => 'pk',
                'data'              => 'varchar(250) NOT NULL',
                'data_type'         => 'integer DEFAULT NULL',
                'staff_id'          => 'integer DEFAULT NULL',
            ],
            $this->getOptions()
        );

    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{staff_staff}}');
        $this->dropTableWithForeignKeys('{{staff_position}}');
        $this->dropTableWithForeignKeys('{{staff_contact}}');
    }
}
