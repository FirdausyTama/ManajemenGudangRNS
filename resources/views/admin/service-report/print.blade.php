<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Service Report - {{ $service_report->report_no }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            background: white;
            color: black;
            position: relative;
        }
        .container {
            width: 210mm;
            max-width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 0 auto;
            box-sizing: border-box;
            position: relative;
            z-index: 1;
        }
        /* Watermark Background */
        .watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            
            box-sizing: border-box;
            object-fit: contain;
            opacity: 0.1;
            z-index: 0;
            pointer-events: none;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat img {
            width: 100%;
            max-width: 800px;
            height: auto;
        }
        
        .header-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .box {
            border: 1px solid black;
            padding: 10px;
            width: 48%;
            box-sizing: border-box;
            background: transparent;
        }
        .box-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
            color: #000;
        }
        table.info-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.info-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        table.info-table td:first-child {
            width: 30%;
        }
        table.info-table td:nth-child(2) {
            width: 2%;
        }

        .service-status-section {
            margin-bottom: 15px;
        }
        .service-status-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .status-options {
            display: flex;
            gap: 20px;
        }
        .status-col {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .status-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .status-circle {
            width: 12px;
            height: 12px;
            border: 2px solid black;
            border-radius: 50%;
            display: inline-block;
        }
        .status-circle.active {
            background-color: black;
        }
        .status-check {
            font-size: 16px;
            font-weight: bold;
        }

        .description-box {
            border: 1px solid black;
            margin-bottom: 20px;
            background: transparent;
        }
        .desc-header {
            background-color: transparent;
            padding: 5px 10px;
            font-weight: bold;
            border-bottom: 1px solid black;
        }
        .desc-content {
            padding: 10px;
        }
        .desc-content {
            padding: 10px;
        }

        .working-status-box {
            border: 1px solid black;
            margin-bottom: 20px;
            background: transparent;
        }
        .working-table {
            width: 100%;
            border-collapse: collapse;
        }
        .working-table th, .working-table td {
            border: 1px solid black;
            padding: 5px 10px;
            text-align: center;
        }
        .working-table th.left-align {
            text-align: left;
            background-color: transparent;
        }
        .status-radio-row td {
            text-align: left;
            border-top: 1px solid black;
        }
        .status-radio-group {
            display: flex;
            justify-content: space-around;
            padding: 5px 0;
        }
        
        .signature-box {
            border: 1px solid black;
            width: 100%;
            background: transparent;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table th {
            border: 1px solid black;
            padding: 5px;
            width: 50%;
        }
            .signature-table td {
                border: 1px solid black;
                height: 100px;
                vertical-align: bottom;
                text-align: center;
                padding-bottom: 10px;
            }

            .btn-floating-print {
                position: fixed;
                bottom: 30px;
                right: 30px;
                background-color: #1e3a8a;
                color: white;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                cursor: pointer;
                border: none;
                z-index: 9999;
                transition: all 0.2s;
            }

            .btn-floating-print:hover {
                background-color: #152c6b;
                transform: scale(1.05);
            }

            .btn-floating-print svg {
                width: 25px;
                height: 25px;
                fill: currentColor;
            }

            .btn-back {
                position: fixed;
                top: 20px;
                left: 20px;
                background-color: white;
                color: #1e3a8a;
                padding: 10px 20px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.15);
                cursor: pointer;
                border: 1px solid #e2e8f0;
                z-index: 9999;
                text-decoration: none;
                font-weight: 600;
                font-size: 14px;
                transition: all 0.2s;
            }

            .btn-back:hover {
                background-color: #f8fafc;
                transform: translateY(-1px);
            }

            @media print {
                .btn-floating-print, .btn-back {
                    display: none !important;
                }
                body {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            .container {
                padding: 10mm;
                background: none;
            }
            .watermark { display: block !important; }
        }
    </style>
</head>
<body>
    <button onclick="window.close(); window.history.back();" class="btn-back" title="Kembali / Tutup Halaman">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
        <span>Kembali / Tutup</span>
    </button>
    <button onclick="window.print()" class="btn-floating-print" title="Cetak Service Report">
        <svg viewBox="0 0 24 24"><path d="M19 8H5V3H19V8ZM16 5H8V6H16V5ZM22 13.5C22 14.33 21.33 15 20.5 15C19.67 15 19 14.33 19 13.5C19 12.67 19.67 12 20.5 12C21.33 12 22 12.67 22 13.5ZM18 19H6V15H18V19ZM19 22H5V17H2.99C1.89 17 1 16.1 1 15V11C1 9.34 2.34 8 4 8H20C21.66 8 23 9.34 23 11V15C23 16.1 22.11 17 21.01 17H19V22Z"/></svg>
    </button>

    <div class="container">
        <img src="{{ asset('assets/images/logo-rns-bg.png') }}" class="watermark" alt="Watermark">
        <!-- Header -->
        <div class="kop-surat">
            <img src="{{ asset('assets/images/kopsurat.png') }}" alt="Kop Surat PT. RAND Nusantara Sejahtera">
        </div>

        <!-- Info Section -->
        <div class="header-section">
            <div class="box">
                <div class="box-title">SERVICE REPORT</div>
                <div class="box-title" style="font-weight: normal;">CUSTOMER INFORMATION</div>
                <table class="info-table">
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td>{{ $service_report->customer_name }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td>{!! nl2br(e($service_report->customer_address)) !!}</td>
                    </tr>
                    <tr>
                        <td>Departement</td>
                        <td>:</td>
                        <td>{{ $service_report->department }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="box">
                <div class="box-title">NO. {{ $service_report->report_no }}</div>
                <div class="box-title" style="font-weight: normal;">EQUIPMENT INFORMATION</div>
                <table class="info-table">
                    <tr>
                        <td>Brand</td>
                        <td>:</td>
                        <td>{{ $service_report->equipment_brand }}</td>
                    </tr>
                    <tr>
                        <td>Model</td>
                        <td>:</td>
                        <td>{{ $service_report->equipment_model }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Service Status -->
        <div class="service-status-section">
            <div class="service-status-title">SERVICE STATUS</div>
            <div class="status-options" style="display: flex; flex-direction: row; justify-content: flex-start; gap: 40px; align-items: center; margin-top: 10px;">
                <div class="status-item">
                    <div class="status-circle"></div>
                    <span>Contract Maintanance</span>
                </div>
                <div class="status-item">
                    <div class="status-circle"></div>
                    <span>Service</span>
                </div>
                <div class="status-item">
                    <div class="status-circle"></div>
                    <span>Instal</span>
                </div>
                <div class="status-item">
                    <div class="status-circle"></div>
                    <span>Other</span>
                </div>
            </div>
        </div>

        <!-- Service Description -->
        <div class="description-box">
            <div class="desc-header">SERVICE DESCRIPTION</div>
            <div class="desc-content">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 25%; font-weight: bold; vertical-align: top; padding-bottom: 10px;">PROBLEM</td>
                        <td style="width: 2%; font-weight: bold; vertical-align: top;">:</td>
                        <td style="width: 73%; vertical-align: top; padding-bottom: 10px; line-height: 1.5;">{!! nl2br(e($service_report->problem)) !!}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; vertical-align: top; padding-bottom: 10px;">ACTION</td>
                        <td style="font-weight: bold; vertical-align: top;">:</td>
                        <td style="vertical-align: top; padding-bottom: 10px; line-height: 1.5;">{!! nl2br(e($service_report->action)) !!}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; vertical-align: top; padding-bottom: 10px;">REMARK</td>
                        <td style="font-weight: bold; vertical-align: top;">:</td>
                        <td style="font-weight: bold; vertical-align: top; padding-bottom: 10px; line-height: 1.5;">{!! nl2br(e($service_report->remark)) !!}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; vertical-align: top; padding-bottom: 10px;">RECOMMENDATION</td>
                        <td style="font-weight: bold; vertical-align: top;">:</td>
                        <td style="font-weight: bold; vertical-align: top; padding-bottom: 10px; line-height: 1.5;">{!! nl2br(e($service_report->recommendation)) !!}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Working Status -->
        <div class="working-status-box">
            <table class="working-table">
                <tr>
                    <th class="left-align" style="width: 25%;">WORKING STATUS</th>
                    <th style="width: 75%;" colspan="3"></th>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Start</td>
                    <td>{{ \Carbon\Carbon::parse($service_report->working_start)->translatedFormat('d F Y') }}</td>
                    <td style="font-weight: bold;">Finish</td>
                    <td>{{ \Carbon\Carbon::parse($service_report->working_finish)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr class="status-radio-row">
                    <td colspan="4">
                        <div class="status-radio-group">
                            <div class="status-item">
                                <div class="status-circle"></div>
                                <span>Work Completed</span>
                            </div>
                            <div class="status-item">
                                <div class="status-circle"></div>
                                <span>Work Incompleted</span>
                            </div>
                            <div class="status-item">
                                <div class="status-circle"></div>
                                <span>Part Still Required</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Signatures -->
        <div class="signature-box">
            <table class="signature-table">
                <tr>
                    <th>CUSTOMER SIGNATURE</th>
                    <th>ENGINEER SIGNATURE</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        {{ $service_report->engineer_name }}
                    </td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; text-align: center;">
            <img src="{{ asset('assets/images/footerrns.png') }}" style="width: 100%; display: block;" alt="Footer RNS">
        </div>
    </div>
</body>
</html>
