# WHMCS OIDC Admin Login Module

This is a simple WHMCS OIDC Admin Login module that allows WHMCS administrators
to login to the WHMCS admin area using an OIDC provider.

It will redirect the user to the OIDC provider's login page, log the user in
based on the `preferred_username` claim, and redirect the user back to the WHMCS
admin area.

## Disclaimer

This module is provided as-is, not supported, and not endorsed by WHMCS. Use it
at your own risk.

## Installation

1. Install the module by uploading it to your WHMCS installation directory.

```bash
cd /path/to/whmcs/modules/addons
git clone https://git.private.coffee/kumisystems/whmcs-oidc_admin_login.git oidc_admin_login
cd oidc_admin_login
composer install
cp config.dist.php config.php
```

2. Enable the module in the WHMCS admin area.

- Go to `Setup` -> 'System Settings' -> `Addon Modules`. (https://your-whmcs-domain.com/admin/configaddonmods.php)
- Click on `Activate` next to `OIDC Admin Login`.
- Click on `Configure` next to `OIDC Admin Login`.
- Enter the OIDC provider configuration details in the form.
- Click on `Save Changes`.

## Usage

You can access the OIDC Admin Login page by visiting the following URL:

```
https://your-whmcs-domain.com/modules/addons/oidc_admin_login/login.php
```

After you have logged in, you will be redirected back to the WHMCS admin area.

Unfortunately, there doesn't seem to be a way to hook into the WHMCS login
process to automatically redirect the user to the OIDC login page. You can
instead configure your web server to redirect the user to the OIDC login page
when they visit the WHMCS admin login page. For example, you can add the
following to your nginx configuration:

```nginx
location = /admin/login.php {
	return 301 /modules/addons/oidc_admin_login/login.php;
}
```

## License

This module is licensed under the MIT License. See the [LICENSE](LICENSE) file
for details.
