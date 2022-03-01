@extends('layouts.admin')
@section('title')
Notifications | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="row justify-content-center">

  <div class="col-12 col-sm-12">
    <div class="timeline">
      <!-- timeline item -->
      <div>
        @forelse($unread as $notification)
        <i class="fas fa-bell bg-blue"></i>

          <br>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> {{ App\Models\Movie::getTimeInTimezoneString($notification->created_at) }}</span>

              <h3 class="timeline-header">{{$notification->data['typeSent']}}</h3>

              <div class="timeline-body">
                <p style="white-space:pre-line;">{{$notification->data['description']}}</p>

              @if($notification->data['typeSent']=="Booked" || $notification->data['typeSent']=="Reserved" || $notification->data['typeSent']=="Checked In" || $notification->data['typeSent']=="Checked In Accepted" || $notification->data['typeSent']=="Canceled")
                <p>Movie: <span class="text-lime">{{$notification->data['movie_name']}}</span> Screen: <span class="text-lime">{{$notification->data['screen_name']}}</span></p>
                <p>Ticket: <span class="text-lime">{{$notification->data['thisticket']}}</span> Seat: <span class="text-lime">{{$notification->data['seat_name']}}</span>({{$notification->data['section']}})</p>
                <p>Start On: <span class="text-lime">{{App\Models\Movie::getTimeInTimezoneString($notification->data['start_date'])}}</span> End On: <span class="text-lime">{{App\Models\Movie::getTimeInTimezoneString($notification->data['end_date'])}}</span></p>
                <p>Ticket Amount: <span class="text-lime">{{$notification->data['ticket_amount']}}</span></p>
                <p>Paid On: <span class="text-lime">{{App\Models\Movie::getTimeInTimezoneString($notification->data['sold_on'])}}</span>
                  @if($notification->data['used_on']=="No Used On")
                  Used On: <span class="text-lime">{{$notification->data['used_on']}}</span>
                @else
                  Used On: <span class="text-lime">{{App\Models\Movie::getTimeInTimezoneString($notification->data['used_on'])}}</span>
                @endif
                </p>

              @endif
                <p class="bg-light text-right">
                  @if($notification->read_at) By: <span class="time text-orange">{{ App\Models\Movie::getAccountDetailsName($notification->data['userid']) }}</span>, Read <span class="time text-lime">
                      {{ App\Models\Movie::getTimeInTimezoneForHumans($notification->read_at) }}</span> <i class="fas fa-clock"></i>  
                  @else 
                    Not Read 
                  @endif</p>
              </div>

          </div>
        @empty
          <i class="fas fa-user bg-green"></i>
          <div class="timeline-item">
            <h3 class="timeline-header no-border bg-warning"> No Notifications Here</h3>
          </div>
        @endforelse
        <div>
      <!-- END timeline item -->
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    load_Orders_All('all');
    load_Orders_Completed('completed');
    load_Orders_Active('active');
    load_Orders_Placed('placed');
    load_Orders_NotPlaced('notplaced');
    load_Orders_NotStarted('notstarted');
  });

function load_Orders_All(status){
  $.ajax({
    url:"/clients/get-orders/"+status,
      method:"GET",
      success:function(data){
        var alldata=JSON.parse(data);
        $('#allordersdata').html('');
        var orders=document.getElementById('allordersdata');
        for (var i = 0; i < alldata.length; i++) {
          var sno=i+1;
          var actions='<a href="/admin/site/countries/edit/'+alldata[i].id+'" class="btn btn-primary btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-edit"></i></a> <a href="/admin/site/countries/delete/'+alldata[i].id+'" class="btn btn-danger btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-trash"></i></a>';
            var uploadedStatus=(alldata[i].uploadsStatus)=="Uploaded"?"completed":"active";
            var status=alldata[i].status;
            var link="";
            if (status=="Not Placed") {
              link='<a href="/client/orders/new/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Placed"){
              link='<a href="/client/orders/placed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Started"){
              link='<a href="/client/orders/started/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Completed"){
              link='<a href="/client/orders/completed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            orders.innerHTML=orders.innerHTML+'<tr><td>'+link+'</td><td>'+alldata[i].topic+'</td> <td>'+alldata[i].status+'</td><td>'+alldata[i].uploadsStatus+'</td><td>'+alldata[i].editedsStatus+'</td><td>'+alldata[i].clientPaidStatus+'</td><td>'+alldata[i].deliverysStatus+'</td> </tr>';
        }
        if (alldata.length==0) {
            var noorders='<tr><td colspan="6"  class="text-center"></td></tr>';
            $('#allordersdata').html(noorders);
        }
        
        $("#all").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false,"ordering":false
        });
      },
      error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        if (errorMessage=="0: error") {
            errorMessage="No Connection" 
        }

        var orders='<tr><td colspan="6" class="text-center"> '+errorMessage+'</td> </tr>';
        $('#allordersdata').html(orders);
    }

  });
}

function load_Orders_Active(status){
  $.ajax({
    url:"/clients/get-orders/"+status,
      method:"GET",
      success:function(data){
        var alldata=JSON.parse(data);
        $('#activeordersdata').html('');
        var orders=document.getElementById('activeordersdata');
        for (var i = 0; i < alldata.length; i++) {
          var sno=i+1;
          var actions='<a href="/admin/site/countries/edit/'+alldata[i].id+'" class="btn btn-primary btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-edit"></i></a> <a href="/admin/site/countries/delete/'+alldata[i].id+'" class="btn btn-danger btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-trash"></i></a>';
            var uploadedStatus=(alldata[i].uploadsStatus)=="Uploaded"?"completed":"active";
            var status=alldata[i].status;
            var link="";
            if (status=="Not Placed") {
              link='<a href="/client/orders/new/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Placed"){
              link='<a href="/client/orders/placed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Started"){
              link='<a href="/client/orders/started/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Completed"){
              link='<a href="/client/orders/completed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            orders.innerHTML=orders.innerHTML+'<tr><td>'+link+'</td><td>'+alldata[i].topic+'</td> <td>'+alldata[i].status+'</td><td>'+alldata[i].uploadsStatus+'</td><td>'+alldata[i].editedsStatus+'</td><td>'+alldata[i].clientPaidStatus+'</td><td>'+alldata[i].deliverysStatus+'</td> </tr>';
        }
        if (alldata.length==0) {
            var noorders='<tr><td colspan="6"  class="text-center"></td></tr>';
            $('#activeordersdata').html(noorders);
        }
        $("#active").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false,"ordering":false
        });
      },
      error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        if (errorMessage=="0: error") {
            errorMessage="No Connection" 
        }

        var orders='<tr><td colspan="6" class="text-center"> '+errorMessage+'</td> </tr>';
        $('#activeordersdata').html(orders);
    }

  });
}

function load_Orders_Completed(status){
  $.ajax({
    url:"/clients/get-orders/"+status,
      method:"GET",
      success:function(data){
        var alldata=JSON.parse(data);
        $('#completedordersdata').html('');
        var orders=document.getElementById('completedordersdata');
        for (var i = 0; i < alldata.length; i++) {
          var sno=i+1;
          var actions='<a href="/admin/site/countries/edit/'+alldata[i].id+'" class="btn btn-primary btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-edit"></i></a> <a href="/admin/site/countries/delete/'+alldata[i].id+'" class="btn btn-danger btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-trash"></i></a>';
            var uploadedStatus=(alldata[i].uploadsStatus)=="Uploaded"?"completed":"active";
            var status=alldata[i].status;
            var link="";
            if (status=="Not Placed") {
              link='<a href="/client/orders/new/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Placed"){
              link='<a href="/client/orders/placed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Started"){
              link='<a href="/client/orders/started/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Completed"){
              link='<a href="/client/orders/completed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            orders.innerHTML=orders.innerHTML+'<tr><td>'+link+'</td><td>'+alldata[i].topic+'</td> <td>'+alldata[i].status+'</td><td>'+alldata[i].uploadsStatus+'</td><td>'+alldata[i].editedsStatus+'</td><td>'+alldata[i].clientPaidStatus+'</td><td>'+alldata[i].deliverysStatus+'</td> </tr>';
        }
        if (alldata.length==0) {
            var noorders='<tr><td colspan="6"  class="text-center"></td></tr>';
            $('#completedordersdata').html(noorders);
        }
        $("#completed").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false,"ordering":false
        });
      },
      error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        if (errorMessage=="0: error") {
            errorMessage="No Connection" 
        }

        var orders='<tr><td colspan="6" class="text-center"> '+errorMessage+'</td> </tr>';
        $('#completedordersdata').html(orders);
    }

  });
}

function load_Orders_Placed(status){
  $.ajax({
    url:"/clients/get-orders/"+status,
      method:"GET",
      success:function(data){
        var alldata=JSON.parse(data);
        $('#pendingordersdata').html('');
        var orders=document.getElementById('pendingordersdata');
        for (var i = 0; i < alldata.length; i++) {
          var sno=i+1;
          var actions='<a href="/admin/site/countries/edit/'+alldata[i].id+'" class="btn btn-primary btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-edit"></i></a> <a href="/admin/site/countries/delete/'+alldata[i].id+'" class="btn btn-danger btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-trash"></i></a>';
            var uploadedStatus=(alldata[i].uploadsStatus)=="Uploaded"?"completed":"active";
            var status=alldata[i].status;
            var link="";
            if (status=="Not Placed") {
              link='<a href="/client/orders/new/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Placed"){
              link='<a href="/client/orders/placed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Started"){
              link='<a href="/client/orders/started/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Completed"){
              link='<a href="/client/orders/completed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            orders.innerHTML=orders.innerHTML+'<tr><td>'+link+'</td><td>'+alldata[i].topic+'</td> <td>'+alldata[i].status+'</td><td>'+alldata[i].uploadsStatus+'</td><td>'+alldata[i].editedsStatus+'</td><td>'+alldata[i].clientPaidStatus+'</td><td>'+alldata[i].deliverysStatus+'</td> </tr>';
        }
        if (alldata.length==0) {
            var noorders='<tr><td colspan="6"  class="text-center"></td></tr>';
            $('#pendingordersdata').html(noorders);
        }
        $("#pending").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false,"ordering":false
        });
      },
      error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        if (errorMessage=="0: error") {
            errorMessage="No Connection" 
        }

        var orders='<tr><td colspan="6" class="text-center"> '+errorMessage+'</td> </tr>';
        $('#pendingordersdata').html(orders);
    }

  });
}

function load_Orders_NotPlaced(status){
  $.ajax({
    url:"/clients/get-orders/"+status,
      method:"GET",
      success:function(data){
        var alldata=JSON.parse(data);
        $('#notplacedordersdata').html('');
        var orders=document.getElementById('notplacedordersdata');
        for (var i = 0; i < alldata.length; i++) {
          var sno=i+1;
          var actions='<a href="/admin/site/countries/edit/'+alldata[i].id+'" class="btn btn-primary btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-edit"></i></a> <a href="/admin/site/countries/delete/'+alldata[i].id+'" class="btn btn-danger btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-trash"></i></a>';
            var uploadedStatus=(alldata[i].uploadsStatus)=="Uploaded"?"completed":"active";
            var status=alldata[i].status;
            var link="";
            if (status=="Not Placed") {
              link='<a href="/client/orders/new/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Placed"){
              link='<a href="/client/orders/placed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Started"){
              link='<a href="/client/orders/started/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Completed"){
              link='<a href="/client/orders/completed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            orders.innerHTML=orders.innerHTML+'<tr><td>'+link+'</td><td>'+alldata[i].topic+'</td> <td>'+alldata[i].status+'</td><td>'+alldata[i].uploadsStatus+'</td><td>'+alldata[i].editedsStatus+'</td><td>'+alldata[i].clientPaidStatus+'</td><td>'+alldata[i].deliverysStatus+'</td> </tr>';
        }
        if (alldata.length==0) {
            var noorders='<tr><td colspan="6"  class="text-center"></td></tr>';
            $('#notplacedordersdata').html(noorders);
        }
        $("#notplaced").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false,"ordering":false
        });
      },
      error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        if (errorMessage=="0: error") {
            errorMessage="No Connection" 
        }

        var orders='<tr><td colspan="6" class="text-center"> '+errorMessage+'</td> </tr>';
        $('#notplacedordersdata').html(orders);
    }

  });
}

function load_Orders_NotStarted(status){
  $.ajax({
    url:"/clients/get-orders/"+status,
      method:"GET",
      success:function(data){
        var alldata=JSON.parse(data);
        $('#notstartedordersdata').html('');
        var orders=document.getElementById('notstartedordersdata');
        for (var i = 0; i < alldata.length; i++) {
          var sno=i+1;
          var actions='<a href="/admin/site/countries/edit/'+alldata[i].id+'" class="btn btn-primary btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-edit"></i></a> <a href="/admin/site/countries/delete/'+alldata[i].id+'" class="btn btn-danger btn-sm" style="padding: 5px;font-size: 12px;"><i class="fa fa-trash"></i></a>';
            var uploadedStatus=(alldata[i].uploadsStatus)=="Uploaded"?"completed":"active";
            var status=alldata[i].status;
            var link="";
            if (status=="Not Placed") {
              link='<a href="/client/orders/new/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Placed"){
              link='<a href="/client/orders/placed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Started"){
              link='<a href="/client/orders/started/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            else if(status=="Completed"){
              link='<a href="/client/orders/completed/'+alldata[i].id+'">OR'+alldata[i].id+'</a>';
            }
            orders.innerHTML=orders.innerHTML+'<tr><td>'+link+'</td><td>'+alldata[i].topic+'</td> <td>'+alldata[i].status+'</td><td>'+alldata[i].uploadsStatus+'</td><td>'+alldata[i].editedsStatus+'</td><td>'+alldata[i].clientPaidStatus+'</td><td>'+alldata[i].deliverysStatus+'</td> </tr>';
        }
        if (alldata.length==0) {
            var noorders='<tr><td colspan="6"  class="text-center"></td></tr>';
            $('#notstartedordersdata').html(noorders);
        }
        $("#notstarted").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false,"ordering":false
        });
      },
      error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        if (errorMessage=="0: error") {
            errorMessage="No Connection" 
        }

        var orders='<tr><td colspan="6" class="text-center"> '+errorMessage+'</td> </tr>';
        $('#notstartedordersdata').html(orders);
    }

  });
}


function validatelogin(){
  if (!confirm("Do You Want to Proceed")) {
    return false;
  }
}
</script>
@endpush