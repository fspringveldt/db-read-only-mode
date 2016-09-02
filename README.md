# DB Read Only Mode
This module places your entire SilverStripe site into read only mode to safely reduce downtime during deployments. When activated all DML and DQL queries which changes the data are blocked from executing, allowing user to continue using your site in a view-only mode.

## Minimum requirements
```
silverstripe/framework: ^3.4.* 
silverstripe/cms: ^3.4.*
```
## Installation and Setup
To install, run below from root of SilverStripe installation
```bash 
> composer require fspringveldt/db-read-only-mode
``` 
http://<your site url>?flush=1 once composer is complete the flush the manifest.

## Switching it on and off
Readonly mode is de-activated by default. To switch it on, find below in [_ _config/app.yml_](_config/app.yml)
>ReadOnlyMode:
>   activate: 0

and change the 0 to 1. Then flush again to clear the cache manifest, activating the module.

## Switching off exceptions
If you'd like to throw a catchable exception, then switch it on in [_ _config/app.yml_](_config/app.yml)
>ReadOnlyMode:
>   throw-exceptions: 0

by changing the 0 to 1. Flush the manifest afterwards.
