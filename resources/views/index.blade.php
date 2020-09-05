@php
    use App\UserCounter;
    $view_count = UserCounter::where('id', 1)->first();

    if (session()->get('viewed') == 'already'){

    }
    else{
        $view_count->update(['view_count'=> $view_count->view_count+1]);
    }


    session()->put('viewed','already');
@endphp
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title> AI </title>
    <style>
        .speech {
            border: 1px solid #DDD;
            width:300px;
            padding:0;
            margin:0
        }

        .speech input {
            border:0;
            width:240px;
            display:inline-block;
            height:30px;
            font-size: 14px;
        }

        .speech img {
            float:right;
            width:40px
        }

    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Hello, world! </h1>
    <h3 class="text-center">Please feed me with your message to learn more about the world.</h3>
    <small class="text-center">{{ $view_count->view_count }} People have reached me and {{ $view_count->talk_count }} people have send me query. </small>

</div>
<div class="container">
    <form id="ai" action="{{ route('test') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12 form-group speech mb-1">
                <input name="message" class="form-control" id="voice-recognize" placeholder="Say something like" required>
                <img onclick="startDictation()" src="https://i.imgur.com/cHidSVu.gif" />
                @if($errors->has('message'))
                    <small class="text-danger">{{ $errors->first('message') }}</small>
                @endif
            </div>
            <div class="col-md-12 form-group ">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </div>
    </form>
</div>

<div class="container">
    @if( isset($reply) )
        Respond from AI: <strong>{{ $reply }}</strong>
    @endif
</div>



<script>

    function startDictation() {

        if (window.hasOwnProperty('webkitSpeechRecognition')) {

            var recognition = new webkitSpeechRecognition();

            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = "en-US";
            recognition.start();

            recognition.onresult = function (e) {
                document.getElementById('voice-recognize').value = e.results[0][0].transcript;
                recognition.stop();
                document.getElementById('ai').submit();
            };
            recognition.onerror = function(e) {
                recognition.stop();
            }
        }
    }

</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
