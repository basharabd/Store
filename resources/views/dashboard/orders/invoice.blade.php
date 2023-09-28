

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice for Order #12345</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice {
            margin: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            text-align: center;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .invoice-body {
            padding: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .invoice-total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="invoice">
    <div class="invoice-header">
        <h1>Invoice</h1>
        <p>Order #: {{$order->id}}</p>
        <p>Date: {{$order->created_At}}</p>
    </div>
    <div class="invoice-body">
        <h2>Order Information</h2>
        <table class="invoice-table">
            <tr>
                <th>Customer Name:</th>
                <td>{{$order->user->name}}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>{{$order->status}}</td>
            </tr>
        </table>

        <h2>Order Details</h2>
        <table class="invoice-table">
            <thead>
            <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>${{number_format($item->price, 2)}}</td>
                    <td>${{number_format($item->price * $item->quantity, 2)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="invoice-total">
            <p><strong>Total Amount:</strong> ${{number_format($item->price * $item->quantity, 2)}}</p>
        </div>
    </div>
</div>
</body>
</html>
