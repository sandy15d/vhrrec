@extends('layouts.master')
@section('title', 'Dashboard')


@section('PageContent')
    <div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
              <div class="card radius-10 border-start border-0 border-3 border-success">
                 <div class="card-body">
                     <div class="d-flex align-items-center">
                         <div>
                             <p class="mb-0 text-secondary">New MRF's</p>
                             <h4 class="my-1 text-success">1</h4>
                        
                         </div>
                         <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-comment-add'></i>
                         </div>
                     </div>
                 </div>
              </div>
            </div>
            <div class="col">
             <div class="card radius-10 border-start border-0 border-3 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Closed MRF</p>
                            <h4 class="my-1 text-danger">9</h4>
                          
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bxs-comment-minus'></i>
                        </div>
                    </div>
                </div>
             </div>
           </div>
           <div class="col">
             <div class="card radius-10 border-start border-0 border-3 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Active MRF's</p>
                            <h4 class="my-1 text-info">31</h4>
                         
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
                        </div>
                    </div>
                </div>
             </div>
           </div>
           <div class="col">
             <div class="card radius-10 border-start border-0 border-3 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Candidates</p>
                            <h4 class="my-1 text-warning">837</h4>
                          
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bxs-group'></i>
                        </div>
                    </div>
                </div>
             </div>
           </div> 
         </div><!--end row-->
    </div>
@endsection
