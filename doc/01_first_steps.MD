## Changelog extension

### Background

This extension combines changelogs from all MageSuite extensions (and also third party extensions) into one list which is displayed in admin panel.

If any extension has file `etc/changelog.xml`, it will be gathered by changelog extension and included in the list of changes.
The main idea behind this extension is to:

- keep track of all changes within MageSuite ecosystem
- be transparent about all improvements and fixes with merchants and clients
- improve prominency and increase product visibility

Feel free to use this extension and make sure your extension also follows our changelog.xml format and guidelines:

### XML syntax

XML is validated against respective xsd file, so you can use it as reference, however - default and simpliest for is self explanatory:

```
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:MageSuite_Changelog:etc/changelog.xsd">
    <module
        id="MageSuite_Changelog"
        name="Magesuite_Changelog"
        description="This module allows to gather and display changelog entries from all compatible extensions."
        url="https://github.com/magesuite/changelog">
            <changelog>
                <tag version="1.0.0" date="2021-03-12">
                    <entry>
                        <type>INIT</type>
                        <overview>Initial release</overview>
                    </entry>
                </tag>
            </changelog>
     </module>
</config>
```

Possible nodes are:
 - `<type>` - one of FIX, STYLE, PERFORMANCE, SECURITY, etc.
 - `<overview>` - brief description of a change
 - `<description>` - extended description of a change
 - `<ticket_id>` - if change has its source on your tracking system, you can use it here (make sure to setup tracking URL in configuration)
 - `<highlighted>` - you can increase prominency of your change
 - `<url>` - you can link change with documentation/product URL

