## WP Optional

Library to help in generating option pages for plugins and themes.

Work in progress, but the idea is to be able to do:


####  First we need to create a PageSettings object

```php

$page_settings = new PageSettings(
                 'options_id',
                 'Options Page Title',
                 'Options Menu Title',
                 'options-general.php', // options menu parent
                 'manage_options'       // capability required
             );

```


#### Subpages
When settings are long enough or complex enough, you may want to separate them in different "subpages" (or tabs) to make access easier. You always need at least one subpage

```php
$page_general = $page_settings->addSubpage(
    'general',
    __( 'General', TEXT_DOMAIN ),
    'manage_options'
 );
```

#### Sections
Each page should have 1 or more "sections" to group settings

```php
$general_main = $page_general->addSection( 'main', __( 'Automatic Generation', TEXT_DOMAIN ) );
```

#### Fields
 Fields are added to each of the sections, directly.

    $page_general->addField()
