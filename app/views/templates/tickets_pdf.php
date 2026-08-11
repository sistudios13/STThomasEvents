<?php

declare(strict_types= 1);

use chillerlan\QRCode\QRCode;

ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: sans-serif;
            padding: 20px;
            color: #111;
        }

        .grid {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-cell {
            width: 50%;
            padding: 10px;
            vertical-align: top;
        }

        .ticket {
            border: 2px dashed #999;
            padding: 16px;
            height: 40%;
            position: relative;
        }

        .event-name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 20px;
        }

        .seat {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 16px;
        }

        .info {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .qr {
            width: 200px;
            height: 200px;
            border: 2px solid #000;
            margin-top: 20px;
            text-align: center;
            line-height: 120px;
            font-size: 12px;
        }

        .token {
            position: absolute;
            bottom: 16px;
            right: 16px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>

<body>

    <table class="grid">

        <?php
        $chunks = array_chunk($tickets, 2);

        foreach ($chunks as $row):
            ?>
            <tr>

                <?php foreach ($row as $ticket): ?>
                    <td class="ticket-cell">

                        <div class="ticket">

                            <div class="event-name">
                                <?= htmlspecialchars($booking['Events.Name']) ?>
                            </div>

                            <div class="subtitle">
                                <?= htmlspecialchars($booking['Events.StartsAt']) ?>
                            </div>

                            <div class="seat">
                                <?= htmlspecialchars($ticket['Bookings.Seat']) ?>
                            </div>

                            <div class="info">
                                Ticket Holder:
                                <?= htmlspecialchars($booking['Name']) ?>
                            </div>

                            <div class="info">
                                Location:
                                <?= htmlspecialchars($booking['Events.Location']) ?>
                            </div>

                            <div class="qr">
                                <img style="width: 100%; height: 100%" src="<?php echo (new QRCode)->render(($ticket['Bookings.Token'])) ?>" alt="qrcode">
                            </div>

                            <div class="token">
                                Access Code: <br><?= htmlspecialchars($booking['AccessCode']) ?>
                            </div>

                        </div>

                    </td>
                <?php endforeach; ?>

            </tr>
        <?php endforeach; ?>

    </table>

</body>

</html>

<?php
$html = ob_get_clean();