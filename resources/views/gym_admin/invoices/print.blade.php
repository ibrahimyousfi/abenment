<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }
        .rtl table {
            text-align: right;
        }
        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
        @media print {
            .no-print {
                display: none;
            }
            .invoice-box {
                box-shadow: none;
                border: 0;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
            Imprimer la Facture
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
            Fermer
        </button>
    </div>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                @if($invoice->gym->logo)
                                    <img src="{{ asset('storage/' . $invoice->gym->logo) }}" style="width:100%; max-width:150px;">
                                @else
                                    <h2>{{ $invoice->gym->name }}</h2>
                                @endif
                            </td>

                            <td>
                                Facture #: {{ $invoice->invoice_number }}<br>
                                Créée le: {{ $invoice->issue_date->format('d/m/Y') }}<br>
                                Échéance: {{ $invoice->due_date->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>{{ $invoice->gym->name }}</strong><br>
                                {{-- Add gym address if available --}}
                            </td>

                            <td>
                                @if($invoice->member)
                                    <strong>{{ $invoice->member->full_name }}</strong><br>
                                    {{ $invoice->member->email }}<br>
                                    {{ $invoice->member->phone }}
                                @else
                                    Client Anonyme
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Description</td>
                <td>Prix</td>
            </tr>

            @if($invoice->type === 'subscription')
                <tr class="item">
                    <td>
                        Abonnement
                        @if($invoice->member && $invoice->member->subscriptions()->latest()->first())
                             - {{ $invoice->member->subscriptions()->latest()->first()->plan->name }}
                        @endif
                    </td>
                    <td>{{ number_format($invoice->total_amount, 2) }} MAD</td>
                </tr>
            @elseif($invoice->type === 'product')
                 <tr class="item">
                    <td>Achat Produits</td>
                    <td>{{ number_format($invoice->total_amount, 2) }} MAD</td>
                </tr>
            @else
                <tr class="item">
                    <td>Service / Autre</td>
                    <td>{{ number_format($invoice->total_amount, 2) }} MAD</td>
                </tr>
            @endif

            <tr class="total">
                <td></td>
                <td>Total: {{ number_format($invoice->total_amount, 2) }} MAD</td>
            </tr>
             <tr class="total">
                <td></td>
                <td>Payé: {{ number_format($invoice->paid_amount, 2) }} MAD</td>
            </tr>
             <tr class="total">
                <td></td>
                <td style="color: {{ $invoice->status == 'paid' ? 'green' : 'red' }}">
                    Reste à payer: {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }} MAD
                </td>
            </tr>
        </table>
        
        <div style="margin-top: 40px; text-align: center; font-size: 12px; color: #777;">
            Merci de votre confiance !
        </div>
    </div>
</body>
</html>
