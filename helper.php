
<?php
require_once('stripe-php/init.php');

class Helper
{
    var $stripe;

    function __construct()
    {
        $this->stripe = new \Stripe\StripeClient('sk_test_2tf7T5a1JPvJ6wMKSSWrcCTP');
    }

    function accounts()
    {
        return $this->stripe->accounts->all();
    }

    function paymentsByDate($selected_date)
    {
        $dates = explode('/', $selected_date);
        if (checkdate($dates[1], $dates[2], $dates[0])) {
            $payments = $this->stripe->charges->all(
                [
                    'created' => [
                        'gte' => strtotime($selected_date),
                    ]
                ]
            );
            return $payments;
        } else {
            throw new Exception("Invalid Date Format");
        }
    }


    function charge($data)
    {
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $data['card_number'],
                    'exp_month' => $data['exp_month'],
                    'exp_year' => $data['exp_year'],
                    'cvc' => $data['cvc'],
                ]
            ]);

            $charge = $this->stripe->charges->create([
                'amount' => $data['amount'],
                'currency' => $data['currency'],
                'source' => $token->id,
                'description' => $data['description'],
            ]);
            return $charge;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function refund($charge_id)
    {
        $refund = $this->stripe->refunds->create([
            'charge' => $charge_id,
            'amount' => 50
        ]);
        return $refund;
    }
}

// 1: Connect the stripe token by using Stripe-PHP sdk.
$helper = new Helper();

// try{
//     $accounts=$helper->accounts();
//     echo '<pre>';
//     print_r($accounts->all());
//     print_r($accounts->all()->data);
// }catch(Exception $e){
//     echo $e->getMessage();
// }


// 2: Write a function to accept a parameter for any dates which it will return all payments from that
// date

// try{
//     $payments=$helper->paymentsByDate('2021/01/01');
//     echo "<pre>";
//     echo "<ul>";
//     foreach ($payments->data as $payment) {
//         echo "<li>";
//         echo "ID: " . $payment->id . "<br>Amount: " . $payment->currency . " " . ($payment->amount / 100) . "<br>Payment Date: " . date('d-m-Y', $payment->created) . "<br>Description: " . $payment->description;
//         echo "</li>";
//     }
// }catch(Exception $e){
//     echo $e->getMessage();
// }

// 3: Write a function to accept a parameter to charge any amount of money
// $data = [
//     'amount' => '1110',
//     'currency' => 'usd',
//     'description' => 'Test Charge',
//     'card_number' => '4242424242424242',
//     'exp_month' => '08',
//     'exp_year' => '2022',
//     'cvc' => '123',
// ];

// try {
//     $charge = $helper->charge($data);
//     echo "<pre>";
//     echo "<ul>";
//     echo "<li>";
//     echo "ID: " . $charge->id . "<br>Amount: " . $charge->currency . " " . ($charge->amount / 100) . "<br>Payment Date: " . date('d-m-Y', $charge->created) . "<br>Description: " . $charge->description;
//     echo "</li>";
//     echo "</ul>";
// } catch (Exception $e) {
//     echo $e->getMessage();
// }


// //4. Write a function to refund the full amount/partial amount for a specific charge.

// if (isset($charge) && !empty($charge->id)) {
//     try {
//         $refund = $helper->refund($charge->id);

//         echo "<pre>";
//         echo "<ul>";
//         echo "<li>";
//         echo "ID: " . $refund->id . "<br>Amount: " . $refund->currency . " " . ($refund->amount / 100) . "<br>Payment Date: " . date('d-m-Y', $refund->created) . "<br>Status: " . $refund->status;
//     } catch (Exception $e) {
//         echo $e->getMessage();
//     }
// }
