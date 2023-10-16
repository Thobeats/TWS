@extends('layout.vendor_layout')

@section('pagetitle','Profile')

@section('title', 'Profile')

@section('content')

@php
    $tab = session()->has('tab') ? session('tab') : $tab;
@endphp

<section class="section profile">

    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="{{ $user->profileImg() }}" alt="Profile" class="rounded-circle">
            <h2>{{ $user->fullname() }}</h2>
            {{-- <h3>Web Designer</h3> --}}
            {{-- <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div> --}}
          </div>
        </div>

        <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="{{ $user->vendor()->business_logo() }}" alt="Profile" class="rounded-circle">
              <h2>{{ $user->business_name }}</h2>
              {{-- <h3>Web Designer</h3> --}}
              <div class="social-links mt-2">
                <a href="{{ $user->vendor()->twitter }}" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="{{ $user->vendor()->facebook }}" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="{{ $user->vendor()->instagram }}" class="instagram"><i class="bi bi-instagram"></i></a>
                {{-- <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a> --}}
              </div>
            </div>
          </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link {{ $tab == 'profile' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link {{ $tab == 'edit_profile' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show {{ $tab == 'profile' ? 'active' : '' }} profile-overview" id="profile-overview">
                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{ $user->fullname() }}</div>
                </div>

                {{-- <div class="row">
                  <div class="col-lg-3 col-md-4 label">Company</div>
                  <div class="col-lg-9 col-md-8">{{ $user->business_name }}</div>
                </div> --}}

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Country</div>
                  <div class="col-lg-9 col-md-8">
                    USA
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8">
                    {{ $user->address()['address']}}
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8">
                    {{ $user->phone }}
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                </div>

                <hr>
                <h5 class="card-title">Business Details</h5>

                <h5 class="card-title">About {{ $user->business_name }}</h5>
                <p class="small fst-italic">
                    {{ $user->vendor()->about }}
                </p>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Business Name</div>
                  <div class="col-lg-9 col-md-8">{{ $user->business_name }}</div>
                </div>


                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Country</div>
                  <div class="col-lg-9 col-md-8">
                    USA
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Business Address</div>
                  <div class="col-lg-9 col-md-8">
                    {{ $user->address()['address']}}
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Business Phone</div>
                  <div class="col-lg-9 col-md-8">
                    {{ $user->phone }}
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Business Email</div>
                  <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                </div>

              </div>

              <div class="tab-pane fade show {{ $tab == 'edit_profile' ? 'active' : '' }} profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form action="/setProfile" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                        <img src="{{ $user->profileImg() }}" alt="Profile" id="profileImg" width="100px">
                        <div class="pt-2">
                            <label for="profile" class="btn btn-primary btn-sm text-light" title="Upload new profile image" onchange=""><i class="bi bi-upload"></i></label>
                            <input type="file" name="profile" id="profile" class="d-none" onchange="uploadImage(event)" data-target="profileImg" accept=".jpg,.png,.jpeg">
                            <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button class="btn btn-primary btn-sm">Save</button>
                    </div>
                    </div>
                </form>
                <hr>
                <form method="POST" action="/updateProfile">
                    @method('PUT')
                    @csrf

                  <div class="row mb-3">
                    <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="firstname" type="text" class="form-control" id="firstName" value="{{ $user->firstname }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="lastname" type="text" class="form-control" id="lastName" value="{{ $user->lastname }}">
                    </div>
                  </div>

                  {{-- <div class="row mb-3">
                    <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="company" type="text" class="form-control" id="company" value="Lueilwitz, Wisoky and Leuschke">
                    </div>
                  </div> --}}

                  <div class="row mb-3">
                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="country" type="text" class="form-control" id="Country" value="USA">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Zip" class="col-md-4 col-lg-3 col-form-label">Zip</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="zip" type="number" class="form-control" id="zip" value="{{ $user->zip_code }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="address" type="text" class="form-control" id="Address" value="A108 Adam Street, New York, NY 535022">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="state" class="col-md-4 col-lg-3 col-form-label">State</label>
                    <div class="col-md-8 col-lg-9">
                        <select name="state" id="state" class="form-select" onchange="selectCity(event)"></select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="city" class="col-md-4 col-lg-3 col-form-label">City</label>
                    <div class="col-md-8 col-lg-9">
                        <select name="city" id="city" class="form-select">
                            <option value="{{ $user->address()['city']}}">{{ $user->address()['city']}}</option>
                        </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="text" class="form-control" id="Phone" value={{ $user->phone}}>
                    </div>
                  </div>

                  {{-- <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" disabled readonly type="email" class="form-control" id="Email" value="{{ $user->email }}">
                    </div>
                  </div> --}}

                  <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form -->


                <hr>

                <h5 class="card-title mt-3">Edit Business Details</h5>
                  <!-- Business Profile Edit Form -->

                    <form action="/vendor/profile/setLogo" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Logo</label>
                            <div class="col-md-8 col-lg-9">
                                <img src="{{ $vendor->business_logo() }}" alt="Profile" id="busLogo">
                                <div class="pt-2">
                                    <label for="blogo" class="btn btn-primary btn-sm text-light" title="Upload logo"><i class="bi bi-upload"></i></label>
                                    <input type="file" name="b_logo" id="blogo" class="d-none" onchange="uploadImage(event)" data-target="busLogo" accept=".jpg,.png,.jpeg">
                                    <a href="#" class="btn btn-danger btn-sm" title="Remove logo"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-primary btn-sm">Save Logo</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="/vendor/profile/setBanner" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Banner</label>
                            <div class="col-md-8 col-lg-9">
                                <img src="{{ $vendor->business_banner() }}" alt="Profile" id="busBanner">
                                <div class="pt-2">
                                    <label for="banner" class="btn btn-primary btn-sm text-light" title="Upload banner"><i class="bi bi-upload"></i></label>
                                    <input type="file" name="banner" id="banner" class="d-none" onchange="uploadImage(event)" data-target="busBanner" accept=".jpg,.png,.jpeg">
                                    <a href="#" class="btn btn-danger btn-sm" title="Remove banner"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-primary btn-sm">Save Banner</button>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <form method="POST" action="/vendor/profile/updateProfile">
                        @method('PUT')
                        @csrf

                        <div class="row mb-3">
                            <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                            <div class="col-md-8 col-lg-9">
                                <textarea name="about" class="form-control" id="about" style="height: 100px">{{ $user->vendor()->about }}</textarea>
                            </div>

                        </div>

                        <div class="row mb-3">
                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Business Phone</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="phone" type="tel" class="form-control" id="Bphone" value={{ $user->vendor()->bphone}}>
                        </div>
                        </div>

                        <div class="row mb-3">
                            <label for="website" class="col-md-4 col-lg-3 col-form-label">Website</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="website" type="url" class="form-control" id="website" value="{{ $user->vendor()->business_website}}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="twitter" type="url" class="form-control" id="Twitter" value="{{ $user->vendor()->twitter}}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="facebook" type="url" class="form-control" id="Facebook" value="{{ $user->vendor()->facebook}}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="instagram" type="url" class="form-control" id="Instagram" value="{{ $user->vendor()->instagram}}">
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                            </div>
                        </div> --}}

                        <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form><!-- End Business Profile Edit Form -->




              </div>

              <div class="tab-pane fade pt-3" id="profile-settings">

                <!-- Settings Form -->
                <form>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="changesMade" checked>
                        <label class="form-check-label" for="changesMade">
                          Changes made to your account
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="newProducts" checked>
                        <label class="form-check-label" for="newProducts">
                          Information on new products and services
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proOffers">
                        <label class="form-check-label" for="proOffers">
                          Marketing and promo offers
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                        <label class="form-check-label" for="securityNotify">
                          Security alerts
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End settings Form -->

              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form>

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>



  <script>  var selectedStateValue = "{{ $user->address()['state'] }}";</script>
  <script src="{{ asset('assets/js/apicalls.js')}}"></script>

@endsection
