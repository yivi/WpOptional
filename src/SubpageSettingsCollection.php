<?php

namespace Yivoff\Wp_Optional;

use Traversable;

class SubpageSettingsCollection implements \IteratorAggregate, \ArrayAccess, \Countable
{

    /**
     * @var SubpageSettings[]
     */
    private $subpageSettings = [];

    public function __construct( SubpageSettings ... $subpageSettings )
    {

        $this->subpageSettings = $subpageSettings;
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
        return new \ArrayIterator( $this->subpageSettings );
    }

    /**
     *
     * @param SubpageSettings $subPage
     *
     * @return SubpageSettingsCollection
     */
    public function addSubpage( SubpageSettings $subPage ): SubpageSettingsCollection
    {
        $this->subpageSettings[] = $subPage;

        return $this;
    }

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists( $offset )
    {
        return isset( $this->subpageSettings[$offset] );
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet( $offset )
    {
        return $this->subpageSettings[$offset];
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet( $offset, $value )
    {
        if ( ! $value instanceof SubpageSettings ) {
            throw new \InvalidArgumentException( 'We only take Subpage settings here. Don\'t bring other stuff' );
        }
        $this->subpageSettings[$offset] = $value;

    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset( $offset )
    {
        if ( $this->offsetExists( $offset ) ) {
            unset( $this->subpageSettings[$offset] );
        }
    }

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count( $this->subpageSettings );
    }

    public function toArray(): array
    {
        return $this->subpageSettings;
    }

    /**
     * @param $subSection
     *
     * @return null|SubpageSettings
     */
    public function findById( string $subSection ): ?SubpageSettings
    {

        foreach ( $this->subpageSettings as $subPage ) {
            if ( $subSection === $subPage->getId() ) {
                return $subPage;
            }
        }

        return null;

    }
}