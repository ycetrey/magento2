##Products Attachment Extension

This extension allows you to upload files of chosen format by providing users with accurate manuals, licenses, and extra info right on product pages.

##Support:
version - 2.2.x, 2.3.x

##How to install Extension

1. Download the archive file.
2. Unzip the file
3. Create a folder [root]/app/code/Etatvasoft/Productsattachment
4. Drop/move the unzipped folder to directory 'Magento_Root/app/code/Etatvasoft/Productsattachment'

#Enable Extension:
- php bin/magento module:enable Etatvasoft_Productsattachment
- php bin/magento setup:upgrade
- php bin/magento cache:clean
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush