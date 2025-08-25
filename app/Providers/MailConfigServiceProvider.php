<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (\Schema::hasTable('settings')) {
            $mail = (object) DB::table('settings')->pluck('short_value','key')->toArray();

            if (@$mail->is_checked_smtp) //checking if table is not empty
            {
                $config = array(
                    'driver'     => "smtp",
                    'host'       => $mail->smtp_host,
                    'port'       => $mail->smtp_port,
                    'from'       => array('address' => $mail->form_address, 'name' => $mail->from_name),
                    'encryption' => ($mail->is_checked_encry) ? $mail->smtp_encry : '',
                    'username'   => $mail->smtp_username,
                    'password'   => $mail->smtp_password,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
            }
            Config::set('cart.tax', $mail->tax ?? 0);

        }
    }
}