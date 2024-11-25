@extends('main') @section('title')
    My Address
    @endsection @section('stylesheet')
    @endsection @section('content')
    <div class="section section-cart bg-light pt-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="my-account.html">Profile</a>
                </li>
                <li class="breadcrumb-item active">My Address</li>
            </ol>

            <div class="hgroup py-3 w-100">
                <h1 class="h2 text-underline">Profile</h1>
            </div>

            <form class="card-info">
                <div class="card-body px-md-4 py-2">
                    <h2 class="text-secondary mb-3">My Address</h2>

                    <h3 class="fs-18 mb-5">Personal Info</h3>

                    <div class="row form-row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Firstname</label>
                                <input type="text" class="form-control" placeholder="Firstname" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Lastname</label>
                                <input type="text" class="form-control" placeholder="Lastname" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Mobile Phone</label>
                                <input type="text" class="form-control" placeholder="Mobile Phone" value="0987654321"
                                    pattern="[0-9]*" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Email</label>
                                <input type="email" class="form-control" placeholder="Email" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Province</label>
                                <select class="form-select">
                                    <option value="">Province</option>
                                    <option value="1">Text1....</option>
                                    <option value="2">Text2....</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Dristrict</label>
                                <select class="form-select">
                                    <option value="">Dristrict</option>
                                    <option value="1">Text1....</option>
                                    <option value="2">Text2....</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Sub - District</label>
                                <select class="form-select">
                                    <option value="">Sub - District</option>
                                    <option value="1">Text1....</option>
                                    <option value="2">Text2....</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title">Postal Code</label>
                                <input type="text" class="form-control" placeholder="Postal Code" value="10302" />
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="title">Detailed address (house number, building name,
                                    etc)</label>
                                <textarea class="form-control h-145" placeholder="Detailed address"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="check1"
                                    name="" />
                                <label class="form-check-label" for="check1">
                                    <strong>Set as default</strong><br />
                                    <span class="fs-14">Turn on to automatically apply the current
                                        information setting in the future. You can
                                        make changes at any time.</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="buttons button-confirm justify-content-lg-end mb-4">
                                <a class="btn btn-outline-red" href="addresses.html">Cancel</a>
                                <a class="btn btn-secondary" href="addresses.html">Submit
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--row-->
                </div>
                <!--card-body-->
            </form>
            <!--card-info-->
        </div>
        <!--container-->
    </div>
    <!--section-->
    @endsection @section('script')
@endsection
