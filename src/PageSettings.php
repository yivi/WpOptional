<?php

namespace Yivoff\Wp_Optional;


class PageSettings
{

    /**
     * @var string
     */
    private $pageId;
    /**
     * @var string
     */
    private $pageTitle;
    /**
     * @var string
     */
    private $menuTitle;
    /**
     * @var string
     */
    private $parentPage;
    /**
     * @var string
     */
    private $capability;
    /**
     * @var string
     */
    private $themeId;
    /**
     * @var SubpageSettingsCollection
     */
    private $subPages;

    protected $scripts = [];

    protected $styles = [];


    public function __construct(
        string $pageId,
        string $pageTitle,
        string $menuTitle,
        string $parentPage,
        string $capability,
        string $themeId = '',
        ? SubpageSettingsCollection $subPages = null
    ) {

        $this->pageId     = $pageId;
        $this->pageTitle  = $pageTitle;
        $this->menuTitle  = $menuTitle;
        $this->parentPage = $parentPage;
        $this->capability = $capability;
        $this->themeId    = $themeId;
        $this->subPages   = $subPages ?? new SubpageSettingsCollection();
    }

    /**
     * @return string
     */
    public function getPageId(): string
    {
        return $this->pageId;
    }

    /**
     * @param string $pageId
     */
    public function setPageId( string $pageId ): void
    {
        $this->pageId = $pageId;
    }

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    /**
     * @param string $pageTitle
     */
    public function setPageTitle( string $pageTitle ): void
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return string
     */
    public function getMenuTitle(): string
    {
        return $this->menuTitle;
    }

    /**
     * @param string $menuTitle
     */
    public function setMenuTitle( string $menuTitle ): void
    {
        $this->menuTitle = $menuTitle;
    }

    /**
     * @return string
     */
    public function getParentPage(): string
    {
        return $this->parentPage;
    }

    /**
     * @param string $parentPage
     */
    public function setParentPage( string $parentPage ): void
    {
        $this->parentPage = $parentPage;
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
     * @return string
     */
    public function getThemeId(): string
    {
        return $this->themeId;
    }

    /**
     * @param string $themeId
     */
    public function setThemeId( string $themeId ): void
    {
        $this->themeId = $themeId;
    }

    /**
     * @return SubpageSettingsCollection
     */
    public function getSubPages(): SubpageSettingsCollection
    {
        return $this->subPages;
    }

    /**
     * @param SubpageSettingsCollection $subPages
     *
     * @return PageSettings
     */
    public function setSubPages( SubpageSettingsCollection $subPages ): PageSettings
    {
        $this->subPages = $subPages;

        return $this;
    }

    public function addSubpage( string $id, string $title, string $capability, ? SectionSettingsCollection $sectionCollection = null )
    {
        $subPage = new SubpageSettings( $id, $title, $capability, $sectionCollection );

        $this->subPages->addSubpage( $subPage );

        return $subPage;
    }

    public function addScripts( ScriptSettings ... $script_settings )
    {
        $this->scripts = array_merge( $this->scripts, $script_settings );
    }

    public function addScript( $handle, $file = null , $dependencies = [], $version = '', $in_footer = false )
    {
        $script = new ScriptSettings( $handle, $file, $dependencies, $version, $in_footer );

        $this->scripts[] = $script;

        return $this;

    }

    public function getScripts()
    {
        return $this->scripts;
    }

    public function addStyles( StyleSettings ... $style_settings )
    {
        $this->styles = array_merge( $this->styles, $style_settings );
    }

    public function addStyle( $handle, $file = null, $dependencies = [], $version = '', $media = '' )
    {
        $style          = new StyleSettings( $handle, $file, $dependencies, $version, $media );
        $this->styles[] = $style;

        return $this;
    }

    public function getStyles()
    {
        return $this->styles;
    }


}