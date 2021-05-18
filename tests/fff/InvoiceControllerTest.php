<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInvoiceCreatedSuccessfully()
    {

        $payload = [
            'customer_id'   => 1,
            'from'          => '2021-03-01',
            'to'            => '2021-03-30'
        ];

        $this->json('post', 'api/invoices', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'meta'  => [
                        'error' ,
                        'message'
                    ],
                    'body'  =>[
                        'invoice_id'
                    ]
                ]
            );
    }


    public function testGetInvoiceSuccessfully(){

        $id = 23;
        $this->json('get', 'api/invoices/'. $id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'meta'  => [
                        'error' ,
                        'message'
                    ],
                    'body'  =>[
                        'invoice' =>[
                            'id',
                            'customer_id',
                            'from',
                            'to',
                            'total_price',
                            'total_appointment',
                            'total_activated',
                            'total_registered',
                            'created_at',
                            'total_event',
                            'customer'  =>[
                                'id',
                                'name',
                                'email'
                            ],
                            'invoice_details' =>[
                                '*' => [
                                    'id',
                                    'invoice_id',
                                    'user_id',
                                    'type',
                                    'price',
                                    'appointment_count',
                                    'activated_count',
                                    'created_at',
                                    'user' =>[
                                        'id',
                                        'email',
                                        'customer_id',
                                        'created_at'
                                    ]
                                ]
                            ]
                        ],
                        'prices'  =>[
                            '*' =>[
                                'id',
                                'type',
                                'price',
                                'type_text'
                            ]
                        ]
                    ]
                ]
            );
    }
}
