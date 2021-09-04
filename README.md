# Laser [WordPress] made with [BedRock]

Traditional Wordpress is cool, but I prefer the modified [BedRock] version. It easy to use, can be deployed anywhere and used on any domain as well. It's just LASER. I included setup to host on Heroku at a cost of 0$ per month.

Feel free to use it, git clone or composer create project on this repository. I use this to build all my [WordPress] projects, so maintenance is assured.

This project is bundled with Elementor Builder, Google AMP, Fluent SMTP, Fastest Cache and File Manager Plugins.

## Stack and Features

- CMS: [WordPress] Latest
- PHP [Composer] Latest
- Project structure: [BedRock] Latest
- Deployment: <a href="https://heroku.com/deploy?template=https://github.com/divineniiquaye/laser-wordpress">WordPress on Heroku</a>
- Media CDN: [Cloudinary]
- Local development: <a href='https://www.docker.com/'>Docker</a> (not yet)

### Heroku Setup 

1. [Connect your github repository to heroku](https://devcenter.heroku.com/articles/github-integration)
2. Enable `Automatic deploys` on Deploy page
3. Add `JawsDB Maria` on [your add-ons](https://devcenter.heroku.com/articles/managing-add-ons)
4. Add `Heroku Redis` on [your add-ons](https://devcenter.heroku.com/articles/managing-add-ons)
5. Add `heroku/php` on your buildpacks (settings page)
6. Add your `.env` variables on [settings page](https://devcenter.heroku.com/articles/config-vars)
7. Configure your <a href='https://uptimerobot.com/'>Uptime Robot</a> to 20 min to avoid dyno resets
8. Open your app

## License

Released under the [MIT license](./LICENSE).

[WordPress]: https://wordpress.org/
[BedRock]: https://roots.io/bedrock/
[Composer]: http://getcomposer.org/
[Cloudinary]: https://cloudinary.com/
