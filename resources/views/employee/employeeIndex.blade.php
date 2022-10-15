@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
            <div class="col-md-12" style="margin-top: 3%;">
                <h3><p class="">Employee Details :</p></h3>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <a href="{{ URL::to('employee/create') }}" class="btn btn-primary pull-right">Add Employee</a>            
                </div>
                <!-- <br> -->
            </div>

            <div class="row">
                <div class="col-md-6">
                <span  id="export" class="btn btn-success"> Employee CSV</span>

                </div>

                <div class="row">
                <div class="col-md-6">
                <a href="{{ URL::to('test/') }}" class="btn btn-info pull-right">Send Mail</a>            
                </div>
                <!-- <br> -->
            </div>
            </div>
            <div class="col-md-6" style="margin-left: 75%;">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" />
            </div>
            <br>

            <div class="col-md-12" style="margin-top: 3%;">
                <label for=""> Timer </label>
                <body onload="startTime()">
                    <div id="txt"></div>
                </body>
                <div id = "clock" onload="currentTime()"></div>
            </div>
            

    </div>

    @if (Session::has('message'))
        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if(count($errors) > 0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-danger display-hide" id="successMessage" >
                <button id="successMessage" class="close" data-close="alert"></button>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    @endif

    
    <br>
            <div class="iq-card-body table-responsive p-0">
                <div class="table-view">
                    <table class="table text-center  table-striped table-bordered table iq-card " style="width:100%">
                        <thead>
                            <tr class="r1">
                                <th>Employee ID</th>
                                <th>UserName</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                                <tr>                     
                                    <td>{{ $user->Emp_ID }} </td>
                                    <td>{{ $user->name }} </td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->department }}</td>
                                    <td>
                                        <div class="flex align-items-center list-user-action">
                                            <a class="btn btn-success"  href="{{ URL::to('employee/show') . '/' . $user->id }}">View</a>
                                            <a class="btn btn-info"  href="{{ URL::to('employee/edit') . '/' . $user->id }}">Edit</a>
                                            <a class="btn btn-danger"  onclick="return confirm('Are you sure?')" href="{{ URL::to('employee/delete') . '/' . $user->id }}">Delete</a>
                                        </div>
                                    </td>
                       
                                </tr>
                            @endforeach

                        </tbody>
                    </table>


                    <div class="clear"></div>

                    <div class="pagination-outter mt-3 pull-right" >
                        <h6>Showing {{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }} </h6>
                        {!! $users->links() !!}
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ URL::to('/js/function.js')  }}"></script>


<script>
   $(document).ready(function(){
       // $('#message').fadeOut(120);
       setTimeout(function() {
           $('#successMessage').fadeOut('fast');
       }, 3000);
   })
</script>

<script>

    
$(document).ready(function(){

fetch_customer_data();

function fetch_customer_data(query = '')
{
    $.ajax({
    url:"{{ URL::to('/employee/Employee_search') }}",
    method:'GET',
    data:{query:query},
    dataType:'json',
    success:function(data)
    {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    }
    })
}

$(document).on('keyup', '#search', function(){
    var query = $(this).val();
    fetch_customer_data(query);
    });
});

</script>

<!-- //export -->


<script>
        $(document).ready(function(){
            $('#export').click(function(){
            var url = "{{ URL::to('employee/Employee_Export/')  }}";

            $.ajax({
            url: url,
            type: "post",
                data: {
                _token: '{{ csrf_token() }}',
                },      
                success: function(data){
                // alert(data);
                var Excel = data ;
                var Excel_url =  "{{ URL::to('/uploads/csv/')  }}";
                var link_url = Excel_url+'/'+Excel;
                $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Downloaded Employee CSV File </div>');
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                            }, 3000);
                location.href = link_url;
            }
            });
        });
    });
</script>

