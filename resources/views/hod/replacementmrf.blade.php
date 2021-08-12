@extends('layouts.master')

@section('title', 'Replacement Manpower Requisition Form')
@section('PageContent')
<div class="page-content">
    <div class="col-xl-7 mx-auto">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body p-3">
                <div class="card-title d-flex align-items-center">
                    <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                    </div>
                    <h5 class="mb-0 text-primary">Replacement Manpower Requisition Form</h5>
                </div>
                <hr>
                <form class="row g-3">
                    <div class="col-md-6">
                        <label for="Replacement" class="form-label">Replacement For:</label>
                        <input type="email" class="form-control" id="Replacement" name="Replacement">
                        <input type="hidden" name="ReplacementFor" id="ReplacementFor">
                    </div>
                    <div class="col-md-6">
                        <label for="Designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="Designation" name="Designation">
                    </div>
                    <div class="col-md-4">
                        <label for="Grade" class="form-label">Grade</label>
                        <input type="text" class="form-control" id="Grade">
                    </div>
                    <div class="col-md-4">
                        <label for="ExistingLocation" class="form-label">Existing Location</label>
                        <input type="text" class="form-control" id="ExistingLocation">
                    </div>
                    <div class="col-4">
                        <label for="ExCTC" class="form-label">Existing CTC</label>
                        <input type="text" class="form-control" id="ExCTC">
                    </div>
                
                    <div class="col-md-6">
                        <label for="State" class="form-label">State</label>
                  <select name="State" id="State" class="form-control form-select"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">State</label>
                        <select id="inputState" class="form-select">
                            <option selected="">Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="inputZip" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="inputZip">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">Check me out</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-5">Register</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>


@endsection

@section('scriptsection')
<script>

</script>
@endsection
