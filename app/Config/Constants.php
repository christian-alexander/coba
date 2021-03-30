<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
|
|   konstan variabel
|
*/

//konstan variabel untuk title page
defined('TITLE') || define('TITLE', 'Magang Informatika');


//penamaan standard untuk nama inputan form
//array keys = name/id
//dont change associative array keys dan name/id (karena terkait dengan js dan controller)
//struktur >> [name / id, input type, judul, text inside-box] di setiap itemnya

defined('LOGIN_NAMING') || define('LOGIN_NAMING',[

    'username' => [
        'name/id'    => 'username',
        'input_type' => 'text',
        'input_text' => 'Username',
        'inside_box' => 'Email/NRP/NIDN/NIP'
    ],

    'password' => [
        'name/id'    => 'password',
        'input_type' => 'password',
        'input_text' => 'Password',
        'inside_box' => '********'
    ]
]);


//penamaan standard untuk form akun
//array keys = name/id
//dont change associative array keys dan name/id (karena terkait dengan js dan controller)
//struktur >> [name / id, input type(if dikasi selection otomatis membentuk seleksi), judul ] di setiap itemnya

defined('FORM_AKUN_NAMING') || define('FORM_AKUN_NAMING',[

    'nama_akun' => [
        'name/id'    => 'nama_akun',
        'input_type' => 'text',
        'input_text' => 'Nama Lengkap'
    ],

    'no_unik_akun' => [
        'name/id'    => 'no_unik_akun',
        'input_type' => 'tel',
        'input_text' => 'NRP'
    ],
    
    'email_akun' => [
        'name/id'    => 'email_akun',
        'input_type' => 'text',
        'input_text' => 'Email'
    ],

    'password_akun' => [
        'name/id'    => 'password_akun',
        'input_type' => 'password',
        'input_text' => 'Password'
    ],

    'konfirmasi_password_akun' => [
        'name/id'    => 'konfirmasi_password_akun',
        'input_type' => 'password',
        'input_text' => 'Konfirmasi Password'
    ],

    'no_wa_akun' => [
        'name/id'    => 'no_wa_akun', 
        'input_type' => 'tel',
        'input_text' => 'No WhatsApp'
    ],

    'peran_akun' => [
        'name/id'    => 'peran_akun', 
        'input_type' => 'selection',
        'input_text' => 'Peran'
    ],

    'instansi_akun' => [
        'name/id'    => 'instansi_akun',
        'input_type' => 'selection',
        'input_text' => 'Instansi'
    ],

    'dosbing_akun' => [
        'name/id'    => 'dosbing_akun',
        'input_type' => 'selection',
        'input_text' => 'Dosen Pembimbing'
    ],

    'pemlap_akun' => [
        'name/id'    => 'pemlap_akun',
        'input_type' => 'selection',
        'input_text' => 'Pembimbing Lapangan'
    ]
    
]);