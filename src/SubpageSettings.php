<?php

namespace Yivoff\Wp_Optional;

class SubpageSettings
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
    private $capability;
    /**
     * @var SectionSettingsCollection
     */
    private $sectionCollection;

    public function __construct( string $id, string $title, string $capability, ? SectionSettingsCollection $sectionCollection = null )
    {

        $this->id                = $id;
        $this->title             = $title;
        $this->capability        = $capability;
        $this->sectionCollection = $sectionCollection ?? new SectionSettingsCollection();
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
     */
    public function setId( string $id ): void
    {
        $this->id = $id;
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
     */
    public function setTitle( string $title ): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getCapability(): string
    {
        return $this->capability;
    }

    /**
     * @param string $capability
     */
    public function setCapability( string $capability ): void
    {
        $this->capability = $capability;
    }

    /**
     * @return SectionSettingsCollection
     */
    public function getSections(): SectionSettingsCollection
    {
        return $this->sectionCollection;
    }

    /**
     * @param SectionSettingsCollection $sectionCollection
     */
    public function setSections( SectionSettingsCollection $sectionCollection ): void
    {
        $this->sectionCollection = $sectionCollection;

    }

    /**
     * Factory / Injecter for SectionSettings
     *
     * @param string                  $id
     * @param string                  $title
     * @param string                  $subHeader
     * @param FieldSettingsCollection $fields
     *
     * @return SectionSettings
     */
    public function addSection( string $id, string $title, string $subHeader = '', ? FieldSettingsCollection $fields = null ): SectionSettings
    {
        $section = new SectionSettings( $id, $title, $subHeader, $fields );

        $this->sectionCollection->addSection( $section );

        return $section;
    }


}