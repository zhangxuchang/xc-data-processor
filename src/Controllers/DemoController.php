<?php
/**
 * Created by SlimApp.
 *
 * Date: 2018-09-05
 * Time: 02:10
 */

namespace Vendor\XcDataProcessor\Controllers;

use Symfony\Component\HttpFoundation\Response;

class DemoController
{
    public function testAction()
    {
        return new Response('Hello World!');
    }
}

