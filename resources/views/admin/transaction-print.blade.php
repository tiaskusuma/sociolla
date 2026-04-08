<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Bill - SCL00{{ $order->id }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; padding: 40px; font-family: 'Inter', sans-serif; background: #BADFDB; display: flex; flex-direction: column; align-items: center; min-height: 100vh; }
        
        .receipt {
            background: white;
            border-radius: 15px;
            width: 400px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            position: relative;
            margin-bottom: 30px;
        }

        .logo-area { display: flex; flex-direction: column; align-items: center; margin-bottom: 30px; }
        .logo-icon { width: 50px; height: 50px; background: #F9A3A3; border-radius: 50%; color: white; display: flex; justify-content: center; align-items: center; font-size: 1.5rem; margin-bottom: 10px; }
        .logo-text { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: #F9A3A3; font-weight: 700; letter-spacing: 2px; }

        .meta-row { display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 12px; }
        .meta-row .label { color: #888; }
        .meta-row .val { font-weight: 700; color: #111; }

        .divider { height: 2px; background: repeating-linear-gradient(90deg, #F9A3A3, #F9A3A3 5px, transparent 5px, transparent 10px); margin: 20px 0; }
        .divider-solid { height: 1px; background: #eee; margin: 10px 0; }

        .item { margin-bottom: 15px; }
        .item-top { display: flex; justify-content: space-between; font-weight: 700; font-size: 0.9rem; margin-bottom: 5px; }
        .item-bot { color: #888; font-size: 0.75rem; }

        .summary-row { display: flex; justify-content: flex-end; font-size: 0.8rem; margin-bottom: 8px; }
        .summary-row .label { width: 100px; color: #888; text-transform: uppercase; font-weight: 600; }
        .summary-row .val { font-weight: 700; width: 100px; text-align: right; }

        .grand-total { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; font-weight: 800; font-size: 1.1rem; }
        .grand-total .val { color: #F9A3A3; }

        .footer { text-align: center; margin-top: 30px; }
        .footer .dots { color: #F9A3A3; font-size: 1.5rem; letter-spacing: 5px; margin-bottom: 10px; }
        .footer .tnx { font-weight: 700; font-size: 0.9rem; margin-bottom: 5px; }
        .footer .sub { color: #888; font-style: italic; font-size: 0.75rem; margin-bottom: 20px; }
        .footer .barcode { font-size: 2rem; color: #aaa; letter-spacing: 2px; font-family: monospace; }
        
        .actions { display: flex; gap: 15px; }
        .btn-print { background: #F9A3A3; color: white; border: none; padding: 15px 40px; border-radius: 30px; font-weight: 700; cursor: pointer; font-size: 1rem; box-shadow: 0 4px 15px rgba(249, 163, 163, 0.4); display: flex; align-items: center; gap: 10px; flex: 1; justify-content: center; }
        .btn-share { background: white; color: #F9A3A3; border: none; width: 50px; height: 50px; border-radius: 50%; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }

        @media print {
            body { background: white; padding: 0; }
            .actions { display: none; }
            .receipt { box-shadow: none; width: 100%; border-radius: 0; }
        }
    </style>
</head>
<body>

    <div class="receipt">
        <div class="logo-area">
            <div class="logo-icon"><i class="fa-solid fa-leaf"></i></div>
            <div class="logo-text">SOCIOLLA</div>
        </div>

        <div class="meta-row">
            <div class="label">Date</div>
            <div class="val">{{ $order->created_at ? $order->created_at->format('d-m-Y') : 'N/A' }}</div>
        </div>
        <div class="meta-row">
            <div class="label">Transaction</div>
            <div class="val">012220261935130{{ $order->id }}</div>
        </div>
        <div class="meta-row">
            <div class="label">Customer</div>
            <div class="val">{{ optional($order->user)->name ?? 'Guest' }}</div>
        </div>

        <div class="divider"></div>

        @foreach($order->items as $item)
        <div class="item">
            <div class="item-top">
                <div>{{ optional($item->product)->name ?? 'Product' }}</div>
                <div>IDR. {{ number_format((float)$item->price, 0, ',', '.') }}</div>
            </div>
            <div class="item-bot">Shade: Berry (4.5g)</div>
        </div>
        <div class="divider-solid"></div>
        @endforeach

        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-top:15px;">
            <div style="color:#888; font-size:0.85rem; font-weight:600;">{{ $order->items->sum('quantity') }} Item</div>
            <div>
                <div class="summary-row">
                    <div class="label">TOTAL :</div>
                    <div class="val">IDR. {{ number_format((float)$order->total_amount, 0, ',', '.') }}</div>
                </div>
                <div class="summary-row">
                    <div class="label">DISCOUNT :</div>
                    <div class="val">0</div>
                </div>
                <div class="summary-row">
                    <div class="label">TAX :</div>
                    <div class="val">0</div>
                </div>
            </div>
        </div>

        <div class="divider-solid" style="margin-top:20px;"></div>

        <div class="grand-total">
            <div>GRAND TOTAL :</div>
            <div class="val">IDR. {{ number_format((float)$order->total_amount, 0, ',', '.') }}</div>
        </div>

        <div class="footer">
            <div class="dots">• • •</div>
            <div class="tnx">Thank You For Visiting</div>
            <div class="sub">We Hope You Are Satisfied with Our Service</div>
            <div class="barcode">|||| |||| | ||| || ||</div>
        </div>
    </div>

    <div class="actions">
        <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print"></i> Print Bill</button>
        <button class="btn-share"><i class="fa-solid fa-share-nodes"></i></button>
    </div>

</body>
</html>
