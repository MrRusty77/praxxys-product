<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,500,1,0" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body>

    <!-- <div class="flex items-center justify-center w-screen h-screen bg-gradient-to-r " @class( [ 'from-emerald-500 to-emerald-300'=> $status == 'success', 'text-gray-500' => $status == 'success', ])> -->

    <div @class( [ 'flex' , 'items-center' , 'justify-center' , 'w-screen' , 'h-screen' , 'bg-gradient-to-r' , 'from-emerald-500'=> $status == 'success',
        'to-emerald-300'=> $status == 'success',
        'from-red-500' => $status == 'failure',
        'to-red-400'=> $status == 'failure',
        ])>

        <div class="px-40 py-20 bg-white rounded-md shadow-xl">
            <div class="flex flex-col items-center">
                @if( $status == 'success' )
                <h1 class="font-bold text-emerald-500 text-9xl">
                    <span class="material-symbols-outlined text-9xl">
                        check_circle
                    </span>
                </h1>
                @else
                <h1 class="font-bold text-red-500 text-9xl">
                    <span class="material-symbols-outlined text-9xl">
                        cancel
                    </span>
                </h1>
                @endif

                <h6 class="mb-2 text-2xl font-bold text-center text-gray-800 md:text-3xl">

                    @if( $status == 'success' )
                    <span class="text-emerald-500">Payment Success!!!</span>
                    @else
                    <span class="text-rose-500">Payment Failed!!!</span>
                    @endif
                </h6>

                <h6 class="mb-2 text-xl font-bold text-center text-gray-800 md:text-3xl">
                    <span>Reference number: {{ $code }} </span>
                </h6>

                @if( $status == 'success' )
                <p class="mb-8 text-center text-gray-500 md:text-lg">
                    We have recieved your payment from Maya
                    You will be redirected back to your cart sortly
                </p>
                @else
                <p class="mb-8 text-center text-gray-500 md:text-lg">
                    Unfotunately Maya is able to process your payment
                </p>
                @endif

                <!-- <a href="#" class="px-6 py-2 text-sm font-semibold text-blue-800 bg-blue-100">Go home</a> -->
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.replace(`${window.location.origin}/#/transactions?search=${ {{$code}} }`);
        }, 3000);
    </script>
</body>

</html>