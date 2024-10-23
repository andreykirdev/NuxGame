<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Page A - Special Link</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }

        h1, h2 {
            color: #444;
            text-align: center;
        }

        form, #result, ul {
            max-width: 600px;
            margin: 20px auto;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px 0;
            display: block;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        #history {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #history li {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #result {
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 4px;
            text-align: center;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
<h1>Welcome to Page A</h1>

<form action="/generate" method="POST">
    <button type="submit">Generate New Link</button>
</form>

<form action="/deactivate" method="POST">
    <button type="submit">Deactivate Link</button>
</form>

<h2>Feeling Lucky?</h2>
<form action="/imfeelinglucky" method="POST">
    <button type="submit">I'm Feeling Lucky</button>
</form>

<div id="result">
</div>

<h2>History</h2>
<form action="/history" method="POST">
    <button type="submit">Get History</button>
</form>
<ul id="history">
</ul>

</body>
</html>
<script>
    $(document).ready(function() {
        const currentUrl = window.location.href;
        const linkId = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);

        $('form[action="/generate"]').on('submit', function(e) {
            e.preventDefault();
            $.post($(this).attr('action'), { linkId: linkId }, function(response) {
                window.location.replace(response.link);
            });
        });

        $('form[action="/deactivate"]').on('submit', function(e) {
            e.preventDefault();
            $.post($(this).attr('action'), { linkId: linkId }, function(response) {
                if (response.message === 'deactivated') {
                    window.location.replace(window.location.origin);
                }
            });
        });

        $('form[action="/imfeelinglucky"]').on('submit', function(e) {
            e.preventDefault();
            $.post($(this).attr('action'), { linkId: linkId }, function(response) {
                $('#result').html('<p>Result: ' + response.result + '</p><p>Winning Amount: ' + response.winAmount + '</p>');
            });
        });

        $('form[action="/history"]').on('submit', function(e) {
            e.preventDefault();
            $('#history').empty();
            $.post($(this).attr('action'), { linkId: linkId }, function(response) {
                $.each(response, function(index, historyItem) {
                    var listItem = '<li>Result: ' + historyItem.result + ', Win Amount: ' + historyItem.win_amount +
                        ', Created At: ' + historyItem.created_at + '</li>';
                    $('#history').append(listItem);
                });
            });
        });
    });
</script>
