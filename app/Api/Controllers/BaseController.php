<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - LightMediaEdge: Project Canard
 *
 * @link    https://github.com/LightMediaEdge/Canard
 */
namespace App\Api\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Swagger\Annotations as SWG;

/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="api.canard.dev",
 *     basePath="/api",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Project Laravel",
 *         description="Project Laravel",
 *         @SWG\Contact(
 *             email="bertrand@idearobin.com"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Project Laravel",
 *         url="https://github.com/g-six/laravel"
 *     )
 * )
 */
class BaseController extends Controller
{
    use Helpers;
}
