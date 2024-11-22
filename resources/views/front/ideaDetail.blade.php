@extends('front.layouts.app')

@section('main')
    <section class="section-4 bg-2">
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('ideas') }}"><i class="fa fa-arrow-left"
                                        aria-hidden="true"></i> &nbsp;Back to Ideas</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8">
                    <div class="card shadow border-0">
                        @include('front.message')

                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">

                                    <div class="jobs_conetent">
                                        <a href="#">
                                            <h4>{{ $idea->title }}</h4>
                                        </a>
                                        <div class="links_locat d-flex align-items-center">
                                            <div class="location">
                                                <p> <i class="fa fa-map-marker"></i> {{ $idea->category }}</p>
                                            </div>
                                            <div class="location">
                                                <p> <i class="fa fa-clock-o"></i> {{ $idea->idea_type }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" flex flex-col justify-center items-center">
                                    <div class="apply_now">
                                        <a 
                                            class="heart_mark" 
                                            id="upvote-button" 
                                            onclick="upvoteIdea({{ $idea->id }})" 
                                            href="#" 
                                            style="color: {{ $userHasUpvoted ? 'black' : 'grey' }};">
                                            <i class="fa {{ $userHasUpvoted ? 'fa-heart' : 'fa-heart-o' }}" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <span id="upvote-count">{{ $idea->upvotesCount() }}</span>
                                </div>                                
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            <div class="single_wrap">
                                <h4>Idea description</h4>
                                <p>{{ $idea->description }}</p>
                                <p>Variations of passages of lorem Ipsum available, but the majority have suffered
                                    alteration in some form, by injected humour, or randomised words which don't look even
                                    slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be
                                    sure there isn't anything embarrassing.</p>
                            </div>
                            <div class="single_wrap">
                                <h4>Is the Author working on it?</h4>
                                @if ($idea->working_on_it == 'Yes')
                                    <p>{{ $idea->working_on_it }}, he is working on this Idea</p>
                                @else
                                    <p>{{ $idea->working_on_it }}, he is not working on this Idea</p>
                                @endif
                            </div>
                            <div class="single_wrap">
                                <h4>Relevant Links</h4>
                                @if ($idea->relevant_links != '')
                                    <p>{{ $idea->relevant_links }}</p>
                                @else
                                    <p>No relevant links given for this idea</p>
                                @endif
                            </div>
                            <div class="single_wrap flex gap-4">
                                <h4>Tags:</h4>
                                <p>{{ implode(', ', json_decode($idea->tags, true)) }}</p>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="pt-3 text-end">
                                @if (Auth::check())
                                    <a href="#" onclick="saveIdea({{ $idea->id }});"
                                        class="btn btn-secondary">Save</a>
                                    {{-- <a href="#" class="btn btn-primary">Apply</a> --}}
                                @else
                                    <a href="javascript:void(0);" class="btn btn-secondary">Login to Save</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Idea stats</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Created On:
                                        <span>{{ \Carbon\Carbon::parse($idea->Created_at)->format('d M, Y') }}</span></li>
                                    <li>Upvotes: <span>{{ $idea->upvotes }}</span></li>
                                    {{-- <li>Downvotes: <span>{{ $idea->downvotes }}</span></li> --}}
                                    <li>Saves: <span>{{ $idea->saves }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                @if ($idea->user->role == 'company')
                                    <h3>Company Details</h3>
                                @else
                                    <h3>Author Details</h3>
                                @endif

                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{ $idea->user->name }}</span></li>
                                    <li>Designation: <span>{{ $idea->user->designation }}</span></li>
                                    <li>Social handle: <span><a
                                                href="https://www.instagram.com/thecosmicthinkr/">instagram</a></span></li>
                                    @if ($idea->user->role == 'company')
                                        <li>Website: <span><a
                                                    href="{{ $idea->user->website }}">{{ $idea->user->website }}</a></span>
                                        </li>
                                    @else
                                        <li>Website: <span> <a
                                                    href="{{ $idea->user->portfolio }}">{{ $idea->user->portfolio }}</a></span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('customJs')
    <script type="text/javascript">
        function saveIdea(id) {
            $.ajax({
                url: "{{ route('saveIdea') }}",
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(response) {
                    window.location.href = '{{ url()->current() }}'
                }
            });
        }

        function upvoteIdea(ideaId) {
        $.ajax({
            url: "{{ route('upvote') }}",
            method: "POST",
            data: {
                idea_id: ideaId,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.success) {
                    const upvoteButton = document.getElementById('upvote-button');
                    const upvoteCountElement = document.getElementById('upvote-count');
                    let currentCount = parseInt(upvoteCountElement.innerText);

                    if (response.message === 'Upvote removed.') {
                        // Toggle to unfilled heart
                        upvoteButton.style.color = 'grey';
                        upvoteButton.querySelector('i').className = 'fa fa-heart-o';
                        upvoteCountElement.innerText = currentCount - 1;
                    } else {
                        // Toggle to filled heart
                        upvoteButton.style.color = 'black';
                        upvoteButton.querySelector('i').className = 'fa fa-heart';
                        upvoteCountElement.innerText = currentCount + 1;
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Something went wrong.');
            }
        });
    }
    </script>
@endsection
