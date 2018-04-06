<?php

namespace Yivoff\Wp_Optional\Field;

use Yivoff\VerySimpleHtmlWriter\WriterInterface;

class RadioField extends AbstractField
{

    public function renderField( WriterInterface $writer ): void
    {
        $id_counter = 0;
        $fieldHtml  = $writer->layout( 'radio-' . $this->field_settings->getId() );

        if ( $this->field_settings->getDescription() !== '' ) {
            $labelText = $writer->fragment( $this->field_settings->getDescription() );
            $br        = $writer->tag( 'br' );
            $label     = $writer->tag( 'label' )
                                ->content( $labelText );

            $fieldHtml->addParts( $br, $label );
        }

        foreach ( $this->field_settings->getChoices() as $value => $label ) {
            $radio = $writer->tag( 'input' )
                            ->attribute( 'type', 'radio' )
                            ->name( $this->field_settings->getSettingsKey() )
                            ->id( $this->field_settings->getSettingsKey() . '_' . ++$id_counter )
                            ->value( $value );

            if ( $this->field_settings->getValue() == $value ) {
                $radio->attribute( 'checked', 'checked' );
            }

            $labelText = $writer->fragment( $label );
            $labelHtml = $writer->tag( 'label' )
                                ->attribute( 'for', $this->field_settings->getSettingsKey() . '_' . $id_counter )
                                ->content( $labelText );

            $fieldHtml->addParts( $radio, $labelHtml );
            //if ( $id_counter < count( $options ) - 1 ) {
            //    echo '<br />';
            //}
        }
    }

    public function sanitizeField( $value )
    {
        if ( in_array( $value, array_keys( $this->field_settings->getChoices() ) ) ) {

            return $value;
        }

        // if the value passed wasn't acceptable, we reset the one we had.
        return get_option( $this->field_settings->getSettingsKey(), '' );
        // TODO: Would be nice to shortcut saving altogether.
    }
}