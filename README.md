# Sketchfab Portfolio v1.0.0

Sketchfab Portfolio generates a portfolio from your Sketchfab account.
This application is not officially supported by Sketchfab.

![Screenshot of Portfolio](./docs/screenshot.jpg?raw=true)

## Requirements

* Web hosting with PHP 5.3 or later

## Setup

* Upload all the files to your server (with an FTP client for example)
* Open your server URL in a browser
* Enter your Sketchfab username
* Your portfolio is ready!

## Customizing your portfolio

### Customizing content

By default, the portfolio will display all the models on your account.

If you want to display a selection of models only:
* tag them with the **portfolio** tag on Sketchfab
* on your portfolio, scroll to the very bottom and click on "Update portfolio". If models do not update, wait a few minutes and try again.

To update the profile info, update it in your [profile settings on Sketchfab](https://sketchfab.com/settings/profile).

### Customizing the design

Sketchfab Portfolio is based on the [Bootstrap](http://getbootstrap.com/)
framework and should be compatible with Bootstrap themes. Nice free themes
are available from [Bootswatch CDN](https://www.bootstrapcdn.com/bootswatch/).

To add a theme:
* edit the file `app/templates/base.html`
* add the link to your theme CSS

## Troubleshooting

* "Username is not valid" error during install
  * Make sure to enter your username, not your display name. Refer to [your settings](https://sketchfab.com/settings/profile) to find your username.
* "Can't save configuration" error during install
  * Make sure the `data` directory is writable. You can generally use your FTP client to fix the permissions.
* My latest models are not displayed
  * To update your portfolio, scroll to the very bottom and click on "Update portfolio"
  * You may have to wait a few minutes and try again
