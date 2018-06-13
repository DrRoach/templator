# templator

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/DrRoach/templator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/DrRoach/templator/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/DrRoach/templator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/DrRoach/templator/build-status/master)

Templator is a small, quick and powerful templating engine that's easy for anyone to pick up and use but is still as powerful as a fully fleged programming language.

With it's own built in caching system, you don't need to worry about loading times and as it is compiled down into PHP, you can add anything that it supports.

## This project has moved
This project has moved to [Gitlab](https://gitlab.com/DrRoach/templator).

Installing
---
Clone this repo into the project that you want to use it in then `require` the `templator/Templator.php` file. Once you've done that, add your templates to `/templates` with the `.tpl` file extension and load them into your views like so:
```php
Templator::load('HelloWorld', get_defined_vars());
```

If your templates folder isn't in your root directory, you can set it's path using the `setup.json` file. Just make sure that the path that you enter ends with `/`.

Example Syntax
---

### Echo

```
{{hello}}
```

And that's all that you need!

#### Escaping

By default, all echos are escaped to protect you from potential XSS but you can stop this by adding `|e` or `|escape` like so:

```
{{hello|e}}
{{hello|escape}}
```

You can also escape variables by using `!` instead of `|`:

```
{{hello!e}}
{{hello!escape}}
```

You can use `{{{` and `}}}` to escape variables too. Like this:

```
{{{hello}}}
```

Which will put the raw code onto your page including any HTML.

### If

```
{{ if(variable == true) }}
```

You can add `!` to switch results

```
{{ if(!variable) }}}
```

You can even use pre built PHP functions like `empty()`

```
{{ if(empty(variable)) }}
```

You can use else statements too:

```
{{ else: }}
```

And ending your `if` is just as simple:

```
{{ endif; }}
```

The spacing between the `{{` and `}}` doesn't matter!

### Foreach

```
{{ foreach(array as value) }}
<a href="#">{{ value }}</a>
{{ endforeach; }}
```

Looping through arrays is really simple and follows a simple language structure.

You can also get array keys like so:

```
{{ foreach(array as key => value) }}
<b>{{ key }}</b> - {{ value }}
{{ endforeach; }}
```

As you can see, ending your foreach loops is simple too:

```
{{ endforeach; }}
```

You can also add `else` statements to your foreach loops. These sections will be ran if the variable that you try and loop over is empty. See the example below:

```
{{ foreach(emptyVariable as value) }}
<p>{{value}}</p>
{{ else: }}
<h1>emptyVariable is empty!</h1>
{{ endforeach; }}
```

### While

```
{{ while(count < 10) }}
<h3>{{count}}</h3>
<?php $count++; ?>
{{ endwhile; }}
```

While loops are half implemented. You can increment or decrement variables like so:

```
{{ count++ }}
{{ ++count }}
{{ count-- }}
{{ --count }}
```

But as of yet, you cannot change a variables number by more than one without using pure PHP. This is likely going to be changed in the next release.

### Includes

```
{{ include(header) }}
```

Includes are now fully supported and all included files are also cached. Includes are going to be greatly worked on in future releases so that you can add a template file to your composer file (if you have one) and then instantly use that template in your code.

Includes work exactly as you'd expect. Whatever file you include is loaded into your code exactly where you load it. Any variables that you pass into your "parent" template are passed onto your "child" template automatically.

### Including templates via composer

You can require desired templates that you or other people have made and use them straight in your template without having to move them around or worry about them at all using the include code like so:

```
{{ include(loginTemplate) }}
```

Using composer to load in third party templates means that version control of these templates is very easy and getting updates is also super simple. Because these are just other templates, they can also be made very powerful. Another benefit of including templates this way, is that you wont have to rewrite code for seperate projects as you can just use the same html as an example.

### JavaScript Templates

You can load your templates and add them to your page using JavaScript too. There are a couple of ways to go about this, you can "populate" the JavaScript using the `Templator::populateJs()` PHP method to then include a template later in JavaScript like so:

```JavaScript
<script>
    Templator.load('template', null, $('#targetElement'));
</script>
```

Or you can pass data straight into the JavaScript implementation of `load` like so:

```JavaScript
<script>
    Templator.load(
        'template',
        {
            variable: "Variable Value"
        },
        $('#targetElement')
    );
</script>
```

For reference, `Templator::populateJs()` take in a key value array where the key is the variable name and the value is the data.

### Raw Code

Something that makes this template engine stand out is that you can add raw code to the file

```PHP
<?php var_dump($_SESSION']); ?>
```

## The Goal
The end goal is to create a fast and flexible template engine that can be quickly picked up by anyone. It would work best for teams of front and back end developers where the front end devs aren't completely comfortable writing PHP or JavaScript logic.
