<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blinking Text Example</title>
    <style>
        .blinking-text {
            font-size: 24px;
            font-weight: bold;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            0% {
                color: red;
                opacity: 1;
            }
            25% {
                color: blue;
                opacity: 0.5;
            }
            50% {
                color: green;
                opacity: 1;
            }
            75% {
                color: yellow;
                opacity: 0.5;
            }
            100% {
                color: red;
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <div class="blinking-text">Blinking Text</div>

</body>
</html>
