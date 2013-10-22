LwcCmsPage
==========

ZF2 module for handling a nested set of CMS pages. Still in heavy development, please don't use it ;-)

### Composer ###
Add the repository to your composer.json:

    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "lwc/LwcCmsPage",
                "version": "1.0.0",
                "source": {
                    "url": "http://github.com/lewildcode/LwcCmsPage",
                    "type": "git",
                    "reference": "master"
                }
            }
        }
    ],

then add the package to the require block

    "require": {
        "lwc/LwcCmsPage": "1.*"
    }

### ZF2 config setup ###
* Add the "LwcCmsPage" module to your <b>config/application.config.php</b> file
* Copy the <b>config/lwccmspage.global.dist</b> file to your config/autoload/ directory, replace the .dist with ".php"

### Database setup ###
* Import the <b>data/table-init.sql</b> file into your database. It will create a 2 tables:
** one for storing the pages
** another one for "rows" - which is basically a CSS/JS grid approach for saving content elements via the LwcCmsContent module.
* The module will provide a ServiceManager alias called <b>LwcCmsPage\DbAdapter</b>. Per default, it points to a "dbAdapter" service. You may have to change this according to your application's default database adapter.

Still work in progress. :)

