# Known Issues — tall_boilerplate

_Last checked: 2026-08-02_

## Failing tests

Could not run the test suite — `composer install --no-interaction` fails before installing anything, so no `vendor/` directory exists and `php artisan test` / `composer test` cannot execute. The actual error:

```
Warning: The lock file is not up to date with the latest changes in composer.json. You may be getting outdated dependencies.
- Required package "centrex/tallui" is not present in the lock file.
- Required package "laravel/framework" is in the lock file as "v12.47.0" but that does not satisfy your constraint "^13.7".
- Required package "laravel/tinker" is in the lock file as "v2.11.0" but that does not satisfy your constraint "^3.0".
- Required package "livewire/livewire" is in the lock file as "v4.0.1" but that does not satisfy your constraint "^4.2".
- Required (in require-dev) package "barryvdh/laravel-debugbar" is in the lock file as "v3.16.3" but that does not satisfy your constraint "^4.2".
- Required (in require-dev) package "laravel/pail" is in the lock file as "v1.2.4" but that does not satisfy your constraint "^1.2.5".
- Required (in require-dev) package "phpunit/phpunit" is in the lock file as "11.5.46" but that does not satisfy your constraint "^12.5.12".
```

`composer.lock` is stale relative to `composer.json` (working tree is clean, both files are committed as-is — this isn't a local edit) — the lock was generated against an older set of constraints (Laravel 12, Livewire v4.0.1, phpunit 11, etc.) while `composer.json` has since been bumped to require Laravel `^13.7`, `livewire/livewire ^4.2`, `phpunit/phpunit ^12.5.12`, and a new `centrex/tallui ^1.0` dependency that isn't in the lock at all. Per audit constraints, `composer update` was not run to avoid resolving this destructively; a maintainer needs to run `composer update` (or regenerate the lock) intentionally and commit the result. Until then, this package cannot be installed reproducibly from `composer.lock`.

Everything below (lint/static-analysis/tests) could not be executed as a result — this is the single blocking issue for this package.

## Style / static-analysis debt

Not checked — no `vendor/` available (see above), so `pint`, `phpstan`, and `rector` binaries are not present.

## TODO / FIXME markers

None found (`grep -rn "TODO\|FIXME" --include="*.php" app/ config/ database/ routes/ tests/ resources/`).

## Open GitHub issues

Not checked — the `gh` CLI is not installed in this environment.
