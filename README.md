# Laracheck

## Check Outages & Bugs in your Laravel Application

Laracheck is a simple but powerful Laravel application monitoring software that tracks outages and errors in your projects.

## Installation & Configuration

- Install Laracheck into a nginx hosting
- Configure your .env file with your own configurations
- Sign In using admin@admin.com/password credentials
- Edit email, password and 2FA into User Profile page
- Create an API token via User Profile page
- Set Cron Jobs '* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1'
- Create your sites to monitor and for each site install this package: https://github.com/andreapollastri/laracheck-client
- Configure your site .env file with API Token, Site ID and your Laracheck hosting URL with /api/bugs path... e.g. monitoring.site.com/api/bugs

> Systems will send notification, remember to configure Cron Jobs and SMTP data!

## Contributing
Thank you for considering contributing to this project (Pull Requests, Issues, Feedbacks, Stars, Promo, Beers) :)

## Licence
Laracheck is an open-source software licensed under the MIT license.

Need support with Laracheck?
Please open an issue here: https://github.com/andreapollastri/laracheck/issues.

...enjoy  Leracheck :)
