<?php

namespace Yivoff\Wp_Optional;


use Traversable;

class FieldSettingsCollection implements \IteratorAggregate
{

    /**
     * @var FieldSettings[]
     */
    private $fieldSettings;

    public function __construct( FieldSettings ... $fieldSettings )
    {

        $this->fieldSettings = (array)$fieldSettings;
    }

    /**
     * Retrieve an external iterator
     *
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->fieldSettings );
    }

    /**
     * @param FieldSettings $setting
     *
     * @return FieldSettingsCollection
     */
    public function addField( FieldSettings $setting ): FieldSettingsCollection
    {
        $this->fieldSettings[] = $setting;

        return $this;
    }

}