# OData-plugin-for-SugarCRM #

##Note from Matt
I've modified the plug-in to work with Sugar 7.

1) This can only be installed on-site since it writes to a PHP file on disk during the generation phase where it creates some PHP classes the represents Sugar Modules to be used in OData connector.  I don't see need for this because Sugar metadata already includes this information and could be retrieved on demand.  I think we could refactor the plug-in so that it doesn't generate PHP code.

2) There's an .htaccess file under the odata directory that needs to be updated for your local install.  Ideally this should be generated during an install process like the Sugar application's .htaccess file.  And again, this would prevent this from being used in Sugar OnDemand.

3) Touching the "List SugarOData" button in Admin panel will trigger OData generation.  The SugarOData module is a regular user module.  You create records in there where the name matches the table name you want to use with OData provider.  Again, this needs to change in future.

4) This plug-in queries MySQL directly which bypasses security and vardefs / view metadata.  This is the biggest thing that needs to change - it should be driven via SugarQuery and SugarBean instead.


add OData v2 producer support for SugarCRM
## Installation ##
1. Login with administrator account and go to ‘Admin’ section.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/1.jpg?token=AIFd0KA807C6--bVLfOw4txF8BdnoIFjks5U-U9kwA%3D%3D)

2.	Go to developer section and select ‘Module Loader’.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/2.jpg?token=AIFd0OLbsmV673WNha1PpB1cV2NgOpF2ks5U-U-dwA%3D%3D)

3.	Select SugarOData.zip in Module file selector and click ‘Upload’.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/3.jpg?token=AIFd0KToyE5xMdtojie2XMkRnYZUWL2lks5U-U_cwA%3D%3D)

4.	After upload succeed, then install that package.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/4.jpg?token=AIFd0E9E0K0YVhZp062aA41uPhzShtQRks5U-U_4wA%3D%3D)

5.	Accept License and commit.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/5.jpg?token=AIFd0Ebbyn-Ksjb2bNPIXQ-8JlK1UmBAks5U-VAWwA%3D%3D)

6.	After install succeed then click ‘Back to Module Loader’.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/6.jpg?token=AIFd0PnH2Cdcp_KmLctueVegnOlz1GMaks5U-VAwwA%3D%3D)

7.	You can see ‘SugarCRM OData’ module is already there.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/7.jpg?token=AIFd0OETAr0GVkP7-UF5gd5ym6u6IOu-ks5U-VBFwA%3D%3D)

## Usage guide ##
1.	Go to admin ‘Users’ section and Click ‘SugarOData’.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/8.jpg?token=AIFd0E9Fn9Tx7-11DNEP8ld6T0KdDn6Bks5U-VBqwA%3D%3D)

2.	Go to ‘Create SugarOData’ and input table name and save.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/9.jpg?token=AIFd0IEbzPcfJaHBDxrudDOoWIpz9Bzmks5U-VCFwA%3D%3D)

    ![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/10.jpg?token=AIFd0KVoK3euei2NCDn0OFNHwMv2CVNIks5U-VDkwA%3D%3D)

3.	Go to ‘List SugarOdata’ to see your database table data you want to share.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/11.jpg?token=AIFd0DtFV1DjCTZZVg6KM4Ee2Ay-av2lks5U-VE0wA%3D%3D)

4.	If you want to more table data to share, you could go to create another table in ‘Create SugarOData’ section and you can delete table name in ‘List SugarOData’ section by check the box and click delete button.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/12.jpg?token=AIFd0NVSJ2jolL8Y1lFu1FS8KNnQ_d5gks5U-VFgwA%3D%3D)

5.	Go to ‘Generate SugarOData’ section to generate OData.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/13.jpg?token=AIFd0Ny6ebc3N9KIGk4cmtrq55WhvR4uks5U-VF5wA%3D%3D)

6.	After generation you will find OData links, click those links to see your OData.
![](https://raw.githubusercontent.com/msopentechcn/odata-plugin-for-sugarcrm/master/icons/default/images/14.jpg?token=AIFd0Iaps9LKg8shmi1Nsym3tCSsw-f9ks5U-VGRwA%3D%3D)

## Notice ##
1.	This module only support Apache web server.

2.	If your server is Linux, after installation, you have to add /yourpathtosugarcrm/odata/library this path to your php.ini include_path, in order to add this library code through PHP ‘Include_path’.
