<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4 fw-bold">Customer Name:</div>
                        <div class="col-8 text-capitalize">{{$InquiryDetails->customer->first_name}} {{$InquiryDetails->customer->last_name}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-bold">Inquiry Reference:</div>
                        <div class="col-8">{{$InquiryDetails->inquirie_ref}}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 fw-bold">Message:</div>
                        <div class="col-8">{{$InquiryDetails->inquirie_message}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
