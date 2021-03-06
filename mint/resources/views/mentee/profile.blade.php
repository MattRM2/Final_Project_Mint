@extends('layouts.app')
@section('css')
<link href="{{ asset('css/menteeProfile.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="field">
    <section class="maininfo">
        <img src="{{ asset('img/') }}/{{$profile->profile_image}}" class="image circle">
        <section>
            <h2>{{$profile->getFullName()}}</h2>
            <h5>{{$profile->type}}</h5>
        </section>
    </section>
    <section class="menteepagelook mrgtop">
        <section class="flex leftsection">
            <section class="block">
                <h5>Pitch:</h5>
                <p class="bg spaceinside">{{$profile->pitch}}</p>
            </section>
            <section class="block">
                <h5>Ratings:</h5>
                <section class="scroll" id="ratingList">
                    @foreach($profile->receiveRatings as $rating)
                    <div class="bg">
                        <h6>{{$rating->writer->getFullName()}}:</h6>
                        <section class="rating">
                            <p>{{$rating->score}}</p><i class="material-icons left star">star</i>
                            <p>{{$rating->comment}}</p>
                        </section>
                    </div>
                    @endforeach
                </section>
            </section>

            @if($canWriteRating)
            <section class="db myform">
                <div>
                    <form id="form" action="{{route('rating.create')}}" method="POST">
                        @csrf
                        <p class="col s2">
                            <select name="score" style="display: initial;">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5" selected="selected">5</option>
                            </select>
                        </p>
                        <div class="input-field col s6 leftpad">
                            <input type="hidden" name="target" value="{{$profile->id}}">
                            <input type="hidden" name="writer" value="{{Auth::user()->id}}">
                            <textarea name="comment" id="textArea" class="materialize-textarea"></textarea>
                            <label id="label" for="comment">Add a feedback</label>
                        </div>
                        <div id="button" class="waves-effect waves-light btn-small sendbtn">
                            <input id="submitButton" type="submit" value="Submit" class='textbtn'>
                        </div>


                    </form>
                </div>
            </section>
            @endif



            <!-- message part part -->
            <section>
                @if(count($messages) >0)
                <h5>Messages:</h5>
                <section class="scroll bg" id="messagegList">
                    @foreach($messages as $message)
                    <section class="rating">
                        <i class="material-icons left message messagemy">message</i>
                        <h6>{{$message->writer->getFullName()}}:</h6>
                    </section>
                    <p>{{$message->message}}</p>
                    @endforeach
                </section>
                @endif
            </section>

            @if($collaborator !== null)
            <div class="row mrgtop">
                <form id="form2" action="{{route('message.create')}}" method="POST" class="col s12">
                    <div class="input-field col s12 leftpad" id="pad">
                        @csrf
                        {{ csrf_field() }}
                        <input type="hidden" name="writer" value="{{Auth::user()->id}}">
                        <input type="hidden" name="target" value="{{$collaborator->id}}">

                        <textarea id="icon_prefix2" class="materialize-textarea" name="message"></textarea>
                        <label for="icon_prefix2">Write a message</label>
                        <!-- <label id="labelMessage" for="message">Write a message</label>
                        <br>
                        <textarea name="message" id="textAreaMessage" placeholder="Write your message here"></textarea>
                        <br> -->
                        <div id="button" class="waves-effect waves-light btn-small sendbtn">
                            <input id="submitButton2" type="submit" value="Send" name="form2" class='textbtn'>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            @endif
        </section>

        <section class="menteebtn flex rightsection">
            <!-- mentee part -->
            @if(Auth::user()->type == 'mentee')

            <section class="searchbtn">
                <div class="mybtn">
                    <a href="{{route('searchmentor', Auth::user()->id)}}" class="btn waves-effect waves-light sendbtn amy">Look for a mentor</a>
                </div>

                <div class="mybtn">
                    <a href="{{route('editmenteeprofile', Auth::user()->id)}}" class="btn waves-effect waves-light sendbtn amy">Modify profile</a>
                </div>
            </section>


            <!-- API part -->
            <div>
                <h5>Jobs:</h5>

                <section class="scrollbig" id="jobList">
                    @foreach($jobsData as $job)
                    <!-- <i class="material-icons left motion_photos_on messagemy">motion_photos_on</i> -->
                    <h6 class="jobtitle">{{$job['title']}}</h6>
                    <p>Company: {{$job['company_name']}}</p>
                    <a href="{{$job['url']}}" class="mybtn">Details</a>
                    <hr>
                    @endforeach
                </section>
            </div>
            @endif
        </section>

        <!-- mentor part -->
        @if(Auth::user()->type == 'mentor')
        @if($collabRequestStatus == 'pending')
        <section class="menteebtn">
            <section class="searchbtn ">
                <form action="" method="get" class="mybtn">
                    @csrf
                    <button name="accept-request" value="{{$collabRequestId}}" class="btn waves-effect waves-light sendbtn amy">Accept invitation</button>
                </form>
                <form action="{{route('mentor.connection.destroy', $collabRequestId)}}" method="post" class="mybtn">
                    @csrf
                    @method('DELETE')
                    <button name="decline-request" value="{{$collabRequestId}}" class="btn waves-effect waves-light sendbtn amy">Decline invitation</button>
                </form>
            </section>
            @else
            <form action="{{route('mentor.connection.destroy', $collabRequestId)}}" method="post" class="mybtn">
                @csrf
                @method('DELETE')
                <button name="disconnect" value="{{$collabRequestId}}" class="btn waves-effect waves-light sendbtn amy">Disconnect</button>
            </form>
        </section>
        @endif
    </section>


    @section('script')
    <script>
        $(document).ready(function() {
            function deleteCollaboration(collabId) {
                routeUrl = "{{url('')}}/mentoracdisconnect/" + collabId;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: routeUrl,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function(result) {
                        window.location.replace("{{route('mentorprofile', Auth::user()->id)}}");
                    }
                })
            }

            //? Button to accept invitation
            $("button[name='accept-request']").click(function(event) {
                event.preventDefault();
                if (confirm("Are you sure to accept this invitation?")) {
                    routeUrl = "{{url('')}}/mentoraiaccept/" + $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: routeUrl,
                        method: 'GET',
                        dataType: 'json',
                        success: function(result) {
                            location.reload();
                        }
                    })
                }
            });

            //? Button to decline collaboration request
            $("button[name='decline-request']").click(function(event) {
                event.preventDefault();
                if (confirm("Are you sure to decline invitation?")) {
                    deleteCollaboration($(this).val());
                }
            });
            //? Button to break the connection
            $("button[name='disconnect']").click(function(event) {
                event.preventDefault();
                if (confirm("Are you sure to disconnect from this mentee?")) {
                    deleteCollaboration($(this).val());
                }
            });
        });
    </script>
    @endsection
    @endif

    <!-- admin part -->

    @if(Auth::user()->type == 'admin')

    <form action="{{route('mentee.destroy', $profile->id)}}" method="post">
        @csrf
        @method('DELETE')

        <input type="hidden" value="{{$profile->id}}">
        <button>Delete profile</button>
    </form>
    @endif
</section>
@endsection