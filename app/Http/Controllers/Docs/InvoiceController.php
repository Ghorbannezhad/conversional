<?php


namespace App\Http\Controllers\API\Docs;


class InvoiceDoc
{
    /**
     * @api {post} invoices Create Invoice
     * @apiName Create Invoice
     * @apiGroup invoice
     *
     * @@apiParam {integer} customer_id
     * @@apiParam {date} from format Y-m-d
     * @@apiParam {date} to  format Y-m-d
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *   "meta": {
     *      "error": [],
     *      "message": "Result return successfully"
     *   },
     *   "body": {
     *      "invoice_id": 24
     *   }
     * }
     *
     *  @apiErrorExample {json} Error-Response:
     * HTTP/1.1 422 Unprocessable Entity
     * {
     *   "meta": {
     *     "error": [],
     *     "message": "Requested period has overlap or gap with the previous invoice"
     *   },
     *   "body": {
     *     "last_invoice_from": "2021-03-01",
     *     "last_invoice_to": "2021-03-30",
     *     "accepted_from": "2021-03-31"
     *    }
     * }
     *
     */

    /**
     * @api {get} invoices/{id} Invoice Detail
     * @apiName Invoice Detail
     * @apiGroup invoice
     *
     *
     * @apiSuccessExample Success-Response:
     *  {
     *  "meta": {
     *      "error": [],
     *      "message": "Result return successfully"
     *  },
     *  "body": {
     *      "invoice": {
     *          "id": 24,
     *          "customer_id": 1,
     *          "from": "2021-02-01",
     *          "to": "2021-02-28",
     *          "total_price": 3.99,
     *          "total_appointment": 1,
     *          "total_activated": 0,
     *          "total_registered": 0,
     *          "created_at": "2021-05-17T15:29:11.000000Z",
     *          "total_event": 1,
     *          "customer": {
     *              "id": 1,
     *              "name": "Faezeh",
     *              "email": "fghorbannezhad@gmail.com"
     *          },
     *          "invoice_details": [
     *              {
     *              "id": 2,
     *              "invoice_id": 24,
     *              "user_id": 1,
     *              "type": "Appointment",
     *              "price": 3.99,
     *              "appointment_count": 1,
     *              "activated_count": 1,
     *              "created_at": "2021-05-17T15:29:11.000000Z",
     *              "user": {
     *                  "id": 1,
     *                  "email": "hossein@gmail.com",
     *                  "customer_id": 1,
     *                  "created_at": "2021-02-10T00:00:00.000000Z"
     *                  }
     *              }
     *          ]
     *      },
     *      "prices": [
     *          {
     *              "id": 1,
     *              "type": 1,
     *              "price": 0.49,
     *              "type_text": "Register"
     *          },
     *          {
     *              "id": 2,
     *              "type": 2,
     *              "price": 0.99,
     *              "type_text": "Activated"
     *          },
     *          {
     *              "id": 3,
     *              "type": 3,
     *              "price": 3.99,
     *              "type_text": "Appointment"
     *          },
     *          {
     *              "id": 4,
     *              "type": 4,
     *              "price": 0.5,
     *              "type_text": "Register to Activate"
     *          },
     *          {
     *              "id": 5,
     *              "type": 5,
     *              "price": 3.5,
     *              "type_text": "Register to Appointment"
     *          },
     *          {
     *              "id": 6,
     *              "type": 6,
     *              "price": 3,
     *              "type_text": "Activate to Appointment"
     *          }
     *        ]
     *      }
     *  }
     */
}