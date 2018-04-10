# WP Optional

Library to help in generating option pages for plugins and themes.

Work in progress, but the basic usage is as follows:

### PageSettings object

```php

$page_settings = new PageSettings(
                 'options_id',
                 'Options Page Title',
                 'Options Menu Title',
                 'options-general.php', // options menu parent
                 'manage_options'       // capability required
             );

```

### Subpages
When settings are long enough or complex enough, you may want to separate them in different "subpages" (or tabs) to make access easier. You always need at least one subpage

```php
$page_general = $page_settings->addSubpage(
    'general',
    __( 'General', TEXT_DOMAIN ),
    'manage_options'
 );
```

### Sections
Each page should have 1 or more "sections" to group settings

```php
$general_main = $page_general->addSection( 'main', __( 'Automatic Generation', TEXT_DOMAIN ) );
```

### Fields
 Fields are added to each of the sections, directly.

```php
 $field = $page_general->addField(
     // string identifying the field (will be concatenated to the section, page and options id)
     $id,
     // will be used as a label for the <input> element
     $title,
     // this should be a class that extends AbstractField,
     $type
 );

 ```

#### Field Types
* TextField
* PasswordField
* TextareaField
* SelectField
* SelectMultipleField
* CheckboxField

#### Field Configuration

##### Description
Sets the optional value for a field description. If provided, will be rendered close to the field

    $field->setDescription('This field rocks and rolls');

##### Default
Default value for the field, if the user doesn't provide one

     $field->setDefault('1');

 #### Class
 If provided, this string will be rendered in the class attribute of the field

     $field->setClass('mucho-clase very-nav');

##### Extra Attributes
This should be a associative array. Each key => value combination will be rendered as an additional attribute for the field

     $field->setAttributes(['rows' => '30', 'data-value' => $whatever ]);


#### Choices
This is a list of values and labels, generally used for `<select>` or `<radio>`

     $field->setChoices('WS' => 'Washington', 'NY', 'New York', 'MAD' => 'Madrid');

#### Example

Since these calls are chainable, you could do:

```php

$page_general->addField($id, $title, SelectField::class)
             ->setClass('optional')
             ->setAttributes($attribute_array)
             ->setChoices($choices_array);
```