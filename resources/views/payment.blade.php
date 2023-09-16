<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <p>{{$payLink}}</p>
    {{-- <a href="{{$payLink}}">test</a> --}}
    <a href="#!" class="paddle_button" data-override="{{$payLink}}">Buy Now!</a>

    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
    <script type="text/javascript">
        Paddle.Environment.set('sandbox');
        Paddle.Setup({ vendor: 14565 });
        // Paddle.Checkout.open({
        //     override: "{{$payLink}}",
        //     vendor_id: "14565",
        //     vendor_auth_code:"3045c1b7e11908306d8ffc48bbfa56bf8c05753f11bf111801"
        //     });


    </script>
</body>

</html>