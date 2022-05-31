# rewasoft_task
Answers of Stripe &amp; MySQL database task 

database.txt file contains the answers of mysql questions.

# stripe task solutions

1. Connect the stripe token by using Stripe-PHP sdk.

		$helper = new Helper();
        try{
            $accounts=$helper->accounts();
            echo '<pre>';
            print_r($accounts->all());
            print_r($accounts->all()->data);
        }catch(Exception $e){
            echo $e->getMessage();
        }

 2. Write a function to accept a parameter for any dates which it will return all payments from that date

        try{
            $payments=$helper->paymentsByDate('2021/01/01');
            echo "<pre>";
            echo "<ul>";
            foreach ($payments->data as $payment) {
                echo "<li>";
                echo "ID: " . $payment->id . "<br>Amount: " . $payment->currency . " " . ($payment->amount / 100) . "<br>Payment Date: " . date('d-m-Y', $payment->created) . "<br>Description: " . $payment->description;
                echo "</li>";
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }

3. Write a function to accept a parameter to charge any amount of money.

        $data = [
          'amount' => '1110',
          'currency' => 'usd',
          'description' => 'Test Charge',
          'card_number' => '4242424242424242',
          'exp_month' => '08',
          'exp_year' => '2022',
          'cvc' => '123',
        ];
		
        try {
            $charge = $helper->charge($data);
            echo "<pre>";
            echo "<ul>";
            echo "<li>";
            echo "ID: " . $charge->id . "<br>Amount: " . $charge->currency . " " . ($charge->amount / 100) . "<br>Payment Date: " . date('d-m-Y', $charge->created) . "<br>Description: " . $charge->description;
            echo "</li>";
            echo "</ul>";
        } catch (Exception $e) {
            echo $e->getMessage();
        }


 4. Write a function to refund the full amount/partial amount for a specific charge.

        if (isset($charge) && !empty($charge->id)) {
            try {
                $refund = $helper->refund($charge->id);

                echo "<pre>";
                echo "<ul>";
                echo "<li>";
                echo "ID: " . $refund->id . "<br>Amount: " . $refund->currency . " " . ($refund->amount / 100) . "<br>Payment Date: " . date('d-m-Y', $refund->created) . "<br>Status: " . $refund->status;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

