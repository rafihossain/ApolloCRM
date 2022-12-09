<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use App\EmailSetting;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = EmailSetting::first();
                $config = array(
                    'driver' => $settings->protocol,
                    'stream' => [
                        'ssl' => [
                            'allow_self_signed' => true,
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        ],
                        ],
                    'host'       => $settings->host,
                    'port'       => $settings->port,
                    'from'       => array('address' => $settings->username, 'name' => 'Admin'),
                    'encryption' => 'tls',
                    'username'   => $settings->username,
                    'password'   => $settings->password,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
               Config::set('mail', $config);
    }
}
