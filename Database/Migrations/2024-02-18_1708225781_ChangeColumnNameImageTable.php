<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class ChangeColumnNameImageTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE images CHANGE id_address ip_address VARCHAR(255) NOT NULL"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE images CHANGE ip_address id_address VARCHAR(255) NOT NULL"
        ];
    }
}
