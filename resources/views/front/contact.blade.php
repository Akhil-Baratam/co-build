@extends('front.layouts.app')

@section('main')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-center">Contact Us</h2>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Contact Form -->
            <form action="#" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                </div>
                
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject" required>
                </div>
                
                <div class="form-group mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" rows="5" class="form-control" placeholder="Write your message here..." required></textarea>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection