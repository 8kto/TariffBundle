#!/bin/sh

EXTERNAL_LIB_PATH=src/TariffBundle/Resources/public/external

composer install

cd $EXTERNAL_LIB_PATH
git clone git://github.com/montrezorro/bootstrap-radio.git montrezorro/bootstrap-radio/
git clone git://github.com/montrezorro/bootstrap-select.git montrezorro/bootstrap-select/
npm install

