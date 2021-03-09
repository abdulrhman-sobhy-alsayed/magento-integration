# Integrate your Magento Store With Pocket Up System

this extension enable you to integrate your system to Pocket-Up Voucher and points system 

# Installation

Under your magento store root folder run the following commands:
```angular2html
composer require abdulrhman-sobhy-alsayed/magento-integration

php bin/magento setup:upgrade

php bin/magento cache:flush
```
# activation

to activate the integration module you must define the following parameters in **Store > Configuration > Pocket Up**:

1. API Key (provided by pocket-up company)
2. earn points status
3. burn points status

