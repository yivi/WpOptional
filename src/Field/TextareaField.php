<?php

namespace Yivoff\Invoicium\Wordpress\Options\Field;

use Yivoff\VerySimpleHtmlWriter\WriterInterface;

class TextareaField extends AbstractField
{

    public function renderField( WriterInterface $writer ): void
    {
        $fieldHtml       = $writer->layout( 'textarea-' . $this->field_settings->getId() );
        $textareaContent = $writer->fragment( $this->field_settings->getValue() );
        $textarea        = $writer->tag( 'textarea' )
                                  ->id( $this->field_settings->getSettingsKey() )
                                  ->name( $this->field_settings->getSettingsKey() )
                                  ->addClass( $this->field_settings->getClass() )
                                  ->content( $textareaContent );

        $extraAtts = $this->field_settings->getExtraAttributes();
        array_walk( $extraAtts, [$textarea, 'attribute'] );

        if ( ! in_array( "col", $this->field_settings->getExtraAttributes() ) ) {
            $textarea->attribute( 'cols', "30" );
        }

        if ( ! in_array( "col", $this->field_settings->getExtraAttributes() ) ) {
            $textarea->attribute( 'rows', "5" );
        }

        $fieldHtml->addParts( $textarea );

        if ( $this->field_settings->getDescription() !== '' ) {
            $labelText = $writer->fragment( $this->field_settings->getDescription() );
            $br        = $writer->tag( 'br' );
            $label     = $writer->tag( 'label' )
                                ->attribute( 'for', $this->field_settings->getSettingsKey() )
                                ->content( $labelText );

            $fieldHtml->addParts( $br, $label );
        }

        echo $fieldHtml->compile();
    }

    public function sanitizeField( $value )
    {
        return sanitize_textarea_field( $value );
    }
}