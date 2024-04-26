# Simple WHMCS OIDC Admin Login

This is a simple WHMCS OIDC Admin Login module that allows WHMCS administrators
to login to the WHMCS admin area using an OIDC provider.

It is not a full-fledged WHMCS module (yet), but so far only a script that
allows WHMCS administrators to login to the WHMCS admin area using an OIDC
provider.

## Disclaimer

The module was developed as a proof of concept and is not intended for
production use. It may have security vulnerabilities and may not work as
expected.

This module is provided as-is, not supported, and not endorsed by WHMCS. Use it
at your own risk.

## Installation

1. Install the module by uploading it to your WHMCS installation directory.

```bash
cd /path/to/whmcs/modules/security
git clone https://git.private.coffee/kumisystems/whmcs-oidc_admin_login.git oidc_admin_login
```

2. Configure the module by editing the `oidc_admin_login/config.php` file.

## Usage

You can access the OIDC Admin Login page by visiting the following URL:

```
https://your-whmcs-domain.com/modules/security/oidc_admin_login.php
```

If you are not logged in, you will be redirected to the OIDC provider login
page. After you have logged in, you will be redirected back to the WHMCS admin
area.

## License

This module is licensed under the MIT License. See the [LICENSE](LICENSE) file
for details.
