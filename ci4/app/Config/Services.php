<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function authentification()
    {
       return new \App\Services\Authentification();
    }

    public static function cardProduit()
    {
       return new \App\Services\CardProduit();
    }

    public static function feedback()
    {
      return new \App\Services\Feedback();
    }

    public static function lbbdp($getShared = true)
     {
      
         if ($getShared) {
             return static::getSharedInstance('lbbdp');
         }
         
          return new \App\Services\SessionLBBDP('153','39715c8f486b05c362dd45fd2872dc03');
     }
}
