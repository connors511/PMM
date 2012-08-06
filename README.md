#PMM
PHP Media Manager is using FuelPHP as base.

#Requirements
* PHP 5.3.2+
* mod_rewrite for pretty url (optional)
* GD library
* Fileinfo
* cURL


##FuelPHP

* Version: 1.2
* [Website](http://fuelphp.com/)
* [Release Documentation](http://docs.fuelphp.com)
* [Development Documentation](http://fueldevdocs.exite.eu) and in its own [git repo](https://github.com/fuel/docs)
* [Forums](http://fuelphp.com/forums) for comments, discussion and community support

##Cloning PMM

PMM is using FuelPHP which uses submodules for things like the **core** folder.  After you clone the repository you will need to init and update the submodules.

Here is the basic usage:

    git clone --recursive git://github.com/connors511/PMM.git

The above command is the same as running:

    git clone git://github.com/connors511/PMM.git
    cd PMM/
    git submodule init
    git submodule update

You can also shorten the last two commands to one:

    git submodule update --init


After getting the source, make sure the following directories is writeable:

	fuel/app/logs
	fuel/app/config
	fuel/app/cache

Enter the directory and run the following command to use the installation wizard

    php oil refine install

After the installation has completed, you can access it at http://localhost/PMM/public
The url can be changed by putting everything outside the web-root and the contents of public in web-root.

# Background workers

It is recommended to use background workers to reduce the loading time of some pages.
The following commands will have to started in its own terminal or commandline

	php oil r jobqueue scraper
	php oil r jobqueue fanart
	php oil r jobqueue subtitles

##Features
PMM is currently able to scrape basic info about movies from IMDb and TMDb.
Other features include:
* Validate nfo files against .xsd
* Load info from XBMC nfo files validated against .xsd
* Edit movies, actors, directors, producers, people and genres.
* Define which scraper retrieves which fields with `scraper groups`
* Define which scraper groups are used for which folders with `sources`
* Continue browsing after starting a scrape using `background workers`
* Export validated nfo files (UI almost finished)
* Stream movies (currently working in FF and Chrome with VLC installed)
* Different save locations for each type of file (fanart, thumb, subtitle, nfo, cover)
* Basic frontend for cover view
* Export movie lists; currently supporting all movies or movies missing chosen fields

#Planned features
* Renaming of files
* Support for TV shows
* Subtitles downloader
* People scraper (for bio, portrait)
* Fanart scraper
