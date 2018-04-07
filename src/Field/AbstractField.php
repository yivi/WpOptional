<?php

namespace Yivoff\Wp_Optional\Field;

use Yivoff\VerySimpleHtmlWriter\WriterInterface;
use Yivoff\Wp_Optional\FieldSettings;

abstract class AbstractField
{

    protected $passed_validation = false;
    protected $passed_sanitization = false;

    /**
     * @var FieldSettings
     */
    protected $field_settings;

    public function __construct( FieldSettings $field_settings )
    {

        $this->field_settings = $field_settings;
    }

    public abstract function renderField( WriterInterface $writer ): void;

    public abstract function sanitizeField( $value );

    public function validateField( $value )
    {
        if ( false ) {
            add_settings_error( $this->field_settings->getSettingsKey(), 'invalid', 'something amiss' );

            return false;
        }

        $this->passed_validation = true;

        return $value;
    }
}