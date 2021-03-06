@extends('layouts.app')
@section('css')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row" id="top-content">
    <div class="top-element">
        <img src="img\main_img.png" alt="mint">
    </div>

    <div class="top-element">
        <h4>Keep your skills fresh with Mint !</h4>
        <p class="flow-text">Mint is a luxembourg-based platform that connects motivated people with dedicated mintors in the IT field, quickly and accurately. Become one of our mintees,
            browse through our mintors catalog and choose a mentor that catch your interest. Get connected and you'll get some fresh insights on how to progress ! You can also become a mintor and
            enjoy helping your mintee get some new cool skills and experience !</p>
    </div>
</div>
<div id="arrow"></div>

<div class="row shadow" id="middle-jumbotron">
    <div class="carousel">
        <img class="carousel-item" src="img\javascript.png">
        <img class="carousel-item" src="img\react.png">
        <img class="carousel-item" src="img\java.png">
        <img class="carousel-item" src="img\php.png">
        <img class="carousel-item" src="img\vue.png">
    </div>
    <h2>Learn some of the finest and most popular technologies with your mintor</h2>
    <p id="subtext">Here's a quickview of technologies you can learn on Mint, but there is a lot more than what is shown here, so don't forget to check our mintors catalog !</p>
</div>

<div class="row" id="home-register">
    <div class="col s6" id="register_col_1">

        <img src="img\mentee.png" alt="mentee">
        <h5>A fresh mintee</h5>


        <p>Join Mint as a mintee and get some fresh new skills and grow up in the luxembourgish IT market !</p>


        <a class="waves-effect waves-light btn" href="/register_mentee">Become a mintee</a>


    </div>
    <div class="col s6" id="register_col_2">

        <img src="img\mentor.png" alt="mentor">
        <h5>A green and experienced mintor</h5>


        <p>Join Mint as a mintor and help your mintees to get some insights, experience, and maybe make your network grow up !</p>


        <a class="waves-effect waves-light btn" href="/register_mentor">Become a mintor</a>



    </div>
</div>
@endsection
