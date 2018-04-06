<?php

namespace Yivoff\Wp_Optional;

class StyleSettings
{

    private $handle;
    private $file;
    /**
     * @var array
     */
    private $dependencies;
    /**
     * @var mixed
     */
    private $version;

    private $media;

    public function __construct( $handle, $file = null, $dependencies = [], $version = '', $media = '' )
    {

        $this->handle       = $handle;
        $this->file         = $file;
        $this->dependencies = $dependencies;
        $this->media        = $media;
        $this->version      = $version;
    }

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $handle
     *
     * @return StyleSettings
     */
    public function setHandle( $handle )
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     *
     * @return StyleSettings
     */
    public function setFile( $file )
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    /**
     * @param array $dependencies
     *
     * @return StyleSettings
     */
    public function setDependencies( array $dependencies ): StyleSettings
    {
        $this->dependencies = $dependencies;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return StyleSettings
     */
    public function setVersion( string $version ): StyleSettings
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return bool
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param bool $media
     *
     * @return StyleSettings
     */
    public function setMedia( bool $media ): StyleSettings
    {
        $this->media = $media;

        return $this;
    }


}