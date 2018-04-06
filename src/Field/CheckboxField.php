<?php

namespace Yivoff\Invoicium\Wordpress\Options\Field;

use Yivoff\VerySimpleHtmlWriter\WriterInterface;

class CheckboxField extends AbstractField
{

    public function renderField( WriterInterface $writer ): void
    {
        $fieldHtml = $writer->layout( $this->field_settings->getId() );
        $checkbox  = $writer->tag( 'input' )
                            ->attribute( 'type', 'checkbox' )
                            ->value( 1 )
                            ->name( $this->field_settings->getSettingsKey() )
                            ->id( $this->field_settings->getSettingsKey() )
                            ->addClass( 'checkbox' )
                            ->addClass( $this->field_settings->getClass() );

        $extraAtts = $this->field_settings->getExtraAttributes();
        array_walk( $extraAtts, [$checkbox, 'attribute'] );

        if ( $this->field_settings->getValue() == 1 ) {
            $checkbox->attribute( 'checked', 'checked' );
        }

        $fieldHtml->addParts( $checkbox );

        if ( $this->field_settings->getDescription() !== '' ) {
            $labelText = $writer->fragment( $this->field_settings->getDescription() );
            $label     = $writer->tag( 'label' )
                                ->attribute( 'for', $this->field_settings->getSettingsKey() )
                                ->content( $labelText );

            $fieldHtml->addParts( $label );
        }

        echo $fieldHtml->compile();
    }

    public function sanitizeField( $value )
    {
        // we accept only 1 and empty. checkboxes are easy.
        if ( $value == '1' || $value == '' ) {
            return $value;
        }

        return false;
    }
}