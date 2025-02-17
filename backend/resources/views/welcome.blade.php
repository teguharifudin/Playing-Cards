<!DOCTYPE html>
<html>
<head>
    <title>Playing Cards</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .input-section {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .input-group {
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        input[type="number"] {
            padding: 12px;
            font-size: 16px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }

        button {
            padding: 12px 24px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
        }

        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            color: #dc3545;
            margin: 10px 0;
            text-align: center;
            font-weight: bold;
            padding: 10px;
            background-color: #ffe6e6;
            border-radius: 4px;
            display: none;
        }

        .info-message {
            color: #0c5460;
            background-color: #d1ecf1;
            border-radius: 4px;
            padding: 10px;
            margin: 10px 0;
            display: none;
        }

        .result-section {
            margin-top: 20px;
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .hand {
            background-color: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            font-family: monospace;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hand-number {
            min-width: 100px;
            font-weight: bold;
            color: #007bff;
        }

        .hand-cards {
            flex-grow: 1;
            word-break: break-all;
            padding-left: 15px;
        }

        .loading {
            display: none;
            text-align: center;
            margin: 20px 0;
        }

        .loading::after {
            content: "";
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            display: none;
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            input[type="number"] {
                width: 150px;
            }

            .hand {
                flex-direction: column;
                align-items: flex-start;
            }

            .hand-number {
                margin-bottom: 5px;
            }

            .hand-cards {
                padding-left: 0;
            }
        }

        .warning-message {
            color: #856404;
            background-color: #fff3cd;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            margin: 10px 0;
            text-align: center;
            font-weight: bold;
            border-radius: 4px;
            display: none;
        }

        .input-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .input-group input[type="text"] {
            flex: 1;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            outline: none;
            width: 100%;
            max-width: 300px;
        }

        .input-group input[type="text"]:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .input-group input[type="text"]::placeholder {
            color: #6c757d;
            opacity: 0.7;
        }

        .input-group input[type="text"]:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .input-group button {
            padding: 12px 24px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            min-width: 150px;
            white-space: nowrap;
        }

        .input-group button:hover:not(:disabled) {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .input-group button:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .input-group button:disabled {
            background-color: #6c757d;
            border-color: #6c757d;
            cursor: not-allowed;
            opacity: 0.65;
        }

        /* Responsive styles */
        @media (max-width: 576px) {
            .input-group {
                flex-direction: column;
                gap: 15px;
            }

            .input-group input[type="text"] {
                max-width: 100%;
            }

            .input-group button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Playing Cards</h1>

        <div class="input-section">
            <div class="input-group">
                <input 
                    type="text" 
                    id="numPeople" 
                    placeholder="Enter number of people"
                    title="Please enter a positive number"
                >
                <button onclick="distributeCards()" id="distributeButton">
                    Distribute Cards
                </button>
            </div>
            <div id="info" class="info-message"></div>
        </div>

        <div id="error" class="error-message"></div>
        <div id="warning" class="warning-message"></div>
        <div id="loading" class="loading">Processing...</div>
        <div id="result" class="result-section"></div>
    </div>

    <div class="scroll-top" onclick="scrollToTop()">↑</div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function validateInput(value) {
            if (!/^\d*$/.test(value)) {
                return { isValid: false, message: 'Input value does not exist or value is invalid' };
            }
            if (value === '0' || value <= 0 || /^0\d+/.test(value)) {
                return { isValid: false, message: 'Input value does not exist or value is invalid' };
            }
            if (parseInt(value) > 52) {
                return { 
                    isValid: true, 
                    message: '', 
                    warning: 'Total 52 cards, Person 53, and the next one doesn\'t hold any cards.' 
                };
            }
            return { isValid: true, message: '', warning: '' };
        }

        function distributeCards() {
            const numPeople = $('#numPeople').val();
            const button = $('#distributeButton');
            
            $('#error').hide();
            $('#warning').hide();
            $('#info').hide();
            $('#result').empty();
            button.prop('disabled', true);

            const validation = validateInput(numPeople);
            if (!validation.isValid) {
                $('#error').text(validation.message).show();
                button.prop('disabled', false);
                return;
            }

            if (validation.warning) {
                $('#warning').text(validation.warning).show();
            }

            $('#loading').show();

            setTimeout(() => {
                $.ajax({
                    url: '/api/distribute',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ numPeople: parseInt(numPeople) }),
                    success: function(response) {
                        if (response.data) {
                            const distributedCards = response.data.split('\n');
                            const totalPeople = parseInt(numPeople);
                            const results = Array(totalPeople).fill(null);

                            distributedCards.forEach((hand, index) => {
                                if (index < 52) {
                                    results[index] = hand;
                                }
                            });

                            results.forEach((hand, index) => {
                                $('#result').append(`
                                    <div class="hand">
                                        <span class="hand-number">Person ${index + 1}</span>
                                        <span class="hand-cards">${hand === null ? 'null' : hand}</span>
                                    </div>
                                `);
                            });
                            
                            if (results.length > 10) {
                                $('.scroll-top').show();
                            }
                        } else {
                            $('#error').text('Irregularity occurred').show();
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        $('#error').text(response?.message || 'Irregularity occurred').show();
                    },
                    complete: function() {
                        $('#loading').hide();
                        button.prop('disabled', false);
                    }
                });
            }, 1000);
        }

        // Input validation on change
        $('#numPeople').on('input', function() {
            const value = $(this).val();
            const validation = validateInput(value);

            $('#error').hide();
            $('#warning').hide();
            $('#info').hide();

            if (!validation.isValid) {
                $('#error').text(validation.message).show();
            } else if (validation.warning) {
                $('#warning').text(validation.warning).show();
            }
        });

        // Handle Enter key
        $('#numPeople').keypress(function(e) {
            if (e.which == 13) {
                distributeCards();
            }
        });

        // Scroll to top functionality
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('.scroll-top').fadeIn();
            } else {
                $('.scroll-top').fadeOut();
            }
        });

        function scrollToTop() {
            $('html, body').animate({scrollTop: 0}, 'smooth');
        }

        // Clear messages when clicking outside
        $(document).click(function(e) {
            if (!$(e.target).closest('.input-section, .error-message, .warning-message').length) {
                $('#error').hide();
                $('#warning').hide();
                $('#info').hide();
            }
        });
    </script>
</body>
</html>