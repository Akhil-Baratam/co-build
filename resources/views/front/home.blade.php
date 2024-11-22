@extends('front.layouts.app')

@section('main')

<section class="section-0 lazy d-flex dark align-items-center bg-white " >
  <div class="container">
      <div class="row">
          <div class="col-12 col-xl-8">
              <h1>Find and Share Potential Ideas</h1>
              <p>Let's Build together.</p>
              <div class="banner-btn"><a href="{{ route('ideas') }}" class="btn btn-primary mb-8 mb-sm-0">Explore Now</a></div>
          </div>
      </div>
  </div>
</section>

<section class="section-2 bg-2 py-5">
  <div class="container">
      <h2>Popular Categories</h2>
      <div class="row pt-5">
        @if ($popularCategories->IsNotEmpty())    
            @foreach ($popularCategories as $category)
                <div class="col-lg-4 col-xl-3 col-md-6">
                    <div class="single_catagory">
                        <a href="jobs.html"><h4 class="pb-2">{{ $category->category }}</h4></a>
                        <p class="mb-0"> <span>50</span> Available position</p>
                    </div>
                </div>
            @endforeach       
        @else
            <p>No popular categories available at the moment.</p>
        @endif
      </div>
  </div>
</section>

<section class="section-3  py-5">
  <div class="container">
      <h2>Featured Ideas</h2>
      <div class="row pt-5">
          <div class="job_listing_area">                    
              <div class="job_lists">
                  <div class="row">
                    @foreach($topIdeas as $idea)
                      <div class="col-md-4">
                          <div class="card border-0 p-3 shadow mb-4">
                              <div class="card-body">
                                  <h3 class="border-0 fs-5 pb-2 mb-0">{{ $idea->title }}</h3>
                                  <p>{{ $idea->description }}</p>
                                  <div class="bg-light p-3 border">
                                      <p class="mb-0">
                                          <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                          <span class="ps-1">{{ $idea->category }}</span>
                                      </p>
                                      <p class="mb-0">
                                          <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                          <span class="ps-1">{{ $idea->idea_type }}</span>
                                      </p>
                                      <p class="mb-0">
                                          <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                          <span class="ps-1">{{ $idea->tags }}</span>
                                      </p>
                                  </div>

                                  <div class="d-grid mt-3">
                                      <a href="{{ route('ideaDetail', $idea->id) }}" class="btn btn-primary btn-lg">Details</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                    @endforeach;
                                               
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

@endsection