<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drevesa</title>
    <link rel="stylesheet" href="static/style.css">
    <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
    <script>
        // JavaScript to add the special class to buttons linking to the current URL
        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('a');

            buttons.forEach(function(button) {
                if (button.href == window.location.href)
                    button.classList.add('special-button');

            });
        });
    </script>
</head>
