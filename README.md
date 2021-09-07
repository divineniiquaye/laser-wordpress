# Laser [WordPress] made with [BedRock]

Traditional Wordpress is cool, but I prefer the modified [BedRock] version. It easy to use, can be deployed anywhere and used on any domain as well. It's just LASER. I included setup to host on Heroku at a cost of 0$ per month.

Feel free to use it, git clone or composer create project on this repository. I use this to build all my [WordPress] projects, so maintenance is assured.

## Stack and Features

- CMS: [WordPress] Latest
- PHP [Composer] Latest
- Project structure: [BedRock] Latest
- Media CDN: [Cloudinary]
- Deployment: Works on all servers that supports PHP including Heroku
- Plugins: Elementor Builder, Google AMP, Fluent SMTP, Fastest Cache and File Manager Plugins.
- URL Setup: Works on all domains, no need for setting `WP_HOME` & `WP_SITEURL` environment configs.

### Heroku Setup

1. [Connect your github repository to heroku](https://devcenter.heroku.com/articles/github-integration)
2. Enable `Automatic deploys` on Deploy page
3. Add `JawsDB Maria` on [your add-ons](https://devcenter.heroku.com/articles/managing-add-ons)
4. Add `Heroku Redis` on [your add-ons](https://devcenter.heroku.com/articles/managing-add-ons)
5. Add `heroku/php` on your buildpacks (settings page)
6. Add your `.env` variables on [settings page](https://devcenter.heroku.com/articles/config-vars)
7. Configure your [Uptime Robot](https://uptimerobot.com/) to 20 min to avoid dyno resets
8. Open your app

- Deployment Link: [WordPress on Heroku](https://heroku.com/deploy?template=https://github.com/divineniiquaye/laser-wordpress)

### Deployment Setup

1. The web server should support PHP and [Composer]. If [Composer] is missing, then manually download it and include it to this repository.
2. Incase your repository for the wordpress app is private. Create your SSH key on both server (which should support SSH and GIT), and in GitHub. Then git clone this repository the SSH way, and run composer install.
3. Point your public directory to the `web` folder, using `.htaccess`, or if your server supports `Procfile` edit it to how your server may require it to be.

## License

Released under the [MIT license](./LICENSE).

[WordPress]: https://wordpress.org/
[BedRock]: https://roots.io/bedrock/
[Composer]: http://getcomposer.org/
[Cloudinary]: https://cloudinary.com/
