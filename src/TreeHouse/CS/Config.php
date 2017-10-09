<?php

declare(strict_types=1);

namespace TreeHouse\CS;

use PhpCsFixer\Config as BaseConfig;

class Config extends BaseConfig
{
    /**
     * @param string $name
     */
    public function __construct($name = 'treehouse')
    {
        parent::__construct($name);

        $this->setRiskyAllowed(true);
    }

    /**
     * @inheritdoc
     */
    public function getRules(): array
    {
        return [
            '@Symfony' => true,
            '@Symfony:risky' => true,
            'align_multiline_comment' => true,
            'array_syntax' => [
                'syntax' => 'short'
            ],
            'combine_consecutive_unsets' => true,
            'concat_space' => [
                'spacing' => 'one',
            ],
            'declare_strict_types' => true,
            'dir_constant' => true,
            'list_syntax' => [
                'syntax' => 'short',
            ],
            'phpdoc_add_missing_param_annotation' => true,
            'phpdoc_inline_tag' => false,
            'phpdoc_order' => true,
            'ternary_to_null_coalescing' => true,
            'yoda_style' => false,
        ];
    }
}
