<?php


namespace Yivoff\Wp_Optional;


class FieldSettings
{

    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var array
     */
    protected $choices;
    /**
     * @var string
     */
    protected $class;
    /**
     * @var string
     */
    protected $settingsKey;
    /**
     * @var string
     */
    protected $htmlWriter;

    protected $value;

    protected $default;
    /**
     * @var array
     */
    protected $extraAttributes;

    protected $scripts_requirements = [];
    private $style_requirements = [];


    /**
     * OptionsPageSectionField constructor.
     *
     * @param string $id
     * @param string $title
     * @param string $type
     * @param string $description
     * @param string $default
     * @param string $class
     * @param array  $extraAttributes
     * @param array  $choices Only used for radio and select
     */
    public function __construct(
        string $id,
        string $title,
        string $type,
        string $description = '',
        string $default = '',
        string $class = '',
        array $extraAttributes = [],
        array $choices = []
    ) {

        $this->id              = $id;
        $this->title           = $title;
        $this->type            = $type;
        $this->description     = $description;
        $this->choices         = $choices;
        $this->class           = $class;
        $this->default         = $default;
        $this->extraAttributes = $extraAttributes;
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
     * @return FieldSettings
     */
    public function setId( string $id ): FieldSettings
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
     * @return FieldSettings
     */
    public function setTitle( string $title ): FieldSettings
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return FieldSettings
     */
    public function setType( string $type ): FieldSettings
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return FieldSettings
     */
    public function setDescription( string $description ): FieldSettings
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return FieldSettings
     */
    public function setClass( string $class ): FieldSettings
    {
        $this->class = $class;

        return $this;
    }


    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /**
     * @param array $choices
     *
     * @return FieldSettings
     */
    public function setChoices( array $choices ): FieldSettings
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault( $default ): void
    {
        $this->default = $default;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return FieldSettings
     */
    public function setValue( $value ): FieldSettings
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getExtraAttributes(): array
    {
        return $this->extraAttributes;
    }

    public function asArray(): array
    {
        return [
            'id'          => $this->getId(),
            'title'       => $this->getTitle(),
            'class'       => $this->getClass(),
            'description' => $this->getDescription(),
            'type'        => $this->getType(),
            'choices'     => $this->getChoices(),
            'default'     => $this->getDefault(),
            'extraAtts'   => $this->getExtraAttributes(),
            'settingsKey' => $this->getSettingsKey(),
            'writerClass' => $this->getHtmlWriter(),
            'value'       => $this->getValue(),
        ];
    }

    public static function fromArray( array $array ): FieldSettings
    {
        $field = new FieldSettings(
            $array['id'],
            $array['title'],
            $array['type'],
            $array['description'],
            $array['default'],
            $array['class'],
            $array['extraAtts'],
            $array['choices']
        );

        $field->setSettingsKey( $array['settingsKey'] ?? '' );
        $field->setHtmlWriter( $array['writerClass'] ?? '' );

        return $field;

    }

    /**
     * @return string
     */
    public function getSettingsKey(): string
    {
        return $this->settingsKey ?? '';
    }

    /**
     * @param string $settingsKey
     *
     * @return FieldSettings
     */
    public function setSettingsKey( string $settingsKey ): FieldSettings
    {
        $this->settingsKey = $settingsKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getHtmlWriter(): string
    {
        return $this->htmlWriter ?? '';
    }

    /**
     * @param $writer
     *
     * @return $this
     */
    public function setHtmlWriter( string $writer ): FieldSettings
    {
        $this->htmlWriter = $writer;

        return $this;
    }

    /**
     * @param ScriptSettings $script_settings
     *
     * @return FieldSettings
     */
    public function addScriptRequirement( ScriptSettings $script_settings ): FieldSettings
    {
        $this->scripts_requirements[] = $script_settings;

        return $this;
    }

    /**
     * @return ScriptSettings[]
     */
    public function getScriptRequirements(): array
    {
        return $this->scripts_requirements;
    }

    /**
     * @param StyleSettings $style_settings
     *
     * @return $this
     */
    public function addStyleRequirement( StyleSettings $style_settings ): FieldSettings
    {
        $this->style_requirements[] = $style_settings;

        return $this;
    }

    /**
     * @return StyleSettings[]
     */
    public function getStyleRequirements(): array
    {
        return $this->style_requirements;
    }

    public function addScript( $handle, $file = null, $dependencies = [], $version = '', $in_footer = false )
    {
        $script = new ScriptSettings( $handle, $file, $dependencies, $version, $in_footer );

        $this->scripts_requirements[] = $script;

        return $this;

    }

    public function addStyle( $handle, $file = null, $dependencies = [], $version = '', $media = '' )
    {
        $style = new StyleSettings( $handle, $file, $dependencies, $version, $media );

        $this->style_requirements[] = $style;

        return $this;
    }

}