<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\Beverage;
use App\Models\Reservation;

class UssdHandler extends Component
{
  public $text;
    public $phoneNumber;

    public function mount($text = null, $phoneNumber = null)
    {
        $this->text = $text;
        $this->phoneNumber = $phoneNumber;
    }

    public function render()
    {
        $response = $this->processUssdRequest();
        return response($response)->header('Content-Type', 'text/plain');
    }

    private function processUssdRequest()
    {
        if ($this->text == "") {
            return "CON Welcome to [Bar Name]\n1. Place an Order\n2. Reserve a Table\n3. View Menu\n4. Cancel Order/Reservation\n5. Check Status";
        } else {
            $textArray = explode("*", $this->text);
            $userResponse = trim(end($textArray));

            switch (count($textArray)) {
                case 1:
                    return $this->handleFirstLevelOptions($userResponse);
                case 2:
                    return $this->handleSecondLevelOptions($textArray);
                case 3:
                    return $this->handleThirdLevelOptions($textArray);
                default:
                    return "END Invalid option. Please try again.";
            }
        }
    }

    private function handleFirstLevelOptions($userResponse)
    {
        switch ($userResponse) {
            case "1":
                return $this->showBeverageOptions();
            case "2":
                return $this->showTableOptions();
            case "3":
                return $this->viewMenu();
            case "4":
                return "CON Enter your order or reservation ID to cancel:";
            case "5":
                return "CON Enter your order or reservation ID to check status:";
            default:
                return "END Invalid option. Please try again.";
        }
    }

    private function handleSecondLevelOptions($textArray)
    {
        $input = $textArray[2];
        if ($textArray[1] == "1") {
            return "CON Enter your name for the order:";
        } elseif ($textArray[1] == "2") {
            return "CON Enter your name for the reservation:";
        } elseif ($textArray[1] == "4" || $textArray[1] == "5") {
            return $this->checkOrCancel($textArray[1], $input);
        }
    }

    private function handleThirdLevelOptions($textArray)
    {
        $name = $textArray[3];
        if ($textArray[1] == "1") {
            return $this->placeOrder($textArray[2], $name);
        } elseif ($textArray[1] == "2") {
            return $this->reserveTable($textArray[2], $name);
        }
    }

    private function showBeverageOptions()
    {
        $beverages = Beverage::pluck('name', 'id')->toArray();
        $response = "CON Select a beverage:\n";
        foreach ($beverages as $id => $name) {
            $response .= "$id. $name\n";
        }
        return $response;
    }

    private function showTableOptions()
    {
        $tables = range(1, 20); // Example: assuming table numbers are from 1 to 20
        $response = "CON Select a table number:\n";
        foreach ($tables as $tableNumber) {
            $response .= "$tableNumber. Table $tableNumber\n";
        }
        return $response;
    }

    private function placeOrder($beverageId, $clientName)
    {
        $beverage = Beverage::find($beverageId);

        if (!$beverage) {
            return "END Beverage not found. Please try again.";
        }

        Order::create([
            'client_name' => $clientName,
            'phone_number' => $this->phoneNumber,
            'beverage_id' => $beverage->id,
            'status' => 'pending',
        ]);

        return "END Order received for $beverage->name. Thank you, $clientName!";
    }

    private function reserveTable($tableNumber, $clientName)
    {
        Reservation::create([
            'table_number' => $tableNumber,
            'client_name' => $clientName,
            'phone_number' => $this->phoneNumber,
            'status' => 'reserved',
        ]);

        return "END Table $tableNumber reserved. Thank you, $clientName!";
    }

    private function viewMenu()
    {
        $menuItems = Beverage::pluck('name')->toArray();
        $menuString = implode(", ", $menuItems);

        return "END Menu: $menuString";
    }

    private function checkOrCancel($option, $id)
    {
        if ($option == "4") {
            $order = Order::where('id', $id)->where('phone_number', $this->phoneNumber)->first();
            $reservation = Reservation::where('id', $id)->where('phone_number', $this->phoneNumber)->first();

            if ($order) {
                $order->delete();
                return "END Order $id canceled successfully.";
            } elseif ($reservation) {
                $reservation->delete();
                return "END Reservation $id canceled successfully.";
            } else {
                return "END ID not found or does not belong to you.";
            }
        } elseif ($option == "5") {
            $order = Order::where('id', $id)->where('phone_number', $this->phoneNumber)->first();
            $reservation = Reservation::where('id', $id)->where('phone_number', $this->phoneNumber)->first();

            if ($order) {
                return "END Your order status: $order->status.";
            } elseif ($reservation) {
                return "END Your reservation status: $reservation->status.";
            } else {
                return "END ID not found or does not belong to you.";
            }
        }
    }
    
}