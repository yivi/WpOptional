<?php

namespace Yivoff\Wp_Optional;

class SectionSettings
{

    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $subHeader;
    /**
     * @var FieldSettingsCollection
     */
    private $fields;

    public function __construct( string $id, string $title, string $subHeader = '', ? FieldSettingsCollection $fields = null )
    {

        $this->id        = $id;
        $this->title     = $title;
        $this->subHeader = $subHeader;
        $this->fields    = $fields ?? new FieldSettingsCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return SectionSettings
     */
    public function setId( string $id ): SectionSettings
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return SectionSettings
     */
    public function setTitle( string $title ): SectionSettings
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubHeader(): string
    {
        return $this->subHeader;
    }

    /**
     * @param string $subHeader
     *
     * @return SectionSettings
     */
    public function setSubHeader( string $subHeader ): SectionSettings
    {
        $this->subHeader = $subHeader;

        return $this;
    }

    /**
     * @return FieldSettingsCollection
     */
    public function getFields(): FieldSettingsCollection
    {
        return $this->fields;
    }

    /**
     * @param FieldSettingsCollection $fields
     *
     * @return SectionSettings
     */
    public function setFields( FieldSettingsCollection $fields ): SectionSettings
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Field Factory + Injecter
     *
     * @param string $id
     * @param string $title
     * @param string $type
     *
     * @return FieldSettings
     */
    public function addField( string $id, string $title, string $type ): FieldSettings
    {

        $field = new FieldSettings( $id, $title, $type );
        $this->fields->addField( $field );

        return $field;
    }


}