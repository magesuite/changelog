### Custom paths configuration

By default, changelog extension looks for changelog xmls in foldet `etc/changelog.xml`.

However, sometimes we use some libraries, modules or 3rd party solutions, which don't have `etc` folder. - for example, please see MageSuite patches repository - which is just pack of patches we put on native Magento.
It doesn't have Magento module structure, so changelog is placed in root directory of a project.

Using `di.xml` you can define multiple custom changelogs that should be included:

```
<!-- Place custom paths to 3rd party libs/modules here-->
<type name="MageSuite\Changelog\Model\CustomChangelogPathsPool">
    <arguments>
        <argument name="customChangelogPaths" xsi:type="array">
            <item name="magesuite_patches" xsi:type="string">vendor/creativestyle/magento-patches/changelog.xml</item>
        </argument>
    </arguments>
</type>
```

This directive will tell changelog extension to look for changelog files also in `vendor/creativestyle/magento-patches/changelog.xml`.

This way, we can keep track of all changes introduced in magesuite-patches repository, even if it's not Magento module.
