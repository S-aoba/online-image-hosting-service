<?php

namespace Database\Seeds;

use Database\AbstractSeeder;

class SnippetsSeeder extends AbstractSeeder
{

    // TODO: tableName文字列を割り当ててください。
    protected ?string $tableName = "snippets";

    // TODO: tableColumns配列を割り当ててください。
    protected array $tableColumns = [
        [
            'data_type' => 'string',
            'column_name' => 'snippet'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'language'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'path'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'expiration'
        ]
    ];

    public function createRowData(string $snippet, string $language, string $path, string $expiration): array
    {
        // TODO: createRowData()メソッドを実装してください。
        return [
            $snippet,
            $language,
            $path,
            $expiration
        ];
    }
}
