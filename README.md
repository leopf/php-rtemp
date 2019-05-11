# RTemplate
This is a PHP-Libarary to create a uniform application with custom pages.
Don't worry about any standards you have to implement, just write your HTML and your extensions will do everything you need.

## Extension
An Extension can have all the methods shown in the example. The Methods ```before``` and ```after``` are executed to place HTML before and after the document head and body. The apply property method is called, when a property with a specific value is received. This will only happen, if registered in the ```init``` function. In addition property elements can be defined, which are bound to a property name. The conents of a property element is used as te properties value.

```php
class TutorialExtension extends RTExtension
{
    public function Init(ExtensionHandler $handler)
    {
        //register property
        $handler->registerProp("title", $this);
        //register property element <tpl-title></tpl-title>
        $handler->registerPropElement("tpl-title", "title");
    }
    public function before(DocBuilder $docBuilder) {
        $docBuilder->addBody("<div>My Default Header</div>");
        //executed to set content before the child elements
    }
    public function after(DocBuilder $docBuilder) {
        //executed to set content after the child elements
    }
    //execute the functionallity for a property 
    public function applyProp(String $name, String $value, DocBuilder $docBuilder) {
        if ($name == "title") {
            $docBuilder->addHead("<meta name=\"title\" content=\"{$value}\"/>");
            $docBuilder->addHead("<title>{$value}</title>");
        }
    }
}
//register a new object of the extension
ext_reg(new TutorialExtension());
```

with this extension the ```tutorial.html``` document was converted from this:
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <tpl-title>Hello</tpl-title>
</head>
<body>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis rerum minima quas quos tempora sunt, qui ab dolores cumque aliquam autem blanditiis neque laborum error veritatis dignissimos necessitatibus recusandae quam.
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam facere impedit deserunt reiciendis, delectus ex repellendus nostrum voluptas animi veniam quam fugiat itaque qui eum veritatis blanditiis nobis unde quos.
</body>
</html>
```
to this:
```html
<!DOCTYPE html>
<html>
<head>
    <meta name="title" content="Hello">
    <title>Hello</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div>My Default Header</div>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. 
    Nobis rerum minima quas quos tempora sunt, qui ab dolores cumque aliquam autem blanditiis neque laborum error veritatis dignissimos necessitatibus recusandae quam.
    Lorem ipsum dolor sit amet consectetur adipisicing elit. 
    Quibusdam facere impedit deserunt reiciendis, delectus ex repellendus nostrum voluptas animi veniam quam fugiat itaque qui eum veritatis blanditiis nobis unde quos.
</body>
</html>
```
The only change is the ```div``` element, which says "My Default Header". The property defined in the extension is executed by the ```tpl-title``` tag. The content of this element is the value of the property. Property can also be executed manually. An example of the is in the ```test.php``` under site:
```
doc_prop_set("title", "My Test Site");
```

## File Structure
All the web files go in the site directory. (so far only html and php files can be requested).
If the php-files require external functionallity, the non executable scripts are to be included in the require directory.
Extensions go in the ext directory. Any sub directories for external content are allowed and will not conflict.
