<?php

namespace Yivoff\Wp_Optional;


use Traversable;

class SectionSettingsCollection implements \IteratorAggregate
{

    /**
     * @var SectionSettings[]
     */
    private $sections;

    public function __construct( SectionSettings ... $sections )
    {

        $this->sections = $sections;

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
        return new \ArrayIterator( $this->sections );
    }

    /**
     * @param SectionSettings $section
     *
     * @return SectionSettingsCollection
     */
    public function addSection( SectionSettings $section ): SectionSettingsCollection
    {

        $this->sections[] = $section;

        return $this;
    }

}