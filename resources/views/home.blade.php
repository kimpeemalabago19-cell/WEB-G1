@extends('layouts.main')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <h1>Reconnect People With <span>Their Belongings</span></h1>
    <p>
        Quickly report, search, and recover lost items with our system. Making it
        easier for everyone to find what matters most.
    </p>
</div>

<!-- Tutorial Section -->
<div class="tutorial-section">
    <h2>How to Claim Your Belongings</h2>
    <div class="tutorial-intro">
        All items reported in the system are already available at 
        <strong>OSAS (CHMSU CLAIMING STATION)</strong>. Follow the steps below to safely claim your lost items. 
        You can also contact us for assistance:
        <br>
        Message us at <strong>Carlos Hilado Memorial State University</strong>, 
        email <strong>cier@chmsu.edu.ph</strong>, or call <strong>(034) 454 0529</strong>.
    </div>

    <div class="steps">
        <div class="step">
            <div class="step-number">1</div>
            <p>Go to the <strong>Lost Items</strong> section in your dashboard to search for your missing belongings.</p>
        </div>

        <div class="step">
            <div class="step-number">2</div>
            <p>Click on the item card to view detailed information, including the finder's contact details.</p>
        </div>

        <div class="step">
            <div class="step-number">3</div>
            <p>Once you locate your item, click the <strong>Claim</strong> button under the card. A small confirmation modal will appear asking you to verify that you are claiming the item.</p>
        </div>

        <div class="step">
            <div class="step-number">4</div>
            <p>Confirm the claim by submitting the form in the modal. After submission, the item will automatically move to the <strong>Claimed Items</strong> section and be marked with your name as the claimer.</p>
        </div>

        <div class="step">
            <div class="step-number">5</div>
            <p>Proceed to <strong>OSAS (CHMSU CLAIMING STATION)</strong> to physically collect your item. Use the provided contact info if you need further assistance.</p>
        </div>
    </div>
</div>
@endsection

