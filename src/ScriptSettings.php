<?php

namespace Yivoff\Wp_Optional;

class ScriptSettings
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
    /**
     * @var bool
     */
    private $in_footer;

    public function __construct( $handle, $file = null, $dependencies = [], $version = '', $in_footer = false )
    {
        $this->handle       = $handle;
        $this->file         = $file;
        $this->dependencies = $dependencies;
        $this->in_footer    = $in_footer;
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
     * @return ScriptSettings
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
     * @return ScriptSettings
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
     * @return ScriptSettings
     */
    public function setDependencies( array $dependencies ): ScriptSettings
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
     * @return ScriptSettings
     */
    public function setVersion( string $version ): ScriptSettings
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return bool
     */
    public function isInFooter(): bool
    {
        return $this->in_footer;
    }

    /**
     * @param bool $in_footer
     *
     * @return ScriptSettings
     */
    public function setInFooter( bool $in_footer ): ScriptSettings
    {
        $this->in_footer = $in_footer;

        return $this;
    }


}