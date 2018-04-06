<?php

namespace Yivoff\Wp_Optional;

use Yivoff\Wp_Optional\Field\TextField;
use Yivoff\VerySimpleHtmlWriter\HtmlWriterService;

/**
 * Created by PhpStorm.
 * User: yivi
 * Date: 18/12/14
 * Time: 22:23
 *
 * V 0.5.0 (20180327)
 */
class Page
{

    private $settingsKey;
    /**
     * @var HtmlWriterService
     */
    private $writer;
    /**
     * @var PageSettings
     */
    private $settings;

    /**
     * OptionsPage constructor.
     *
     * @param PageSettings      $settings
     * @param HtmlWriterService $writer
     */
    function __construct( PageSettings $settings, HtmlWriterService $writer )
    {
        $this->writer   = $writer;
        $this->settings = $settings;

        // if it's a theme, we use the 'theme_mods_' prefix to use the theme option functions (customizer support, etc)
        if ( $this->settings->getThemeId() !== '' ) {
            $this->settingsKey = 'theme_mods_' . $this->settings->getThemeId();
        } else {
            $this->settingsKey = $this->settings->getPageId();
        }

    }

    /**
     *  To be used on 'admin_init' action hook
     */
    public function register_settings()
    {
        // We iterate all the subpages this Options Page has:
        /** @var SubpageSettings $subPage */
        foreach ( $this->settings->getSubPages() as $subPage ) {

            // Each subpage can have multiple sections
            /** @var SectionSettings $section */
            foreach ( $subPage->getSections() as $section ) {

                // And each section may have multiple fiealds
                /** @var FieldSettings $field */
                foreach ( $section->getFields() as $field ) {

                    if ( class_exists( $field->getType() ) ) {
                        $validatorClass = $field->getType();

                        /** @var Field\AbstractField $validator */
                        $validator = new $validatorClass( $field );

                    } else {
                        $validator = new TextField( $field );
                    }

                    // just before sanitization, we call the validator, which can add validation errors to the output
                    // (although no error markup to the fields with errors)
                    add_filter( 'sanitize_option_' . $field->getSettingsKey(), [$validator, 'validateField'], 9 );

                    // For each existing field, we register the setting
                    register_setting( $this->settings->getPageId() . '_' . $subPage->getId(), $field->getSettingsKey(),
                        [
                            'type'              => 'string',
                            'description'       => $field->getDescription(),
                            'sanitize_callback' => [$validator, 'sanitizeField'],
                            'show_in_rest'      => true,
                            'default'           => $field->getDefault() ?? '',
                        ] );
                }
            }
        }

    }

    /**
     * To be used in 'admin_menu' action hook
     */
    public function settings_init()
    {

        foreach ( $this->settings->getSubPages() as $subPage ) {
            /** @var SubpageSettings $subPage */

            foreach ( $subPage->getSections() as $section ) {
                /** @var SectionSettings $section */
                add_settings_section(
                    $section->getId(),
                    $section->getTitle(),
                    function () use ( $section ) {
                        echo $section->getSubHeader();
                    },
                    $this->settings->getPageId() . "_" . $subPage->getId()
                );

                /** @var FieldSettings $fieldSetting */
                foreach ( $section->getFields() as $fieldSetting ) {

                    if ( ! empty( $fieldSetting->getScriptRequirements() ) ) {
                        $this->settings->addScripts( ... $fieldSetting->getScriptRequirements() );

                    }

                    if ( ! empty( $fieldSetting->getStyleRequirements() ) ) {
                        $this->settings->addStyles( ... $fieldSetting->getStyleRequirements() );

                    }

                    $fieldSetting->setSettingsKey( $this->settingsKey . "_" . $subPage->getId() . "_" . $fieldSetting->getId() );
                    $fieldSetting->setValue(get_option($fieldSetting->getSettingsKey()));

                    add_settings_field( $fieldSetting->getId(),
                        $fieldSetting->getTitle(),
                        [$this, 'render_field'],
                        $this->settings->getPageId() . "_" . $subPage->getId(),
                        $section->getId(),
                        $fieldSetting->asArray()
                    );

                }
            }
        }
    }

    /**
     * To be used in 'admin_menu' action hook
     */
    public function add_page()
    {

        add_submenu_page(
            $this->settings->getParentPage(),
            $this->settings->getPageTitle(),
            $this->settings->getMenuTitle(),
            $this->settings->getCapability(),
            $this->settings->getPageId(),
            [$this, 'display_page'] );

    }

    public function enqueue_assets( $hook )
    {
        // we only enqueue if the hook matches the expected for this setting page
        if ( get_plugin_page_hookname( $this->settingsKey, $this->settings->getParentPage() ) === $hook ) {

            /** @var ScriptSettings $script */
            foreach ( $this->settings->getScripts() as $script ) {

                if ( $script->getFile() === null ) {
                    wp_enqueue_script( $script->getHandle() );
                } else {
                    wp_enqueue_script(
                        $script->getHandle(),
                        $script->getFile(),
                        $script->getDependencies(),
                        $script->getVersion(),
                        $script->isInFooter()
                    );
                }
            }

            /** @var StyleSettings $style */
            foreach ( $this->settings->getStyles() as $style ) {
                if ( $style->getFile() === null ) {
                    wp_enqueue_style( $style->getHandle() );
                } else {
                    wp_enqueue_style(
                        $style->getHandle(),
                        $style->getFile(),
                        $style->getDependencies(),
                        $style->getVersion(),
                        $style->getMedia()
                    );
                }
            }
        }
    }

    /**
     * To be used as a callback for add_submenu_page()
     *
     * @throws InvalidOptionsConfigurationException
     */
    public function display_page()
    {

        // if no subpages were configured, we bail out.
        if ( ! count( $this->settings->getSubPages() ) ) {
            throw new InvalidOptionsConfigurationException( 'No subpages configured. Nothing to render.' );
        }

        $subPageLink = $_GET['subpage'] ?? $this->settings->getSubPages()[0]->getId();
        $subPage     = $this->settings->getSubPages()->findById( $subPageLink );

        if ( is_null( $subPage ) ) {
            throw new InvalidOptionsConfigurationException( 'Trying to get subpage ' . $subPageLink
                                                            . ', but it doesn\'t appear to be defined. Sad face.' );
        }

        $layout = $this->writer->layout( 'main' );
        $div    = $this->writer->tag( 'div' )->attribute( 'class', 'wrap' )->leaveOpen();
        $icon   = $this->writer->tag( 'div' )
                               ->attribute( 'class', 'icon32' )
                               ->attribute( 'id', 'icon-options-general' )
                               ->content( $this->writer->fragment( '' ) );
        $h2     = $this->writer->tag( 'h2' )
                               ->content( $this->writer->fragment( $this->settings->getPageTitle() . ' - ' . $subPage->getTitle() ) );

        $layout->addParts( $div, $icon, $h2 );

        $navigation = [];
        /** @var SubpageSettings $fsubPage */
        foreach ( $this->settings->getSubPages() as $fsubPage ) {
            // for each registered subpage, we add a navigation element to the top
            $linkText  = $this->writer->fragment( $fsubPage->getTitle() );
            $url       = get_admin_url( null, $this->settings->getParentPage() ) . "?" .
                         http_build_query( ['page' => $this->settings->getPageId(), 'subpage' => $fsubPage->getId(),] );
            $separator = $this->writer->fragment( ' - ' );

            // if the id of the subpage is the same than the one we are iterating, no need for an anchor.
            if ( $subPage->getId() == $fsubPage->getId() ) {
                $navigation[] = $linkText;
            } else {
                // otherwise, we surround the $linkText with an anchor.

                $anchor       = $this->writer->tag( 'a' )
                                             ->content( $linkText )
                                             ->attribute( 'href', $url );
                $navigation[] = $anchor;

            }
            // a new separator after each part
            $navigation[] = $separator;

        }

        // we remove the dangling separator.
        array_pop( $navigation );

        // add all the navigation parts to the layout
        $layout->addParts( ... $navigation );


        // open the form, but leave open because WP will printout the settings fields on its own in the middle.
        $form = $this->writer->tag( 'form' )
                             ->attribute( 'action', 'options.php' )
                             ->attribute( 'method', 'post' )
                             ->leaveOpen();

        $layout->addParts( $form );

        echo $layout->compile();

        settings_fields( $this->settings->getPageId() . '_' . $subPage->getId() );
        do_settings_sections( $this->settings->getPageId() . '_' . $subPage->getId() );
        submit_button();

        // close the form
        echo $this->writer->tag( 'form' )->justClose()->compile();

    }

    /**
     * This method is used as a callback defined in the add_settings call.
     * It will instantiate a new FieldSettings from the received array, and try to instantiate
     * the corresponding renderer.
     *
     * @param array $fieldArray
     */
    public function render_field( array $fieldArray )
    {

        $field = FieldSettings::fromArray( $fieldArray );

        $field->setValue( get_option( $field->getSettingsKey(), '' ) );

        if ( empty( $field->getHtmlWriter() ) || ! class_exists( $field->getHtmlWriter() ) ) {
            $writer = $this->writer;
        } else {
            $writerClass = $field->getHtmlWriter();
            $writer      = new $writerClass();
        }

        if ( class_exists( $field->getType() ) ) {
            $renderClass = $field->getType();

            /** @var Field\AbstractField $renderer */
            $renderer = new $renderClass( $field );

        } else {
            $renderer = new TextField( $field );
        }

        $renderer->renderField( $writer );

        unset( $renderer );

    }

    /**
     * Convenience method to hook everything in one go.
     */
    public function bootstrap()
    {

        add_action( 'admin_init', [$this, 'register_settings'] );

        add_action( 'admin_menu', [$this, 'settings_init'] );

        add_action( 'admin_menu', [$this, 'add_page'] );

        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_assets'] );

    }

}