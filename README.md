### Livewire in a nutshell

### Install tailwindcss

[Install Tailwind CSS with Laravel](https://tailwindcss.com/docs/guides/laravel)
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
npm run dev
```

### 1. Make a laravel component

1. turn laravel component to livewire component

```bash
php artisan make:component Counter
```

2. return view in render method

```php
    public function render(): View|Closure|string
    {
        // Single quotes do not parse variables
        return <<<'HTML'
    <span>{{$count}}</span>
</div>
HTML;
    }
```

3. Blade output convert to directive
```php

{!!(new \App\View\Components\Counter())->render()!!}
```

