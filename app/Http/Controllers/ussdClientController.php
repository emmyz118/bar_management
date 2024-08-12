<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Beverage;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ussdClientController extends Controller
{
     public function handle()
    {
        $sessionId   = request('sessionId');
        $serviceCode = request('serviceCode');
        $phoneNumber = request('phoneNumber');
        $text        = request('text');

        $response = $this->menu($text, $phoneNumber);

        return response($response)->header('Content-Type', 'text/plain');
    }

    private function menu($text, $phoneNumber)
    {
        if ($text=="") {
           return "CON Welcome to [Bar Name]\n1. Place an Order\n2. Reserve a Table\n3. View Menu\n4. Cancel Order/Reservation\n5. Check Status";
        }
        else{
        $textArray = explode("*", $text);
        $userResponse = trim(end($textArray));

        switch (count($textArray)) {       
            case 1:
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
            case 2:
                $input = $textArray[2];
                if ($textArray[1] == "1") {
                    return "CON Enter your name for the order:";
                } elseif ($textArray[1] == "2") {
                    return "CON Enter your name for the reservation:";
                } elseif ($textArray[1] == "4" || $textArray[1] == "5") {
                    return $this->checkOrCancel($textArray[1], $input, $phoneNumber);
                }
                break;
            case 3:
                $name = $textArray[3];
                if ($textArray[1] == "1") {
                    return $this->placeOrder($textArray[2], $name, $phoneNumber);
                } elseif ($textArray[1] == "2") {
                    return $this->reserveTable($textArray[2], $name, $phoneNumber);
                }
                break;
            default:
                return "END Invalid option. Please try again.";
        }    
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

    private function placeOrder($beverageId, $clientName, $phoneNumber)
    {
        $beverage = Beverage::find($beverageId);

        if (!$beverage) {
            return "END Beverage not found. Please try again.";
        }

        Order::create([
            'client_name' => $clientName,
            'phone_number' => $phoneNumber,
            'beverage_id' => $beverage->id,
            'status' => 'pending',
        ]);

        return "END Order received for $beverage->name. Thank you, $clientName!";
    }

    private function reserveTable($tableNumber, $clientName, $phoneNumber)
    {
        Reservation::create([
            'table_number' => $tableNumber,
            'client_name' => $clientName,
            'phone_number' => $phoneNumber,
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

    private function checkOrCancel($option, $id, $phoneNumber)
    {
        if ($option == "4") {
            $order = Order::where('id', $id)->where('phone_number', $phoneNumber)->first();
            $reservation = Reservation::where('id', $id)->where('phone_number', $phoneNumber)->first();

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
            $order = Order::where('id', $id)->where('phone_number', $phoneNumber)->first();
            $reservation = Reservation::where('id', $id)->where('phone_number', $phoneNumber)->first();

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