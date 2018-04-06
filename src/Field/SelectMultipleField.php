<?php

namespace Yivoff\Invoicium\Wordpress\Options\Field;

use Yivoff\VerySimpleHtmlWriter\WriterInterface;

class SelectMultipleField extends AbstractField
{

    public function renderField( WriterInterface $writer ): void
    {
        $fieldHtml = $writer->layout( $this->field_settings->getId() );
        $select    = $writer->tag( 'select' )
                            ->id( $this->field_settings->getSettingsKey() )
                            ->name( $this->field_settings->getSettingsKey() . '[]' )
                            ->addClass( 'select' )
                            ->addClass( $this->field_settings->getClass() )
                            ->attribute( 'multiple', 'multiple' );

        $extraAtts = $this->field_settings->getExtraAttributes();
        array_walk( $extraAtts, [$select, 'attribute'] );

        $optionsHtml = $writer->layout( 'options_' . $this->field_settings->getId() );

        foreach ( $this->field_settings->getChoices() as $value => $label ) {
            $option = $writer->tag( 'option' )
                             ->value( $value )
                             ->content( $writer->fragment( $label ) );

            if ( is_array( $this->field_settings->getValue() ) && in_array( $value, $this->field_settings->getValue() ) ) {
                $option->attribute( 'selected', '' );
            }

            $optionsHtml->addParts( $option );
        }
        unset( $value );
        unset( $label );

        $select->content( $optionsHtml );
        $fieldHtml->addParts( $select );

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

    public function sanitizeField( $values )
    {
        foreach ( $values as $key => $value ) {
            // we only accept a value that is included in the available choices for this field
            if ( ! in_array( $value, array_keys( $this->field_settings->getChoices() ) ) ) {
                unset ($values[$key]);
            }
        }

        // if the value passed wasn't acceptable, we reset the one we had.
        return $values;
    }

}