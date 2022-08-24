## New feature in changelog extension!

Sometimes, your feature or change is more complex - sometimes it requires additional guidelines, explanation about configuration or way of working.

Till now, changelog only allowed to include small, brief notifications about introduced changes.

This is about to change with new feature, which allows developers and agencies to propagate additional content through admin panel.

#### 💡 For developers:

When you create changelog entry in `changelog.xml` - you may now add extra node:

```
<tag>
    <type>FEATURE</type>
    <overview>New feature coming in!</overview>
    <doc_reference>markdown_file_with_additional_information</doc_reference>
</tag>
```

Then, simply create markdown file in folder `/doc` (in root directory of your extension) and place there a file (in above case: `markdown_file_with_additional_information.MD`) - keep in mind to add .MD extension.
When changelog is rendered, Markdown content will be parsed to HTML and displayed accordingly.

You can see how this very page is created in [magesuite-changelog](https://github.com/magesuite/changelog) extension.

#### Some things to keep in mind:

- Images can be included, however with absolute URLs only
- Feel free to use lists, code snippets and all other directives provided by Markdown syntax
