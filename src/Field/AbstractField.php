<?php

namespace Yivoff\Invoicium\Wordpress\Options\Field;

use Yivoff\Invoicium\Wordpress\Options\FieldSettings;
use Yivoff\VerySimpleHtmlWriter\WriterInterface;

abstract class AbstractField
{

    protected $passed_validation = false;

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