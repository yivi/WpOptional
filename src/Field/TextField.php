<?php

namespace Yivoff\Invoicium\Wordpress\Options\Field;

use Yivoff\VerySimpleHtmlWriter\WriterInterface;

class TextField extends AbstractField
{

    public function renderField( WriterInterface $writer ): void
    {
        $fieldHtml = $writer->layout( 'text-' . $this->field_settings->getId() );
        $input     = $writer->tag( 'input' )
                            ->attribute( 'type', 'text' )
                            ->id( $this->field_settings->getSettingsKey() )
                            ->name( $this->field_settings->getSettingsKey() )
                            ->addClass( "regular-text" )
                            ->addClass( $this->field_settings->getClass() )
                            ->value( $this->field_settings->getValue() );

        $extraAtts = $this->field_settings->getExtraAttributes();
        array_walk( $extraAtts, [$input, 'attribute'] );

        $fieldHtml->addParts( $input );

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
        return sanitize_text_field( $value );
    }
}