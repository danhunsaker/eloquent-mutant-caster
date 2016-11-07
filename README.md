Eloquent MutantCaster
=====================
Extend Eloquent's attribute casting feature to support applying a single
mutator/accessor pair to multiple fields

Install
-------
Use composer:

```
composer require danhunsaker/eloquent-mutant-caster
```

That's literally it.

Usage
-----
Include the `Danhunsaker\Eloquent\Traits\MutantCaster` trait on any model you want to
extend:

```php
use Danhunsaker\Eloquent\Traits\MutantCaster;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use MutantCaster;
}
```

Now you can define new types to cast to by simply creating an accessor for your
type:

```php
    public function getMyNewAwesomeTypeAttribute($value)
    {
        return new MyNewAwesomeType($value);
    }
```

And use them as you would any of the built-in cast options:

```php
    protected $casts = [
        'field' => 'my-new-awesome-type',
    ];
```

And to have Eloquent automatically convert the value back on save (assuming your
new type doesn't already handle this properly via something like
`__toString()`), simply add a mutator for your type:

```php
    public function setMyNewAwesomeTypeAttribute($key, $value)
    {
        $this->attributes[$key] = $value->prepForDatabaseStorage();

        return $this;
    }
```

Note that you don't need both an accessor and a mutator - you can simply create
whichever of the two you need for your new type, and everything will continue to
flow smoothly.

### Caster Traits

The recommended way to use this library is by writing traits for each of your
new types, then including those traits on whichever models will use it.  One
such trait is included both as an example and for those who wish to use it.

#### CastIP

`CastIP` is a trait for handling IP addresses.  It requires the GMP extension,
which allows it to support both IPv4 and IPv6, and stores the address in your
database as an integer.  Because IPv6 addresses use 128 bits, you may not be
able to use your database's integer types to store these addresses - I recommend
a `DECIMAL(40, 0)` column instead, but you can use any field type which will
hold the value correctly (including a string type).

To use the trait, simply include it in your model, and set your `$casts`
property to use `ip` appropriately:

```php
use Danhunsaker\Eloquent\Traits\CastIP;
use Danhunsaker\Eloquent\Traits\MutantCaster;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use MutantCaster, CastIP;

    protected $casts = [
        'field' => 'ip',
    ];
}
```

Contributions
-------------
Contributions (issues, pull requests, etc) are always welcome on GitHub.

If you find a security issue, please [email me
directly](mailto:dan.hunsaker+mucast@gmail.com).
