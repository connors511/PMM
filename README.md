#PMM
PHP Media Manager is using FuelPHP as base.

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
    cd pmm/
    git submodule init
    git submodule update

You can also shorten the last two commands to one:

    git submodule update --init
