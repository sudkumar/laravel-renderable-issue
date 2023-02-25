# CAUTION while passing renderables to Blade View/Components

In Laravel Blade, if we pass renderables as Data/Prop to Views/Components, the renderables (e.g. E-Mails) will get rendered during data passing. This is the expected behaviour as mostly we would be rendering the renderables. 

But sometimes, you may face some issues. I am working with [money package](https://github.com/cknow/laravel-money), which allows to render money as simple as {{ $money }} as it is implementing the `Illuminate\Contracts\Support\Renderable`. Now suppose you have a component that expects a `money` prop and does something with it (calls some methods on the Money instance) before rendering it.

```php
// inside your component
@prop(['money'])

@if($money->isPositive())
  <span>{{ $money }}</span>
@else
  <span>N/A</span>
@endif
```

But when we render this component inside our view and pass a money prop (renderable Money) to it, this prop will get transformed (rendered) to string before your component receives it! And that will throw an exception.

```php
// inside your main view
<x-money :money="new \Money(100, 'USD')" />
```

This is a reproduction repo to see it in action. 


## Testing 

Checkout the [Test File](/tests/Feature/RenderablePropTest.php) for more info.

```
git clone <repo> && cd <dir>
composer i
php artisan test
```


