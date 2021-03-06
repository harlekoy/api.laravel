<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace Test\Auth;

use Test\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * @test
     *
     * +---------------------------------+
     * | POSITIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function it_should_return_a_token_if_login_is_successful()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand@idearobin.com', 'password' => 'retardko'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('token', $content_array);
        $this->assertEquals(200, $status_code);
    }

    /**
     * @test
     *
     * +---------------------------------+
     * | NEGATIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function it_should_return_an_error_if_email_is_invalid()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand.kintanar', 'password' => 'retardko'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('error', $content_array);
        $this->assertEquals(401, $status_code);
    }

    /**
     * @test
     *
     * +---------------------------------+
     * | NEGATIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function it_should_return_an_error_if_password_invalid()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand@idearobin.com', 'password' => 'retardk'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('error', $content_array);
        $this->assertEquals(401, $status_code);
    }

    /**
     * @test
     *
     * +---------------------------------+
     * | NEGATIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function it_should_throw_an_exception_if_no_parameters_being_passed()
    {
        $response = $this->post('/api/login')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('error', $content_array);
        $this->assertEquals(500, $status_code);
    }

    /**
     * @test
     *
     * +---------------------------------+
     * | NEGATIVE TEST | GET /api/logout |
     * +---------------------------------+
     */
    public function it_should_return_error_in_logout_when_token_cant_be_invalidated()
    {
        $content_array = $this->login();
        $token = $content_array['token'];

        $response = $this->call('GET', '/api/logout');

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('status', $content_array);
        $this->assertEquals(500, $status_code);
    }

    /**
     * @test
     *
     * +---------------------------------+
     * | NEGATIVE TEST | GET /api/logout |
     * +---------------------------------+
     */
    public function it_should_return_error_in_logout_when_no_token_is_passed()
    {
        $response = $this->get('/api/logout')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('error', $content_array);
        $this->assertEquals(400, $status_code);
    }

    /**
     * @test
     *
     * +-----------------------------------+
     * | POSITIVE TEST | GET /api/users/me |
     * +-----------------------------------+
     */
    public function it_should_return_a_user_transformer_if_successful()
    {
        $content_array = $this->login();
        $token = $content_array['token'];

        $response = $this->call('GET', '/api/users/me');

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('data', $content_array);
        $this->assertArrayHasKey('id', $content_array['data']);
        $this->assertArrayHasKey('email', $content_array['data']);
        $this->assertArrayHasKey('last_login', $content_array['data']);

        $this->assertEquals(200, $status_code);
    }

    /**
     * @test
     *
     * +-----------------------------------+
     * | NEGATIVE TEST | GET /api/users/me |
     * +-----------------------------------+
     */
    public function it_should_return_error_if_no_token_is_passed()
    {
        $response = $this->get('/api/users/me')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('error', $content_array);
        $this->assertEquals(400, $status_code);
    }

    /**
     * @test
     *
     * +-----------------------------------+
     * | NEGATIVE TEST | GET /api/users/me |
     * +-----------------------------------+
     */
    public function it_should_return_error_if_token_is_invalid()
    {
        $content_array = $this->login();
        $token = $content_array['token'];

        $response = $this->call('GET', '/api/users/me', [], [], [], ['HTTP_Authorization' => 'Bearer '.$token.'invalid_token'], []);

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('error', $content_array);
        $this->assertEquals(400, $status_code);
    }
}
