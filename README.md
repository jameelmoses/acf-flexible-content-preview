# Advanced Custom Fields: Flexible Content Preview

Transforms ACF's flexible content field's layout list into a modal with image previews.

## Image convention

* The size of image should be 366 x 150 or bigger 732 x 300.
* They should be named based on the layout's name (`text_block`) with no underscores but dashes (`text-block.jpg`).

## Image Location

Images should be placed in your theme. Be fault, images are located here: `lib/admin/images/acf-flexible-content-preview`.

Also note that you can filter this path:

`add_filter( 'acf-flexible-content-preview.images_path', $path );`

Finally, you could filter all images like this:

`add_filter( 'acf-flexible-content-preview.images', $images );`

# Requirements

- [ACF Pro](https://www.advancedcustomfields.com/) plugin
- WordPress 4.7+ because of `[get_theme_file_uri()](https://developer.wordpress.org/reference/functions/get_theme_file_uri)`

# Installation

## [Composer](http://composer.rarst.net/)

- Add repository source : `{ "type": "vcs", "url": "https://github.com/jameelmoses/acf-flexible-content-preview" }`.
- Include `"acf-flexible-content-preview": "dev-master"` in your composer file for last master's commits or a tag released.
- Then add your awesome layout images.

## Contributing

Please refer to the [contributing guidelines](.github/CONTRIBUTING.md) to increase the chance of your pull request to be merged and/or receive the best support for your issue.

### Issues & Feature Requests

If you identify any errors or have an idea for improving the plugin, feel free to open an [issue](../../issues/new) or [create a pull request](../../compare). Please provide as much info as needed in order to help us resolving / approve your request.

## Credit

Credit largely goes to @BeAPI for their [bea-beautiful-flexible](https://github.com/BeAPI/bea-beautiful-flexible) plugin. This plugin began using their plugin as a starting point.

## License

Advanced Custom Fields: Flexible Content Preview is licensed under the [GPLv3 or later](LICENSE.md).
